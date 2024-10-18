<?php
    // vérification que la session est bien connecter 
    session_start();

    // Vérifier si l'identifiant et le mot de passe sont présents
    if (!isset($_SESSION['id']) || !isset($_SESSION['mdp'])) {
        header('Location: index.php');
        exit(); // Assurez-vous d'arrêter l'exécution du script après redirection
    }

    // Vérifier si le statut est "Etudiant"
    if ($_SESSION['statut'] !== 'Enseignant') {
        header('Location: index.php');
        exit();
    }
    include("config.php"); // Connexion à la base de données
    // Supposons que l'ID utilisateur soit stocké dans la session
    $user_id = $_SESSION['id'];

    // Préparer la requête SQL pour récupérer les données de l'utilisateur selon l'ID
    $sql = "SELECT * FROM utilisateurs WHERE id_utilisateur = :id_utilisateur";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id_utilisateur' => $user_id]);

    // Récupérer les données sous forme de tableau associatif
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si l'utilisateur est trouvé, on stocke les données dans des variables
    if ($user) {
        $nom = $user['nom'];
        $prenom = $user['prenom'];
        $photo = $user['photo'];
    } else {
        echo "Utilisateur non trouvé.";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./calendriers.css"> 
    <script src='script.js' async></script>
</head>
<body>
<header>
            <div class="gauche">
            
                <?php
                    if ($photo == NULL) {
                        echo '<img src="./media/profile.png" alt="profile">';
                    } else {
                        // On encode l'image blob en base64 et on l'affiche dans l'attribut src
                        $image = base64_encode($photo);
                        echo '<img src="data:image/jpeg;base64,' . $image . '" alt="profile">';
                    }
                ?>
                
                <p><?php echo $nom, " ", $prenom?></p>
            </div>
            <div class="droite">
                <a href="./deconnexion.php">
                    <button>se déconnecté</button>
                </a>
            </div>
        </header>
        <div class="nav">
            <a href="#">Vie scolaire</a>
            <a href="./prof.php">Home</a>
            <a href="#">Emploi du temps</a> 
        </div>

        <section>
            <div class="aujourdhui">
                <p id='p1'></p>
                <p id='p2'></p>
                <p id='p3'></p>
            </div>
                <div class="conteneur">
                    <div>
                        <div class="item">Lundi</div>
                        <div class="item">Mardi</div>
                        <div class="item">Merdi</div>
                        <div class="item">Jeudi</div>
                        <div class="item">Vendredi</div>
                        <div class="item">Samendi</div>
                        <div class="item">dimache</div>
                        <div class="item heure">8h10</div>
                        <div class="item heure">8h10</div>
                        <div class="item heure">8h10</div>
                        <div class="item heure">9h10</div>
                        <div class="item heure">8h10</div>
                        <div class="item heure"></div>
                        <div class="item heure"></div>
                        <div class="item tt">Travail</div>
                        <div class="item tt">Travail</div>
                        <div class="item tt">Travail</div>
                        <div class="item tt">Travail</div>
                        <div class="item tt">Travail</div>
                        <div class="item conge">Congés</div>
                        <div class="item conge">Congés</div>
                        <div class="item heure">12hh10</div>
                        <div class="item heure">12h10</div>
                        <div class="item heure">12h10</div>
                        <div class="item heure">12h10</div>
                        <div class="item heure">12h10</div>
                        <div class="item heure"></div>
                        <div class="item heure"></div>
                        <div class="item dejeuner">Déjeuner</div>
                        <div class="item dejeuner">Déjeuner</div>
                        <div class="item dejeuner">Déjeuner</div>
                        <div class="item dejeuner">Déjeuner</div>
                        <div class="item dejeuner">Déjeuner</div>
                        <div class="item conge"></div>
                        <div class="item conge"></div>
                        <div class="item heure">13h</div>
                        <div class="item heure">13h</div>
                        <div class="item heure">13h</div>
                        <div class="item heure">13h</div>
                        <div class="item heure">13h</div>
                        <div class="item heure"></div>
                        <div class="item heure"></div>
                        <div class="item tt">Travail</div>
                        <div class="item tt">Travail</div>
                        <div class="item tt">Travail</div>
                        <div class="item tt">travail</div>
                        <div class="item tt">Travail</div>
                        <div class="item conge"></div>
                        <div class="item conge"></div>
                        <div class="item heure">17h</div>
                        <div class="item heure">17h</div>
                        <div class="item heure">17h</div>
                        <div class="item heure">17h</div>
                        <div class="item heure">17h</div>
                        <div class="item heure"></div>
                        <div class="item heure"></div>
                    </div>
                </div>
        </section>
</body>
</html>