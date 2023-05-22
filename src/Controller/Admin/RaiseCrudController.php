<?php

namespace App\Controller\Admin;

use App\Entity\Raise;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RaiseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Raise::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
