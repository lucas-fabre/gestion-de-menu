<?php

session_start();

$con = new PDO('mysql:host=localhost;dbname=gestion-menu', 'root', '');

if(isset($_POST['connexion'])) 
{
    if (!empty($_POST['email']) && !empty($_POST['motdepasse']))
    {
      $email = $_POST['email'];
      $mdp = $_POST['motdepasse'];

        if($email !== "" && $mdp !== "") 
        {
            $sql = "SELECT * FROM user WHERE login = '$email' AND password = '$mdp' ";
            $statement = $con->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll();
            if(empty($result)) // Si la recherche dans la BDD renvoie aucune valeur, alors:
            {
                echo('Utilisateur ou MDP incorrect !'); 
            }
            if(!empty($result)) 
            {
                foreach(array_column($result, 'login') as $emailresult) //Vérification de la présence du login dans la colonne login de la BDD.
                {   
                    foreach(array_column($result, 'password') as $mdpresult) ////Vérification de la présence du password dans la colonne password de la BDD.
                    {
                        if($emailresult == $email && $mdpresult == $mdp) // Si les deux valeurs 'login' et 'password' correspondent entre la BDD 
                                                                         // et les données rentrées dans le form, alors:
                        {
                            //echo("Utilisateur existe");
                            $_SESSION['username'] = $email; // Créé une nouvelle session avec les identifiants valides.
                            header('Location: ../php/index.php'); // Redirige vers la page du livre d'or.
                        }
                    }
                }
            }    
        }      
    }
}

if(isset($_POST['envoyer']))
{
  if (!empty($_POST['email2']) && !empty($_POST['motdepasse2']))
    {
        $email2 = $_POST['email2'];
        $mdp2 = $_POST['motdepasse2'];

        $sql = "INSERT INTO user (Id, login, password) VALUES ('', '$email2', '$mdp2');";
        $con->query($sql);
        header('Location: ../php/gestion.php'); // Redirection vers la page du livre d'or une fois l'inscription réalisée.
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription/connexion</title>
    <link rel="stylesheet" type="text/css" href="../css/co-in.css">
</head>
<body>
    <div class="left">
    <h1>Inscription !</h1>
    <form action="<?php echo($_SERVER['REQUEST_URI']); ?>" method="post">
        <div class="inputbox">
            <input type="text" required="required" name="email2" id="eml" value="" />
            <span>Email</span>
        </div>
        
        <div class="inputbox">
            <input type="text" required="required" name="motdepasse2" id="mdp" value="" />
            <span>Mot de passe</span>
        </div>
        
        <div class="inputbox">
            <input type="submit" value="Rejoindre" id="btn" name= "envoyer">
        </div>
    </form>
    </div>

    <div class="right">
        <h1>Connexion</h1>
        <form action="<?php echo($_SERVER['REQUEST_URI']); ?>" method="post">
                <div class="inputbox">
                    <input type="text" required="required" name="email" id="login" value="" />
                    <span>Email</span>
                </div>

                <div class="inputbox">
                    <input type="password" required="required" name="motdepasse" id="password" value="" />
                    <span>Mot de passe</span>
                </div>

                <div class="inputbox">
                    <input type="submit" value="Connexion" id="btn" name= "connexion">
                </div>
        </form>
    </div>
</body>
</html>