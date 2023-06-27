<?php

class CRUD
{   

    public function __construct()
    {
        $this->con = new PDO('mysql:host=localhost;dbname=gestion-menu', 'root', '');
    }
    
    // Connection test function
    // function testconnection()
    // {
    //     if ($this->con == true)
    //     {
    //         echo "Connected";
    //     }
    //     else
    //     {
    //         echo "Not connected";
    //     }
    // }

    //SQL infos//
    public $sqlname = "carte";
    public $sql0 = "id";
    public $sql1 = "produit";
    public $sql2 = "prix";
    public $sql3 = "description";
    public $sql4 = "catégorie";
    public $sql5 = "image";

    
    //Add an element to the specific table in the database//
    public function addproduct($add1, $add2, $add3, $add4)
    {
        if(isset($_POST["btn_add"]))
        {
            if (!empty($add1) && !empty($add2) && !empty($add3) && !empty($add4))
            {   
                //$exec_add permit to prepare the SQL command that add product and it's informations to the database. 
                //"$this->con" get the PDO command informations, use it to connect to the database and protect for SQL injection. 
                $exec_add = $this->con->prepare("INSERT INTO $this->sqlname ($this->sql0, $this->sql1, $this->sql2, $this->sql3, $this->sql4, $this->sql5) VALUES ('', '$add1','$add2', '$add3', '$add4', '');");
                $exec_add->execute();
                echo "Added to DB";
            }
            else
            {
                echo "Didn't add to DB";
            }
        }
    }
    
    public function updateproduct($update1, $update2, $update3, $update4, $update5)
    {
        if (!empty($update1))
        {
            $exec_update = $this->con->prepare("UPDATE $this->sqlname SET '', $this->sql1 = $update1, $this->sql2 = $update2, $this->sql3 = $update3, $this->sql4 = $update4, $this->sql5 = $update5' WHERE $sql1 = $update1;");
            $exec_update->execute();
            echo "Updated to DB";
        }
        else
        {
            echo "Didn't updated to DB";
        }
    }
}
// $test = new CRUD();
// $test->testconnection();
// $test->addproduct("Tomate", "0.50€", "Tomate rouge du jardin", "Ingrédient", "Tomate.png");
// $test->updateproduct("Tomate", "1€", "Tomate rouge du jardin", "Ingrédient", "Tomate.png");
// var_dump($test);
?>


