<?php


namespace App\Admin;


use App\Entity\Canal;
use App\Entity\Company;
use App\Entity\TypeCompany;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\BooleanType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class UserAdmin extends AbstractAdmin
{

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->remove("create");
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add("email", EmailType::class)
            ->add("name", TextType::class)
            ->add("firstname", TextType::class)
            ->add("drink", TextType::class)
            ->add("isEnable", BooleanType::class)
            ->add("isVisible", BooleanType::class)
            ->add("phoneNumber", TextType::class)
            ->add("competence", TextType::class)
            ->add("canals", EntityType::class, [
                'class' => Canal::class,
                'choice_label' => function($category) {
                    return $category->getName();
                }
            ])
            ->add("company", EntityType::class, [
            'class' => Company::class,
            'choice_label' => function($category) {
                return $category->getName();
                }
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add("name")
            ->add("email")
            ->add("isEnable")
            ->add("isVisible")
            ->add("phoneNumber")
            ->add("competence");
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier("name")
            ->addIdentifier("email")
            ->addIdentifier("competence");
    }

    protected function configureShowFields(ShowMapper $show)
    {
        $show
            ->add("email", EmailType::class)
            ->add("name", TextType::class)
            ->add("firstname", TextType::class)
            ->add("drink", TextType::class)
            ->add("isEnable", BooleanType::class)
            ->add("isVisible", BooleanType::class)
            ->add("phoneNumber", TextType::class)
            ->add("competence", TextType::class);
    }
}