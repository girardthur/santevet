<?php

namespace BoncoinBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class in charge of managing a search form
 *
 * Class MySearchType
 * @package BoncoinBundle\Form\Type
 */
class MySearchType extends \Symfony\Component\Form\AbstractType
{

    /**
     * Building form method
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'required' => false,
                'label' => 'Titre',
            ))
            ->add('pmin', NumberType::class, array(
                'required' => false,
                'label' => 'Prix min',
            ))
            ->add('pmax', NumberType::class, array(
                'required' => false,
                'label' => 'Prix max',
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Rechercher',
            ));
    }

}
