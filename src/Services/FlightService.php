<?php

namespace App\Services;

class FlightService {

    /**
     * Undocumented function
     * 
     * 
     */
    public function getFlightNumber(): string
    {
        # pour les deux lettres
        $deuxlettres = "";
        # tableau de lettres de A à Z
        $lettres = range('A', 'Z');
        shuffle($lettres);
        // extraire 2 fois la 1ère lettre du tableau
        $deuxlettres = array_shift($lettres);
        $deuxlettres .= array_shift($lettres);
        #-- pour les nombres
        $nombre=mt_rand(1000, 9999);
        return $deuxlettres.$nombre;
    }
}