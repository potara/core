<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2020 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */


namespace Potara\Core\Crud\Repository;


use Doctrine\DBAL\Cache\CacheException;
use Doctrine\DBAL\Cache\QueryCacheProfile;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Driver\Statement;
use Doctrine\DBAL\Query\QueryBuilder;
use Potara\Core\Provider\Doctrine\DoctrineRepository;

class AbstractRepository extends DoctrineRepository
{

    public $table;
    public $entity;

    public function __construct(&$doctrineEntity, $entity)
    {
        $this->table  = get_class_vars($entity)['_table'];
        $this->entity = $entity;
        parent::__construct($doctrineEntity);
    }

    /**
     * @param        $value
     * @param string $inputWhere
     * @param array  $inputSelect
     *
     * @return mixed
     * @throws DBALException
     */
    public function find($value, $inputWhere = 'id', $inputSelect = [])
    {
        $inputSelect = is_array($inputSelect) ? implode(", ", $inputSelect) : '*';
        $query       = $this->conn->query("SELECT {$inputSelect} FROM {$this->table} WHERE {$inputWhere}='{$value}'");
        $this->setFetchMode($query);
        return $query->fetch();
    }

    /**
     * @param null  $limit
     * @param int   $page
     * @param array $options
     *
     * @return object
     * @throws \Exception
     */
    public function findByPage($limit = null, $page = 0, $options = [])
    {
        $where   = !empty($options['where']) ? $options['where'] : [];
        $orderBy = !empty($options['order_by']) ? $options['order_by'] : ['id' => 'DESC'];
        return $this->findBy($where, $orderBy, $limit, $page, $options);
    }

    /**
     * @param array|null $where
     * @param array|null $orderBy
     * @param null|int   $limit
     * @param bool|int   $page
     * @param array      $options
     *
     * @return object
     * @throws \Exception
     */
    public function findBy(array $where = [], array $orderBy = [], $limit = 25, $page = null, $options = [])
    {
        $queryObject = new EntityRepositoryQuery($where, $orderBy, $limit, $page, $options);

        try {
            $queryBuilder = $this->conn->createQueryBuilder();

            $queryBuilder->select($queryObject->inputSelect)
                         ->from($this->table, $queryObject->fromAlias);

            $this
                ->hydratorLike($queryBuilder, $queryObject)
                ->hydratorWhere($queryBuilder, $queryObject)
                ->hydratorOrder($queryBuilder, $queryObject);

            //ADICIONAR LIMITE DE RESULTADOS E PONTO DE PARTIDA
            if ($queryObject->limit) {
                $queryBuilder->setMaxResults($queryObject->limit);
            }

            $page = [];
            if ($queryObject->showPage) {
                $page = $this->factoryPagination($this->getTotalRegister($queryBuilder), $queryObject->page, $queryObject->limit);
                $queryBuilder->setFirstResult($queryObject->offset);
            }

            return (object) [
                'page'  => $page,
                'itens' => $this->hydratorCache($queryBuilder, $queryObject)
            ];

        } catch (\Exception $e) {
            throw new \Exception($this->entity . ": " . $e->getMessage());
        }
    }

    /**
     * @param QueryBuilder          $queryBuilder
     * @param EntityRepositoryQuery $queryObject
     *
     * @return $this
     */
    public function hydratorLike(QueryBuilder &$queryBuilder, EntityRepositoryQuery &$queryObject)
    {
        if ($queryObject->isLike) {
            array_walk($queryObject->inputSearch, function ($value) use ($queryBuilder)
            {
                $likeInput = preg_match("%([a-z_]+)\.([a-z_]+)%", $value) ? $value : "{$value}";

                if (empty($queryBuilder->getQueryPart('where'))) {
                    $queryBuilder->where($queryBuilder->expr()->like($likeInput, ":key"));
                } else {
                    $queryBuilder->orWhere($queryBuilder->expr()->like($likeInput, ":key"));
                }
                $queryBuilder->orWhere($queryBuilder->expr()->like($likeInput, ":keyHtml"));
            });

            $queryBuilder
                ->setParameter("key", "%{$queryObject->isLike}%")
                ->setParameter("keyHtml", "%{$queryObject->isLikeHtml}%");
        }

        return $this;
    }

    /**
     * @param QueryBuilder          $queryBuilder
     * @param EntityRepositoryQuery $queryObject
     *
     * @return $this
     */
    public function hydratorWhere(QueryBuilder &$queryBuilder, EntityRepositoryQuery &$queryObject)
    {
        if (!empty($queryObject->where)) {
            array_walk($queryObject->where, function ($value, $index) use ($queryBuilder)
            {
                $whereInput = preg_match("%([a-z_]+)\.([a-z_]+)%", $index) ? $index : "{$index}";
                if (empty($queryBuilder->getQueryPart('where'))) {
                    $queryBuilder->where("{$whereInput} = :{$index}");
                } else {
                    $queryBuilder->andWhere("{$whereInput} = :{$index}");
                }
                $queryBuilder->setParameter(":{$index}", $value);
            });
        }
        return $this;
    }

    /**
     * @param QueryBuilder          $queryBuilder
     * @param EntityRepositoryQuery $queryObject
     *
     * @return $this
     */
    public function hydratorOrder(QueryBuilder &$queryBuilder, EntityRepositoryQuery &$queryObject)
    {
        if (!empty($queryObject->orderBy)) {
            array_walk($queryObject->orderBy, function ($inputValue, $inputKey) use ($queryBuilder)
            {
                $orderInput = preg_match("%([a-z_]+)\.([a-z_]+)%", $inputKey) ? $inputKey : "{$inputKey}";
                if (empty($queryBuilder->getQueryPart('orderBy'))) {
                    $queryBuilder->orderBy($orderInput, $inputValue);
                } else {
                    $queryBuilder->addOrderBy($orderInput, $inputValue);
                }
            });
        }
        return $this;
    }

