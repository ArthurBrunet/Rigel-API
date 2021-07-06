<?php


namespace App\Admin;


use App\Entity\TypeCompany;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class CompanyAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add("name", TextType::class)
            ->add("description", TextType::class)
            ->add("type", EntityType::class, [
                'class' => TypeCompany::class,
                'choice_label' => function($category) {
                    return $category->getName();
                }
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add("type");
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier("name")
            ->addIdentifier("description")
            ->addIdentifier("type");
    }
}