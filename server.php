<?php
/** @var DbKomunikacija $db */
$db = require 'import.php';

$operacija = $_GET['operacija'] ?? null;

if (null === $operacija){
    $operacija = $_POST['operacija'] ?? throw new Exception("Operacija nije poslata. Molimo vas posaljite operaciju");
}

switch ($operacija){
    case 'VRATI-FIRME':
        echo json_encode($db->vratiFirme());
        break;

    case 'VRATI-PODATKE':
        $min = $_GET['min'] ?? 0;
        $max = $_GET['max'] ?? 10000000;
        $firma = $_GET['firma'];
        echo json_encode($db->vratiPodatke($firma, $min, $max));
        break;

    case 'VRATI-RADNIKE':
        $firma = $_GET['firma'];
        echo json_encode($db->vratiRadnike($firma));
        break;

    case 'VRATI-IZNOS':
        $firma = $_GET['firma'];
        echo json_encode($db->vratiFirmuPoIdu($firma));
        break;
    case 'UNESI':
        $firma = $_POST['firma'];
        $radnik = $_POST['radnik'];
        $iznos = $_POST['iznos'];

        $firmaObjekat = $db->vratiFirmuPoIdu($firma);

        if($firmaObjekat->getIznosNaRacunu() - $iznos < 0){
            echo json_encode([
                "uspesno" => false,
                "poruka" => "Nemate dovoljno novca za ovu transakciju"
            ]);
            return;
        }

        $uspesnoUnetaTransakcija = $db->unesi($radnik, $iznos);
        if($uspesnoUnetaTransakcija){
            $uspesnoPromenjenoStanjeRacunaFirme = $db->izmeniIznosRacunaFirme($firma, $iznos, 'ODUZMI');

            if($uspesnoPromenjenoStanjeRacunaFirme){
                echo json_encode([
                    "uspesno" => true,
                    "poruka" => "Uspesno ste uneli transakciju"
                ]);
            }else{
                echo json_encode([
                    "uspesno" => false,
                    "poruka" => "Doslo je do greske prilikom promene racuna, kontaktirajte administratora!"
                ]);
            }
        }else{
            echo json_encode([
                "uspesno" => false,
                "poruka" => "Doslo je do greske prilikom unosa transakcije, kontaktirajte administratora!"
            ]);
        }
        break;
    case 'OBRISI':
        $firma = $_POST['firma'];
        $transakcija = $_POST['transakcija'];

        $firmaObjekat = $db->vratiFirmuPoIdu($firma);

        $iznos = $db->vratiIznosTransakcijePoIdu($transakcija);

        $uspesnoObrisanaTransakcija = $db->obrisi($transakcija);
        if($uspesnoObrisanaTransakcija){
            $uspesnoPromenjenoStanjeRacunaFirme = $db->izmeniIznosRacunaFirme($firma, $iznos, 'SABERI');

            if($uspesnoPromenjenoStanjeRacunaFirme){
                echo json_encode([
                    "uspesno" => true,
                    "poruka" => "Uspesno ste obrisali transakciju, Iznos transakcije je vracen na racun firme."
                ]);
            }else{
                echo json_encode([
                    "uspesno" => false,
                    "poruka" => "Doslo je do greske prilikom promene racuna, kontaktirajte administratora!"
                ]);
            }
        }else{
            echo json_encode([
                "uspesno" => false,
                "poruka" => "Doslo je do greske prilikom brisanja transakcije, kontaktirajte administratora!"
            ]);
        }
        break;
}
