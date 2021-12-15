<?php

namespace Core\Entity;

use Core\Inferface\EntityInterface;

class EntityColection
{
    public $pagina;
    public $itens;

    public function __construct($dados = null)
    {
        if (!empty($dados)) {
            $this->pagina = $dados->page;
            $this->itens  = $dados->itens;
        }
    }

    public function paginaAtual()
    {
        return $this->pagina->current;
    }

    public function proximaPagina()
    {
        return $this->pagina->next;
    }

    public function proximaAnterior()
    {
        return $this->pagina->before;
    }

    public function totalPaginas()
    {
        return $this->pagina->total;
    }

    public function totalDeRegistros()
    {
        return $this->pagina->results;
    }

    public function toApiJson()
    {
        return (object)[
            'page'  => $this->pagina,
            'itens' => $this->itensToJson()
        ];
    }

    public function itensToJson()
    {
        return array_reduce($this->itens, function ($result, EntityInterface $item) {
            $result[] = (object)$item->toApiJson();
            return $result;
        }, []);
    }
}