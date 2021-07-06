<?php


namespace App\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class TypeCompagnyAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add("name", TextType::class);
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add("name");
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier("name");
    }
}