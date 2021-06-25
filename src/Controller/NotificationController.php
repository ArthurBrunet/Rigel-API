<?php

namespace App\Controller;

use App\Entity\EmergencyAperitif;
use App\Repository\EmergencyAperitifRepository;
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

/**
 * Class NotificationController
 * @package App\Controller
 * // * @Route ("/api")
 */
class NotificationController extends AbstractController
{
    /**
     * @Route("/notification", name="notification")
     */
    public function index(): Response
    {
        return $this->render('notification/index.html.twig', [
            'controller_name' => 'NotificationController',
        ]);
    }

    /**
     * @Route("/notification/aperitif", name="notification_aperitif", methods={"POST"})
     */
    public function aperitifAlert(EntityManagerInterface $em, Request $request, UserRepository $userRepository, MailerInterface $mailer, EmergencyAperitifRepository $emergencyAperitifRepository): JsonResponse
    {
//        $user = $this->getUser();
        //Récupération de la data dans le JSON
        $datas = json_decode($request->getContent(), true);
        $companies = $datas['companie'];
        $reason = $datas['reason'];
        $meetingPoint = $datas['meetingPoint'];
        $date = $datas['date'];
        $email = $datas['email'];
        $user = $userRepository->findOneBy(['email' => $email]);

        $dateNow = new \DateTime("now");
        $aperitif = $emergencyAperitifRepository->findOneBy(['user' => $user], ['createdAt' => 'ASC']);

        if ($user) {
            if ($dateNow > $aperitif) {
                $usersCompany = $userRepository->getUsersOfCompanyById($companies);
                foreach ($usersCompany as $value) {
                    $email = (new Email())
                        ->from('sirius@mailhog.local')
//                ->from('turpinpaulpro@gmail.com')
                        ->to($value)
                        ->subject($user->getUsername() . 'vous invite sur sa platforme!')
                        ->htmlTemplate('mail/emergency.html.twig');
                    $mailer->send($email);
                }
                $emergencyAperitif = new EmergencyAperitif();
                $emergencyAperitif->setDate($date);
                $emergencyAperitif->setMeetingPoint($meetingPoint);
                $emergencyAperitif->setReason($reason);
                $emergencyAperitif->setUser($user);
                $em->persist($emergencyAperitif);
                $em->flush();
                return new JsonResponse('Notifications send', Response::HTTP_OK);

            } else {
                return new JsonResponse('User already use the emergency for today', Response::HTTP_BAD_REQUEST);
            }
        } else {
            return new JsonResponse('User not found', Response::HTTP_BAD_REQUEST);
        }
    }
}
