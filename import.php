<?php

include 'domen/Firma.php';
include 'domen/Radnik.php';
include 'domen/Transakcija.php';

require 'db/DbKomunikacija.php';


$db = new DbKomunikacija();

//echo json_encode($db->vratiPodatke(3));

return $db;
