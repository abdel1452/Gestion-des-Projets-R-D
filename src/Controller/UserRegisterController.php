<?php
// src/Controller/UserRegisterController.php
namespace App\Controller;

use App\Entity\Register;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserRegisterController extends AbstractController
{
    #[Route('/user/register', name: 'user_register')]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $em): Response
    {
        $user = new Register();

        // Création et traitement du formulaire
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        // Debug pour voir ce que contient le formulaire à la soumission
        if ($form->isSubmitted()) {
           
        }

        // Si formulaire valide, on hash le mot de passe et on sauvegarde
        if ($form->isSubmitted() && $form->isValid()) {
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $form->get('plainPassword')->getData()
            );
            $user->setPassword($hashedPassword);

            $em->persist($user);
            $em->flush();

            // Redirection vers la page de connexion utilisateur
            return $this->redirectToRoute('user_login');
        }

        // Affichage du formulaire
        return $this->render('security/user_register.html.twig', [
            'RegistrationForm' => $form->createView(),
        ]);
    }
}
