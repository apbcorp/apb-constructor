<?php

namespace CoreBundle\Entity;

/**
 * Class RolePermission
 * @package CoreBundle\Entity
 * @ORM\Table(name="role_permission")
 */
class RolePermission extends Permission
{
    /**
     * @var string
     * @ORM\Column(name="role_id", type="integer", nullable=false)
     */
    protected $ownerId;
}