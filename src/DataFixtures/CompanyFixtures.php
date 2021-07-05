<?php

namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class CompanyFixtures extends Fixture
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
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < self::NUMBER_USER; $i++) {
            $company = new Company();

            $company->setName($faker->company);
            $company->setType($this->getReference($faker->randomElement(array_keys(CompanyTypeFixtures::TYPES_COMPANY))));
            $company->setDescription('Truffaut photo booth semiotics readymade shoreditch, four loko tofu 
            letterpress. Mixtape austin tacos offal pug forage trust fund synth art party. Truffaut marfa +1 irony 
            pour-over letterpress tumblr, banjo next level taxidermy chartreuse. Put a bird on it photo booth authentic 
            kinfolk, bitters disrupt whatever air plant pitchfork fingerstache selfies taxidermy. PBR&B kinfolk 
            trust fund, asymmetrical vinyl tumeric waistcoat. Pitchfork locavore cronut scenester snackwave salvia.');

            $manager->persist($company);
        }
    }
}
