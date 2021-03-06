<?php

namespace Advertproject\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Choix
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Advertproject\PlatformBundle\Entity\ChoixRepository")
 */
class Choix
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
     * @ORM\Column(name="proposition", type="string", length=255)
     */
    private $proposition;

    /**
     * @var integer
     *
     * @ORM\Column(name="count", type="float")
     */
    private $count = 0;

    /**
     * 
     *
     * @ORM\OneToMany(targetEntity="Advertproject\PlatformBundle\Entity\Votant", mappedBy="choix")
     */
    private $votants;
    
    public function __construct()
    {
        $this->votants = new ArrayCollection();
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
     * Set proposition
     *
     * @param string $proposition
     * @return Choix
     */
    public function setProposition($proposition)
    {
        $this->proposition = $proposition;

        return $this;
    }

    /**
     * Get proposition
     *
     * @return string 
     */
    public function getProposition()
    {
        return $this->proposition;
    }

    /**
     * Set count
     *
     * @param integer $count
     * @return Choix
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get count
     *
     * @return integer 
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set votant
     *
     * @param string $votant
     * @return Choix
     */
    public function setVotant($votant)
    {
        $this->votant = $votant;

        return $this;
    }

    /**
     * Get votant
     *
     * @return string 
     */
    public function getVotant()
    {
        return $this->votant;
    }
    
    public function __toString() 
    {
        return $this->getProposition();
    }

    /**
     * Add votants
     *
     * @param \Advertproject\PlatformBundle\Entity\Votant $votants
     * @return Choix
     */
    public function addVotant(\Advertproject\PlatformBundle\Entity\Votant $votants)
    {
        $this->votants[] = $votants;

        return $this;
    }

    /**
     * Remove votants
     *
     * @param \Advertproject\PlatformBundle\Entity\Votant $votants
     */
    public function removeVotant(\Advertproject\PlatformBundle\Entity\Votant $votants)
    {
        $this->votants->removeElement($votants);
    }

    /**
     * Get votants
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVotants()
    {
        return $this->votants;
    }
}
