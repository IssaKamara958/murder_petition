<?php
// Démarrer une session
session_start();

// Vérifiez si un message de remerciement a été défini dans la session
$message = isset($_SESSION['thank_you_message']) ? $_SESSION['thank_you_message'] : "Merci pour votre soutien. Accédez à la pétition pour signer.";

// Effacez le message après l'avoir récupéré de la session
unset($_SESSION['thank_you_message']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Page de remerciement pour la pétition contre la violence au Sénégal.">
    <title>Merci pour votre signature</title>
    <link rel="stylesheet" href="./css/style.css"> <!-- Lien vers votre fichier CSS -->
</head>
<body>
    <header>
        <h1>Merci pour votre soutien !</h1>
    </header>
    <main class="container">
        <div class="message">
            <p><?php echo htmlspecialchars($message); ?></p>
        </div>
        <br>
        <a href="index.php" class="btn">Retour à la page d'accueil</a>
    </main>
    <footer>
        <p>&copy; 2024 Chackor Organisation. Tous droits réservés.</p>
    </footer>
    <script src="./js/script.js"></script>
</body>
</html>
