<?php
// src/Controller/TestController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProjectRepository;  // <-- Importer le repository

class TestController extends AbstractController
{
    #[Route('/project', name: 'project_index')]
    public function index(ProjectRepository $projectRepository): Response
    {
        // Récupérer tous les projets
        $projects = $projectRepository->findAll();

        // Passer la variable projects à la vue
        return $this->render('project/index.html.twig', [
            'projects' => $projects,
        ]);
    }
}
