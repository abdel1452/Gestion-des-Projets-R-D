<?php

namespace App\DataFixtures;

use App\Entity\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 35; $i++) {
            $project = new Project();
            $project->setName("Projet $i");
            $project->setDescription("Description du projet numéro $i");
            $project->setImageFilename("image$i.jpg"); // Place ces images dans public/images/

            $project->setHTTP("https://prod.exemple.com/projet-$i");
            $project->setHTTPS("https://preprod.exemple.com/projet-$i");

            $manager->persist($project);
        }

        $manager->flush();
    }
}
