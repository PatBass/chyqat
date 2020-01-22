<?php

namespace Advertproject\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Advertproject\PlatformBundle\Validator\Antiflood;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Advert
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="advert")
 * @ORM\Entity(repositoryClass="Advertproject\PlatformBundle\Entity\AdvertRepository")
 * @UniqueEntity(fields="title", message="Il existe déjà un titre avec ce nom")
 */
class Advert
{
    /**
     * @var
     * @ORM\OneToMany(targetEntity="Advertproject\PlatformBundle\Entity\AdvertSkill", mappedBy="Advert")
     */
    private $advertSkill;

    /**
     * @var
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @var int
     * @ORM\Column(name="nb_applications", type="integer")
     */
    private $nbApllications = 0;

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var
     * @ORM\ManyToMany(targetEntity="Advertproject\PlatformBundle\Entity\Category", cascade={"persist"})
     */
    private $categories;

    /**
     * @var
     * @Assert\Valid()
     * @ORM\OneToMany(targetEntity="Advertproject\PlatformBundle\Entity\Application", mappedBy="advert")
     */
    private $applications;

    /**
     * @Assert\Valid()
     * @ORM\OneToOne(targetEntity="Advertproject\PlatformBundle\Entity\Image", cascade={"persist", "remove"})
     */
    private $image;

    /**
     * @var
     * @ORM\Column(name="published", type="boolean")
     */
    private $published = true;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min=5)
     * @ORM\Column(name="title", type="string", length=255, unique=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255, nullable=true)
     */
    private $author;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min=30)
     * @ORM\Column(name="content", type="string", length=255)
     */
    private $content;

    public function __construct()
    {
        //Par défaut, la date de l'annonce est la date d'aujourd'hui
        $this->date = new \Datetime();
        $this->categories = new ArrayCollection();
        $this->applications = new ArrayCollection();
    }

    /**
     * @ORM\PreUpdate
     */
    public function updateDate()
    {
        $this->setUpdatedAt(new \Datetime());
    }

    public function increaseNbApplications()
    {
        $this->nbApllications++;
    }

    public function decreaseNbApplications()
    {
        $this->nbApllications--;
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
     * Set date
     *
     * @param \DateTime $date
     * @return Advert
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Advert
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return Advert
     */
    public function setAuthor($author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Advert
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set published
     *
     * @param boolean $published
     * @return Advert
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean 
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set image
     *
     * @param Image $image
     * @return Advert
     */
    public function setImage(Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \Advertproject\PlatformBundle\Entity\Image 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Add category
     *
     * @param \Advertproject\PlatformBundle\Entity\Category $category
     * @return Advert
     */
    public function addCategory(\Advertproject\PlatformBundle\Entity\Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param \Advertproject\PlatformBundle\Entity\Category $categories
     */
    public function removeCategory(\Advertproject\PlatformBundle\Entity\Category $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Add applications
     *
     * @param \Advertproject\PlatformBundle\Entity\Application $applications
     * @return Advert
     */
    public function addApplication(\Advertproject\PlatformBundle\Entity\Application $applications)
    {
        $this->applications[] = $applications;

        $applications->setAdvert($this);

        return $this;
    }

    /**
     * Remove applications
     *
     * @param \Advertproject\PlatformBundle\Entity\Application $applications
     */
    public function removeApplication(\Advertproject\PlatformBundle\Entity\Application $applications)
    {
        $this->applications->removeElement($applications);
    }

    /**
     * Get applications
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getApplications()
    {
        return $this->applications;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Advert
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Advert
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set nbApllications
     *
     * @param integer $nbApllications
     * @return Advert
     */
    public function setNbApllications($nbApllications)
    {
        $this->nbApllications = $nbApllications;

        return $this;
    }

    /**
     * Get nbApllications
     *
     * @return integer 
     */
    public function getNbApllications()
    {
        return $this->nbApllications;
    }

    /**
     * @param ExecutionContextInterface $context
     * @Assert\Callback
     */
    public function isContentValid(ExecutionContextInterface $context)
    {
        $forbidenWords = array('échec', 'abandon');

        if(preg_match('#'.implode("|", $forbidenWords).'#', $this->getContent())){
            $context
                ->buildViolation('Contenu invalide car il contient un mot interdit')
                ->atPath('content')
                ->addViolation()
            ;
        }
    }

    /**
     * Add advertSkill
     *
     * @param \Advertproject\PlatformBundle\Entity\AdvertSkill $advertSkill
     * @return Advert
     */
    public function addAdvertSkill(\Advertproject\PlatformBundle\Entity\AdvertSkill $advertSkill)
    {
        $this->advertSkill[] = $advertSkill;

        return $this;
    }

    /**
     * Remove advertSkill
     *
     * @param \Advertproject\PlatformBundle\Entity\AdvertSkill $advertSkill
     */
    public function removeAdvertSkill(\Advertproject\PlatformBundle\Entity\AdvertSkill $advertSkill)
    {
        $this->advertSkill->removeElement($advertSkill);
    }

    /**
     * Get advertSkill
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAdvertSkill()
    {
        return $this->advertSkill;
    }
}
