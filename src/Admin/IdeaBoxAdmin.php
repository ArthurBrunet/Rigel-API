<?php


namespace App\Admin;


use App\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class IdeaBoxAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add("title",TextType::class)
            ->add("description", TextType::class)
            ->add("publicationDate",DateTimeType::class)
            ->add("reaction",TextType::class)
            ->add("idUser",EntityType::class, [
                'class' => User::class,
                'choice_label' => function($category) {
                    return $category->getUsername();
                }
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add("title")
            ->add("publicationDate");
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier("title")
            ->addIdentifier("description")
            ->addIdentifier("publicationDate");
    }
}