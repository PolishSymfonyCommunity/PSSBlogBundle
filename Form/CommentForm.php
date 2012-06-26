<?php

namespace PSS\Bundle\BlogBundle\Form;


// Symfony/Doctrine internal
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;


// Specific


// Domain objects


// Entities




class CommentForm extends AbstractType
{
    const DATA_CLASS = 'PSS\Bundle\BlogBundle\Entity\Comment';

    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('authorName', 'text')
            ->add('authorUrl', 'text')
            ->add('authorEmail', 'text')
            ->add('contentt', 'text')
            ->add('post', 'text');
    }


    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class'=> self::DATA_CLASS,
            'csrf_field_name' => '_comment_intent'
        );
    }


    public function getName()
    {
        return 'wordpress_comment_form';
    }
}