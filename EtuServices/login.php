<?php
session_start();

// Connexion à la base de données
$bdd = new PDO('mysql:host=localhost;dbname=info834', 'root', '');

if(isset($_POST['email']) && isset($_POST['password'])) {
    // Récupération des données envoyées par le formulaire
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Requête pour récupérer l'user avec l'email correspondant
    $query = $bdd->prepare('SELECT * FROM user WHERE email = :email');
    $query->execute(array(':email' => $email));
    $user = $query->fetch();

    // var_dump($user);

    // Vérification du mot de passe
    if($user && $password == $user['mdp']) {
        // Authentification réussie
        $_SESSION['user']['email'] = $user['email'];
        $_SESSION['user']['name'] = $user['name'];
        $_SESSION['user']['firstname'] = $user['firstname'];


        // Lancer le script python
        $cmd = "/opt/homebrew/Cellar/python@3.11/3.11.7_1/Frameworks/Python.framework/Versions/3.11/Resources/Python.app/Contents/MacOS/Python /Applications/XAMPP/xamppfiles/htdocs/projects/IDU4/S8/INFO834/TP1_Redis/EtuServices/script.py ". $_SESSION['user']['email'];
        $command = escapeshellcmd($cmd);
        $shelloutput = shell_exec($command);

        // Redirection vers la page d'accueil si le script python return true (1)
        if(intval($shelloutput) == 1) {
            header('Location: accueil.php'); // Redirection vers la page accueil
        }
        else {
            echo "Trop de connexion lors des 10 dernières minutes. Veuillez réessayer plus tard.";
        }
        

        exit;
    } else {
        // Identifiants incorrects
        $erreur = "Adresse email ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
</head>
<body>
    <h2>Connexion</h2>
    <?php if(isset($erreur)) { echo '<div style="color:red;">' . $erreur . '</div>'; } ?>
    <form method="post" action="">
        <label>Email :</label><br>
        <input type="email" name="email" required><br><br>
        <label>Mot de passe :</label><br>
        <input type="password" name="password" required><br><br>
        <input type="submit" value="Se connecter">
    </form>
</body>
</html>
