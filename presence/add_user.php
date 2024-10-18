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

// Fonction pour récupérer le premier ID disponible
function getAvailableID($pdo) {
    // Requête pour obtenir les IDs existants
    $stmt = $pdo->query("SELECT id_utilisateur FROM utilisateurs ORDER BY id_utilisateur ASC");
    $ids = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Chercher le premier ID manquant dans la séquence
    $expectedID = 1;
    foreach ($ids as $id) {
        if ($id != $expectedID) {
            return $expectedID;
        }
        $expectedID++;
    }

    // Si aucun trou, retourner l'ID suivant dans la séquence
    return $expectedID;
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $identifiant = $_POST['identifiant'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $statut = $_POST['statut'];
    $classe = $_POST['classe'];
    $num_badge = $_POST['num_badge'];
    $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT); // Hachage du mot de passe pour la sécurité

    // Obtenir le premier ID disponible
    $id_utilisateur = getAvailableID($pdo);

    // Préparation de l'insertion dans la base de données
    $query = "INSERT INTO utilisateurs (id_utilisateur,identifiant, nom, prenom, email, statut, classe, num_badge, mdp) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    
    // Exécution de la requête avec les données du formulaire
    if ($stmt->execute([$id_utilisateur,$identifiant, $nom, $prenom, $email, $statut, $classe, $num_badge, $mdp])) {
        // Redirection après ajout
        header('Location: admin.php');
        exit();
    } else {
        echo "Erreur lors de l'ajout de l'utilisateur.";
    }
}
?>
