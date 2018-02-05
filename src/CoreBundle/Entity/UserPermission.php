<?php

namespace CoreBundle\Entity;

/**
 * Class UserPermission
 * @package CoreBundle\Entity
 * @ORM\Table(name="user_permission")
 */
class UserPermission extends Permission
{
    /**
     * @var string
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    protected $ownerId;
}