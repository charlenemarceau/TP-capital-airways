<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Flight;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $cities = [ 'Paris', 'Berlin', 'Madrid', 'Londres', 'Vienne', 'Bruxelles', 
        'Sofia', 'Athènes', 'Budapest', 'Rome', 'Dublin', 'Copenhague', 'Amsterdam', 'Varsovie', 'Prague'];
        // Tableau d'objets de type City
        $tabObjCity = [];
        // -- Crée autant d'objet City que de villes dans $cities
        foreach ($cities as $name) {
            $city = new City();
            $city->setName($name);
            $tabObjCity[] = $city;
            $manager->persist($city);
            $manager->flush();
        }

        /***---------------------------------------------------
         *                      UN VOL
          -----------------------------------------------------*/

            $flight = new Flight;
            $flight
                    ->setFlightNumber('AA7777')
                    ->setSchedule(\DateTime::createFromFormat('H:i', '08:00'))
                    ->setPrice(210)
                    ->setReduction(false)
                    ->setDeparture($tabObjCity[0])
                    ->setArrival($tabObjCity[4]);
                $manager->persist(($flight));

        }
    }
