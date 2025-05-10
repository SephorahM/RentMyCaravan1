<?php
    session_start();

        include("connectregister.php");
        include("check_login.php");

        $user_data = check_login($con);
        $user_id = $_SESSION['user_id'];

        $query = "select * from caravan_db where user_id = '$user_id'";
        $result = mysqli_query($con, $query);

        if (!$result) {
            die("Invalid query: " . $con->error);
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Your Caravan List</title>
</head>
<body>
    <div class="navbar">
        <a href="userhomepage.php">Home</a>
        <div class="dropdown">
            <a class="dropbtn">List Your Caravan</a>
            <div class="dropdown-content">
            <a href="addcaravan.php">Add Caravan</a>
            <a href="caravanlist.php">Your Caravan List</a>
            </div>
        </div>
        <a href="caravansummary.php">Caravan Summary</a>
        <a href="logout.php">Logout</a>
    </div>
    <div id="caravan-list" class="table-container" style="background: teal;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 style="margin: 0;">Your Caravan List</h1>
        <a href="caravansummary.php" class="btn btn-summary">View Caravan Summary</a>
    </div>
        <div class="table-scroll">
            <table class="table">
                <thead>
                    <tr>
                        <th>Caravan Make</th>
                        <th>Caravan Model</th>
                        <th>Registration Year</th>
                        <th>Caravan Details</th>
                        <th>Caravan Image</th>
                        <th>Mobile Number</th>
                        <th>Edit/Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>$row[caravan_make]</td>
                                <td>$row[caravan_model]</td>
                                <td>$row[caravan_year]</td>
                                <td>$row[caravan_details]</td>
                                <td><img src='{$row['caravan_image']}' alt='Caravan Image' class='caravan-thumb'></td>
                                <td>$row[mobile_number]</td>
                                <td>
                                    <a class='btn btn-edit' href='editcaravan.php?id={$row['id']}'>Edit</a><br></br>
                                    <a class='btn btn-delete' href='deletecaravan.php'>Delete</a>
                                </td>
                            </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
</body>
</html>