<?php


namespace App\Admin;


use App\Entity\Canal;
use App\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class MessageAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add("text", TextType::class)
            ->add("created_by",EntityType::class, [
                'class' => User::class,
                'choice_label' => function($category) {
                    return $category->getUsername();
                }
            ])
            ->add("canal", EntityType::class, [
                'class' => Canal::class,
                'choice_label' => function($category) {
                    return $category->getName();
                }
            ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add("text")
            ->add("created_by");
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier("text")
            ->addIdentifier("created_by");
    }
}