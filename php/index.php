<?php
require 'crud.php';
require 'upload.php';

session_start();

if($_SESSION['username'] !== ""){
    $user = $_SESSION['username'];
    echo "Bonjour $user, vous êtes connecté";
}

$con = new PDO('mysql:host=localhost;dbname=gestion-menu', 'root', '');
$sql = "SELECT * FROM carte";
$result = $con->query($sql);

$crud = new CRUD;
$upload = new Image;

$crud->addproduct($_POST["add_prod"], $_POST["add_price"], $_POST["add_descr"], $_POST["add_cat"]);
$upload->addimage($_POST["add_pic"]);

// var_dump($crud);
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de menu</title>
    <link rel="stylesheet" type="text/css" href="../css/gestion.css">
</head>
<body>
    <!-- TABLE PART -->
    <table class = "table">
        <thead>
            <tr>
                <th colspan="5">Gestion de la carte</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Produit</td>
                <td>Prix</td>
                <td>Description</td>
                <td>Catégorie</td>
                <td>Image</td>
            </tr>
            <!-- Loop that permit to get all data from table "carte" -->
            <?php while($management = $result->fetch()){?>
            <!-- Display data ordered by columns -->
            <tr>
                <td> <?php echo $management["produit"] ?></td>
                <td> <?php echo $management["prix"] ?></td>
                <td> <?php echo $management["description"] ?></td>
                <td> <?php echo $management["catégorie"] ?></td>
                <td> <?php echo $management["image"] ?></td>
            </tr>
            <?php }?>
        </tbody>
    </table>

    <!-- ADD FORM PART  -->
    <div class = "add">
        <form action="<?php echo($_SERVER['REQUEST_URI']); ?>" method="post">
        
            <!-- "required" means all the input must be completed to add data in database -->
            <div class="inputbox">
                <span>Produit :</span>
                <input type="text" required="required" name="add_prod" value="" />  
            </div>

            <div class="inputbox">
                <span>Prix :</span>
                <input type="text" required="required" name="add_price" value="" />
            </div>

            <div class="inputbox">
                <span>Description :</span>
                <input type="text" required="required" name="add_descr" value="" />
            </div>
            
            <div class="inputbox">
                <span>Catégorie :</span>
                <select name="add_cat" id="lang">
                    <option value="vide">Catégorie</option>
                    <option value="Ingrédient">Ingrédient</option>
                    <option value="Plat">Plat</option>
                    <option value="Menu">Menu</option>
                </select>
            </div>
        
            <div>
                <span>Image :</span>
                <input type="file" name="add_pic" id="fileToUpload">
            </div>

            <div class="inputbox">
                <input type="submit" value="Ajouter" name= "btn_add">
            </div>
        </form>
    </div>
   
    <!-- UPDATE FORM PART -->
    <div class="modification">
        <h1>Modifier un produit</h1>
        <form action="<?php echo($_SERVER['REQUEST_URI']); ?>" method="post">
            <div class="inputbox">
                <span>Produit</span>  
                <input type="text" required="required" name="modif_prod" value="" />  
            </div>

            <div class="inputbox">
                <span>Prix</span>
                <input type="text" required="required" name="modif_price" value="" />
            </div>

            <div class="inputbox">
                <span>Description</span>
                <input type="text" required="required" name="modif_descr" value="" />
            </div>
            
            <div class="inputbox">
                <select name="modif_category" id="lang">
                    <option value="vide">Catégorie</option>
                    <option value="ingredient">Ingrédient</option>
                    <option value="plat">Plat</option>
                    <option value="menu">Menu</option>
                </select>
            </div>

            <div class="inputbox">
                <input type="submit" value="Modifier" name= "btn_modif">
            </div>
        </form>
    </div>
</body>
</html>