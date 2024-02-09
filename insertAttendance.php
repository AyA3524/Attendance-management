<?php
session_start(); // Démarre la session pour récupérer les données de l'utilisateur connecté

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: login.php");
    exit();
}

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$database = "database";
$conn = new mysqli($servername, $username, $password, $database);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Récupérer les données envoyées par la requête AJAX
$id = $_SESSION['id']; // Utilise l'ID de l'utilisateur connecté
$date = $_POST['date'];
$time = $_POST['time'];
$day = $_POST['day'];

// Préparer et exécuter la requête SQL pour insérer les données dans la base de données
$sql = "INSERT INTO attendance (id, date, time, day) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isss", $id, $date, $time, $day);

if ($stmt->execute()) {
    // Succès de l'insertion
    echo "Attendance recorded successfully.";
} else {
    // Erreur lors de l'insertion
    echo "Failed to record attendance.";
}

// Fermer la connexion à la base de données
$stmt->close();
$conn->close();
?>

