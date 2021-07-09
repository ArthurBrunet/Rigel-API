<?php

namespace App\Controller;

use App\Repository\CompanyRepository;
use App\Repository\TypeCompanyRepository;
use App\Repository\UserRepository;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompanyController extends AbstractController
{
    /**
     * @Route("/api/company/get/asc", name="get_company_asc", methods={"GET"})
     */
    public function getCompanyASC(CompanyRepository $companyRepository): JsonResponse
    {
        // Méthode pour récupérer un utilisateur via son email
        $company = $companyRepository->findBy(array(), array('name' => 'ASC'));
        $serialize = SerializerBuilder::create()->build();
        $jsonContent = $serialize->serialize($company, 'json', SerializationContext::create());
        return new JsonResponse($jsonContent, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/company/get/desc", name="get_company_desc", methods={"GET"})
     */
    public function getCompanyDESC(CompanyRepository $companyRepository): JsonResponse
    {
        // Méthode pour récupérer un utilisateur via son email
        $company = $companyRepository->findBy(array(), array('name' => 'DESC'));
        $serialize = SerializerBuilder::create()->build();
        $jsonContent = $serialize->serialize($company, 'json', SerializationContext::create());
        return new JsonResponse($jsonContent, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/company/get/Type/{name}", name="get_company_by_company_type", methods={"GET"})
     */
    public function getCompanyByTypeCompany($name, TypeCompanyRepository $typeCompanyRepository): JsonResponse
    {
        // Méthode pour récupérer un utilisateur via son email
        $companyType = $typeCompanyRepository->findBy(['name'=> $name]);
        $serialize = SerializerBuilder::create()->build();
        $jsonContent = $serialize->serialize($companyType, 'json', SerializationContext::create());
        return new JsonResponse($jsonContent, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/typeCompany/get", name="get_company_type", methods={"GET"})
     */
    public function getTypeCOmpany(TypeCompanyRepository $typeCompanyRepository): JsonResponse
    {
        // Méthode pour récupérer un utilisateur via son email
        $companyType = $typeCompanyRepository->getName();
        $serialize = SerializerBuilder::create()->build();
        $jsonContent = $serialize->serialize($companyType, 'json', SerializationContext::create());
        return new JsonResponse($jsonContent, Response::HTTP_OK, [], true);
    }

}
