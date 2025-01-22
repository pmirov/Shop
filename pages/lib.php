<?php


class Tools
{
    static function ConnectSQL()
    {

        $host = "localhost";
        $user = "root";
        $password = "";
        $dbname = "shop2024";
        $connect = "mysql:host=$host;dbname=$dbname; charset=utf8;";
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_BOTH,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'
        );

        try {
            return new PDO($connect, $user, $password, $options);
        } catch (PDOException $e) {
        }
    }
}

class Menu
{

    static function Getpage($page)
    {
        if (strlen($page) <= 0) {
            //тут будет хомепадж
            return;
        }
        switch ($page) {
            case "admin":
                include_once("./pages/admin.php");
                break;
            case "cart":
                include_once("./pages/cart.php");
                break;
            case "reg":
                include_once("./pages/registration.php");
                break;
            case "report":
                include_once("./pages/reports.php");
                break;
            case "catalog":
                include_once("./pages/catalog.php");
                break;
            case "login":
                include_once("./pages/login.php");
                break;
            case "logout":
                include_once("./pages/logout.php");
                break;
            default:
                include_once("./pages/error.php");
                break;
        }
    }
}

class Customer
{
    public $id;
    public $login;
    public $PASSWORD;
    public $roleId;
    public $discount;
    public $total;
    public $imagepath;

    function __construct($login, $password, $roleId, $discount, $total, $imagepath, $id = 0)
    {
        $this->login = $login;
        $this->PASSWORD = $password;
        $this->roleId = $roleId;
        $this->discount = $discount;
        $this->total = $total;
        $this->imagepath = $imagepath;
        $this->id = $id;
    }

    function WriteDB()
    {

        try {
            $connect = Tools::ConnectSQL();
            $query = $connect->prepare("INSERT INTO Customers(login, PASSWORD, roleId, discount, total, imagepath) 
                                    VALUES (:login,
                                            :PASSWORD,
                                            :roleId,
                                            :discount,
                                             :total,
                                             :imagepath)");
            $options = (array)$this;
            array_shift($options);
            $query->execute($options);
        } catch (Exception $e) {
            echo "error $e";
        }
    }

    static function GetDB($id)
    {
        try {
            $connect = Tools::ConnectSQL();
            $query = $connect->prepare("SELECT * FROM Customers WHERE id=?");
            $query->execute(array($id));
            $user = $query->fetch();
            return new Customer(
                $user['login'],
                $user['PASSWORD'],
                $user['roleId'],
                $user['discount'],
                $user['total'],
                $user['imagepath'],
                $user['id']
            );
        } catch (Exception $e) {
            echo "error: $e";
        }
    }
    static function GetAll()
    {
        try {
            $connect = Tools::ConnectSQL();
            $query = $connect->prepare("SELECT * FROM Customers");
            $query->execute();
            $users = array();
            while ($row = $query->fetch()) {
                $users[] = new Customer(
                    $row['login'],
                    $row['PASSWORD'],
                    $row['roleId'],
                    $row['discount'],
                    $row['total'],
                    $row['imagepath'],
                    $row['id']
                );
            }
            return $users;
        } catch (Exception $e) {
            echo "error: $e";
            return [];
        }
    }
}

class Item
{
    public $id;
    public $name;
    public $CategoriId;
    public $price;
    public $pricesale;
    public $information;
    public $rate;
    public $imagepath;
    public $action;

