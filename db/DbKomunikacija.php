<?php

class DbKomunikacija
{
    private $konekcija;

    public function __construct()
    {
        try {
            $this->konekcija = new mysqli("localhost", 'root', '', 'transakcije');
            $this->konekcija->set_charset('utf8');
        }catch (Exception $e){
            echo json_encode($e->getTrace());
        }
    }

    public function vratiFirme(): array
    {
        $upit = "SELECT * FROM firme";

        $resultSet = $this->konekcija->query($upit);
        $nizPodataka = [];

        while ($red = $resultSet->fetch_object()){
            $nizPodataka[] = new Firma($red->id, $red->nazivFirme, $red->iznosNaRacunu);
        }

        return $nizPodataka;
    }

    public function vratiPodatke($firma, $min = 0, $max = 100000000): array
    {
        $upit = "SELECT t.id as transakcijaId, r.*, t.*, f.*  FROM firme f JOIN radnici r ON f.id = r.firmaId JOIN transakcije t ON r.id = t.radnikId WHERE t.iznos > $min AND t.iznos < $max AND r.firmaId = $firma";

        $resultSet = $this->konekcija->query($upit);
        $nizPodataka = [];

        while ($red = $resultSet->fetch_object()){
            $firma = new Firma($red->id, $red->nazivFirme, $red->iznosNaRacunu);
            $radnik = new Radnik($red->radnikId, $red->imePrezime, $red->opisPosla, $firma);
            $nizPodataka[] = new Transakcija($red->transakcijaId, $radnik, $red->iznos);
        }

        return $nizPodataka;
    }

    public function vratiRadnike($firma)
    {
        $upit = "SELECT * FROM firme f JOIN radnici r ON f.id = r.firmaId WHERE r.firmaId = $firma";

        $resultSet = $this->konekcija->query($upit);
        $nizPodataka = [];

        while ($red = $resultSet->fetch_object()){
            $firma = new Firma($red->firmaId, $red->nazivFirme, $red->iznosNaRacunu);
            $radnik = new Radnik($red->id, $red->imePrezime, $red->opisPosla, $firma);
            $nizPodataka[] = $radnik;
        }

        return $nizPodataka;
    }

    public function vratiFirmuPoIdu($firma)
    {
        $upit = "SELECT * FROM firme  WHERE id = $firma";

        $resultSet = $this->konekcija->query($upit);

        while ($red = $resultSet->fetch_object()){
            return new Firma($red->id, $red->nazivFirme, $red->iznosNaRacunu);
        }

        return null;
    }

    public function vratiIznosTransakcijePoIdu($transakcija)
    {
        $upit = "SELECT iznos FROM transakcije  WHERE id = $transakcija";

        $resultSet = $this->konekcija->query($upit);

        while ($red = $resultSet->fetch_object()){
            return $red->iznos;
        }

        return 0;
    }

    public function unesi($radnik, $iznos)
    {
        return $this->konekcija->query("INSERT INTO transakcije VALUES (null, $radnik, $iznos)");
    }

    public function izmeniIznosRacunaFirme($firma, $iznos, $operacija)
    {
        if('ODUZMI' === $operacija){
            $upit = "UPDATE firme SET iznosNaRacunu = iznosNaRacunu - $iznos WHERE id=$firma";
        }else{
            $upit = "UPDATE firme SET iznosNaRacunu = iznosNaRacunu + $iznos WHERE id=$firma";
        }

        return $this->konekcija->query($upit);
    }

    public function obrisi($transakcija)
    {
        return $this->konekcija->query("DELETE FROM transakcije WHERE id=$transakcija");
    }
}