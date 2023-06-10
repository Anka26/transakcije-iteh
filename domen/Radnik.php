<?php

class Radnik implements JsonSerializable {
    private $id;
    private $imePrezime;
    private $opisPosla;
    private $firmaId;

    public function __construct($id, $imePrezime, $opisPosla, $firmaId) {
        $this->id = $id;
        $this->imePrezime = $imePrezime;
        $this->opisPosla = $opisPosla;
        $this->firmaId = $firmaId;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getImePrezime() {
        return $this->imePrezime;
    }

    public function setImePrezime($imePrezime) {
        $this->imePrezime = $imePrezime;
    }

    public function getOpisPosla() {
        return $this->opisPosla;
    }

    public function setOpisPosla($opisPosla) {
        $this->opisPosla = $opisPosla;
    }

    public function getFirmaId() {
        return $this->firmaId;
    }

    public function setFirmaId($firmaId) {
        $this->firmaId = $firmaId;
    }

    public function jsonSerialize(): array {
        return [
            'id' => $this->id,
            'imePrezime' => $this->imePrezime,
            'opisPosla' => $this->opisPosla,
            'firma' => $this->firmaId
        ];
    }
}
