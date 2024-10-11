<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Système de Vote</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
    <!-- Ajout de liens CSS pour les polices et les icônes si nécessaire -->
</head>
<style type="text/css">
 .candidats {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

.candidat {
    margin: 20px;
    padding: 15px;
    border: 1px solid #ccc;
    border-radius: 10px;
    background-color: #f9f9f9;
    width: 250px;
    text-align: center;
}

.candidat-photo {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 15px;
}

.candidat h2 {
    margin: 0;
    font-size: 18px;
    color: #333;
}

.candidat p {
    margin: 10px 0 0;
    font-size: 14px;
    color: #666;
}

</style>
<body>
    <!-- En-tête de la page -->
    <header>
        <div class="top-bar">
            <div class="container">
                <div class="logo">
                    <img src="<?php echo base_url('assets/images/logo.png'); ?>" alt="Logo">
                </div>
                <div class="header-right">
                    <nav>
                        <ul>
                            <li><a href="#">Accueil</a></li>
                            <li><a href="#">À propos</a></li>
                            <li><a href="#">Services</a></li>
                            <li><a href="#">Contact</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <!-- Section principale avec les candidats -->
    <section class="main-content">
        <div class="container">
            <h1>Bienvenue au Système de Vote</h1>
            <div class="candidats">
                <?php foreach ($data as $candidat): ?>
                    <div class="candidat">
                    <a href="<?php.$candidat['PHOTO']; ?>" target="_blank" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="<?php.$candidat['PHOTO']; ?>"></a>
                        <h2><?php echo $candidat['PRENOM'] . ' ' . $candidat['NOM']; ?></h2>
                        <p>Parti Politique: <?php echo $candidat['parti']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Pied de page -->
    <footer>
        <div class="container">
            <p>&copy; 2024 - Tous droits réservés</p>
        </div>
    </footer>
</body>
</html>
