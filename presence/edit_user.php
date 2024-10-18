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

// Vérifier si l'ID de l'utilisateur à modifier est passé dans l'URL
if (isset($_GET['id'])) {
    $id_utilisateur = $_GET['id'];

    // Récupérer les informations actuelles de l'utilisateur
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE id_utilisateur = ?");
    $stmt->execute([$id_utilisateur]);
    $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$utilisateur) {
        echo "Utilisateur non trouvé.";
        exit();
    }

    // Vérifier si le formulaire a été soumis pour la mise à jour
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $email = htmlspecialchars($_POST['email']);
        $statut = htmlspecialchars($_POST['statut']);
        $classe = htmlspecialchars($_POST['classe']);
        $num_badge = htmlspecialchars($_POST['num_badge']);
        
        // Validation des champs
        if (!empty($nom) && !empty($prenom) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Mettre à jour l'utilisateur
            $query = "UPDATE utilisateurs SET nom = ?, prenom = ?, email = ?, statut = ?, classe = ?, num_badge = ? WHERE id_utilisateur = ?";
            $stmt = $pdo->prepare($query);
            
            if ($stmt->execute([$nom, $prenom, $email, $statut, $classe, $num_badge, $id_utilisateur])) {
                // Redirection après la mise à jour réussie
                header('Location: admin.php');
                exit();
            } else {
                $erreur = "Erreur lors de la mise à jour. Veuillez réessayer.";
            }
        } else {
            $erreur = "Veuillez remplir tous les champs correctement.";
        }
    }
} else {
    echo "ID utilisateur non spécifié.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'utilisateur</title>
    <link rel="stylesheet" href="elevee.css">
</head>
<body>
    <h1>Modifier l'utilisateur</h1>

    <?php if (isset($erreur)): ?>
        <p style="color:red;"><?php echo $erreur; ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" value="<?php echo htmlspecialchars($utilisateur['nom']); ?>" required><br><br>

        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" id="prenom" value="<?php echo htmlspecialchars($utilisateur['prenom']); ?>" required><br><br>

        <label for="email">Email :</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($utilisateur['email']); ?>" required><br><br>

        <label for="statut">Statut :</label>
        <select name="statut" id="statut" required>
            <option value="admin" <?php if ($utilisateur['statut'] == 'admin') echo 'selected'; ?>>Admin</option>
            <option value="enseignant" <?php if ($utilisateur['statut'] == 'enseignant') echo 'selected'; ?>>Enseignant</option>
            <option value="eleve" <?php if ($utilisateur['statut'] == 'eleve') echo 'selected'; ?>>Élève</option>
        </select><br><br>

        <label for="classe">Classe :</label>
        <input type="text" name="classe" id="classe" value="<?php echo htmlspecialchars($utilisateur['classe']); ?>"><br><br>

        <label for="num_badge">Numéro de badge :</label>
        <input type="text" name="num_badge" id="num_badge" value="<?php echo htmlspecialchars($utilisateur['num_badge']); ?>"><br><br>

        <button type="submit" onclick="this.disabled=true;this.form.submit();">Mettre à jour</button>
    </form>

    <a href="admin.php">Retour à la liste des utilisateurs</a>
</body>
</html>
