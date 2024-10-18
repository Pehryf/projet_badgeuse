
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
        $nombre_retard = $user['nombre_retard'];
        $nombre_absences = $user['nombre_absences'];
        $absence_justifier = $user['absence_justifier'];

        if($nombre_absences == NULL) {
            $nombre_absences = 0;
        }

        if($nombre_retard == NULL) {
            $nombre_retard = 0;
        }
    } else {
        echo "Utilisateur non trouvé.";
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eleve</title>
    <link rel="stylesheet" href="./elev.css">
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
                    <button>se déconnecter</button>
                </a>
            </div>
        </header>
        <div class="nav">
            <a href="./alerte.php">Vie scolaire</a>
            <a href="#">Home</a>
            <a href="./calendrier_profs.php">Emploie du temps</a> 
        </div>
        <section class="info">

            <div class="left">

                <div class="retard">
                    <p>Nombre de Retards</p>
                    <div>
                        <?php echo $nombre_retard; ?>
                    </div>
                </div>
                    
                <div class="absence">
                    <p>Nombre d'absences</p>
                    <div>
                        <?php echo $nombre_absences; ?>
                    </div>
                </div>

                
            </div>

            <div class="right">
                <div class="barre"></div>
        <p id='p1'></p>
        <p id='p2'></p>
        <p id='p3'></p>



        <?php
            setlocale(LC_TIME, 'fr_FR.UTF-8'); // Définit la langue en français
            $jour = strftime('%A'); // Renvoie le jour en toutes lettres
            echo $jour;
            if($jour == 'Monday' || 'Tuesday' || 'Wednesday' || 'Thursday' || 'Friday') {
                ?> 
                <div class="containeur">
                    <div class="item heure">8h10</div>
                    <div class="item tt">Travail</div>
                    <div class="item heure">12h00</div>
                    <div class="item deje">Déjeuner</div>
                    <div class="item">13h</div>
                    <div class="item">Travail</div>
                    <div class="item">17h00</div>
                </div>
                <?php

                
            } elseif ($jour == 'Saturday' || 'Sunday') {
                echo "moi";
            } else {
                echo "Aucun évenement se jour !";
            }
            
        ?>
            </div>
        </section>
        
    </body>
</html>
