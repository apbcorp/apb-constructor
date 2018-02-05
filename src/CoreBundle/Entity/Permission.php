<?php

namespace CoreBundle\Entity;


abstract class Permission
{
    const PERMISSION_NONE       = 0;
    const PERMISSION_SELF       = 1;
    const PERMISSION_EXPRESSION = 2;
    const PERMISSION_ALL        = 3;

    const PERMISSION_FIELD = 'p';
    const EXPRESSION_FIELD = 'e';
    
    protected $ownerId;

    /**
     * @var string
     * @ORM\Column(name="table", type="string", nullable=false)
     */
    protected $table;

    /**
     * @var int
     * @ORM\Column(name="table_permission", type="integer", nullable=false)
     */
    protected $tablePermission;

    /**
     * @var int
     * @ORM\Column(name="field_permission", type="json", nullable=false)
     */
    protected $fieldsPermission;

    public function setOwnerId(int $ownerId) : Permission
    {
        $this->ownerId = $ownerId;

        return $this;
    }

    public function getOwnetId() : int
    {
        return $this->ownerId;
    }

    public function getTable() : string
    {
        return $this->table;
    }

    public function setTable(string $table) : Permission
    {
        $this->table = $table;

        return $this;
    }

    public function getTablePermission() : int
    {
        return $this->tablePermission;
    }

    public function setTablePermission(int $permission) : Permission
    {
        $this->tablePermission = $permission;

        return $this;
    }

    public function getFieldPermission(string $field) : int
    {
        if (isset($this->fieldsPermission[$field])) {
            return $this->fieldsPermission[$field][self::PERMISSION_FIELD];
        }

        return self::PERMISSION_NONE;
    }

    public function getFieldReadPermission(string $field) : int
    {
        return ($this->getFieldPermission($field) - $this->getFieldWritePermission($field)) / 4;
    }

    public function getFieldWritePermission(string $field) : int
    {
        return $this->getFieldPermission($field) % 4;
    }

    public function getFieldExpression(string $field) : string
    {
        if (isset($this->fieldsPermission[$field])) {
            return $this->fieldsPermission[$field][self::EXPRESSION_FIELD];
        }

        return '';
    }

    public function setFieldPermission(string $field, int $permission) : Permission
    {
        $this->checkField($field);

        $this->fieldsPermission[$field][self::PERMISSION_NONE] = $permission;

        return $this;
    }

    public function setFieldDetailPermission(string $field, int $read, int $write): Permission
    {
        $this->checkField($field);

        $this->fieldsPermission[$field][self::PERMISSION_NONE] = ($read * 4) + $write;

        return $this;
    }

    public function setFieldExpression(string $field, string $expression) : Permission
    {
        $this->checkField($field);

        $this->fieldsPermission[$field][self::EXPRESSION_FIELD] = $expression;

        return $this;
    }

    protected function checkField(string $field) : void
    {
        if (!isset($this->fieldsPermission[$field])) {
            $this->fieldsPermission[$field] = [self::PERMISSION_FIELD => self::PERMISSION_NONE, self::EXPRESSION_FIELD => ''];
        }
    }
}