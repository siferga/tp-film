<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 
 */

class UsersDAO extends Dao
{


    //Ajouter un utilisateur
    public function add($data)
    {
        //Requete INNER JOIN dans le MODEL
        $valeurs = ['email' => $data->get_email(), 'password' => $data->get_password()];
        $requete = 'INSERT INTO * FROM `user` (email, password) VALUES (:email, :password)';
        $insert = $this->_bdd->prepare($requete);
        if (!$insert->execute($valeurs)) {
            //print_r($insert->errorInfo());
            return false;
        } else {
            return true;
        }
    }


    //Récupérer tous les utilisateurs
    public function getAll()
    {
        //On définit la bdd pour la fonction

        $query = $this->_bdd->prepare("SELECT * FROM user WHERE username=:id;");
        //$query = $this->_bdd->prepare("SELECT idUser, email, password FROM utilisateurs");
        $query->execute();
        $users = array();

        while ($data = $query->fetch()) {
            $users[] = new Users($data['idUser'], $data['email'], $data['password']);
        }
        return ($users);
    }

    //Récupérer plus d'info sur 1 film
    public function getOne($id_user)
    {

        $query = $this->_bdd->prepare('SELECT * FROM user WHERE user.idUsers = :id_user')->fetch(PDO::FETCH_ASSOC);
        $query->execute(array(':id_user' => $id_user));
        $data = $query->fetch();
        $user = new Users($data['id_user'], $data['email'], $data['password']);
        return ($user);
    }

    /*//Ajouter un utilisateur 
    function addUser($email, $password)
    {
        // Récupération de la liste de tous les utilisateurs
        $users = getUsers();
        // Ajout du nouvel utilisateur
        $users[$email] = [
            'password' => hashPassword($password),
            'token'    => generateToken()
        ];
        // Sauvegarde de la liste des utilisateurs
        saveUsers($users);
    }

    // Enregistre un nouvel utilisateur
    function register($email, $password)
    {
        // Récupération de l'utilisateur demandé
        $user = getUser($email);
        // Si l'utilisateur existe déjà, on arrête tout.
        if ($user) {
            die("L'utilisateur {$email} est déjà enregistré.");
        }

        // Enregistrement du nouvel utilisateur
        addUser($email, $password);
    }

    //Se connecter (utilisateur)
    function login($email, $password)
    {
        // Récupération de la l'utilisateur
        $user = getUser($email);

        // Si l'utilisateur n'a pas pu être récupéré.
        if (!array_key_exists($email, $users)) {
            die("L'utilisateur {$email} n'est pas enregistré.");
        }
    }*/
}