<?php

namespace Advertproject\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Votant
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Advertproject\PlatformBundle\Entity\VotantRepository")
 */
class Votant
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var bool
     *
     * @ORM\Column(name="has_voted", type="boolean")
     */
    private $hasVoted = false;
    
    /**
     * 
     *
     * @ORM\ManyToOne(targetEntity="Advertproject\PlatformBundle\Entity\Choix", inversedBy="votants")
     */
    private $choix;


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
     * @return Votant
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
     * Set choix
     *
     * @param \Advertproject\PlatformBundle\Entity\Choix $choix
     * @return Votant
     */
    public function setChoix(\Advertproject\PlatformBundle\Entity\Choix $choix = null)
    {
        $this->choix = $choix;

        return $this;
    }

    /**
     * Get choix
     *
     * @return \Advertproject\PlatformBundle\Entity\Choix 
     */
    public function getChoix()
    {
        return $this->choix;
    }

    /**
     * Set hasVoted
     *
     * @param boolean $hasVoted
     * @return Votant
     */
    public function setHasVoted($hasVoted)
    {
        $this->hasVoted = $hasVoted;

        return $this;
    }

    /**
     * Get hasVoted
     *
     * @return boolean 
     */
    public function getHasVoted()
    {
        return $this->hasVoted;
    }
}
