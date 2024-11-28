<?php
session_start();

include './php/db.php';

$total_signataires = 0;
$message = "";

// Récupérer le nombre de signataires
$sql_count = "SELECT COUNT(*) as total FROM users";
$result_count = $conn->query($sql_count);
if ($result_count) {
    $row_count = $result_count->fetch_assoc();
    $total_signataires = $row_count['total'];
}

// Vérifiez si un message de remerciement a été défini dans la session
$message = isset($_SESSION['thank_you_message']) ? $_SESSION['thank_you_message'] : "Merci pour votre soutien. Faites votre choix et signer.";

// Effacez le message après l'avoir récupéré de la session
unset($_SESSION['thank_you_message']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Page de remerciement pour la pétition contre la violence au Sénégal.">
    <title>Soumettez votre Opinion</title>
    <link rel="stylesheet" href="./css/style.css"> <!-- Lien vers votre fichier CSS -->
    <style>
        .yes-span { color: green; }
        .no-span { color: red; }
        #yes-label { color: green; font-style: italic; margin-bottom: 86px; }
        #no-label { color: orangered; font-style: italic; margin-top: 86px; }
    </style>
</head>
<body>
    <header>
        <h1>Merci de soumettre votre Opinion !</h1>
    </header>
    <main class="container">
        <div class="message">
            <p><?php echo htmlspecialchars($message); ?></p>
        </div>
        <div id="boxs">
            <form id="opinionForm">
                <input type="checkbox" name="oui" id="oui">
                <label for="oui" id="yes-label"><span class="yes-span"><strong>OUI !</strong></span> Que les tueurs subissent une peine de mort</label><br>
                <input type="checkbox" name="non" id="non">
                <label for="non" id="no-label"><span class="no-span"><strong>NON !</strong></span> Que les tueurs subissent la prison</label><br>
                <button type="button" onclick="submitOpinion()">Je soumet !</button>
            </form>
        </div>
        <br><br>
        <a href="thank_you.php" class="btn">Vérifier votre soumission</a>
    </main>
    <footer>
        <p>&copy; 2024 Chackor Organisation. Tous droits réservés.</p>
    </footer>
    <script src="./js/script.js"></script>
    <script>
        // Fonction pour vérifier les cases à cocher et envoyer un message d'opinion
        function submitOpinion() {
            const ouiChecked = document.getElementById('oui').checked;
            const nonChecked = document.getElementById('non').checked;

            if (ouiChecked && nonChecked) {
                alert("Vous ne pouvez pas sélectionner les deux options. Veuillez choisir une seule.");
            } else if (ouiChecked) {
                alert("Merci pour votre avis : Vous soutenez la peine de mort pour les tueurs.");
                window.location.href = './thank_you.php';
            } else if (nonChecked) {
                alert("Merci pour votre avis : Vous soutenez la prison pour les tueurs.");
                window.location.href = '.thank_you.php';
            } else {
                alert("Veuillez sélectionner une option avant de soumettre.");
            }
        }
    </script>
</body>
</html>
