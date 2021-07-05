<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\TypeCompany;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class CompanyTypeFixtures extends Fixture
{

    const  ARCHITECTURE = 'Architecture';
    const INFORMATICS = 'Informatics';
    const MARKETING = 'Marketing';

    const TYPES_COMPANY = [
        self::ARCHITECTURE => [
            'name' => 'Architecture'
        ],
        self::INFORMATICS => [
            'name' => 'Informatics'
        ],
        self::MARKETING => [
            'name' => 'Marketing'
        ]
    ];

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        $this->loadTypeCompany($manager);
        $manager->flush();

    }

    /**
     * @param ObjectManager $manager
     */
    public function loadTypeCompany(ObjectManager $manager)
    {
        foreach (self::TYPES_COMPANY as $id => $data) {
            $typeCompany = new TypeCompany();
            $typeCompany
                ->setName($data['name']);
            $this->setReference($id, $typeCompany);
            $manager->persist($typeCompany);
        }

        $manager->flush();
    }
}
