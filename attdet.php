<?php
session_start(); // Démarre la session pour récupérer les données de l'utilisateur connecté

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Récupérer l'ID de l'employé connecté depuis la session
$employee_id = $_SESSION['id'];

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

// Requête SQL pour récupérer les informations de l'employé depuis la base de données
$sql_employee = "SELECT * FROM employee WHERE id='$employee_id'";
$result_employee = $conn->query($sql_employee);

// Récupérer les informations 
if ($result_employee->num_rows > 0) {
    $employee_data = $result_employee->fetch_assoc();
    $employee_name = $employee_data['name'];
    $employee_function = $employee_data['function'];
}

// Requête SQL pour récupérer les détails de présence de l'employé depuis la base de données
$sql_attendance = "SELECT * FROM attendance WHERE id='$employee_id'";
$result_attendance = $conn->query($sql_attendance);

// Fermer la connexion à la base de données
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Details</title>
    <link rel="stylesheet" href="stylatt.css">
</head>
<body>
    <div class="container">
        <!-- Logo Naftal -->
        <img src="naftal.jpg" alt="Naftal Logo" class="logo">

        <!-- Employee Information -->
        <div class="employee-info">
            <h2>Employee Informations:</h2>
            <p><strong>Name:</strong> <?php echo $employee_name; ?></p>
            <p><strong>Function:</strong> <?php echo $employee_function; ?></p>
            <p><strong>Id:</strong> <?php echo $employee_id; ?></p>
        </div>

        <!-- Attendance Details Table -->
        <div class="attendance-details">
            <h3>Attendance Details :</h3>
            <table>
                <thead>
                    <tr>
                        <th>Day</th>
                        <th>Date</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Afficher les détails de présence de l'employé
                    if ($result_attendance->num_rows > 0) {
                        while ($row = $result_attendance->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['day'] . "</td>";
                            echo "<td>" . $row['date'] . "</td>";
                            echo "<td>" . $row['time'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No attendance records found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

