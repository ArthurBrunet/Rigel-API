<?php

namespace App\DataFixtures;

use App\Entity\TypeCompany;
use Doctrine\Persistence\ObjectManager;

class CompanyTypeFixtures extends AbstractFixtures
{

    const COMPANY_ACTIVITY_ARCHITECTURE = 'company_activity_architecture';
    const COMPANY_ACTIVITY_INFORMATICS = 'company_activity_informatics';
    const COMPANY_ACTIVITY_MARKETING = 'company_activity_marketing';

    const COMPANY_ACTIVITY = [
        self::COMPANY_ACTIVITY_ARCHITECTURE => [
            'name' => 'Architecture',
        ],
        self::COMPANY_ACTIVITY_INFORMATICS => [
            'name' => 'Informatics',
        ],
        self::COMPANY_ACTIVITY_MARKETING => [
            'name' => 'Marketing',
        ],
    ];

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->loadCompanyActivity($manager);

        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     */
    public function loadCompanyActivity(ObjectManager $manager)
    {
        foreach (self::COMPANY_ACTIVITY as $id => $data) {
            $companyActivity = new TypeCompany();
            $companyActivity
                ->setName($data['name'])
            ;

            $this->setReference($id, $companyActivity);

            $manager->persist($companyActivity);
        }
    }
}
