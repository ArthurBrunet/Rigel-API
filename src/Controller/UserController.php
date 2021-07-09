<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;
use JMS\SerializerBundle\JMSSerializerBundle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/user/create", name="user_registration", methods={"POST"})
     */
    public function mailUser(Request $request, ValidatorInterface $validator, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder, UserRepository $userRepository): Response
    {
        //Récupération de la data dans le JSON
        $datas = json_decode($request->getContent(), true);

        $token = $datas['token'];

        // Vérifier si le user existe
        $user = $userRepository->findOneBy(['token' => $token]);
        $tokenUser = $user->getToken();
        $visibleUser = $user->getIsVisible();
        $enableUser = $user->getIsEnable();
        if ($token === $tokenUser && $visibleUser === FALSE && $enableUser === FALSE) {

            // Génération du form qui se base sur l'entité USER
            $form = $this->createForm(RegistrationType::class, $datas);

            $form->submit($datas);

            $validate = $validator->validate($user, null, 'Register');
            // Vérifie si il n'y a pas d'erreurs en fonction des assert saisies dans l'entité
            if (count($validate) !== 0) {
                foreach ($validate as $error) {
                    return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
                }
            }

            // Gestion du mot de passe
            $password = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $user->setIsVisible(1);
            $user->setIsEnable(1);
            $user->setToken(rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '='));

            $em->persist($user);
            $em->flush();

            return new JsonResponse('User Created', 200);
        } else {
            return new JsonResponse('Mail already exist', Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/user/get/{email}", name="user_get_by_mail", methods={"GET"})
     */
    public function getUserByEmail($email, UserRepository $userRepository): JsonResponse
    {
        // Méthode pour récupérer un utilisateur via son email
        $user = $userRepository->findOneBy(['email' => $email]);
        $serialize = SerializerBuilder::create()->build();
        $jsonContent = $serialize->serialize($user, 'json', SerializationContext::create());
        return new JsonResponse($jsonContent, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/user/getUserFromToken/{token}", name="getUserFromToken", methods={"GET"})
     */
    public function getUserFromToken($token, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->findOneBy(['token' => $token]);
        if ($user) {
            $serialize = SerializerBuilder::create()->build();
            $jsonContent = $serialize->serialize($user, 'json', SerializationContext::create());
            return new JsonResponse($jsonContent, Response::HTTP_OK, [], true);
        }else {
            return new JsonResponse(json_encode("user dont exist"), Response::HTTP_OK, [], true);
        }
    }
}
