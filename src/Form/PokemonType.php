<?php

// src/Form/PokemonType.php
namespace App\Form;

use App\Entity\Pokemon;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PokemonType extends AbstractType
{
    private $jsonArrayTransformer;

    public function __construct(JsonArrayTransformer $jsonArrayTransformer)
    {
        $this->jsonArrayTransformer = $jsonArrayTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('type', TextareaType::class, [
                'attr' => ['rows' => 5],
            ])
            ->add('abilities', TextareaType::class, [
                'attr' => ['rows' => 5],
            ])
            ->add('moves', TextareaType::class, [
                'attr' => ['rows' => 5],
            ])
            ->add('sprite');

        // Add data transformers
        $builder->get('type')->addModelTransformer($this->jsonArrayTransformer);
        $builder->get('abilities')->addModelTransformer($this->jsonArrayTransformer);
        $builder->get('moves')->addModelTransformer($this->jsonArrayTransformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pokemon::class,
        ]);
    }
}
