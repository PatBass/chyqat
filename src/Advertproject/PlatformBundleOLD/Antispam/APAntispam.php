<?php
/**
 * Created by PhpStorm.
 * User: Patrick
 * Date: 6/9/15
 * Time: 8:26 PM
 */

namespace Advertproject\PlatformBundle\Antispam;


class APAntispam extends \Twig_Extension
{
    private $mailer;
    private $locale;
    private $minLength;

    public function __construct(\Swift_Mailer $mailer, $minLength){
        $this->mailer = $mailer;
        $this->minLength = (int)$minLength;
    }

    public function setLocale($locale)
    {
        $this->locale = $locale;
    }
    /**
     * Vérifie si le text peut être assimilé à un spam ou non
     *
     * @param string $text
     * @return bool
     */
    public function isSpam($text)
    {
        return strlen($text)< $this->minLength;
    }

    public function getFunctions()
    {
        return array(
            "checkIfSpam" => new \Twig_Function_Method($this, 'isSpam')
        );
    }

    public function getName()
    {
        return 'APAntispam';
    }
} 