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


class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('companyName', 'text')
            ->add('email', 'email', array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
            ->add('phone', 'text')
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'form.password'),
                'second_options' => array('label' => 'form.password_confirmation'),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
            ->add('details', 'textarea')
            ->add('image',   new \Advertproject\PlatformBundle\Form\ImageType(), array('required' => false))
            ->add('type', 'choice', array(
                'choices' =>  \Advertproject\UserBundle\Tools\Constant::getTypeList(),
                'required' => true,
                'expanded' => true,
                'multiple' => false,
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Advertproject\UserBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'advertproject_userbundle_registration';
    }
} 