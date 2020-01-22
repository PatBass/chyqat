<?php

namespace Advertproject\PlatformBundle\Form;

use Advertproject\PlatformBundle\Entity\AdvertRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdvertEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->remove('date');
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'advertproject_platformbundle_advert_edit';
    }

    public function getParent()
    {
        return new AdvertType();
    }
}
