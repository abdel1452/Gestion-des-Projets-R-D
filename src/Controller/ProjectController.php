<?php
// src/Controller/ProjectController.php
namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProjectController extends AbstractController
{
    #[Route('/project', name: 'project_index')]
    public function index(Request $request, ProjectRepository $projectRepository): Response
{
    $readonly = $request->query->get('readonly', false);
    $readonly = $readonly === '1' ? true : false;

    $projects = $projectRepository->findAllOrderedByNameAndDescription();

    return $this->render('project/index.html.twig', [
        'projects' => $projects,
        'readonly' => $readonly,
    ]);
}

    // src/Controller/ProjectController.php

        #[Route('/project/public', name: 'project_public')]
public function publicIndex(ProjectRepository $projectRepository): Response
{
    // Si utilisateur connecté, rediriger vers la page privée
    if ($this->getUser()) {
        return $this->redirectToRoute('project_index');
    }

    $projects = $projectRepository->findAllOrderedByNameAndDescription();

    return $this->render('project/public.html.twig', [
        'projects' => $projects,
    ]);
}

    #[Route('/', name: 'home')]
public function home()
{
    return $this->redirectToRoute('project_public'); // ou 'project_index'
}



    #[Route('/project/new', name: 'project_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageFile')->getData();

            if ($imageFile) {
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move($this->getParameter('images_directory'), $newFilename);
                $project->setImageFilename($newFilename);
            }

            // Assurer que prodUrl et preprodUrl ont bien le bon protocole
            if ($project->getProdUrl()) {
                $url = preg_replace('#^https?://#', '', $project->getProdUrl());
                $project->setProdUrl('https://' . $url);
            }
            if ($project->getPreprodUrl()) {
                $url = preg_replace('#^https?://#', '', $project->getPreprodUrl());
                $project->setPreprodUrl('http://' . $url);
            }

            $em->persist($project);
            $em->flush();

            $this->addFlash('success', 'Projet créé avec succès.');
            return $this->redirectToRoute('project_index');
        }

        return $this->render('project/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/project/{id}/edit', name: 'project_edit')]
    public function edit(Project $project, Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageFile')->getData();

            if ($imageFile) {
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move($this->getParameter('images_directory'), $newFilename);
                $project->setImageFilename($newFilename);
            }

            if ($project->getProdUrl()) {
                $url = preg_replace('#^https?://#', '', $project->getProdUrl());
                $project->setProdUrl('https://' . $url);
            }

            if ($project->getPreprodUrl()) {
                $url = preg_replace('#^https?://#', '', $project->getPreprodUrl());
                $project->setPreprodUrl('http://' . $url);
            }

            $em->flush();

            $this->addFlash('success', 'Projet modifié avec succès.');
            return $this->redirectToRoute('project_index');
        }

        return $this->render('project/edit.html.twig', [
            'form' => $form->createView(),
            'project' => $project,
        ]);
    }

    #[Route('/project/{id}/delete', name: 'project_delete', methods: ['POST'])]
    public function delete(Project $project, Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete' . $project->getId(), $request->request->get('_token'))) {
            $em->remove($project);
            $em->flush();
            $this->addFlash('success', 'Projet supprimé avec succès.');
        }

        return $this->redirectToRoute('project_index');
    }
}
