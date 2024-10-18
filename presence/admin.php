<?php
// On démarre la session
session_start();

// On inclut le fichier de connexion à la base de données
include_once 'config.php';

// Vérifier si le statut est "Administrateur"
if ($_SESSION['statut'] !== 'admin') {
    header('Location: index.php');
    exit();
}

// Récupération de tous les utilisateurs pour l'affichage
$query = "SELECT * FROM utilisateurs";
$stmt = $pdo->prepare($query);
$stmt->execute();
$utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="admin.css"> 
</head>
<body>
    <header>
        <div class="gauche">
            <p>Bienvenue, Administrateur</p>
        </div>
        <div class="droite">
            <button onclick="location.href='deconnexion.php';">Déconnexion</button>
        </div>
    </header>

    <!-- Barre de navigation -->
    <div class="nav">
        <a href="#">Accueil</a>
        <a href="#">Gestion des utilisateurs</a>
        <a href="#">Paramètres</a>
    </div>

    <!-- Section principale -->
    <div class="info">
        <div class="left">
            <h1>Liste des Utilisateurs</h1><br>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Preom</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($utilisateurs as $utilisateur) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($utilisateur['id_utilisateur']); ?></td>
                        <td><?php echo htmlspecialchars($utilisateur['nom']); ?></td>
                        <td><?php echo htmlspecialchars($utilisateur['prenom']); ?></td>
                        <td><?php echo htmlspecialchars($utilisateur['statut']); ?></td>
                        <td>
                            <a href="edit_user.php?id=<?php echo $utilisateur['id_utilisateur']; ?>" class="modifier">Modifier</a> |
                            <a href="delete_user.php?id=<?php echo $utilisateur['id_utilisateur']; ?>" class="supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">Supprimer</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="right">
            <h1>Ajouter un nouvel utilisateur</h1>
            <form method="post" action="add_user.php">
                

                <label for="identifiant">Identifiant :</label>
                <input type="text" id="identifiant" name="identifiant" placeholder="Identifiant" required><br>
                
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" placeholder="Nom" required><br>

                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" placeholder="Prénom" required><br>

                <label for="email">Email :</label>
                <input type="email" id="email" name="email" placeholder="Email" required><br>

                <label for="statut">Statut :</label>
                <select name="statut" id="statut">
                    <option value="Enseignant">Enseignant</option>
                    <option value="Etudiant">Etudiant</option>
                    <option value="admin">Admin</option>
                </select><br>

                <label for="classe">Classe :</label>
                <input type="text" id="classe" name="classe" placeholder="Classe" required><br>

                <label for="num_badge">Numéro de Badge :</label>
                <input type="text" id="num_badge" name="num_badge" placeholder="Numéro de Badge" required><br>

                <label for="mdp">Mot de passe :</label>
                <input type="password" id="mdp" name="mdp" placeholder="Mot de passe" required><br>

                <div class="ajouter">
                    <button type="submit">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

