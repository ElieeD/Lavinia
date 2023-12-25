<?php
include('conect.php');
$s = "";

if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    // Fetch user data based on id
    $result = mysqli_query($conn, "SELECT Formative_Ass, Summative_Ass, Comprehensive_Ass FROM marks WHERE Mark_ID=$id");

    while ($user_data = mysqli_fetch_array($result)) {
        $Formative_Ass = $user_data['Formative_Ass'];
        $Summative_Ass = $user_data['Summative_Ass'];
        $Comprehensive_Ass = $user_data['Comprehensive_Ass'];
    }
}

if (isset($_POST['ok'])) {
    $id = $_POST['Mark_ID'];
    $Formative_Ass = $_POST['Formative_Ass'];
    $Summative_Ass = $_POST['Summative_Ass'];
    $Comprehensive_Ass = $_POST['Comprehensive_Ass'];

    // Calculate the total
    $Total_Marks_100 = ($Formative_Ass + $Summative_Ass + $Comprehensive_Ass) / 3;

    $insertSql = "UPDATE marks SET Formative_Ass='$Formative_Ass', Summative_Ass='$Summative_Ass', Comprehensive_Ass='$Comprehensive_Ass', Total_Marks_100='$Total_Marks_100' WHERE Mark_ID='$id'";

    if ($conn->query($insertSql) === TRUE) {
        header('location:operation.php');
        $s = "Mark Record successfully Updated";
    } else {
        $s = "Error occurred: " . $conn->error;
    }
}

$traineeQuery = "SELECT Trainee_Id, FirstName, LastName FROM trainees";
$traineeResult = $conn->query($traineeQuery);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylee.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Update Marks</title>
    <style>
        /* Your existing CSS styles */
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    position: fixed;
    overflow: hidden;
}

header {
    background-color: #900C3F;
    color: #000;
    text-align: center;
    padding: 10px 0;
}

nav {
    background-color: #900C3F;
}

nav ul {
    list-style: none;
    margin: 0;
    padding: 0;
}

nav li {
    display: inline;
    margin-right: 30px;
}

nav a {
    text-decoration: none;
    color: #000;
    font-weight: bold;
    font-size: 16px;
    transition: color 0.3s ease, transform 0.3s ease;
}

nav a:hover {
    color: #fff;
    transform: translateY(-3px);
}

nav i {
    margin-right: 5px;
}

.elie {
    height: 80px;
    width: 80%;
    background-color: #900C3F;
    margin-left: 310px;
    margin-top: 10px;
}

.elie ul {
    list-style: none;
    padding: 10px 0;
}

.elie li {
    display: inline;
    margin-left: -30px;
}

.elie a {
    text-decoration: none;
    display: inline;
    margin-right: 20px;
    color: #fff;
}

.main-content {
    text-align: center;
    position: fixed;
    bottom: -52px;
    left: 0;
    right: 0;
    overflow-y: auto;
}

footer {
    background-color: #900C3F;
    color: #000;
    text-align: center;
    padding: 10px 0;
    width: 100%;
    position: fixed;
    bottom: 0;
}

.login-form {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin: 20px auto;
    max-width: 400px;
}

.login-form h2 {
    text-align: center;
    color: #333;
}

.login-form form {
    display: flex;
    flex-direction: column;
}

.login-form label {
    margin-bottom: 8px;
    color: #555;
}

.login-form select,
.login-form input {
    padding: 10px;
    margin-bottom: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
}

.login-form button {
    background-color: #900C3F;
    color: #fff;
    padding: 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

.login-form button:hover {
    background-color: #900C3F;
}

    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="#"><i class="fas fa-home"></i> DASHBOARD</a></li>
                <li><a href="login.php"><i class="fas fa-sign-in-alt"></i> LOG OUT</a></li>
            </ul>
        </nav>
    </header>
    <br><br>
    <div class="elie"> 
        <ul><br>
            <li><a href="inserts.php"><i class="fas fa-book"></i> MODULES</a></li>
            <li><a href="trade.php"><i class="fas fa-tools"></i> TRADES</a></li>
            <li><a href="trainee.php"><i class="fas fa-users"></i> TRAINEES</a></li>
            <li><a href="marks.php"><i class="fas fa-marker"></i> MARKS</a></li>
        </ul>
    </div>
    <br>
    <div class="main-content">
        <div class="login-form">
            <p><?php echo $s; ?></p>
            <form action="" method="post">
                <input type="hidden" name="Mark_ID" value="<?php echo $id; ?>">
                
                <!-- Display a message to inform users -->
<p style="color: #900C3F; font-weight: bold;">Note: Trainee information is not editable.</p>

<!-- Trainee input field -->
<label>Trainee  Name</label>  
<input type="text" name="Trainee" value="<?php
    $traineeQuery = "SELECT t.FirstName, t.LastName 
                     FROM trainees t
                     INNER JOIN marks m ON t.Trainee_Id = m.Trainee_Id
                     WHERE m.Mark_ID = $id";

    $traineeResult = $conn->query($traineeQuery);

    if ($traineeResult->num_rows > 0) {
        $traineeData = $traineeResult->fetch_assoc();
        echo "{$traineeData['FirstName']} {$traineeData['LastName']}";
    } else {
        echo "Trainee not found"; // Adjust the message as needed
    }
?>" readonly>

                  
                 <label>Formative Assessment</label>

                <input type="number" name="Formative_Ass" value="<?php echo $Formative_Ass; ?>" required min="0" max="100">
                <label>Summative Assessment</label>
                <input type="number" name="Summative_Ass" value="<?php echo $Summative_Ass; ?>" min="0" max="100">
                <label>Comprehensive Assessment</label>
                <input type="number" name="Comprehensive_Ass" value="<?php echo $Comprehensive_Ass; ?>" min="0" max="100">
                <button type="submit" name="ok">UPDATE</button>
            </form>
        </div>
    </div>

    <footer>
        <nav>
            <p>&copy; 2023 All Rights Reserved</p>
        </nav>
    </footer>
</body>
</html>
