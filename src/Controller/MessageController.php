<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageForm;
use App\Form\RegistrationType;
use App\Repository\CanalRepository;
use App\Repository\MessageRepository;
use App\Repository\UserRepository;
use App\Service\JWTService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use function Composer\Autoload\includeFile;

class MessageController extends AbstractController
{

    public function verifCanalAccess($request, $canal, $canalRepository, $userRepository) {
        $jwtController = new JWTService();
        $headerAuthorization = $request->headers->get("authorization");
        $email = $jwtController->getUsername($headerAuthorization);
        $user = $userRepository->findOneBy(['email' => $email]);
        if($user) {
            $canals = $canalRepository->getCanalsOfUserById($user->getId());
            foreach ($canals as $value) {
                if (in_array($canal,$value)){
                    return true;
                }
            }
            return false;
        }else{
            return false;
        }
    }


    /**
     * @Route("/api/message/create", name="message_create")
     */
    public function createMessage(Request $request, ValidatorInterface $validator, EntityManagerInterface $em, CanalRepository $canalRepository, UserRepository $userRepository): Response
    {
        $response = new JsonResponse();
        $response->setStatusCode(Response::HTTP_BAD_REQUEST);
        $datas = json_decode($request->getContent(), true);
        $jwtController = new JWTService();
        $headerAuthorization = $request->headers->get("authorization");
        $email = $jwtController->getUsername($headerAuthorization);
        $user = $userRepository->findOneBy(['email' => $email]);
        $verif = $this->verifCanalAccess($request,$datas['canal'],$canalRepository,$userRepository);
        if ($verif){
            $message = new Message();
            /*$form = $this->createForm(MessageForm::class, $message);
            $form->submit($datas);
            $validate = $validator->validate($message);
            // Vérifie si il n'y a pas d'erreurs en fonction des assert saisies dans l'entité
            if (count($validate) !== 0) {
                foreach ($validate as $error) {
                    return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
                }
            }*/
            $canal = $canalRepository->findOneBy(['name' => $datas['canal']]);
            $message->setCanal($canal);
            $message->setText($datas['message']);
            $message->setCreatedBy($user);
            $em->persist($message);
            $em->flush();
            $response->setStatusCode(Response::HTTP_OK);
            $response->setContent(json_encode("OK"));
        }else{
            $response->setContent(json_encode("NOT AUTHORIZE TO ACCESS TO THIS CANAL"));
        }
        return $response;
    }

    /**
     * @Route("/api/message/get/{idCanal}", name="message_get")
     */
    public function getMessage($idCanal, Request $request ,CanalRepository $canalRepository, UserRepository $userRepository, MessageRepository  $messageRepository): Response
    {
        //Récupération de la data dans le JSON
        $response = new JsonResponse();
        $canal = $canalRepository->findOneBy(['id' => $idCanal]);
        if ($canal){
            $verif = $this->verifCanalAccess($request,$canal->getName(),$canalRepository,$userRepository);
        }else{
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            return $response;
        }
        if ($verif) {
            $result = $messageRepository->getMessagesOfCanalById($canal->getId());
            $response->setData($result);
            $response->setStatusCode(Response::HTTP_OK);
        }else{
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
        return $response;
    }
}