<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Flight;
use App\Services\FlightService;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    private $flightService;
    /**
     * On injecte un service dans le constructeur
     *
     * @param FlightService $fs
     */

    function __construct(FlightService $fs)
    {
        $this->flightService = $fs;
    }
    
    /** Pemert d'alimenter la base de données avec
     * - 13 enregistrements de villes 
     * - 1 enregistrement de vol */

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
        }

        /***---------------------------------------------------
         *                      UN VOL
          -----------------------------------------------------*/
            for($i = 0; $i<5; $i++) :
            $flight = new Flight;
            $flight
                    ->setFlightNumber($this->flightService->getFlightNumber())
                    ->setSchedule(\DateTime::createFromFormat('H:i', '08:00'))
                    ->setPrice(mt_rand(100,200))
                    ->setSeat(mt_rand(1,50))
                    ->setReduction(false)
                    ->setDeparture($tabObjCity[$i])
                    ->setArrival($tabObjCity[$i+1]);
                $manager->persist(($flight));
            endfor;

            $manager->flush();

        }
    }

