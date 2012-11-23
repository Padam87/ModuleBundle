<?php

namespace Padam87\ModuleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="module")
 */
class Module
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=100)
     * @var string
     */
	protected $name;
    
    /**
     * @ORM\Column(type="boolean")
     * @var boolean 
     */
	protected $active;
	
	public function __toString()
	{
		return $this->getName();
	}

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set is_active
     *
     * @param boolean $isActive
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * Get is_active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }
}