<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\LegalStatus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('SIREN')
            ->add('registrationCity')
//            ->add('registrationDate', DateType::class, [
//                'widget' => 'single_text',
//                'attr' => ['class' => 'js-datepicker'],
//                'html5' => false,
//            ])
            ->add('registrationDate', DateTimeType::class, [
                'placeholder' => 'Select a value',
            ])
            ->add('Capital')
            ->add(
                'legalStatus',
                EntityType::class,
                array(
                    'class' => LegalStatus::class,
                    'choice_label' => 'status',
                    'mapped' => true
                )
            )
            ->add('Address', CollectionType::class, [
                'entry_type' => AddressType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
//                'required'=>false,
                'entry_options' => [
                    'attr' => ['class' => 'email-box'],
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
