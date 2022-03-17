<?php

namespace App\Models;

class User
{
    private $connexion;
    
    // Table dans la base des données
    public $table = "User"; 


    // Propriétés
    public $id;
    public $name;
    public $middleName;
    public $firstName;
    public $phoneNumber;
    public $password;
    public $role;
    public $userId;
    public $dateCreat;
    public $dateLastConnexion;
    
}