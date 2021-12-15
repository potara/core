<?php


namespace Core\Entity\Value;


use Respect\Validation\Validator;

class EntityValueDate extends EntityValueDatetime
{
    protected function validarFormato($formato = null)
    {
        return (is_string($formato) && !empty($formato)) ?: self::DATE_FORMAT;
    }

    protected function validarFormatoBr($formato = null)
    {
        return (is_string($formato) && !empty($formato)) ?: self::DATE_FORMAT_BR;
    }

    /**
     * @param string $valor
     * @param null $formato
     * @return \DateTime|false
     */
    protected function convert(string $valor, $formato = null)
    {
        $formato = $this->validarFormato($formato);
        $data    = \DateTime::createFromFormat($formato, $valor);
        if (!Validator::date()->validate($data)) {
            throw new \InvalidArgumentException(sprintf('<%s>[%s] não permite o valor <%s> no formato <%s>.', static::class, (new \ReflectionClass($this))->getShortName(),$valor, $formato));
        }
        return $data;
    }
}