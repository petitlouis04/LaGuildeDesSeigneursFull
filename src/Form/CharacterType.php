<?php

namespace App\Form;

use App\Entity\Character;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CharacterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('identifier')
            ->add('name')
            ->add('kind')
            ->add('surname')
            ->add('caste')
            ->add('knowledge')
            ->add('intelligence')
            ->add('life')
            ->add('image')
            ->add('created')
            ->add('modified')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Character::class,
        ]);
    }
}
