<?php


namespace Potara\Core\Crud\tests;

use Potara\Core\Crud\AbstractEntity;
use Potara\Core\Crud\HelperEntity;

class EntitySample extends AbstractEntity
{
    /**
     * @toPHP integer
     * @toDB integer
     */
    public $id;
    /**
     * @toPHP string
     * @toDB string
     */
    public $name;
    /**
     * @toPHP Datetime
     * @toDB string
     */
    public $date;
    public $money;
    /**
     * @toPHP array
     * @toDB serialize
     */
    public $serialize;
    /**
     * @toPHP bolean
     * @toDB integer
     */
    public $status;

    public function __construct($data = [])
    {
        parent::__construct($data);
    }

    public function convertToPhpValue(): AbstractEntity
    {
        $reflector = new \ReflectionClass($this);
        $docId     = $reflector->getProperty('id')->getDocComment();
        var_dump($this->convertDocToActons($docId));
        die;
        $this->id = (int)$this->id;
        HelperEntity::convertStringToDateTime($this->date);
        $this->serialize = unserialize($this->serialize);
        $this->status    = (bool)$this->status;
        return $this;
    }

    protected function convertDocToActons($doc)
    {
        $pattern = "#(@[a-zA-Z]+\s*[a-zA-Z0-9, ()_].*)#";
        preg_match_all($pattern, $doc, $matches, PREG_PATTERN_ORDER);
        $roles = array_reduce($matches[1], function ($result, $doc) {
            $patternRole = "#@to([a-zA-Z]+)\s([a-zA-Z0-9, ()_].*)#";
            preg_match_all($patternRole, $doc, $roleMatches, PREG_PATTERN_ORDER);

            $roleTo    = current($roleMatches[1]);
            $roleValue = current($roleMatches[2]);
            if (!empty($roleValue)) {
                $result[strtolower($roleTo)] = explode(",", $roleValue);
            }
            return $result;
        }, []);

    }

}
