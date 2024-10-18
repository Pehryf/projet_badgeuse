
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./styles.css">
</head>
<body>
    <div class="conteneur">

        <form method="POST"> 
            <div class="image">
                <img src="./media/profile" alt="profile">
            </div>

            <div class="formulaire">
                <h1>Connexion</h1>
                <input type="text" name="pseudo" id="pseudo" autocomplete="off" require placeholder="Identifident"> <br>
                <input type="password" name="mdp" id="mdp" autocomplete="off" require placeholder="mot de passe"> <br> <br>
                <a href="#">mot de passe oublier</a> <br>
                <button name="envoie">Envoyer</button>
            </div>
            <?php
session_start();
// Connexion à la base de données
$bdd = new PDO('mysql:host=localhost;dbname=cantine;charset=utf8;', 'root', '');

if (isset($_POST['envoie'])) {
    // Vérifier si les champs pseudo et mot de passe sont remplis
    if (!empty($_POST['pseudo']) AND !empty($_POST['mdp'])) {
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mdp = $_POST['mdp'];

        // Récupérer les données de l'utilisateur dans la base
        $recup = $bdd->prepare('SELECT * FROM utilisateurs WHERE identifiant = ?');
        $recup->execute(array($pseudo));

        // Si l'utilisateur est trouvé
        if ($recup->rowCount() > 0) {
            $user = $recup->fetch();

            // Vérifier si le mot de passe est haché ou non
            if (password_verify($mdp, $user['mdp'])) {
                // Le mot de passe est correct et haché
                $_SESSION['pseudo'] = $user['identifiant'];
                $_SESSION['mdp'] = $user['mdp'];
                $_SESSION['id'] = $user['id_utilisateur'];
                $_SESSION['statut'] = $user['statut'];

                // Redirection de l'utilisateur selon son statut
                if ($_SESSION['statut'] == 'Etudiant') {
                    header('Location: eleve.php');
                } elseif ($_SESSION['statut'] == 'Enseignant') {
                    header('Location: prof.php');
                } elseif ($_SESSION['statut'] == 'admin') {
                    header('Location: admin.php');
                }
            } elseif ($mdp === $user['mdp']) {
                // Comparaison simple si le mot de passe n'est pas haché
                $_SESSION['pseudo'] = $user['identifiant'];
                $_SESSION['mdp'] = $user['mdp'];
                $_SESSION['id'] = $user['id_utilisateur'];
                $_SESSION['statut'] = $user['statut'];

                if ($_SESSION['statut'] == 'Etudiant') {
                    header('Location: eleve.php');
                } elseif ($_SESSION['statut'] == 'Enseignant') {
                    header('Location: prof.php');
                } elseif ($_SESSION['statut'] == 'admin') {
                    header('Location: admin.php');
                }
            } else {
                echo "Mot de passe incorrect !";
            }
        }
    } else {
        echo "Veuillez remplir tous les champs !";
    }
}
?>
        </form>
    </div>
</body>
</html>