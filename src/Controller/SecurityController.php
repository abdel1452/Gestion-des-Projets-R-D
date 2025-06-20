<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/admin/login', name: 'admin_login')]   
    public function login(AuthenticationUtils $authUtils): Response
    {
    return $this->render('security/login.html.twig', [
        'last_username' => $authUtils->getLastUsername(),
        'error' => $authUtils->getLastAuthenticationError(),
    ]);
}   


    #[Route('/admin/logout', name: 'admin_logout')]
    public function adminLogout(): void
    {
        // Symfony intercepte cette route, rien à faire ici
        throw new \LogicException('Cette méthode est interceptée par le firewall.');
    }

    #[Route('/user/login', name: 'user_login', methods: ['GET', 'POST'])]
    public function userLogin(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/user_login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/user/logout', name: 'user_logout')]
    public function userLogout(): void
    {
        throw new \LogicException('Cette méthode est interceptée par le firewall.');
    }
}
