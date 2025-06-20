<?php
namespace App\Command;

use App\Entity\Register;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateAdminUserCommand extends Command
{
    private $em;
    private $passwordHasher;

    public function __construct(EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();
        $this->em = $em;
        $this->passwordHasher = $passwordHasher;
    }

    protected function configure()
    {
        // 👇 ICI ON DÉFINIT LE NOM MANUELLEMENT
        $this->setName('app:create-admin-user')
             ->setDescription('Crée un utilisateur admin root avec le mot de passe rootpassword');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $repo = $this->em->getRepository(Register::class);
        $existingAdmin = $repo->findOneBy(['username' => 'root']);

        if ($existingAdmin) {
            $output->writeln('<comment>L’utilisateur root existe déjà.</comment>');
            return Command::SUCCESS;
        }

        $admin = new Register();
        $admin->setUsername('root');
        $admin->setRoles(['ROLE_ADMIN']);
        $hashedPassword = $this->passwordHasher->hashPassword($admin, 'rootpassword');
        $admin->setPassword($hashedPassword);

        $this->em->persist($admin);
        $this->em->flush();

        $output->writeln('<info>Utilisateur admin "root" créé avec succès.</info>');

        return Command::SUCCESS;
    }
}
