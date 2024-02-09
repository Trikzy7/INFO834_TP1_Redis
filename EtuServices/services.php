<?php
    define("SERVER", "localhost");
    define("USERNAME", "root");
    define("PWD", "");

        /*Connexion à la base de données sur le serveur tp-epua*/
        global $conn;
        $conn = @mysqli_connect(SERVER, USERNAME, PWD);

		/*connexion à la base de donnée depuis la machine virtuelle INFO642*/
		/*$conn = @mysqli_connect("localhost", "etu", "bdtw2021");*/

		if (mysqli_connect_errno()) {
            $msg = "erreur ". mysqli_connect_error();
        } else {
            $msg = "connecté au serveur " . mysqli_get_host_info($conn);
            /*Sélection de la base de données*/
            mysqli_select_db($conn, "info834");
            /*mysqli_select_db($conn, "etu"); */ /*sélection de la base sous la VM info642*/

            /*Encodage UTF8 pour les échanges avecla BD*/
            mysqli_query($conn, "SET NAMES UTF8");
        }
    echo $msg;

?>