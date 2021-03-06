<?php

class Item extends activeRecord implements JsonSerializable {

    private $name;
    private $price;
    private $description;

    public function __construct() {
        parent::__construct();
        $this->name = '';
        $this->price = '';
        $this->description = '';

    }

    public function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getPrice() {
        return $this->price;
    }

    function getDescription() {
        return $this->description;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setPrice($price) {
        $this->price = $price;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    //creating new Item and updating Item that already exists
    public function save() {
        if (self::$db->conn != null) {
            if ($this->id == -1) {
                $sql = "INSERT INTO Item (name, price, description) values (:name, :price, :description)";
                $stmt = self::$db->conn->prepare($sql);  //MySQL inejction preventing during registering new user
                $result = $stmt->execute([
                    'name' => $this->name,
                    'price' => $this->price,
                    'description' => $this->description
                ]);

                if ($result == true) {
                    $this->id = self::$db->conn->lastInsertId();
                    return true;
                } else {
                    echo self::$db->conn->error;
                }
            } else {
                $sql = "UPDATE Item SET name = :name, price = :price, description = :description WHERE id = $this->id";

                $stmt = self::$db->conn->prepare($sql);
                $result = $stmt->execute([
                    'name' => $this->name,
                    'price' => $this->price,
                    'description' => $this->description
                ]);

                if ($result == true) {
                    return [json_encode($result)];
                }
            }
        } else {
            echo "Brak polaczenia\n";
        }
        return false;
    }

    public function delete() {
        $id = $this->getId();
        $sql = "DELETE FROM Item WHERE id=:id";
        $stmt = self::$db->conn->prepare($sql);
        $result = $stmt->execute(['id' => $id]);
        if ($result === true) {
            $this->id = -1;
            return [json_encode($this)];
        } else {
            return [];
        }
        
    }
    
//    public function delete() {
//        return [json_encode('hejjj')];
//    }

    static public function loadAll() {
        self::connect();
        $sql = "SELECT * FROM Item";
        $returnTable = [];
        if ($result = self::$db->conn->query($sql)) {
            foreach ($result as $row) {
                $loadedItem = new Item();
                $loadedItem->id = $row['id'];
                $loadedItem->name = $row['name'];
                $loadedItem->price = $row['price'];
                $loadedItem->description = $row['description'];
                $returnTable[] = $loadedItem;
            }
        }
        return $returnTable;
    }

    static public function loadById($id) {
        self::connect();
        $sql = "SELECT * FROM Item WHERE id=$id";
        $result = self::$db->conn->query($sql);
        if ($result && $result->rowCount() == 1) {
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $loadedItem = new Item();
            $loadedItem->id = $row['id'];
            $loadedItem->name = $row['name'];
            $loadedItem->price = $row['price'];
            $loadedItem->description = $row['description'];
            return $loadedItem;
        }
        return null;
    }
    
    public function jsonSerialize() {
        //metoda interfejsu
        //ta tablica bedzie zwrocona przy przekazaniu obiektu do json_encode()
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
        ];
    }

  }
  // sql query for creating table for Items

  /*
   CREATE TABLE Item (
           id int AUTO_INCREMENT,
           name text(20) NOT NULL,
           price float NOT NULL,
           description varchar(255) NOT NULL,
           PRIMARY KEY(id)
           );
           */
