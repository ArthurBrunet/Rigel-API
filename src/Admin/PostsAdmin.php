<?php


namespace App\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\MediaBundle\Form\Type\MediaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class PostsAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add("title",TextType::class)
            ->add("content",TextType::class)
            ->add("datePost",DateTimeType::class)
            ->add('media', MediaType::class, array(
                'provider' => 'sonata.media.provider.image',
                'context'  => 'default'
            ));
            ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add("title");
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier("title")
            ->addIdentifier("datePost");
    }
}