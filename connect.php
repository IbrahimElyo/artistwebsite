<?php

const SERVER = "localhost";
const DBNAME = "helenemazgaj";
const USER = "root";
const PASSWORD = "root";

try{
    $db = new PDO('mysql:host='.SERVER.';dbname='.DBNAME, USER, PASSWORD);
} catch(PDOException $e) {
    die("Erreur lors de la connexion : " .$e->getMessage());
}