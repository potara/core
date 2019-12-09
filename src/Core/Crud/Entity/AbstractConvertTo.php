<?php


namespace Potara\Core\Crud\Entity;


use Potara\Core\Crud\AbstractEntity;

class AbstractConvertTo
{
    protected $entity;
    protected $options;

    public function __construct(AbstractEntity &$entity, &$options = [])
    {
        $this->entity  = $entity;
        $this->options = $options;
    }

    /**
     * @param array $default
     * @param array $options
     * @return array
     */
    protected function factoryOptions($default = [], $options = []): array
    {
        if (empty($default) && empty($options)) {
            return [];
        }
        if (empty($options)) {
            return $default;
        }
        return array_merge($options, $default);
    }
}
