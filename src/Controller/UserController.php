<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
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
    public function createUser(Request $request, ValidatorInterface $validator, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();

        //Récupération de la data dans le JSON
        $datas = json_decode($request->getContent(), true);

        // Génération du form qui se base sur l'entité USER
        $form = $this->createForm(RegistrationType::class, $user);

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

        $em->persist($user);
        $em->flush();

        return new JsonResponse('User Created', 200);
    }
}
