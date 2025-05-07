<?php
session_start();

    include("connectregister.php");
    include("check_login.php");

    $user_data = check_login($con);
    $user_id = $_SESSION['user_id'];
    $id = ($_SERVER['REQUEST_METHOD'] === 'POST') ? $_POST['id'] : $_GET['id'];

        $query = "select * from caravan_db where user_id = '$user_id' and id = '$id' limit 1";
        $result = mysqli_query($con, $query);
        $row = $result->fetch_assoc();

        if (!$row) {
            header("Location: caravanlist.php");
            die;
        }        

if($_SERVER['REQUEST_METHOD'] == "POST") {
    //something was posted
    $caravan_make = $_POST['caravan_make'];
    $caravan_model = $_POST['caravan_model'];
    $caravan_year = $_POST['caravan_year'];
    $caravan_details = $_POST['caravan_details'];
    $caravan_image = $_POST['caravan_image'];
    $mobile_number = $_POST['mobile_number'];

    $update_query = "update caravan_db set
        caravan_make = '$caravan_make',
        caravan_model = '$caravan_model',
        caravan_year = '$caravan_year',
        caravan_details = '$caravan_details',
        caravan_image = '$caravan_image',
        mobile_number = '$mobile_number'
        WHERE user_id = '$user_id' and id = '$id'";

    if (mysqli_query($con, $update_query)) {
        header("Location: caravanlist.php");
        exit;
    } else {
        echo "Error updating record: " . mysqli_error($con);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Edit Page</title>
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
    <div class="container">
        <h1>Edit Your Caravan</h1>
        <div class="form-container">
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="text" id="register-caravan-make" placeholder="Caravan Make" name="caravan_make" value="<?php echo $row['caravan_make']; ?>" required>
            <input type="text" id="register-caravan-model" placeholder="Caravan Model" name="caravan_model" value="<?php echo $row['caravan_model']; ?>" required>
            <input type="text" id="register-caravan-year" placeholder="Registration Year" name="caravan_year" value="<?php echo $row['caravan_year']; ?>" required>
            <textarea id="caravan-details" placeholder="Caravan Details" name="caravan_details" rows="4" required style="width: 100%;"><?php echo $row['caravan_details']; ?></textarea>
            <input type="url" id="caravan-image" placeholder="Caravan Image URL" name="caravan_image" value="<?php echo $row['caravan_image']; ?>" required>
            <input type="text" id="mobile-number" placeholder="Mobile Number" name="mobile_number" value="<?php echo $row['mobile_number']; ?>" required>
            <button type="submit">Submit</button>
            <button class="btn-cancel" onclick="window.location.href='caravanlist.php'">Cancel</button>
            <p id="add-caravan-error" class="error"></p>
        </form>
        </div>
    </div>
</body>
</html>