<?php 
session_start();
include "connect.php";

// requête SQL données table Activités
$affichageActivites = $db->query("SELECT id, image, titre, texte FROM activites WHERE etat = 'publie'")->fetchAll(PDO::FETCH_OBJ);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hélène Mazgaj - Activités</title>
    <script src="https://kit.fontawesome.com/de5f823271.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">  
    <script defer src="script.js"></script>     
</head> 
<body>
    <button class="scrollButton"></button>
    <div id="wrapper">
        <!--Navigation-->
        <header class="headerPrincipal" role="banner">
            <div class="burger-menu"><i class="fa-solid fa-bars"></i>
            <a class="tel-responsive" href="tel:+33610611497"><i class="fa-solid fa-phone"></i>06 10 61 14 97</a>
            </div>
            <nav role="navigation">
                <ul class="liste-nav flex">
                    <li><a href=""><i class="fa-brands fa-facebook"></i></a></li>
                    <li><a href="index.php">Acceuil</a></li>
                    <li><a href="actualites.php">Actualités</a></li>
                    <li><a href="activites.php">Activités</a></li>
                    <li><a href="biographie.php">À propos</a></li>
                    <li><a href="index.php#contactanchor">Contact</a></li>
                    <i class="fa-sharp fa-solid fa-circle-phone-flip"></i>
                    <li><a href="tel:+33610611497"><i class="fa-solid fa-phone"></i>06 10 61 14 97</a></li>
                </ul>
            </nav>
        </header>
        <main role="main">
            <!--Bannière -->
            <div class="bannerGeneric flex">
                <div class="legende-bannerGeneric">
                    <h1>Activités</h1>
                </div>
            </div>
            <!-- Activités -->
            <!-- Contenu dynamique récupération données Activités -->
            <?php
            for($i = 0; $i < count($affichageActivites); $i++) {
            ?>
                <section id="activite-<?=$i + 1?>" class="<?= ($i % 2 == 0) ? "groupeActivites1 sectionActivites flex" : "groupeActivites1 sectionActivites flex rowReverse"; ?>">
                    <div class="texteActivites1 padding-all">
                        <h3><?= $affichageActivites[$i]->titre; ?></h3>
                        <p class="padding-top-bottom"><?= $affichageActivites[$i]->texte ?? "texte non dispo"; ?></p>
                        <div class="boutonNousContacter">
                            <a href="index.php#contactanchor">Nous contacter</a>
                        </div>
                    </div>
                    <div class="imageActivites1 padding-all"><img src="<?= $affichageActivites[$i]->image ?>"alt="<?= $affichageActivites[$i]->titre ?>">
                    </div>
                </section>
                <?php
                ?>
            <?php } ?>
        </main>
        <!-- Pied de page -->
        <div class="iconesreseauxsociaux flex">
            <a href="https://www.facebook.com/mazgajhelene/?locale=fr_FR" target="_blank"><i class="fa-brands fa-facebook"></i></a>
            <a href="https://twitter.com/HeleneMazgaj" target="_blank"><i class="fa-brands fa-twitter"></i></a>
            <a href="https://www.youtube.com/channel/UC9oJFUmucncWmSd7V7wTPtw" target="_blank"><i class="fa-brands fa-youtube"></i></a>
        </div>
        <footer role="contentinfo">
            <a href="index.php">2023 © Hélène Mazgaj <span>|</span>&nbsp;</a>
            <a href="mentionslegales.php">Mentions légales <span>|</span>&nbsp;</a>
            <a href="mentionslegales.php">Politique de confidentialité <span>|</span>&nbsp;</a>
            <a href="https://www.clerc-et-net.com/" target="_blank">Développé par Clerc &amp; Net <span>|</span>&nbsp</a>
            <?php echo $_SESSION['admin_logged_in'] == true || $_SESSION['user']['role'] == 'admin' ? '<a href="espaceAdmin.php">Espace admin</a>' : '<a href="login.php">Connexion espace admin</a>';?>
        </footer>
    </div>
</body>
</html>

