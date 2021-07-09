<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\CanalRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class MailController extends AbstractController
{
    /**
     * @Route("/mail/createUser", name="mail", methods={"POST"})
     */
    public function createUser(Request $request, EntityManagerInterface $em, UserRepository $userRepository, MailerInterface $mailer,CanalRepository $canalRepository): Response
    {
        $datas = json_decode($request->getContent(), true);
        $user = new User();

        $emailUser = $userRepository->findOneBy(['email' => $datas['email']]);

        if (!$emailUser) {
            $user->setEmail($datas['email']);
            $user->setIsVisible(0);
            $user->setIsEnable(0);
            $canals = $canalRepository->findAll();
            if ($datas['role'] == "USER" || "ADMIN") {
                $user->addCanal($canals[0]);
                $user->addCanal($canals[1]);
            }else{
                $user->addCanal($canals[0]);
            }
            $em->persist($user);
            $em->flush();
            $email = (new TemplatedEmail())
                ->from('sirius@mailhog.local')
                ->to($datas['email'])
                ->subject('Sirius vous invite sur sa platforme!')
                ->htmlTemplate('mail/index.html.twig')
                ->context(["server_url" => $_ENV['SERVERAPP'], "token" => $user->getToken()]);

            $mailer->send($email);

            return new JsonResponse('Mail send', 200);

        } else {
            return new JsonResponse('User already exist', 402);
        }
    }
}
