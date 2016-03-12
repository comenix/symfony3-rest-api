<?php

namespace Hip\Content\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Exception\AccessException;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ContentType
 *
 * Generated with "app/console doctrine:generate:form HipAppBundle:Content" (and then moved to Type folder)
 *
 * @package Hip\Content\Form
 */
class ContentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('body', TextType::class)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     *
     * @throws AccessException
     */
    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Hip\AppBundle\Entity\Content'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Hip_AppBundle_content';
    }
}
