<?php
session_start();
include 'config.php';

$username = $_POST['username'];
$password = $_POST['password'];

// Pour l'exemple : admin et admin
if ($username === 'admin' && $password === 'admin') {
    $_SESSION['loggedin'] = true;
    header('Location: admin.php');
} else {
    echo 'Nom d\'utilisateur ou mot de passe incorrect.';
}
?>
