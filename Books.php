<?php

class Books {
    private $dbConn;
    //konstruktor - předáváme jako parametr připojení do db
    public function __construct($p_dbConn){
        $this->dbConn = $p_dbConn;
    }
    //metoda, která nám vrátí z db všechna auta
    public function getBooks(){
        $query = 'SELECT * FROM books';
        $stmt = $this->dbConn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function filterBooks($p_surname, $p_firstname, $p_title, $p_isbn){
        $sql = 'SELECT * FROM books WHERE 1=1';
        $params = [];

        // přidání podmínek do dotazu podle parametrů
        if (!empty($p_surname)){
            $sql .= " AND surname LIKE :surname";
            $params[':surname'] = '%' . $p_surname . '%';
        }
        if (!empty($p_firstname)){
            $sql .= " AND firstname LIKE :firstname";
            $params[':firstname'] = '%' . $p_firstname . '%';
        }
        if (!empty($p_title)){
            $sql .= " AND title LIKE :title";
            $params[':title'] = '%' . $p_title . '%';
        }

        if (!empty($p_isbn)){
            $sql .= " AND isbn LIKE :isbn";
            $params[':isbn'] = '%' . $p_isbn . '%';
        }

        // příprava sql dotazu
        $stmt = $this->dbConn->prepare($sql);

        // bindování hodnot, pokud byly parametry přidány
        foreach ($params as $param => $value) {
            $stmt->bindValue($param, $value, PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addBook($p_isbn, $p_firstname, $p_surname, $p_title , $p_description)
    {
        $sql = 'INSERT INTO books(isbn, firstname, surname, title, description) VALUES(:isbn, :firstname, :surname, :title, :description)';

        $stmt = $this->dbConn->prepare($sql);

        $stmt-> bindParam(':isbn', $p_isbn, PDO::PARAM_STR); 
        $stmt-> bindParam(':firstname', $p_firstname, PDO::PARAM_STR); 
        $stmt-> bindParam(':surname', $p_surname, PDO::PARAM_STR); 
        $stmt-> bindParam(':title', $p_title, PDO::PARAM_STR); 
        $stmt-> bindParam(':description', $p_description, PDO::PARAM_STR); 
        return $stmt->execute();
    }

}