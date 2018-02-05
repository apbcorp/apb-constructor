<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Role
 * @package CoreBundle\Entity
 * @ORM\Table(name="token")
 */
class Token
{
    /**
     * @var int
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var string
     * @ORM\Column(name="token", type="string", nullable=false)
     */
    private $token;

    /**
     * @var \DateTime
     * @ORM\Column(name="expiration_date", type="datetime", nullable=false)
     */
    private $expirationDate;
    
    public function getUser() : User
    {
        return $this->user;
    }
    
    public function setUser(User $user) : Token
    {
        $this->user = $user;

        return $this;
    }
    
    public function getToken() : string
    {
        return $this->token;
    }
    
    public function setToken(string $token) : Token
    {
        $this->token = $token;

        return $this;
    }
    
    public function getExpirationDate() : \DateTime
    {
        return $this->expirationDate;
    }
    
    public function setExpirationDate(\DateTime $expired) : Token
    {
        $this->expirationDate = $expired;

        return $this;
    }
}