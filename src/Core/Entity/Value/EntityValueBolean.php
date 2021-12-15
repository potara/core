<?php


namespace Core\Entity\Value;


class EntityValueBolean implements EntityValueObjectInterface
{
    private $valor;

    public function __construct($valor = 0)
    {
        $this->set($valor);
    }

    public static function factory($valor = 0)
    {
        return new self($valor);
    }

    public function set($valor)
    {
        $this->valor = (bool)$valor;
        return $this;
    }

    public function value()
    {
        return $this->valor;
    }

    public function raw()
    {
        return (int)$this->value();
    }

    public function __toString()
    {
        return empty($this->value()) ? "" : $this->value();
    }
}