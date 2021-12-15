<?php


namespace Core\Entity\Value;


class EntityValueDecimalFull implements EntityValueObjectInterface
{
    private $valor;

    public function __construct($valor = null)
    {
        $this->set($valor);
    }

    public static function factory($valor = null)
    {
        return new self($valor);
    }

    public function set($valor)
    {
        $this->valor = !empty($valor) ? (float)$valor : 0.0;
        return $this;
    }

    public function value():string
    {
        return $this->valor;
    }


    public function __toString()
    {
        return empty($this->value()) ? "" : $this->value();
    }
}