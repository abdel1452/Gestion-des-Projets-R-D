<?php
namespace App\Form;

use App\Entity\Register;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\{TextType, PasswordType};
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminCreationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class)
            ->add('password', PasswordType::class); // Plus d’email demandé
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Register::class,
        ]);
    }
}
