<?php
session_start();
include("connect.php");

// Authentification
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    $_SESSION['error'] = "Accès non autorisé.";
    header('Location: login.php'); // Redirige vers la page de connexion
    exit;
}

// Protection CSRF
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    $_SESSION['error'] = "Invalid request.";
    header('Location: login.php');
    exit;
}

$adminId = $_SESSION['admin_id'];

function isValidImageUrl($url) {
    // Vérification
    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    $urlExtension = strtolower(pathinfo($url, PATHINFO_EXTENSION));
    return in_array($urlExtension, $imageExtensions);
    }
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $type = htmlspecialchars($_POST['type'], ENT_QUOTES, 'UTF-8');
        $id = intval($_POST['id']);
    // Traitement UPDATE Activités
    if ($type == 'activite') {
        $image = htmlspecialchars($_POST['image'], ENT_QUOTES, 'UTF-8');
        $titre = htmlspecialchars($_POST['titre'], ENT_QUOTES, 'UTF-8');
        $texte = htmlspecialchars($_POST['texte'], ENT_QUOTES, 'UTF-8');
        $etat = htmlspecialchars($_POST['etat'], ENT_QUOTES, 'UTF-8');
        $dateNow = date('Y-m-d H:i:s');

        if(isValidImageUrl($image)) {
            $query = $db->prepare("UPDATE activites SET image=?, titre=?, texte=?, etat=?, date=?, admin_id=? WHERE id=?");
            $query->execute([$image, $titre, $texte, $etat, $dateNow, $adminId, $id]);
            $_SESSION['message'] = "Activité modifiée avec succès";
        } else {
            $_SESSION["error-url"] = "L'URL soumise n'est pas une URL d'image valide.";}
            echo $_SESSION['error-url'];

    // Traitement UPDATE Actualités
    } elseif ($type == 'actualite') {
        $image = htmlspecialchars($_POST['image'], ENT_QUOTES, 'UTF-8');
        $titre = htmlspecialchars($_POST['titre'], ENT_QUOTES, 'UTF-8');
        $texte = htmlspecialchars($_POST['texte'], ENT_QUOTES, 'UTF-8');
        $etat = htmlspecialchars($_POST['etat'], ENT_QUOTES, 'UTF-8');
        $dateNow = date('Y-m-d H:i:s');

        if(isValidImageUrl($image)) {
            $query = $db->prepare("UPDATE actualites SET image=?, titre=?, etat=?, texte=?, date=?, admin_id=? WHERE id=?");
            $query->execute([$image, $titre, $etat, $texte, $dateNow, $adminId,$id]);
            $_SESSION['message'] = "Actualité modifiée avec succès";
        } else {
            $_SESSION['error-url'] = "L'URL soumise n'est pas une URL d'image valide.";
        }

    // Traitement UPDATE Vidéos
    } elseif ($type == 'video') {
        $url = $_POST['url'];
        $titre = htmlspecialchars($_POST['titre'], ENT_QUOTES, 'UTF-8');
        $etat = htmlspecialchars($_POST['etat'], ENT_QUOTES, 'UTF-8');
        $dateNow = date('Y-m-d H:i:s');

        $query = $db->prepare("UPDATE videos SET url=?, titre=?, etat=?, date=?, admin_id=? WHERE id=?");
        $query->execute([$url, $titre, $etat, $dateNow, $adminId, $id]);
        $_SESSION['message'] = "Vidéo modifiée avec succès";

    // Traitement CREATE Activités
    } elseif ($type == 'create_activite') {
        $image = htmlspecialchars($_POST['image'], ENT_QUOTES, 'UTF-8');
        $titre = htmlspecialchars($_POST['titre'], ENT_QUOTES, 'UTF-8');
        $texte = htmlspecialchars($_POST['texte'], ENT_QUOTES, 'UTF-8');
        $etat = htmlspecialchars($_POST['etat'], ENT_QUOTES, 'UTF-8');
        $dateNow = date('Y-m-d H:i:s');

        if (isValidImageUrl($image)) {
            $query = $db->prepare("INSERT INTO activites (image, titre, texte, etat, admin_id, date) VALUES (?, ?, ?, ?, ?, ?)");
            $query->execute([$image, $titre, $texte, $etat, $adminId, $dateNow]);
            $_SESSION['message'] = "Activité créée avec succès";
        } else {
            $_SESSION['error-url'] = "L'URL soumise n'est pas une URL d'image valide.";
        }

    // Traitement DELETE Activités
    } elseif ($type == 'delete_activite') {
        $query = $db->prepare("DELETE FROM activites WHERE id=?");
        $query->execute([$id]);
        $_SESSION['message'] = "Activité supprimée avec succès";

    // Traitement CREATE Actualités
    } elseif ($type == 'create_actualite') {
        $image = htmlspecialchars($_POST['image'], ENT_QUOTES, 'UTF-8');
        $titre = htmlspecialchars($_POST['titre'], ENT_QUOTES, 'UTF-8');
        $texte = htmlspecialchars($_POST['texte'], ENT_QUOTES, 'UTF-8');
        $etat = htmlspecialchars($_POST['etat'], ENT_QUOTES, 'UTF-8');
        $dateNow = date('Y-m-d H:i:s');
        $_SESSION['message'] = "Actualité créée avec succès";

        if(isValidImageUrl($image)) {
            $query = $db->prepare("INSERT INTO actualites (image, titre, etat, texte, admin_id, date) VALUES (?, ?, ?, ?, ?, ?)");
            $query->execute([$image, $titre, $etat, $texte, $adminId, $dateNow]);
        } else {
            $_SESSION["error-url"] = "L'URL soumise n'est pas une URL d'image valide";
            echo $_SESSION['error-url'];
        }

    // Traitement DELETE Actualités
    } elseif ($type == 'delete_actualite') {
        $query = $db->prepare("DELETE FROM actualites WHERE id=?");
        $query->execute([$id]);
        $_SESSION['message'] = "Actualité supprimée avec succès";

    // Traitement CREATE Vidéos
    } elseif ($type == 'create_video') {
        $url = $_POST['url'];
        $titre = htmlspecialchars($_POST['titre'], ENT_QUOTES, 'UTF-8');
        $etat = htmlspecialchars($_POST['etat'], ENT_QUOTES, 'UTF-8');
        $dateNow = date('Y-m-d H:i:s');
        $_SESSION['message'] = "Vidéo créée avec succès";

        $query = $db->prepare("INSERT INTO videos (url, titre, etat, admin_id, date) VALUES (?, ?, ?, ?, ?)");
        $query->execute([$url, $titre, $etat, $adminId, $dateNow]);

    // Traitement DELETE Vidéos
    } elseif ($type == 'delete_video') {
        $query = $db->prepare("DELETE FROM videos WHERE id=?");
        $query->execute([$id]);
        $_SESSION['message'] = "Vidéo supprimée avec succès";
    }

    // Redirection vers espaceAdmin.php après traitement
    header('Location: espaceAdmin.php');
    exit;
}

?>
