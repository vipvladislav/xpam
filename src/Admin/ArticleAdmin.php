<?php


namespace App\Admin;

use App\Entity\Article;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ArticleAdmin extends AbstractAdmin
{
    public function toString($object)
    {

        /** @var Article $object */
        return $object->getTitle();
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', TextType::class)
            ->add('content')
            ->add('description')
            ->add('sacraments')
            ->add('categories')
            ->add('image')
            ->add('createdAt', null, [
                'disabled' => true
            ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('title')
            ->add('categories')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier ('id')
            ->add ('title')
            ->add('content')
            ->add('description')
            ->add('sacraments')
            ->add('categories')
            ->add('image')
            ->add('createdAt')



        ;
    }
}