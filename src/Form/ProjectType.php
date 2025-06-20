<?php
namespace App\Form;

use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du projet',
                'attr' => [
                    'placeholder' => 'Entrez le nom du projet',
                    'class' => 'form-control',
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Décrivez le projet',
                    'class' => 'form-control',
                    'rows' => 5,
                ],
            ])
            ->add('prodUrl', UrlType::class, [
                'label' => 'Lien de Production',
                'required' => false,
                 'empty_data' => null,
                'attr' => [
                    'placeholder' => 'https://exemple.com',
                    'class' => 'form-control',
                     'default_protocol' => 'https'
                ],
            ])
            ->add('preprodUrl', UrlType::class, [
                'label' => 'Lien de Pré-Production',
                'required' => false,
                 'empty_data' => null,
                'attr' => [
                    'placeholder' => 'http://exemple-preprod.com',
                    'class' => 'form-control',
                     'default_protocol' => 'http'
                ],
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'Image',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
