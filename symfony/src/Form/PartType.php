<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PartType extends AbstractType
{
    // через компонент $builder ми будуємо нашу форму
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name',
                'attr' => [
                    'placeholder' => 'Part name',
                    'pattern' => false // щоб подавити валідацію в браузері
                ]
            ])
            ->add('price', IntegerType::class, [
                'label' => 'Price',
                'attr' => [
                    'placeholder' => 'Price',
                    'pattern' => false
                ]
            ]);
        /*
         * Коли нам треба відобразити вибір іншої зв'язаної сутності, використовується спеціальний тип поля "EntityType:class".
         * Це відсилка і прив'язка до ORM. Приклад:
         *
         *   ->add('author', EntityType::class, [
         *       'class' => Author::class,
         *       'query_builder' => function (EntityRepository $er): QueryBuilder {
         *           return $er->createQueryBuilder('a')
         *               ->orderBy('a.id')
         *               ->setMaxResults(15); // лімітую список авторів 15-ма за для прикладу
         *       },
         *       'choice_label' => 'fullName',
         *       'placeholder' => 'Choose book author'
         *   ])
         *
         * */
    }
}