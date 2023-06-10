<?php

class Transakcija implements JsonSerializable {
    private $id;
    private $radnikId;
    private $iznos;

    public function __construct($id, $radnikId, $iznos) {
        $this->id = $id;
        $this->radnikId = $radnikId;
        $this->iznos = $iznos;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getRadnikId() {
        return $this->radnikId;
    }

    public function setRadnikId($radnikId) {
        $this->radnikId = $radnikId;
    }

    public function getIznos() {
        return $this->iznos;
    }

    public function setIznos($iznos) {
        $this->iznos = $iznos;
    }

    public function jsonSerialize(): array {
        return [
            'id' => $this->id,
            'radnik' => $this->radnikId,
            'iznos' => $this->iznos
        ];
    }
}
