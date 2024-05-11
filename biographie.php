<?php
session_start();
include 'connect.php';

// requête SQL données table Videos
$affichageVideos = $db->query("SELECT url, titre FROM videos WHERE etat = 'publie'")->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hélène Mazgaj - À propos</title>
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
                    <h1>Biographie</h1>
                </div>
            </div>
            <!-- Texte Biographie -->
            <div class="blocTexte1">
                <div class="textePartie1 flex"><p>Issue d’une famille de musiciens, elle suit ses études de chant Lyrique et de musique de chambre au Conservatoire de Valence où elle obtient son diplôme, se perfectionne au Conservatoire de région du Grand Avignon, puis se spécialise en art lyrique, elle a la chance de rencontrer deux grandes cantatrices internationales Evelyne Brunner, ainsi que Françoise Pollet lors de Masters classes où elle prend conseils auprès d’elles.</p></div>
            </div>
            <div class="blocTexte2 flex">
                <div>
                    <p>
                        Ses différents répertoires varient de la musique sacrée à l’opéra baroque en passant par le chant lyrique, l’opéra classique, le lied, la mélodie, l’opérette, les valses de Vienne, les comédies musicales, la chanson française et internationale. Soliste, elle est appelée dans les chœurs et chorales pour interpréter diverses œuvres, messes et oratorios, entre autres : le « Gloria » de Vivaldi, le « Magnificat » de Jean Sébastien Bach, les sept paroles du Christ en croix de César Franck, l’Enfance du Christ d’Hector Berlioz, le Gloria de Francis Poulenc, le Requiem de Gabriel Fauré, plusieurs messes de Mozart, dont le « Réquiem » . L’unique ambition de cette artiste est de partager avec son public des moments d’émotions. Son timbre de voix envoûtant porte les chants directement dans les cœurs. Hélène MAZGAJ se produit dans des concerts et récitals, mais propose aussi des prestations privées : mariages, cocktails, cérémonies, team building et concerts.
                    </p>
                </div>
                <div>
                    <p>
                        Elle est invitée dans les festivals de régions tels que les « Polymusicales » de Bollène, « musique de chambre » à Bagnols-sur-Cèze et « Château Opéra » à Crest. Lors de ces événements, elle se produit dans les rôles de « Carmen » de Bizet, « La Belle Hélène » et « La Périchole » de Jacques Offenbach, avec 80 musiciens et 250 choristes de la région, dirigés par Andreï Chevtchouk.
                        Sensible aux causes humanitaires, elle donne des concerts notamment pour le Téléthon, les voix pour l’espoir, Opération Orange (sœur Emmanuelle)… Une artiste qui nous rappelle que la vie peut nous offrir de belles choses. Venez participer à ces purs moments de bonheur et partager cette passion du chant… Titulaire du Diplôme d’État, elle enseigne son art en Drôme-Ardèche.
                    </p>
                </div>
            </div>
            <!--Bannière -->
            <div class="bannerGeneric flex">
                <div class="legende-bannerGeneric">
                    <h1>Répertoire</h1>
                </div>
            </div>
            <!-- Répertoire -->
            <h5>Concerts privés, récitals, mariages, cocktails, séminaires, cérémonies, événements familiaux</h5>
                <section class='videosYoutubeSection flex'>
                        <?php 
                        foreach($affichageVideos as $a) { 
                        ?>
                            <div class="divRepertoire">
                                <figure>
                                    <?=$a->url?>
                                    <figcaption><?=$a->titre?></figcaption>
                                </figure>
                            </div>
                        <?php } ?>
                </section>
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