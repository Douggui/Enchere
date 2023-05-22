<?php

namespace App\Form;

use App\Entity\Auction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use App\Enum\AuctionStatus;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AuctionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('translations', TranslationsType::class,[
                'label'=>'Traduction',
                'locales' => ['en', 'fr'],   // [1]
                'default_locale' => ['fr'],              // [1]
                'required_locales' => ['fr'],            // [1]
                'fields' => [                               // [2]
                    'description' => [                         // [3.a]
                        'field_type' => TextareaType::class,                // [4]
                        'label' => 'description',                    // [4]
                        'locale_options' => [                  // [3.b]
                            'en' => ['label' => 'description'],    // [4]
                            'fr' => ['label' => 'description']           // [4]
                        ]
                    ],
                    'title' => [                         // [3.a]
                        'field_type' => TextType::class,                // [4]
                        'label' => 'title',                    // [4]
                        'locale_options' => [                  // [3.b]
                            'en' => ['label' => 'title en'],    // [4]
                            'fr' => ['label' => 'titre fr']           // [4]
                        ]
                    ]
                ],
        
            ])
            ->add('price')
            ->add('dateOpen')
            ->add('dateClose')
            ->add('image')
            ->add('status',EnumType::class,[
                'class'=>AuctionStatus::class
            ])
            ->add('slug')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Auction::class,
        ]);
    }
}