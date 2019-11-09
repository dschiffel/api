<?php

namespace App\Form;

use App\DTO\DeployAttributeDTO;
use App\DTO\DeployDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeployType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('environment')
            ->add('deployAttributes', CollectionType::class, ['entry_type' => DeployAttributeType::class]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DeployDTO::class,
        ]);
    }
}
