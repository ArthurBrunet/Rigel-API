<?php

namespace App\Controller;

use App\Entity\IdeaBox;
use App\Repository\IdeaBoxRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Message;
use Symfony\Component\Routing\Annotation\Route;

class IdeaController extends AbstractController
{
    /**
     * @Route("/idea", name="idea")
     */
    public function index(): Response
    {
        return $this->render('idea/index.html.twig', [
            'controller_name' => 'IdeaController',
        ]);
    }

    /**
     * @Route("/idea/create", name="mail", methods={"POST"})
     */
    public function sendIdeaBox(Request $request, EntityManagerInterface $em, UserRepository $userRepository, MailerInterface $mailer): Response
    {
        $data = json_decode($request->getContent(), true);
        $idea = $data['idea'];
        $userIdea = $data['user'];
        $title = $data['title'];
        $user = $userRepository->findOneBy(['email' => $userIdea]);
        $dateNow = new \DateTime("now");

        if (!$user) {
            $idea = new IdeaBox();
            $idea->setIdUser($user);
            $idea->setDescription($idea);
            $idea->setTitle($title);
            $idea->setPublicationDate($dateNow);

            $em->persist($idea);
            $em->flush();

            $email = (new TemplatedEmail())
                ->from('sirius@mailhog.local')
                ->to($userIdea)
                ->subject($user->getUsername() . 'à une nouvelle pour améliorer la platforme!')
                ->htmlTemplate('mail/index.html.twig')
                ->context(["server_url" => $_ENV['SERVER'], "token" => $user->getToken()]);

            $mailer->send($email);

            return new JsonResponse('Mail send', 200);

        } else {
            return new JsonResponse('User already exist', 402);
        }
    }

    /**
     * @Route("/idea", name="get_idea", methods={"GET"})
     */
    public function getIdea(IdeaBoxRepository $ideaBoxRepository) {
        // Méthode pour récupérer un utilisateur via son email
        $idea = $ideaBoxRepository->findAll();
        $serialize = SerializerBuilder::create()->build();
        $jsonContent = $serialize->serialize($idea, 'json', SerializationContext::create());
        return new JsonResponse($jsonContent, Response::HTTP_OK, [], true);
    }
}
