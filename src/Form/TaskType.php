<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function  buildform(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class, [
                'label'    => 'Title',
                'required' => true,
            ])
            ->add('description',TextareaType::class, [
                'label'    => 'Description',
                'required' => true,
            ])
            ->add('draft',CheckboxType::class, [
                'label'    => 'draft ',
                'required' => true,
            ])->add('save', SubmitType::class, ['label' => 'Soumettre'])
        ;
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault("data_class", Task::class);
    }
}