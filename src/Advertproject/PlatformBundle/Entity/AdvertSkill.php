<?php

namespace Advertproject\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdvertSkill
 *
 * @ORM\Table(name="advert_skill")
 * @ORM\Entity(repositoryClass="Advertproject\PlatformBundle\Entity\AdvertSkillRepository")
 */
class AdvertSkill
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
     * @ORM\Column(name="level", type="string", length=255)
     */
    private $level;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="Advertproject\PlatformBundle\Entity\Advert", inversedBy="AdvertSkill")
     *@ORM\JoinColumn(nullable=false)
     */
    private $advert;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="Advertproject\PlatformBundle\Entity\Skill")
     * @ORM\JoinColumn(nullable=false)
     */
    private $skill;

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
     * Set level
     *
     * @param string $level
     * @return AdvertSkill
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return string 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set advert
     *
     * @param \Advertproject\PlatformBundle\Entity\Advert $advert
     * @return AdvertSkill
     */
    public function setAdvert(\Advertproject\PlatformBundle\Entity\Advert $advert)
    {
        $this->advert = $advert;

        return $this;
    }

    /**
     * Get advert
     *
     * @return \Advertproject\PlatformBundle\Entity\Advert 
     */
    public function getAdvert()
    {
        return $this->advert;
    }

    /**
     * Set skill
     *
     * @param \Advertproject\PlatformBundle\Entity\Skill $skill
     * @return AdvertSkill
     */
    public function setSkill(\Advertproject\PlatformBundle\Entity\Skill $skill)
    {
        $this->skill = $skill;

        return $this;
    }

    /**
     * Get skill
     *
     * @return \Advertproject\PlatformBundle\Entity\Skill 
     */
    public function getSkill()
    {
        return $this->skill;
    }
}
