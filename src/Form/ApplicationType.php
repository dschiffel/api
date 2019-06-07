<?php

namespace App\Form;

use App\DTO\ApplicationDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicationType extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add(
                'environments',
                CollectionType::class,
                [
                    'entry_type' => EnvironmentType::class,
                    'allow_add' => true,
                    'by_reference' => false,
                ]
            )
            ->add(
                'attributes',
                CollectionType::class,
                [
                    'entry_type' => AttributeType::class,
                    'allow_add' => true,
                    'by_reference' => false,
                ]
            );
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ApplicationDTO::class,
        ]);
    }
}
