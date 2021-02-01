<?php

namespace App\Form;

use App\Entity\Picture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;

class SearchPictureType extends AbstractType
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * SearchPictureType constructor.
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //champ de recherche par mot-clé
            ->add('keyword', SearchType::class, [
                'label' => 'Search',
                'required' => false
            ])
            ->add('orderBy', ChoiceType::class, [
                'choices' => [
                    'Downloads' => 'downloads',
                    'Likes' => 'likes',
                    'Created at' => 'createdAt',
                ]
            ])
            ->add('submit', SubmitType::class, ['label' => 'GO'])

            //les form de recherche sont en GET !
            ->setMethod("GET");
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
