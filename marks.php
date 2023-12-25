<?php
include('conect.php');
$s = "";

// Fetch data for foreign key fields
$moduleQuery = "SELECT Module_Id, ModName FROM modules";
$traineeQuery = "SELECT Trainee_Id, FirstName, LastName FROM trainees";

$moduleResult = $conn->query($moduleQuery);
$traineeResult = $conn->query($traineeQuery);

if (isset($_POST['ok'])) {
    $Module_Id = $_POST['module_Id'];
    $Trainee_Id = $_POST['trainee_Id'];
    $Assessment_Type = $_POST['assessmentType'];

    // Assuming you have input fields for each assessment type
    $Formative_Ass = ($_POST['assessmentType'] == 'Formative Assessment') ? $_POST['assessmentValue'] : 0;
    $Summative_Ass = ($_POST['assessmentType'] == 'Summative Assessment') ? $_POST['assessmentValue'] : 0;
    $Comprehensive_Ass = ($_POST['assessmentType'] == 'Comprehensive Assessment') ? $_POST['assessmentValue'] : 0;

    $Total_Marks_100 = ($Formative_Ass + $Summative_Ass + $Comprehensive_Ass) / 3;

    $insertSql = "INSERT INTO marks(Module_Id, Trainee_Id, Formative_Ass, Summative_Ass, Comprehensive_Ass, Total_Marks_100) 
                  VALUES ('$Module_Id', '$Trainee_Id', '$Formative_Ass', '$Summative_Ass', '$Comprehensive_Ass', '$Total_Marks_100')";

    if ($conn->query($insertSql) === TRUE) {
        header('location:operation.php');
        $s = "Trainee submitted successfully";
    } else {
        $s = "Error occurred: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylee.css">
    <!-- Include Font Awesome CSS (you can use a CDN or download the file) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Form with Select Options</title>
    <!-- Add your additional styles here -->
    <style> 
        /* Add your custom styles here */
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    position: fixed;
    overflow: hidden; /* Hide horizontal overflow */
}

header {
    background-color: #900C3F;
    color: #fff;
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
    color: #fff;
    font-weight: bold;
    font-size: 16px;
    transition: color 0.3s ease, transform 0.3s ease;
}

nav a:hover {
    color: #000; /* Change font color to black on hover */
    transform: translateY(-3px);
}

nav i {
    margin-right: 5px;
}

.elie {
    height: 80px;
    width: 80%;
    background-color: #900C3F;
     margin-left: 300px; 
    margin-top: 23px;
}

.elie ul {
    list-style: none;
    margin: 0;
    padding: 0;
}

.elie li {
    display: inline;
    padding: 4 15px;
     margin-left: 60px; 
}

.elie a {
    text-decoration: none;
    color: #fff;
}

.main-content {
    text-align: center;
    position: fixed;
    bottom: -52px;
    left: 0;
    right: 0;
    overflow-y: auto; /* Enable vertical overflow */
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
    max-width: 400px; /* Adjust the maximum width as needed */
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
    <center>
    <div class="elie"> 
        <ul><br><br>
            <li><a href="inserts.php"><i class="fas fa-book"></i> MODULES</a></li>
            <li><a href="trade.php"><i class="fas fa-tools"></i> TRADES</a></li>
            <li><a href="trainee.php"><i class="fas fa-users"></i> TRAINEES</a></li>
            <li><a href="marks.php"><i class="fas fa-marker"></i> MARKS</a></li>
        </ul>
    </div>
    </center>
    <br>
    <div class="main-content">
        <div class="login-form">
            <p><?php echo $s; ?></p>
            <form action="" method="post">
                <label for="moduleId">Select Module:</label>
                <select name="module_Id" required>
                    <option></option>
                    <?php
                    while ($row = $moduleResult->fetch_assoc()) {
                        echo "<option value='{$row['Module_Id']}'>{$row['ModName']}</option>";
                    }
                    ?>
                </select>

                <label for="traineeId">Select Trainee:</label>
                <select name="trainee_Id" required>
                    <option></option>
                    <?php
                    while ($row = $traineeResult->fetch_assoc()) {
                        echo "<option value='{$row['Trainee_Id']}'>{$row['FirstName']} {$row['LastName']}</option>";
                    }
                    ?>
                </select>

                <!-- Select assessment type -->
                <label for="assessmentType">Select Assessment Type:</label>
                <select name="assessmentType" required>
                    <option></option>
                    <option value="Formative Assessment">Formative Assessment</option>
                    <option value="Summative Assessment">Summative Assessment</option>
                    <option value="Comprehensive Assessment">Comprehensive Assessment</option>
                </select>

                <!-- Input field for assessment value -->
                <label for="assessmentValue">Assessment Value:</label>
                <input type="number" name="assessmentValue" required >

                <button type="submit" name="ok">SAVE</button>
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
