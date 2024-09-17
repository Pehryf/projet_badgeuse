<?php
include 'config.php';

// Gestion des utilisateurs
if (isset($_POST['action_user'])) {
    $action = $_POST['action_user'];
    $id_user = $_POST['id_utilisateur'];  
    if ($action == 'delete') {
        $stmt = $pdo->prepare('DELETE FROM compte WHERE id = ?');
        $stmt->execute([$id_user]);
    } elseif ($action == 'update') {
        $identifiant = $_POST['identifiant'];  
        $mdp = password_hash($_POST['mdp'], PASSWORD_BCRYPT);  
        $stmt = $pdo->prepare('UPDATE compte SET identifiant = ?, mdp = ? WHERE id = ?');
        $stmt->execute([$identifiant, $mdp, $id_user]);
    } elseif ($action == 'create') {
        $identifiant = $_POST['identifiant'];  
        $mdp = password_hash($_POST['mdp'], PASSWORD_BCRYPT);  
        $stmt = $pdo->prepare('INSERT INTO compte (identifiant, mdp) VALUES (?, ?)');
        $stmt->execute([$identifiant, $mdp]);
    }
}

// Gestion des alertes
if (isset($_POST['action_alert'])) {
    $action = $_POST['action_alert'];
    $id_alerte = $_POST['id_alerte'];
    if ($action == 'delete') {
        $stmt = $pdo->prepare('DELETE FROM alertes WHERE id_alerte = ?');
        $stmt->execute([$id_alerte]);
    } elseif ($action == 'update') {
        $type_alerte = $_POST['type_alerte'];
        $stmt = $pdo->prepare('UPDATE alertes SET type_alerte = ? WHERE id_alerte = ?');
        $stmt->execute([$type_alerte, $id_alerte]);
    } elseif ($action == 'create') {
        $id_user = $_POST['id_user'];
        $type_alerte = $_POST['type_alerte'];
        $stmt = $pdo->prepare('INSERT INTO alertes (id_utilisateur, type_alerte, date_envoi) VALUES (?, ?, NOW())');
        $stmt->execute([$id_user, $type_alerte]);
    }
}

// Récupérer les utilisateurs et les alertes
$stmt = $pdo->prepare('SELECT * FROM compte');
$stmt->execute();
$utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare('SELECT * FROM alertes');
$stmt->execute();
$alertes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs et Alertes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Tableau de Bord Admin</h1>

        <!-- Gestion des utilisateurs -->
        <h2>Utilisateurs</h2>
        <table class="table table-bordered mt-4">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nom d'utilisateur</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($utilisateurs as $utilisateur): ?>
                <tr>
                    <td><?php echo $utilisateur['id']; ?></td>
                    <td><?php echo $utilisateur['identifiant']; ?></td>
                    <td>
                        <!-- Modifier un utilisateur -->
<form method="post">
    <input type="hidden" name="id_user" value="<?php echo $utilisateur['id']; ?>"> 
     <!-- id de la table compte -->
    <input type="text" name="identifiant" value="<?php echo $utilisateur['identifiant']; ?>" required>
    <input type="password" name="mdp" placeholder="Nouveau mot de passe">
    <button type="submit" name="action_user" value="update" class="btn btn-warning">Modifier</button>
    <button type="submit" name="action_user" value="delete" class="btn btn-danger">Supprimer</button>
</form>

                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <!-- Ajouter un utilisateur -->
        <h3>Ajouter un utilisateur</h3>
        <form method="post" class="mb-5">
            <input type="text" name="identifiant" placeholder="Nom d'utilisateur" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit" name="action_user" value="create" class="btn btn-success">Ajouter</button>
        </form>

        <!-- Gestion des alertes -->
        <h2>Alertes</h2>
        <table class="table table-bordered mt-4">
            <thead class="table-dark">
                <tr>
                    <th>ID Alerte</th>
                    <th>ID Utilisateur</th>
                    <th>Type d'alerte</th>
                    <th>Date d'envoi</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alertes as $alerte): ?>
                <tr>
                    <td><?php echo $alerte['id_alerte']; ?></td>
                    <td><?php echo $alerte['id_utilisateur']; ?></td>
                    <td><?php echo $alerte['type_alerte']; ?></td>
                    <td><?php echo $alerte['date_envoi']; ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="id_alerte" value="<?php echo $alerte['id_alerte']; ?>">
                            <select name="type_alerte">
                                <option value="Absence" <?php echo $alerte['type_alerte'] == 'Absence' ? 'selected' : ''; ?>>Absence</option>
                                <option value="Retard" <?php echo $alerte['type_alerte'] == 'Retard' ? 'selected' : ''; ?>>Retard</option>
                            </select>
                            <button type="submit" name="action_alert" value="update" class="btn btn-warning">Modifier</button>
                            <button type="submit" name="action_alert" value="delete" class="btn btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Ajouter une alerte -->
        <h3>Ajouter une alerte</h3>
        <form method="post">
            <select name="id_user">
                <?php foreach ($utilisateurs as $utilisateur): ?>
                    <option value="<?php echo $utilisateur['id']; ?>"><?php echo $utilisateur['identifiant']; ?></option>
                <?php endforeach; ?>
            </select>
            <select name="type_alerte">
                <option value="Absence">Absence</option>
                <option value="Retard">Retard</option>
            </select>
            <button type="submit" name="action_alert" value="create" class="btn btn-success">Ajouter</button>
        </form>
    </div>
</body>
</html>
