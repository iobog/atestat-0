<?php
    $server="localhost";
    $user="root";
    $password="Parola2019";
    $base="magazin";
    $id_conection=@mysqli_connect("$server","$user","$password","$base");
    if(!$id_conection)
    {
        die("Could not connect to: ".mysqli_connect_error());
    }
?>