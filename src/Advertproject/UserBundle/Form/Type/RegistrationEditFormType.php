<?php
/**
 * Created by PhpStorm.
 * User: Patrick
 * Date: 9/4/15
 * Time: 3:11 PM
 */

namespace Advertproject\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class RegistrationEditFormType extends AbstractType
{

    public function getName()
    {
        return 'advertproject_userbundle_registration_edit';
    }

    public function getParent()
    {
        return new RegistrationFormType();
    }
} 