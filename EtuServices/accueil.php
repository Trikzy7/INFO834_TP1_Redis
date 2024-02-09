<?php
session_start();

// Vérifier si l'user est connecté
if(isset($_SESSION['user'])) {
    // L'user est connecté, récupérer ses informations
    $user = $_SESSION['user'];
    $email = $user['email'];

    // Déconnexion de l'user si le bouton de déconnexion est cliqué
    if(isset($_POST['logout'])) {
        session_unset(); // Supprimer toutes les variables de session
        session_destroy(); // Détruire la session
        header('Location: login.php'); // Rediriger vers la page de connexion
        exit;
    }
} else {
    // L'user n'est pas connecté, rediriger vers la page de connexion
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Bienvenue</title>
</head>
<body>
    <h2>Bienvenue</h2>
    <p>Bienvenue, <?php echo $email; ?> !</p>
    <form method="post" action="">
        <input type="submit" name="logout" value="Se déconnecter">
    </form>
</body>
</html>