    function __construct(
        $name,
        $CategoriId,
        $price,
        $pricesale,
        $information,
        $rate,
        $imagepath,
        $action,
        $id = 0
    ) {
        $this->name = $name;
        $this->CategoriId = $CategoriId;
        $this->price = $price;
        $this->pricesale = $pricesale;
        $this->information = $information;
        $this->rate = $rate;
        $this->imagepath = $imagepath;
        $this->action = $action;
        $this->id = $id;
    }
    function Add()
    {
        try {
            $connection = Tools::ConnectSQL();
            $query = $connection->prepare("INSERT INTO Items (name, CategoriId, price, pricesale, information, rate, imagepath, action) 
                                  values (
                                   :name,
                                   :CategoriId,
                                   :price,
                                   :pricesale,
                                   :information,
                                   :rate,
                                   :imagepath,
                                   :action)");
            $array = (array)$this;
            array_shift($array);
            $query->execute($array);
        } catch (Exception $e) {
            echo "error: $e";
        }
    }

    static function Show($id)
    {
        try {
            $connection = Tools::ConnectSQL();
            $query = $connection->prepare("SELECT * FROM Items where id=?;");
            $query->execute(array($id));
            $item = $query->fetch();
            return new Item(
                $item['name'],
                $item['CategoriId'],
                $item['price'],
                $item['pricesale'],
                $item['information'],
                $item['rate'],
                $item['imagepath'],
                $item['action'],
                $item['id']
            );
        } catch (Exception $e) {
            echo "error: $e";
        }
    }

    static function GetItems($categoriId = -1)
    {
        try {
            $connection = Tools::ConnectSQL();
            $table = null;
            if ($categoriId == -1) {
                $table = $connection->prepare("select * from Items");
                $table->execute();
            } else {
                $table = $connection->prepare("select * from Items where CategoriId =?;");
                $table->execute(array($categoriId));
            }
            $elements = array();
            while ($row = $table->fetch()) {
                $elements[] = new Item(
                    $row['name'],
                    $row['CategoriId'],
                    $row['price'],
                    $row['pricesale'],
                    $row['information'],
                    $row['rate'],
                    $row['imagepath'],
                    $row['action'],
                    $row['id']
                );
            }
            return $elements;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    function Draw()
    {
        echo '<div class="card" style="width: 18rem;">';
        echo "<img src='$this->imagepath' class='card-img-top' alt='$this->imagepath'>";
        echo '<div class="card-body">';
        echo "<h5 class='card-title'>$this->name</h5>";
        echo "<h5 class='card-title'>$this->price руб.</h5>";
        echo "<p class='card-text'>$this->information</p>";

        $itemName = "cart_";
        if (isset($_SESSION['name']) && $_SESSION['name'] != "") {
            $itemName = $_SESSION['name'] . "_";
        }

        $itemName .= $this->id;
        echo "<button  class='btn btn-primary' onclick='createCoockie(`$itemName`,`$this->id`)'> Добавить </button>";
        echo '</div></div>';
    }

    function DrawCart()
    {
        echo "<input type='hidden' name='item_$this->id' value='$this->id'>";
        echo '<div class="card" style="width: 18rem;">';
        echo "<img src='$this->imagepath' class='card-img-top' alt='$this->imagepath'>";
        echo '<div class="card-body">';
        echo "<h5 class='card-title'>$this->name</h5>";
        echo "<h5 class='card-title'>$this->price руб.</h5>";
        $itemName = "cart_";
        if (isset($_SESSION['name']) && $_SESSION['name'] != "") {
            $itemName = $_SESSION['name'] . "_";
        }

        $itemName .= $this->id;
        echo "<button  class='btn btn-primary' onclick='deleteCoockie(`$itemName`,`$this->id`)'> X </button>";
        echo '</div></div>';
    }
}

class Category
{
    public $id;
    public $name;

    function __construct($id, $name)
    {
        $this->name = $name;
        $this->id = $id;
    }
    static function Add($name)
    {
        try {
            $connection = Tools::ConnectSQL();
            $query = $connection->prepare("INSERT INTO Categories (name) VALUES (?)");
            $query->execute(array($name));
        } catch (Exception $e) {
            echo "error: $e";
        }
    }

    static function GetAll()
    {
        try {
            $connection = Tools::ConnectSQL();
            $query = $connection->prepare("SELECT * FROM Categories");
            $query->execute();
            $array = array();
            while ($row = $query->fetch()) {
                $array[] = $row;
            }
            return $array;
        } catch (Exception $e) {
            echo "error: $e";
        }
    }
}
