<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . "/PHPMailer/src/Exception.php";
require __DIR__ . "/PHPMailer/src/PHPMailer.php";

$mail = new PHPMailer(true);

// Fonction pour valider une adresse email
function is_valid_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// Fonction de redirection
function redirect_with_status($status) {
    header("Location: index.php?emailSent=" . $status);
    exit;
}

// Vérification de la méthode POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect_with_status(0);
}

// Vérification CSRF
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    redirect_with_status(0);
}

$nom = isset($_POST['nom']) ? htmlspecialchars(trim($_POST['nom'])) : '';
$prenom = isset($_POST['prenom']) ? htmlspecialchars(trim($_POST['prenom'])) : '';
$email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : '';
$telephone = isset($_POST['telephone']) ? htmlspecialchars(trim($_POST['telephone'])) : '';
$commentaire = isset($_POST['commentaire']) ? htmlspecialchars(trim($_POST['commentaire'])) : '';


// Valider les données du formulaire
if (empty($nom) || empty($prenom) || empty($email) || !is_valid_email($email)) {
    redirect_with_status(0);
}

try {
    //Recipients
    $mail->setFrom($email, $prenom . ' ' . $nom);
    $mail->addAddress('ibrahim-ely@laposte.net');

    //Content
    $mail->isHTML(true);
    $mail->Subject = 'Nouveau Message ! Helene Mazgaj website';
    $mail->Body = "<h1>Voici les informations personnelles de votre expéditeur : </h1>"
        . "<ul><li>$nom</li><li>$prenom</li><li>$email</li><li>$telephone</li></ul>"
        . "<br>Commentaire :<br>" .$commentaire ;

    $mail->send();
    redirect_with_status(1);
} catch (Exception $e) {
    echo "Message d'erreur de PHPMailer : " . $mail->ErrorInfo;
    error_log("Une erreur est survenue lors de l'envoi de l'email : " . $e->getMessage());
    redirect_with_status(0);
}

?>
