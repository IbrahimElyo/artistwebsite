<?php
session_start();

include("connect.php");


if (isset($_SESSION['error-url'])) {
    echo "<div class='error-url'>" . $_SESSION['error-url'] . "</div>";
    unset($_SESSION['error-url']);
}

if (($_SESSION['admin_logged_in']) === false || ($_SESSION['user']['role'] !== 'admin')) {
    header('Location: login.php'); 
    exit;
}
else {
    // Fonction formatage date
    function formatDate($section, $i) {
        $date_from_db = $section[$i]->date;
        $timestamp = strtotime($date_from_db);
        $formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::MEDIUM);
        $formatted_date = $formatter->format($timestamp);
        return $formatted_date;
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta chcrarset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/de5f823271.js" crossorigin="anonymous"></script>
    <script defer src="script.js"></script>  
    <title>Espace Admin</title>
</head>
<body class="bodyAdminPage">
<button class="scrollButton"></button>
    <?php
    if (isset($_SESSION['message'])) {
        $class = "";

        // Vérification du message pour déterminer la classe
        if ((strpos($_SESSION['message'], 'créée') !== false) || (strpos($_SESSION['message'], 'modifiée') !== false)) {
            $class = "added";
        } elseif (strpos($_SESSION['message'], 'supprimée') !== false) {
            $class = "deleted";
        }        

        // Affichage de la notification avec la classe CSS appropriée
        echo "<div class='notification $class'>" . htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8') . "</div>";
        unset($_SESSION['message']);
    }
    ?>
        <ul class="conteneurHeaderAdmin" role="navigation">
            <li>Espace Admin
                <ul>
                    <li><a class='lienSousMenuAdmin' href="espaceAdmin.php#activites">Activités</a></li>
                    <li><a class='lienSousMenuAdmin' href="espaceAdmin.php#actualites">Actualités</a></li>
                    <li class='li-last-child'><a class='lienSousMenuAdmin' href="espaceAdmin.php#videos">Vidéos</a></li>
                </ul>
            </li>
            <li><a href="index.php"><i class="fa-solid fa-house"></i></a></li>
            <li class="li-last-child">
                <i class="fa-solid fa-user"></i>
                <?= $_SESSION['user']['username'];?>
                <ul>
                    <li class="li-last-child"><a href='logout.php'>Déconnexion</a></li>
                </ul>
            </li>
        </ul>

        <!-- ACTIVITÉS -->
        <div id="activites" class="data-table">
            <h2 class="padding-all">Activités</h2>
            <br>
            <ul class="parentImgAdmin">
            <?php 
            // requête SQL
            $affichageActivites = $db->query("SELECT a.id, a.image, a.titre, a.texte, a.etat, a.date, ad.username FROM activites a LEFT JOIN Administrateurs ad ON a.admin_id = ad.id")->fetchAll(PDO::FETCH_OBJ);

        // READ & UPDATE
            for($i = 0; $i < count($affichageActivites); $i++) {

            // Formatage Date
            $dateActivFormatted = formatDate($affichageActivites, $i);

            // READ & UPDATE
            echo "<h3 class='addItemTitle'>Modifier</h3>";
            echo "<form action='traitementFormAdmin.php' method='post' class='formulaireAjout'>
            <input type='text' name='titre' value='".htmlspecialchars($affichageActivites[$i]->titre, ENT_QUOTES, 'UTF-8')."'>
            <figure><img class='imgAdmin' src='".htmlspecialchars($affichageActivites[$i]->image, ENT_QUOTES, 'UTF-8')."' alt='".$affichageActivites[$i]->titre."'>
            <figcaption><textarea name='texte' rows='10'>".htmlspecialchars($affichageActivites[$i]->texte, ENT_QUOTES, 'UTF-8')."</textarea></figcaption></figure>
            <input type='hidden' name='admin_id' value='{$SESSION['user']['username']}'>
            <input type='hidden' name='type' value='activite'>
            <input type='hidden' name='id' value='{$affichageActivites[$i]->id}'>
            <input type='hidden' name='csrf_token' value='".$_SESSION['csrf_token']."'>
            <label>URL </label>
            <input type='text' name='image' value='".htmlspecialchars($affichageActivites[$i]->image, ENT_QUOTES, 'UTF-8')."'><br><br>
            <label>État</label>
            <select name='etat'>
            <option value='publie'";
        
            if ($affichageActivites[$i]->etat == 'publie') echo " selected";
        
            echo ">Publié</option>
                <option value='attente'";
        
            if ($affichageActivites[$i]->etat == 'attente') echo " selected";
        
            echo ">En attente</option>
                <option value='archive'";
        
            if ($affichageActivites[$i]->etat == 'archive') echo " selected";
        
            echo ">Archivé</option>
            </select><br><br>  
            <label>Dernière modification</label>
            <input type='text' name='date' value='".ucwords($dateActivFormatted)." par ".ucfirst($affichageActivites[$i]->username)."' readonly class='readonlyStyle'><br>                    
            <input class='boutonEnregistrer' type='submit' value='Enregistrer'> 
            </form>";
            // DELETE
            echo "<form action='traitementFormAdmin.php' method='post' class='formulaireSuppression'>
            <input type='hidden' name='csrf_token' value='".$_SESSION['csrf_token']."'>
            <input type='hidden' name='type' value='delete_activite'>
            <input type='hidden' name='id' value='{$affichageActivites[$i]->id}'>
            <input class='boutonSupprimer' type='submit' value='Supprimer'>
            </form>";
            echo "<hr><br>";
        }
            ?>
            <!-- CREATE -->
            <h3 class="addItemTitle">Ajouter une nouvelle activité</h3>
            <form action='traitementFormAdmin.php' method='post' class='formulaireAjout'>
                <input type='hidden' name='csrf_token' value="<?=$_SESSION['csrf_token'];?>">
                <input type='hidden' name='type' value='create_activite'>
                <label>URL de l'image</label>
                <input type='text' name='image'><br><br>
                <label>Titre</label>
                <input type='text' name='titre'><br><br>
                <label>Texte</label><br>
                <textarea name='texte' rows='10'></textarea><br>
                <label>État</label>
                <select name='etat'>
                    <option value='publie'>Publié</option>
                    <option value='attente'>En attente</option>
                    <option value='archive'>Archivé</option>
                </select><br><br>
                <input type='submit' class='boutonEnregistrer' value='Ajouter'>
            </form>
            <!-- ACTUALITÉS -->
            </ul>
            <h2 id="actualites" class="padding-all">Actualités</h2>
            <br>
            <ul>
            <?php
            // requête SQL
            $affichageActualites = $db->query("SELECT a.id, a.image, a.titre, a.texte, a.etat, a.date, ad.username FROM actualites a LEFT JOIN Administrateurs ad ON a.admin_id = ad.id")->fetchAll(PDO::FETCH_OBJ);
            // Affichage
            for($i = 0; $i < count($affichageActualites); $i++) {
                    $dateActuFormatted = formatDate($affichageActualites, $i);
                    // READ & UPDATE
                    echo "<h3 class='addItemTitle'>Modifier</h3>";
                    echo "<form action='traitementFormAdmin.php' method='post' class='formulaireAjout'>
                    <input type='text' name='titre' value='".htmlspecialchars($affichageActualites[$i]->titre, ENT_QUOTES, 'UTF-8')."'>
                    <figure><img class='imgAdmin' src='".htmlspecialchars($affichageActualites[$i]->image, ENT_QUOTES, 'UTF-8')."' alt='".$affichageActualites[$i]->titre."'>
                    <figcaption><textarea name='texte' rows='10'>".htmlspecialchars($affichageActualites[$i]->texte, ENT_QUOTES, 'UTF-8')."</textarea></figcaption></figure>
                    <input type='hidden' name='csrf_token' value='".$_SESSION['csrf_token']."'>
                    <input type='hidden' name='type' value='actualite'>
                    <input type='hidden' name='id' value='{$affichageActualites[$i]->id}'>
                    <label>URL</label>
                    <input type='text' name='image' value='".$affichageActualites[$i]->image. "'><br>
                    <label>État</label>
                    <select name='etat'>
                        <option value='publie'";
                        if ($affichageActualites[$i]->etat == 'publie') echo " selected";
                            echo ">Publié</option>
                            <option value='attente'";
                        if ($affichageActualites[$i]->etat == 'attente') echo " selected";
                            echo ">En attente</option>
                            <option value='archive'";
                        if ($affichageActualites[$i]->etat == 'archive') echo " selected";
                            echo ">Archivé</option>
                    </select><br><br>
                    <label>Dernière modification</label>
                    <input type='text' name='date' value='".ucwords($dateActuFormatted)." par ".ucfirst($affichageActualites[$i]->username)."' readonly class='readonlyStyle'><br>  
                    <input type='submit' class='boutonEnregistrer' value='Enregistrer'>
                    </form>";     
                    // DELETE
                    echo "<form action='traitementFormAdmin.php' method='post' class='formulaireSuppression'>
                    <input type='hidden' name='csrf_token' value='".$_SESSION['csrf_token']."'>
                    <input type='hidden' name='type' value='delete_actualite'>
                    <input type='hidden' name='id' value='{$affichageActualites[$i]->id}'>
                    <input class='boutonSupprimer' type='submit' value='Supprimer'>
                    </form>";           
                        echo "<hr><br>";
                    }
                ?>
                        <!-- CREATE -->
                    <h3 class="addItemTitle">Ajouter une nouvelle actualité</h3>
                    <form action='traitementFormAdmin.php' method='post' class='formulaireAjout'>
                        <input type='hidden' name='csrf_token' value="<?=$_SESSION['csrf_token'];?>">
                        <input type='hidden' name='type' value='create_actualite'>
                        <label>URL de l'image</label>
                        <input type='text' name='image'>
                        <label>Titre</label>
                        <input type='text' name='titre'>
                        <label>Texte: </label><br>
                        <textarea name='texte' rows='10'></textarea>
                        <label>État</label>
                        <select name='etat'>
                            <option value='publie'>Publié</option>
                            <option value='attente'>En attente</option>
                            <option value='archive'>Archivé</option>
                        </select><br><br>
                        <input type='submit' class='boutonEnregistrer' value='Ajouter'>
                    </form>
        <!-- VIDÉOS YOUTUBE -->
        </ul>
        <h2 id="videos" class="padding-all">Vidéos Youtube</h2>
        <br>
        <?php
            // requête SQL
            $affichageVideos = $db->query("SELECT v.id, v.url, v.titre, v.etat, v.date, ad.username FROM videos v LEFT JOIN Administrateurs ad ON v.admin_id = ad.id")->fetchAll(PDO::FETCH_OBJ);
            // Affichage
            for($i = 0; $i < count($affichageVideos); $i++) {
                $dateVideoFormatted = formatDate($affichageVideos, $i);
                // READ & UPDATE
                echo "<form action='traitementFormAdmin.php' method='post' class='formulaireAjout'>
                <input type='text' name='titre' value='".htmlspecialchars($affichageVideos[$i]->titre, ENT_QUOTES, 'UTF-8')."'>
                <section class='videosYoutubeSection'><div class='divRepertoire'>" . $affichageVideos[$i]->url ."</div></section>
                <input type='hidden' name='csrf_token' value='".$_SESSION['csrf_token']."'>
                <input type='hidden' name='type' value='video'>
                <input type='hidden' name='id' value='{$affichageVideos[$i]->id}'>
                <label>URL</label>
                <input type='text' name='url' value='".htmlspecialchars($affichageVideos[$i]->url, ENT_QUOTES, 'UTF-8')."'><br>
                <label>État</label>
                <select name='etat'>
                    <option value='publie'";
                    if ($affichageVideos[$i]->etat == 'publie') echo " selected";
                echo ">Publié</option>
                        <option value='attente'";
                if ($affichageVideos[$i]->etat == 'attente') echo " selected";
                echo ">En attente</option>
                        <option value='archive'";
                if ($affichageVideos[$i]->etat == 'archive') echo " selected";
                echo ">Archivé</option>
                </select><br><br>
                <label>Dernière modification</label>
                <input type='text' name='date' value='".ucwords($dateVideoFormatted)." par ".ucfirst($affichageVideos[$i]->username)."' readonly class='readonlyStyle'><br>
                <input type='submit' class='boutonEnregistrer' value='Enregistrer'>
                </form>";

                // DELETE
                echo "<form action='traitementFormAdmin.php' method='post' class='formulaireSuppression'>
                <input type='hidden' name='csrf_token' value='".$_SESSION['csrf_token']."'>
                <input type='hidden' name='type' value='delete_video'>
                <input type='hidden' name='id' value='{$affichageVideos[$i]->id}'>
                <input class='boutonSupprimer' type='submit'  value='Supprimer'>
                </form>";
                echo "<hr><br>";
            }
            ?>
                <h3 class="addItemTitle">Ajouter une nouvelle vidéo</h3>
                <form action='traitementFormAdmin.php' method='post' class='formulaireAjout'>
                    <input type='hidden' name='csrf_token' value="<?=$_SESSION['csrf_token'];?>">
                    <input type='hidden' name='type' value='create_video'>
                    <label>URL</label>
                    <input type='text' name='url'><br><br>
                    <label>Titre</label>
                    <input type='text' name='titre'><br><br>
                    <label>État</label>
                    <select name='etat'>
                        <option value='publie'>Publié</option>
                        <option value='attente'>En attente</option>
                        <option value='archive'>Archivé</option>
                    </select><br><br>
                    <input type='submit' class='boutonEnregistrer' value='Ajouter'>
                </form>
        <ul>
        </ul>
    </div>
</body>
<footer role="contentinfo">
            <a href="index.php">2023 © Hélène Mazgaj <span>|</span>&nbsp;</a>
            <a href="mentionslegales.php">Mentions légales <span>|</span>&nbsp;</a>
            <a href="mentionslegales.php">Politique de confidentialité <span>|</span>&nbsp;</a>
            <a href="https://www.clerc-et-net.com/" target="_blank">Développé par Clerc &amp; Net 
            <?php echo $_SESSION['admin_logged_in'] == true || $_SESSION['user']['role'] == 'admin' ? '<span>|</span>&nbsp;' : null; ?></a>
            <?php echo $_SESSION['admin_logged_in'] == true || $_SESSION['user']['role'] == 'admin' ? '<a href="espaceAdmin.php">Espace admin</a>' : null; ?>
        </footer>
</html>

        <? }