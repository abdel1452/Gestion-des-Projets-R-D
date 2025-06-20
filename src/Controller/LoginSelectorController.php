<?php
// src/Controller/LoginSelectorController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginSelectorController extends AbstractController
{
    #[Route('/choose-login', name: 'choose_login')]
    public function index(): Response
    {
        return $this->render('security/select_login.html.twig');
    }
}
