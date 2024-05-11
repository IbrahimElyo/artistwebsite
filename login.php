<?php
session_start();
include("connect.php");

// Vérification CSRF
if(empty($_SESSION["csrf_token"]) || $_SESSION["csrf_token"] != $_SESSION["csrf_token"]){
    header("Location: index.php");
    exit();
}

$error_message = '';
$add_success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $secret_code = $_POST['secret_code'];

    // Vérifier le code secret
    $sql = "SELECT `value` FROM `configurations` WHERE `key` = 'admin_secret'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $stored_hashed_secret = $stmt->fetchColumn();

    if ($_POST['action'] === 'add_admin' && password_verify($secret_code, $stored_hashed_secret)) {
        // Ajouter un nouvel admin
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO `administrateurs` (`username`, `password`) VALUES (?, ?)";
        $stmt = $db->prepare($sql);

        try {
            $stmt->execute([$username, $hashed_password]);
            $add_success_message = "<p class='successLogin'>Nouvel administrateur ajouté avec succès!</p>";
            echo $add_success_message;
        } catch (PDOException $e) {
            $error_message = "<p class='errorLogin'>Erreur lors de l'ajout d'un nouvel administrateur.</p>";
            echo $error_message;
        }
    } else {
        // Essai de connexion
        $sql = "SELECT `id`, `password` FROM `administrateurs` WHERE `username` = ?";
        $stmt = $db->prepare($sql);

        try {
            $stmt->execute([$username]);
            $row = $stmt->fetch();

            if ($row && password_verify($password, $row['password'])) {
                $_SESSION['user']['username'] = $username;
                $_SESSION['user']['role'] = 'admin'; 
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $row['id'];
                header("Location: espaceAdmin.php");
                exit();
            } else {
                $error_message = "<p class='errorLogin'>Nom d'utilisateur ou mot de passe incorrect.</p>";
                echo $error_message;
            }
        } catch (PDOException $e) {
            $error_message = "<p class='errorLogin'>Une erreur s'est produite. Veuillez réessayer plus tard.</p>";
            echo $error_message;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="fr" id="loginHtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Connexion</title>
</head>
<body id="loginPage">
    <form class='formLogin' action="login.php" method="post">
        <input type='hidden' name='csrf_token' value="<?=$_SESSION['csrf_token'];?>">
        <label for="username">Nom d'utilisateur</label>
        <input class='userLogin' type="text" name="username" id="username" required><br>
        <label for="password">Mot de passe</label>
        <input class='userPassword' type="password" name="password" id="password" required><br>
        <label for="secret_code">Code secret (pour création compte administrateur)</label>
        <input class='secretCodeLogin' type="password" name="secret_code" id="secret_code"><br>
        <input type="hidden" name="action" value="add_admin">
        <input id='submitLogin' type="submit" value="Se connecter/Ajouter">
    </form>
    
    <a class='boutonAccueilLoginPage' href="index.php">Accueil</a>
</body>
</html>



