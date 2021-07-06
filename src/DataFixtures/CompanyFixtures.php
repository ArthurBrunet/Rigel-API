<?php

namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Persistence\ObjectManager;

class CompanyFixtures extends AbstractFixtures
{
    const NUMBER_USER = 15;

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        $this->loadCompany($manager);
        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     */
    public function loadCompany(ObjectManager $manager)
    {
        for ($i = 0; $i < self::NUMBER_USER; $i++) {
            $data = [
                'name' => $this->faker->company,
//                'type' => $this->getReference($this->faker->randomElement(array_keys(CompanyTypeFixtures::COMPANY_ACTIVITY))),
                'description' => $this->faker->text,
            ];

            $company = new Company();
            foreach ($data as $prop => $value) {
                $this->propertyAccessor->setValue($company, $prop, $value);
            }
            $manager->persist($company);
        }
    }
}
