<?php

include_once './function-utils.php';

class DbUtils {

    /**
     *
     * @var PDO 
     */
    public static $db;
    public static $env;

    public static function connect($host, $dbname, $port, $username, $password) {
        try {
            self::$db = new PDO("mysql:host=$host;dbname=$dbname;port=$port", $username, $password);

            self::$db->exec("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
        } catch (PDOException $ex) {
            die($ex->getMessage());
        }
    }

    public static function getUser($email) {
        $query = self::$db->prepare("SELECT * FROM user WHERE email=:mail");
        $query->bindParam(":mail", $email, PDO::PARAM_STR);
        $query->execute();

        return $query->fetch();
    }

    public static function addUser($email, $pseudo, $image) {
        $user = self::getUser($email);

        if (self::getUser($email) != false)
            return $user['id'];

        $query = self::$db->prepare("INSERT INTO user(email, pseudo, image) VALUES(:email, :pseudo, :image)");
        $query->bindParam(":email", $email, PDO::PARAM_STR);
        $query->bindParam(":pseudo", $pseudo, PDO::PARAM_STR);
        $query->bindParam(":image", $image, PDO::PARAM_STR);
        $query->execute();
        return self::$db->lastInsertId();
    }

    public static function addPlace($lat, $lng, $nom, $nbr) {

        $query = self::$db->prepare("INSERT INTO place(lat, lng, nom, nbr) VALUES(:lat, :lng, :nom, :nbr)");
        $query->bindParam(":lat", $lat, PDO::PARAM_STR);
        $query->bindParam(":lng", $lng, PDO::PARAM_STR);
        $query->bindParam(":nom", $nom, PDO::PARAM_STR);
        $query->bindParam(":nbr", $nbr, PDO::PARAM_INT);
        $query->execute();
        return self::$db->lastInsertId();
    }

    public static function addComment($id_user, $id_place, $contenu) {

        $query = self::$db->prepare("INSERT INTO comment(id_user, id_place, contenu) VALUES(:id_user, :id_place, :contenu)");
        $query->bindParam(":id_user", $id_user, PDO::PARAM_INT);
        $query->bindParam(":id_place", $id_place, PDO::PARAM_INT);
        $query->bindParam(":contenu", $contenu, PDO::PARAM_STR);
        $query->execute();
    }

    public static function getComments() {
        $query = self::$db->prepare("SELECT comment.contenu, user.pseudo, user.image  FROM comment "
                . " JOIN user ON user.id= comment.id_user "
                . " ORDER BY comment.id DESC LIMIT 0, 10");
        $query->execute();

        return $query->fetchAll();
    }

    public static function getPlaces() {
        $query = self::$db->prepare("SELECT * FROM place");
        $query->execute();

        return $query->fetchAll();
    }

    public static function confirmPlace($id) {
        $query = self::$db->prepare("SELECT nbr FROM place WHERE id =:id");
        
        $query->bindParam(":id", $id, PDO::PARAM_INT);
        $query->execute();
        $data = $query->fetch();

        if ($data) {
            $nbr = ((int) $data['nbr']) + 1;
            $query = self::$db->prepare("UPDATE place SET nbr = :nbr WHERE id =:id");
            $query->bindParam(":id", $id, PDO::PARAM_INT);
            $query->bindParam(":nbr", $nbr, PDO::PARAM_INT);
            $query->execute();
        }
    }
}
/**
* @param $host
* @param $dbname
* @param $port
* @param $user
* @param $password
*/
DbUtils::connect("", "", "", "", "");

