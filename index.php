<?php
session_start();
include './php/db.php';

$total_signataires = 0;
$message = "";

// Récupérer le nombre de signataires
$sql_count = "SELECT COUNT(*) as total FROM signatures";
$result_count = $conn->query($sql_count);
if ($result_count) {
    $row_count = $result_count->fetch_assoc();
    $total_signataires = $row_count['total'];
}

// Gestion de la soumission AJAX
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ajax'])) {
    $response = ['success' => false, 'message' => '', 'total' => $total_signataires];

    // Récupérer et sécuriser les données
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);

    if (!$email) {
        $response['message'] = "Adresse email invalide.";
        echo json_encode($response);
        exit;
    }

    // Vérifier si l'email existe déjà
    $sql_check = "SELECT * FROM signatures WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows == 0) {
        // Insérer la nouvelle signature
        $sql = "INSERT INTO signatures (name, email) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $name, $email);
        if ($stmt->execute()) {
            $total_signataires++;
            $response['success'] = true;
            $response['message'] = "Merci, $name, pour votre signature ! Votre soutien est précieux.";
            $response['total'] = $total_signataires;
        } else {
            $response['message'] = "Erreur lors de l'enregistrement : " . $stmt->error;
        }
        $stmt->close();
    } else {
        $response['message'] = "Vous avez déjà signé avec cet email.";
    }

    echo json_encode($response);
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Participez à la pétition contre les meurtres au Sénégal. Soutenez la justice et la paix.">
    <meta name="keywords" content="pétition, meurtres au Sénégal, justice, paix, soutien, signataires">

    <title>Pétition pour la justice : Stop aux meurtres au Sénégal | Chackor Organisation</title>
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <h1>Pétition pour les Meurtres au Sénégal</h1>
    </header>
    <div id="banner">
        <h2><span>Ray gui Eupp n'à !</span></h2><br><br>
        <p class="opinion">Il faut peut-être prendre une décision</p>
    </div>
    <main class="container">
        <div id="message-container" class="message">
            <div id="message" class="message-content"><?php echo $message; ?></div>
        </div>

        <div class="jauge">
            <h2>Nombre de signataires : <span id="totalSignataires"><?php echo $total_signataires; ?></span></h2>
            <div class="progress" style="height: 20px; background: #ddd; border-radius: 5px; overflow: hidden;">
                <div id="progressBar" style="height: 100%; width: 0; background: #28a745;"></div>
            </div>
        </div>

        <div class="sensibilisation">
            <h2>Sensibilisation contre les Crimes</h2>
            <p>La violence n'est jamais la solution. Chaque acte de violence laisse des cicatrices indélébiles dans notre société. Ensemble, nous pouvons faire une différence. Engageons-nous à promouvoir la paix et la justice en signant la pétition KOU RAY GNOU RAY</p>
        </div>

        <div class="avantages">
            <h2>Avantages de l'Aboutissement de cette Pétition</h2>
            <ul>
                <li>Demande de renforcement des lois contre les actes criminels.</li>
                <li>Sensibilisation sur les effets dévastateurs du Sang Vérsé.</li>
                <li>Création d'un environnement plus sûr pour tous.</li>
                <li>Engagement communautaire pour la justice et la paix au Sénégal.</li>
            </ul>
        </div>

        <form id="petitionForm">
            <input type="text" name="name" placeholder="Votre Nom" required>
            <input type="email" name="email" placeholder="Votre Email" required>
            <button type="submit" class="button" onclick="formData()">Signer</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Chackor Organisation. Tous droits réservés.</p>
    </footer>
    <script>
        document.getElementById('petitionForm').addEventListener('submit', async (e) => {
    e.preventDefault(); // Empêcher la soumission classique du formulaire

    const formData = new FormData(e.target);
    formData.append('ajax', true);

    try {
        const response = await fetch('', {
            method: 'POST',
            body: formData,
        });

        const result = await response.json();

        // Afficher le message de retour
        document.getElementById('message').textContent = result.message;

        if (result.success) {
            document.getElementById('totalSignataires').textContent = result.total;
            window.location.href = './submit.php'; // Redirection vers la page de remerciement
        }
    } catch (error) {
        console.error('Une erreur est survenue:', error);
        document.getElementById('message').textContent = 'Une erreur est survenue. Veuillez réessayer.';
    }
});

    </script>
    <script src="./js/script.js"></script>
</body>
</html>
