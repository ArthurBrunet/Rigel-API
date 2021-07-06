<?php


namespace App\Command;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateAdminCommand extends Command
{
    protected static $defaultName = 'create:admin:user';
    private $passwordEncoder;
    private $entityManagerInterface;

    public function __construct(string $name = null, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManagerInterface = $entityManager;
        parent::__construct($name);
    }

    /**
     * Configure arguments
     */
    protected function configure()
    {
        $this
            ->setDescription('Create a new admin user')
            ->setHelp('This command allows you to create an admin user...')
            ->addArgument('email', InputArgument::REQUIRED, 'The email of the admin user')
            ->addArgument('password', InputArgument::REQUIRED, 'Admin user password')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $email = $input->getArgument("email");
        $password = $input->getArgument("password");

        $adminUser = new User();
        $adminUser->setPassword($this->passwordEncoder->encodePassword($adminUser,$password));
        $adminUser->setEmail($email);
        $adminUser->setRoles(array("ROLE_ADMIN"));

        $this->entityManagerInterface->persist($adminUser);
        $this->entityManagerInterface->flush();
        $output->write('You are about to ');
        $output->write('create an admin user.');

        return 0;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $questions = [];
        if (!$input->getArgument("email")) {
            $question = new Question("Choose a mail: ");
            $question->setValidator(function ($email) {
                if (empty($email)) {
                    throw new \Exception('Email not empty');
                }
                return $email;
            });
            $questions['email'] = $question;
        }

        if (!$input->getArgument("password")) {
            $question = new Question("Choose a password: ");
            $question->setValidator(function ($password) {
                if (empty($password)) {
                    throw new \Exception('Password not empty');
                }
                return $password;
            });
            $questions['password'] = $question;
        }

        foreach ($questions as $name => $question) {
            $answer = $this->getHelper('question')->ask($input, $output, $question);
            $input->setArgument($name, $answer);
        }
    }
}