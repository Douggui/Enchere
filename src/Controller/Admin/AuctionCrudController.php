<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Field\TranslationField;
use App\Controller\Admin\Fields\TranslationField as FieldsTranslationField;
use App\Entity\Auction;
use App\Enum\AuctionStatus;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AuctionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Auction::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setFormThemes(
                [
                    '@A2lixTranslationForm/bootstrap_5_layout.html.twig',
                    '@EasyAdmin/crud/form_theme.html.twig',
                ]
            );
    }
    
    public function configureFields(string $pageName): iterable
    {
        $fieldsConfig = [
            'description' => [
                'field_type' => TextareaType::class,
                'required' => true,
                'label' => 'description'
            ],
            'title' => [
                'field_type' => TextType::class,
                'required' => true,
                'label' => 'tit'
            ]
        ];
      
            
            return [
                FieldsTranslationField::new('translations', 'Traduction', $fieldsConfig)
                ->setRequired(true)
                ->hideOnIndex(),
                // TextField::new('title')->hideWhenUpdating(),
                // TextEditorField::new('description'),
                MoneyField::new('price')->setCurrency('EUR'),
                ImageField::new('image')->hideWhenUpdating()
                ->setBasePath('uploads/')
                ->setUploadDir('public/uploads/')
                ->setUploadedFileNamePattern('[slug]-[contenthash].[extension]'),
                DateField::new('dateOpen'),
                DateField::new('dateClose'),
                ChoiceField::new('status')
                ->setFormType(EnumType::class)
                ->setFormTypeOptions([
                  'class' => AuctionStatus::class,
                  'choices' => AuctionStatus::cases()
                ]),
                TextField::new('slug'),
                //SlugField::new('slug')->setTargetFieldName('title')->hideWhenUpdating(),
            ];
        }
        
        
    
}