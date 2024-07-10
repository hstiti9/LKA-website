
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style-clubs.css">
    <link rel="icon" href="../images/logo.png" type="image/png">
    <title>Lycée Kheireddine</title>
</head>
<body>

<div id="popup-message" class="popup">
    <div class="content">
        <span id="popup-close" class="close">&times;</span>
        <p id="popup-text"></p>
    </div>
</div>


    <div id="popup-message" class="popup">
        <div class="content">
            <span id="popup-close" class="close">&times;</span>
            <p id="popup-text"></p>
        </div>
    </div>

    <form id="application" action="includes/send_application.php" method="post">
    <img onclick="hideApplicationForm()" id="x" src="../images/x.png" alt="">
        <h2 id="form-header">formulaire d'inscription au </h2>
        
        <input id="hidden" type="text" name="produitID">

        <label for="name">Nom et prenom</label>
        <input type="text" id="name" name="name" placeholder="Votre nom et prenom.." required>
        
        <label for="classe">Classe</label>
        <input type="text" id="classe" name="classe" placeholder="Votre classe.." required>
        
        <label for="phone">Numero du telephone</label>
        <input type="tel" id="phone" name="phone" placeholder="Votre numero telephone.." required>
        
        <label for="mail">Adresse mail</label>
        <input type="mail" id="mail" name="mail" placeholder="Votre Adresse mail.." required>

        <label for="message">Pourquoi avez-vous choisi ce club ? Pouvez-vous également nous parler de vos compétences ?</label>
        <textarea id="message" name="message"></textarea>
        
        <button type="submit">Soumettre l'inscription</button>
    </form>

    <div id="popup-nav">
        <img onclick="hideNav()" id="x" src="../images/x.png" alt="">
        <ul>
            <li><a href="../accueil/index.php">Accueil</a></li>
            <li><a href="../evennement/evennement.php">Evennements</a></li>
            <li><a href="../produit/index-produit.php">Produits</a></li>
            <li><a href="index-clubs.php">Clubs</a></li>
            <li><a href=#footer>Contact</a></li>
        </ul>
    </div>


    <nav id="nav" class='nav'>
        <img id='logo' src="../images/logo.png" alt="">
        <ul>
        <li><a href="../accueil/index.php">Accueil</a></li>
        <li><a href="../evennement/evennement.php">Evennements</a></li>
        <li><a href="../produit/index-produit.php">Produits</a></li>
        <li><a href="index-clubs.php">Clubs</a></li>
        <li><a href=#footer>Contact</a></li>
        </ul>
        <img onclick="showNav()" id="nav-icon" src="../images/nav-icon.png" alt="">
    </nav>

    <div id="header-wrapper">
        <div id="header">
            <h1>CLUBS</h1>
        </div>
    </div>

    <section class="main">
    <?php
        require 'includes/fetch-club.php';
?>

    </section>

    <section id="footer" class="footer">
        <div id="footer-wrapper">
            <div class="contact-div">
                <h5>contact de lycée</h5>
                <p><img class="icon" id="fb-logo" src="../images/fb-icon.png" alt=""><a href="https://www.facebook.com/lycee.k.a">Lycée Khaireddine Ariana</a></p>
                <p><img class="icon" id="insta-logo" src="../images/InstaLogo.png" alt=""><a href="https://www.instagram.com/lycee.khaireddine.becha.ariana/">lycee.khaireddine.becha.ariana</a></p>
                <p><img class="icon" id="insta-logo" src="../images/yt-icon.png" alt=""><a href="https://www.youtube.com/@lyceekhaireddineariana">Lycée khaireddine Ariana</a></p>
                <p><img class="icon" id="phone-logo" src="../images/phone-icon.png" alt="">71 711 361</p>
            </div>
            <div class="contact-div" id="contact-div2">
                <h5>équipe developpemant/assistance</h5>
                <p><img class="icon" src="../images/InstaLogo.png" alt=""><a href="https://www.instagram.com/rayen_haggui_/">Rayen Haggui</a></p>
                <p><img class="icon" id="insta-logo" src="../images/phone-icon.png" alt="">(+216) 99 465 865</p>
                <p><img class="icon" src="../images/InstaLogo.png" alt=""><a href="https://www.instagram.com/hich00em/">Hichem Stiti</a></p>
            </div>
        </div>
        <a href="../admin-files/adminlogin.php" id="connecter">Se connecter en tant qu'administrateur</a>
        <p id="rights">© All rights are reserved to Kheireddine Pacha's informatics club (LKAIC)</p>
    </section>

    <script src="clubs-main.js"></script>
</body>
</html>