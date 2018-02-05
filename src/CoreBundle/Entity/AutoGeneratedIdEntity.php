<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

abstract class AutoGeneratedIdEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;
    
    public function getId() : int
    {
        return $this->id;
    }
}