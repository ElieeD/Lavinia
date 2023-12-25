<?php
include('conect.php');
// $s = "";

// Fetch data for the marks table
$marksQuery = "SELECT marks.*, trainees.FirstName, trainees.LastName, modules.ModName
               FROM marks
               INNER JOIN trainees ON marks.Trainee_Id = trainees.Trainee_Id
               INNER JOIN modules ON marks.Module_Id = modules.Module_Id";

$marksResult = $conn->query($marksQuery);



include('conect.php');

// Check if delete_id parameter is set in the URL
if (isset($_GET['delete_id'])) {
    // Get the mark ID from the URL parameter
    $markID = $_GET['delete_id'];

    // Prepare and execute the SQL query to delete the record
    $deleteQuery = "DELETE FROM marks WHERE Mark_ID = $markID";
    $result = $conn->query($deleteQuery);

    // Check if the delete operation was successful
    if ($result) {
        // $s = "Record deleted successfully";
    } else {
        // $s = "Error deleting record: " . $conn->error;
    }
}

// // Redirect back to the marks.php page
// header("Location: operation.php");
// exit();



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylee.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Edit and Delete Marks</title>
    <style>
        /* Add your custom styles here */
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

header {
    background-color: #900C3F;
    color: #fff;
    text-align: center;
    padding: 10px 0;
}

.elie {
    height: 80px;
    width: 80%;
    background-color: #900C3F;
    margin-left: 170px;
    margin-top: 10px;
}

.elie ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.elie li {
    display: inline-block;
    margin-right: 30px;
}

.elie a {
    text-decoration: none;
    color: #fff;
    font-weight: bold;
    font-size: 16px;
    transition: color 0.3s ease;
}

.elie a:hover {
    color: #fff;
    transform: translateY(-3px);
}

.main-content {
    text-align: center;
}

footer {
    background-color: #900C3F;
    color: #fff;
    text-align: center;
    padding: 10px 0;
    width: 100%;
    position: fixed;
    bottom: 0;
}
table {
    width: 80%;
    margin: 20% auto;
    border-collapse: collapse;
}

table, th, td {
    border: 1px solid #ccc;
}

th, td {
    padding: 10px;
    text-align: center;
}

th {
    background-color: #900C3F;
    color: #fff;
}

td {
    background-color: #fff;
}

.edit-btn, .delete-btn {
    padding: 5px 10px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    cursor: pointer;
    margin: 2px;
    border-radius: 4px;
}

.edit-btn {
    background-color: #4CAF50;
    color: #fff;
}

.delete-btn {
    background-color: #f44336;
    color: #fff;
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
    <center><h2 style="margin-top: 89px; margin-left:540px; position:fixed;">EDIT AND DELETE MARKS</h2></center>

    <div class="main-content">
        <div class="login-form">
            <table>
                <tr>
                    <th>Trainee Name</th>
                    <th>Module</th>
                    <th>Formative</th>
                    <th>Summative</th>
                    <th>Comprehensive</th>
                    <th>Total Marks (out of 100)</th>
                    <th>Action</th>
                </tr>
                <?php
                while ($row = $marksResult->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['FirstName']} {$row['LastName']}</td>";
                    echo "<td>{$row['ModName']}</td>";
                    echo "<td>{$row['Formative_Ass']}</td>";
                    echo "<td>{$row['Summative_Ass']}</td>";
                    echo "<td>{$row['Comprehensive_Ass']}</td>";
                    echo "<td>{$row['Total_Marks_100']}</td>";
                    echo "<td>
                            <a href='update.php?delete_id={$row['Mark_ID']}' class='edit-btn'{$row['Formative_Ass']}, {$row['Summative_Ass']}, {$row['Comprehensive_Ass']})'><i class='fas fa-edit'></i> Edit</a>
                            <a href='operation.php?delete_id={$row['Mark_ID']}' class='delete-btn'><i class='fas fa-trash'></i> Delete</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </table>

    <footer>
        <nav>
            <p>&copy; 2023 All Rights Reserved</p>
        </nav>
    </footer>

</body>
</html>
