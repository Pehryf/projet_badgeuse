<?php
// On démarre la session
session_start();

// On inclut le fichier de connexion à la base de données
include_once 'config.php';

// Vérifier si l'utilisateur est un administrateur
if ($_SESSION['statut'] !== 'admin') {
    header('Location: index.php');
    exit();
}

// Vérifier si l'ID de l'utilisateur à supprimer est passé dans l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Préparer la suppression de l'utilisateur
    $stmt = $pdo->prepare("DELETE FROM utilisateurs WHERE id_utilisateur = ?");
    if ($stmt->execute([$id])) {
        // Redirection après suppression
        header('Location: admin.php');
        exit();
    } else {
        echo "Erreur lors de la suppression de l'utilisateur.";
    }
} else {
    echo "ID utilisateur non spécifié.";
}
?>
