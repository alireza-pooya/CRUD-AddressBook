<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressBookFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName',TextType::class, [
                'attr' => [
                    'placeholder' => 'please enter your First Name',
                    'class' => 'form-control'
                ], 'label' => 'First Name'
            ])
            ->add('lastName',TextType::class, [
                'attr' => [
                    'placeholder' => 'please enter your Last Name',
                    'class' => 'form-control'
                ], 'label' => 'Last Name'
            ])
            ->add('email',TextType::class, [
                'attr' => [
                    'placeholder' => 'please enter your Email',
                    'class' => 'form-control'
                ], 'label' => 'Email'
            ])
            ->add('streetAndNumber',TextareaType::class, [
                'attr' => [
                    'placeholder' => 'please enter your Street And Number',
                    'class' => 'form-control'
                ], 'label' => 'Street And Number'
            ])
            ->add('zip',TextType::class, [
                'attr' => [
                    'placeholder' => 'please enter your Zip',
                    'class' => 'form-control'
                ], 'label' => 'Zip'
            ])
            ->add('city',TextType::class, [
                'attr' => [
                    'placeholder' => 'please enter your City',
                    'class' => 'form-control'
                ], 'label' => 'City'
            ])
            ->add('country',TextType::class, [
                'attr' => [
                    'placeholder' => 'please enter your Country',
                    'class' => 'form-control'
                ], 'label' => 'Country'
            ])
            ->add('phoneNumber',TextType::class, [
                'attr' => [
                    'placeholder' => 'please enter your Phone Number',
                    'class' => 'form-control'
                ], 'label' => 'Phone Number'
            ])
            ->add('birthday',DateType::class, [
                'attr' => [
                    'placeholder' => 'please enter your Birthday',
                    'class' => 'form-control'
                ], 'label' => 'Birthday'
            ])
            ->add('image',FileType::class, [
                'attr' => [
                    'class' => 'form-control',
                ], 'label' => 'Picture',
                    'mapped'=> false
            ])
            ->add('Submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success mt-3'
                ]
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\AddressBook'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_addressbook';
    }

}
