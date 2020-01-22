<?php
/**
 * Created by PhpStorm.
 * User: Patrick
 * Date: 11/30/15
 * Time: 11:58 AM
 */

namespace Advertproject\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Tests\Validator\Constraints as PasswordValidation;



/**
 *
 * Class Contact
 * @ORM\Table(name="contact")
 * @package Advertproject\PlatformBundle\Entity
 * @ORM\Entity()
 */
class Contact
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="email", type="string", length=100)
     *@Assert\NotBlank(message="Veuillez fournir une adresse email")
     * @Assert\Length(max=100)
     */
    protected $email;

    /**
     * @var string
     * @Assert\NotBlank(message="Veuillez fournir votre nom ou celui de la société")
     * @ORM\Column(name="name", type="string", length=100)
     */
    protected $name;

    /**
     * @var string
     * @Assert\NotBlank(message="Veuillez saisir un message contenant au moins 50 caractères")
     * @Assert\Length(max=1000)
     * @ORM\Column(name="message", type="string")
     */
    protected $message;

    /**
     * @var \DateTime
     * @ORM\Column(name="date", type="datetime")
     */
    protected $date;

    public function __construct()
    {
        $this->date = new \Datetime();
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Contact
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Contact
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
     * Set message
     *
     * @param string $message
     * @return Contact
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Contact
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
