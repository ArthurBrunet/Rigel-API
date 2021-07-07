<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Message;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class MailController extends AbstractController
{
    /**
     * @Route("/api/mail/createUser", name="mail", methods={"POST"})
     */
    public function createUser(Request $request, EntityManagerInterface $em, UserRepository $userRepository, MailerInterface $mailer): Response
    {
        $datas = json_decode($request->getContent(), true);
        $user = new User();

        $emailUser = $userRepository->findOneBy(['email' => $datas['email']]);

        if (!$emailUser) {
            $user->setEmail($datas['email']);
            $user->setIsVisible(0);
            $user->setIsEnable(0);
            $em->persist($user);
            $em->flush();

            $email = (new TemplatedEmail())
                ->from('sirius@mailhog.local')
                ->to($datas['email'])
                ->subject('Sirius vous invite sur sa platforme!')
                ->htmlTemplate('mail/index.html.twig')
                ->context(["server_url" => $_ENV['SERVER'], "token" => $user->getToken()]);

            $mailer->send($email);

            return new JsonResponse('Mail send', 200);

        } else {
            return new JsonResponse('User already exist', 402);
        }
    }
}
