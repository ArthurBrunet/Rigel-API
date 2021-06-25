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
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Message;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MailController extends AbstractController
{
    /**
     * @Route("/mail/createUser", name="mail", methods={"POST"})
     */
    public function createUser(Request $request, EntityManagerInterface $em, UserRepository $userRepository, MailerInterface $mailer): Response
    {
        $datas = json_decode($request->getContent(), true);
//        $name = $datas['name'];
//        $firstname = $datas['firstname'];
        $user = new User();

        $emailUser = $userRepository->findOneBy(['email' => $datas['email']]);

        if (!$emailUser) {
            $email = (new Email())
                ->from('sirius@mailhog.local')
//                ->from('turpinpaulpro@gmail.com')
                ->to($datas['email'])
                ->subject('Sirius vous invite sur sa platforme!')
                ->htmlTemplate('mail/index.html.twig');

            $mailer->send($email);
//            $user->setFirstname($firstname);
//            $user->setName($name);
            $user->setEmail($datas['email']);
            $user->setIsVisible(0);
            $user->setIsEnable(0);
            $em->persist($user);
            $em->flush();
            return new JsonResponse('Mail send', 200);

        } else {
            return new JsonResponse('User already exist', 402);
        }
    }
}