    /**
     * @param QueryBuilder          $queryBuilder
     * @param EntityRepositoryQuery $queryObject
     *
     * @return array|mixed[]
     * @throws CacheException
     */
    public function hydratorCache(QueryBuilder &$queryBuilder, EntityRepositoryQuery &$queryObject)
    {
        //VERIFICAR O USO DE CACHE
        if (!empty($cacheKey) && is_string($cacheKey)) {
            $resultQueryExecute = $this->conn->executeCacheQuery(
                $queryBuilder->getSQL(),
                $queryBuilder->getParameters(),
                $queryBuilder->getParameterTypes(),
                new QueryCacheProfile($queryObject->cacheTimeOut, $queryObject->cacheKey));
            $this->setFetchMode($resultQueryExecute);
            $resultQuery = $resultQueryExecute->fetchAll();

            $resultQueryExecute->closeCursor();

        } else {

            $executeQuery = $queryBuilder->execute();
            $this->setFetchMode($executeQuery);
            $resultQuery = $executeQuery->fetchAll();
        }

        return $resultQuery;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string       $input
     *
     * @return mixed
     */
    public function getTotalRegister(QueryBuilder &$queryBuilder, $input = 'id')
    {
        $queryBuilderTotal = clone $queryBuilder;
        $queryBuilderTotal->select("COUNT({$input}) as total");
        return $queryBuilderTotal->execute()->fetch()['total'];
    }

    /**
     * @param      $query
     * @param null $entity
     */
    public function setFetchMode(&$query, $entity = null)
    {
        if (!is_null($this->entity) || !is_null($entity)) {
            $entity = is_null($entity) ? $this->entity : $entity;

            $query->setFetchMode(\PDO::FETCH_CLASS, $entity, []);
        }
    }

    /**
     *
     * @param int $total_results
     * @param int $page
     * @param int $limit
     *
     * @return object
     */
    public function factoryPagination($total_results = 0, $page = 0, $limit = 1)
    {
        $page          = (int) $page;
        $limit         = (int) $limit;
        $total_results = (int) $total_results;

        $total_pages = ($total_results <= 0 || $limit == 0) ? 1 : (int) ceil($total_results / $limit);

        $current_page = $page <= 0 ? 1 : $page;

        $next_page = $current_page + 1;

        if ($next_page >= $total_pages) {
            $next_page = $total_pages;
        }

        if ($next_page == $current_page) {
            $next_page = 0;
        }

        $before_page = $current_page - 1;

        if ($before_page <= 0) {
            $before_page = 0;
        }

        return (object) [
            "current" => $current_page,
            "next"    => $next_page,
            "before"  => $before_page,
            "total"   => $total_pages,
            "results" => $total_results,
        ];
    }

    /**
     * @param array $data
     *
     * @return bool|string
     * @throws \Exception
     */
    public function insert(array $data = [])
    {
        try {
            $entity       = new $this->entity($data);
            $entityDataDb = $entity->toSave()->toArray();
            unset($entityDataDb['id']);

            $queryBuilder = $this->conn->createQueryBuilder();
            $queryBuilder->insert($this->table);

            foreach (array_keys($entityDataDb) as $key) {
                $queryBuilder->setValue($key, ":{$key}");
            }
            $queryBuilder->setParameters($entityDataDb);

            $saveQuery = $queryBuilder->execute();

            return $saveQuery ? $this->conn->lastInsertId() : false;

        } catch (\Exception $e) {
            throw new \Exception($this->entity . ": " . $e->getMessage());
        }
    }

    /**
     * @param array $where
     * @param array $data
     *
     * @return Statement|int
     * @throws \Exception
     */
    public function update(array $where, array $data = [])
    {
        try {
            $entity       = new $this->entity($data);
            $entityDataDb = $entity->toSave()->toArray();

            $queryBuilder = $this->conn->createQueryBuilder();
            $queryBuilder->update($this->table);

            foreach (array_keys($where) as $whereKey) {
                if (empty($queryBuilder->getQueryPart('where'))) {
                    $queryBuilder->where("{$whereKey} = :{$whereKey}");
                } else {
                    $queryBuilder->andWhere("{$whereKey} = :{$whereKey}");
                }
            }

            foreach (array_keys($entityDataDb) as $entityKey) {
                $queryBuilder->set($entityKey, ":{$entityKey}");
            }
            $queryBuilder->setParameters($where + $entityDataDb);

            return $queryBuilder->execute();

        } catch (\Exception $e) {
            throw new \Exception($this->entity . ": " . $e->getMessage());
        }
    }

    /**
     * @param array $where
     *
     * @return Statement|int
     * @throws \Exception
     */
    public function delete(array $where)
    {
        try {
            $queryBuilder = $this->conn->createQueryBuilder();
            $queryBuilder->delete($this->table);

            foreach (array_keys($where) as $whereKey) {
                if (empty($queryBuilder->getQueryPart('where'))) {
                    $queryBuilder->where("{$whereKey} = :{$whereKey}");
                } else {
                    $queryBuilder->andWhere("{$whereKey} = :{$whereKey}");
                }
            }

            $queryBuilder->setParameters($where);

            return $queryBuilder->execute();

        } catch (\Exception $e) {
            throw new \Exception($this->entity . ": " . $e->getMessage());
        }
    }
}