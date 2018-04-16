<?php

namespace App\Admin;

use App\Entity\BlogPost;
use App\Entity\Category;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BlogPostAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab("Content")
                ->with('Content', ['class' => 'col-md-9'])
                    ->add('title', TextType::class)
                    ->add('body', TextareaType::class)
                ->end()
            ->end()

            ->tab("Meta data")
                ->with('Meta data', ['class' => 'col-md-3'])
                    ->add('category', EntityType::class, [
                        'class' => Category::class,
                        'choice_label' => 'name',
                    ])
                ->end()
            ->end()
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('category.name')
            ->add('draft')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title')
            ->add('category', null, [], EntityType::class, [
                'class'    => Category::class,
                'choice_label' => 'name',
            ]);
    }

    public function toString($object)
    {
        return $object instanceof BlogPost
            ? $object->getTitle()
            : 'Blog Post'; // shown in the breadcrumb on the create view
    }
}