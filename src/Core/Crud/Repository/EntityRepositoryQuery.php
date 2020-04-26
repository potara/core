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


class EntityRepositoryQuery
{
    public $where;
    public $orderBy;
    public $inputSelect;
    public $fromAlias;
    public $inputSearch;
    public $isLike;
    public $isLikeHtml;
    public $showPage;
    public $page;
    public $limit;
    public $offset;
    public $cacheKey;
    public $cacheTimeOut;

    public function __construct(array &$where = [], array &$orderBy = [], $limit = null, $page = null, &$options = [])
    {
        $this->where        = $where;
        $this->orderBy      = $orderBy;
        $this->inputSelect  = is_array($options['select']) ? $options['select'] : ['*'];
        $this->isLike       = !empty($options['is_like']) ? $options['is_like'] : false;
        $this->isLikeHtml   = !empty($options['is_like']) ? htmlentities($options['is_like']) : false;
        $this->inputSearch  = is_array($options['like']) ? $options['like'] : [];
        $this->fromAlias    = !empty($options['alias']) ? $options['alias'] : null;
        if((int) $limit>0){
            $this->page         = !is_null($page) ? (int) $page : 0;
            $this->limit        = (int) $limit;
            $this->showPage     = true;
        }else{
            $this->page         = !is_null($page) ? (int) $page : null;
            $this->limit        = (int) $limit <= 0 ? 25 : (int) $limit;
            $this->showPage     = is_int($page) ? true : false;
        }
        $this->cacheKey     = empty($options['cache_key']) ? null : $options['cache_key'];
        $this->cacheTimeOut = empty($options['cache_timeout']) ? 1000 : $options['cache_timeout'];

        if ($this->page > 2) {
            $this->offset = ($this->limit * $this->page) - $this->limit;
        } else {
            $this->offset = $this->page <= 1 ? 0 : $this->limit;
        }

    }
}