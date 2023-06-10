<?php

class Firma implements JsonSerializable {
    private $id;
    private $nazivFirme;
    private $iznosNaRacunu;

    public function __construct($id, $nazivFirme, $iznosNaRacunu) {
        $this->id = $id;
        $this->nazivFirme = $nazivFirme;
        $this->iznosNaRacunu = $iznosNaRacunu;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNazivFirme() {
        return $this->nazivFirme;
    }

    public function setNazivFirme($nazivFirme) {
        $this->nazivFirme = $nazivFirme;
    }

    public function getIznosNaRacunu() {
        return $this->iznosNaRacunu;
    }

    public function setIznosNaRacunu($iznosNaRacunu) {
        $this->iznosNaRacunu = $iznosNaRacunu;
    }

    public function jsonSerialize(): array {
        return [
            'id' => $this->id,
            'nazivFirme' => $this->nazivFirme,
            'iznosNaRacunu' => $this->iznosNaRacunu
        ];
    }
}
