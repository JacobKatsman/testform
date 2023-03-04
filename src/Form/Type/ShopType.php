<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ShopType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('productPrice', ChoiceType::class, [
                              'label' => 'продукты:',
                              'choices'  => [
                                    'наушники (100 евро)' => 100,
                                    'чехол для телефона (20евро)' => 200 ]
                     ])
                ->add(
                    'taxnumber',
                    TextType::class,
                    ['label' => 'введите Ваш код:']
                )
                ->add('submit', SubmitType::class);
    }
}
