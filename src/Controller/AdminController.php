<?php
// src/Controller/AdminController.php
namespace App\Controller;

use App\Entity\Register;
use App\Form\AdminCreationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminController extends AbstractController
{
    #[Route('/admin/create', name: 'admin_create')]
    public function create(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_ADMIN'); // Seuls les admins peuvent créer un autre admin

        $user = new Register();
        $form = $this->createForm(AdminCreationType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles(['ROLE_ADMIN']); // Forcer le rôle admin
            $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Administrateur créé avec succès.');
            return $this->redirectToRoute('project_index');
        }

        return $this->render('security/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
