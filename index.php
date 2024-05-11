<?php
session_start();

//token CSRF
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

include "connect.php";

// requête SQL données table Actualités
$affichageActualites = $db->query(
    "SELECT id, image, TRIM(LEFT(texte, 55)) AS texte, titre FROM actualites WHERE etat = 'publie'"
)->fetchAll(PDO::FETCH_OBJ);

// requête SQL données table Activités
$affichageActivites = $db->query("SELECT id, image, titre FROM activites WHERE etat = 'publie'")->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hélène Mazgaj - Accueil</title>
    <script src="https://kit.fontawesome.com/de5f823271.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">  
    <script src="script.js"></script>     
</head>
<body>
    <div id="notificationEmail">
            <!-- Le contenu de la notification s'affichera ici -->
    </div>
    <button class="scrollButton"></button>
    <div class="pop-up flex">
        <p class="texte-pop-up">Nous utilisons des cookies pour vous garantir la meilleure expérience sur notre site web. Si vous continuez à utiliser ce site, nous supposerons que vous en êtes satisfait.</p>
        <a id="buttonPopUp" href="#">OK</a>
        <a href="mentionslegales.php">Politique de confidentialité</a>
    </div>
    <div id="wrapper">
        <!--Navigation-->
        <header class="headerPrincipal" role="banner">
            <div class="burger-menu"><i class="fa-solid fa-bars"></i>
            <a class="tel-responsive" href="tel:+33610611497"><i class="fa-solid fa-phone"></i>06 10 61 14 97</a>
            </div>
            <nav role="navigation">
                <ul class="liste-nav flex">
                    <li><a href="https://www.facebook.com/mazgajhelene/?locale=fr_FR" target="_blank"><i class="fa-brands fa-facebook" style="color: #1778f2;"></i></a></li>
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
        <!---->
        <!--Contenu principal-->
        <main role="main">
            <!--Bannière -->
            <div class="bannerPrincipale">
                <div class="legende-bannerPrincipale">
                    <h1>Hélène Mazgaj</h1>
                    <p>Chanteuse lyrique</p>
                    <p>Mezzo Soprano</p>
                </div>
            </div>
            <!-- Section 1 : Blocs "Biographie & Activités" -->
            <section class="biographieActivites flex margin-top-bottom padding-all">
                <div class="biographie">
                    <h3>Biographie</h3>
                    <p>Issue d’une famille de musiciens, elle suit ses études de chant Lyrique et de musique de chambre au <strong>Conservatoire de Valence</strong> où elle obtient son diplôme, se perfectionne au <strong>Conservatoire de région du Grand Avignon</strong>, puis se spécialise en art lyrique, elle a la chance de rencontrer..</p>
                    <a href="biographie.php">Lire la suite</a>
                </div>
                <div class="activites flex">
                    <h3>Activités</h3>
                        <ul class="padding-top-bottom">
                            <?php
                            $i = 1;
                            foreach ($affichageActivites as $activite) { ?>
                                <li><a href="activites.php#activite-<?=$i ?>"><?= $activite->titre ?></a></li>
                            <?php 
                            $i++;
                            } ?>
                        </ul>
                </div>
            </section>
            <!-- BANDE 1 : Témoignages -->
            <div class="bandeTemoignages flex">
                <h4>Témoignages</h4>
            </div>
            <!-- Carroussel (Témoignages) -->
            <div class="slider flex">
                <div class="slider-container">
                  <div class="slide active">
                    <strong>Un team building transformé grâce à Hélène Mazgaj</strong>
                    <p>Nous avons fait appel à Hélène Mazgaj pour un team building et ce fut une expérience fantastique. Elle a su créer une atmosphère détendue et amusante qui a vraiment aidé notre équipe à se connecter et à travailler ensemble de manière plus efficace.</p>
                    <small>Pierre Martin</small>
                    <div class="rating-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                      </div>
                  </div>
                  <div class="slide">
                    <strong>Une soirée inoubliable avec Hélène Mazgaj</strong>
                    <p>J’ai eu la chance d’assister à un concert privé d’Hélène Mazgaj et c’était une expérience inoubliable. Sa voix est tout simplement envoûtante et sa présence sur scène est incroyable. Elle a une façon unique de connecter avec son public qui rend chaque chanson encore plus spéciale. Je recommande vivement à tout le monde de saisir l’occasion de la voir en concert si vous en avez la chance.</p>
                    <small>Jeanne Dupont</small>
                    <div class="rating-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                      </div>
                  </div>
                  <div class="slide">
                    <strong>Des cours de chant enrichissants avec Hélène Mazgaj</strong>
                    <p>J’ai pris des cours de chant avec Hélène Mazgaj et je ne peux pas exprimer à quel point cela a été bénéfique. Non seulement ma technique vocale s’est améliorée, mais j’ai aussi gagné en confiance et j’ai appris à exprimer mes émotions à travers la musique.</p>
                    <small>Claire Lefèvre</small>
                    <div class="rating-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                      </div>
                  </div>
                </div>
                <div class="slider-arrow slider-arrow-left"><span>&lt;</span></div>
                <div class="slider-pagination"></div>
                <div class="slider-arrow slider-arrow-right"><span>&gt;</span></div>
              </div>
            <!-- BANDE 2 : Actualités -->
            <div class="bandeActualites flex">
                <h4>Actualités</h4>
            </div>
            <section class="groupeActualites flex padding-all">
            <!-- Contenu dynamique récupération données Actualités -->
            <?php
                $ancreActu;
                $compteur = 1;
                foreach ($affichageActualites as $a) {
                $classDiv = "actualites" . $compteur;
                ?>
                <div class="<?= $classDiv; ?>">
                    <h3><?= $a->titre ?></h3>
                    <figure>
                        <img src="<?= $a->image ?>" alt="<?= $a->titre ?>">
                        <div class="description-actu">
                            <figcaption>
                            <?= $a->texte. ".."; ?>
                            </figcaption>
                            <a href="actualites.php#article-<?=$a->id?>">Lire la suite..</a>
                        </div>
                    </figure>
                </div>
                <?php
                $compteur++;
            }
            ?>
            </section>
            <!-- BANDE 3 : Contact -->
            <span id="contactanchor"></span>
            <div class="bandeContact flex">
                <h4>Contact</h4>
            </div>
            <section class="groupeContact flex">
                <!-- Coordonnées -->
                <div class="coordonnees padding-all">
                    <p>Hélène Mazgaj</p>
                    <a href="tel:+33610611497">Téléphone : 06 10 61 14 97</a>
                    <a href="mailto:r.mazgaj@advia.fr">e-mail : r.mazgaj@advia.fr</a>
                </div>
                <!-- Formulaire de contact -->
                <div class="formulaire padding-top-bottom">
                    <form action="traitementFormContact.php" class="flex" method="post">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <label for="prenom">Prénom</label>
                        <input type="text" name="prenom" placeholder="Entrez votre prénom" required>
                        <label for="nom">Nom</label>
                        <input type="text" name="nom" placeholder="Entrez votre nom" required>
                        <label for="email">E-mail</label>
                        <input type="email" name="email" placeholder="exemple@gmail.com" required>
                        <label for="telephone">Téléphone</label>
                        <input type="number" name="telephone" placeholder="06XXXXXXXX">
                        <small class="padding-all">En soumettant ce formulaire j’accepte que mes informations soient utilisées exclusivement dans le cadre de ma demande et de la relation commerciale éthique et personnalisée qui pourrait en découler si je le souhaite.</small>
                        <label for="commentaire">Commentaire</label>
                        <textarea name="commentaire" id="commentaire" cols="30" rows="10" placeholder="Votre message.."></textarea>
                        <input type="submit" name="bouton" value="Envoyer">
                    </form>
                </div>
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

