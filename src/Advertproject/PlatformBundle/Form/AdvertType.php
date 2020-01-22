<?php

namespace Advertproject\PlatformBundle\Form;

use Advertproject\PlatformBundle\Entity\AdvertRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdvertType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',       'text')
            ->add('content',     'ckeditor')
            ->add('image',        new ImageType(), array('required' => false))
            ->add('categories',  'entity', array(
                'class'       => 'APPlatformBundle:Category',
                'property'    => 'name',
                'multiple'    => true,
                'expanded'    => false

            ))

        ;

        $builder
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                function(FormEvent $event){
                    $advert = $event->getData();
                    if(null === $advert)
                    {
                        return;
                    }
                    if(!$advert->getPublished() || null === $advert->getId())
                    {
                        $event->getForm()->add('published', 'checkbox', array('required' => false));
                    }else{
                        $event->getForm()->remove('published');
                    }
                }
            );
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Advertproject\PlatformBundle\Entity\Advert'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'advertproject_platformbundle_advert';
    }
}
