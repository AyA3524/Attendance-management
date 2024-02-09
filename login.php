<?php
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

// Vérifier si le formulaire de connexion a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les identifiants entrés par l'utilisateur
    $id = $_POST['id'];
    $password = $_POST['password'];
    $function = $_POST['function'];
    $name = $_POST['employee-name'];

    // Requête SQL pour vérifier si les identifiants existent dans la base de données
    $sql = "SELECT * FROM employee WHERE id='$id' AND password='$password' AND function='$function' AND name='$name'";
    $result = $conn->query($sql);

    // Vérifier si des résultats ont été trouvés
    if ($result->num_rows > 0) {
        // Rediriger l'utilisateur vers une autre page
        header("Location: pointing.html");
        exit();
    } else {
        // Afficher un message d'erreur si les identifiants sont incorrects
        header("Location: error.html");
        echo "<script>alert('Identifiants incorrects.');</script>";
    }
}

// Fermer la connexion à la base de données
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <img src="naftal.jpg" alt="Naftal Logo" class="logo">
        <form class="signin-form" method="POST" action="">
            <h2 style="color: #1e90ff;">Sign In</h2>
            <div class="form-group">
                <label for="employee-name">Employee Name</label>
                <input type="text" id="employee-name" name="employee-name" required>
            </div>
            <div class="form-group">
                <label for="function">Function</label>
                <input type="text" id="function" name="function" required>
            </div>
            <div class="form-group">
                <label for="id">id</label>
                <input type="text" id="id" name="id" required>
            </div>
            <div class="form-group">
                <label for="password">password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" name="submit">Sign In</button>
        </form>
    </div>
</body>
</html>
