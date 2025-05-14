<?php
session_start();

    include("connectregister.php");
    include("check_login.php");

    $user_data = check_login($con);

    if (!isset($_SESSION['user_id'])) {
        die("User not logged in. Session ID missing.");
    }

    $error_message = "";

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        //something was posted
        $user_id = $_SESSION['user_id'];
        $caravan_make = $_POST['caravan_make'];
        $caravan_model = $_POST['caravan_model'];
        $caravan_year = $_POST['caravan_year'];
        $caravan_details = $_POST['caravan_details'];
        $caravan_image = $_POST['caravan_image'];
        $mobile_number = $_POST['mobile_number'];

        if(!empty($user_id) && !empty($caravan_make) && !empty($caravan_model) && !empty($caravan_year) && !empty($caravan_details) &&!empty($caravan_image))
        { 
            if (!ctype_digit($mobile_number)) {
                $error_message = "Please enter numeric mobile number!";
            } else {
                //save to database
                $query = "insert into caravan_db (user_id, caravan_make, caravan_model, caravan_year, caravan_details, caravan_image, mobile_number)
                values ('$user_id', '$caravan_make', '$caravan_model', '$caravan_year', '$caravan_details','$caravan_image', '$mobile_number')";

                mysqli_query($con, $query);

                header("Location: caravanlist.php");
                die;
            }
        } else {
            $error_message = "Please enter vailid information!";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Add Caravan</title>
</head>
<body class="<?php echo isset($_SESSION['user_id']) ? 'logged-in' : 'logged_out'; ?>">
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
    <div id="add-caravan" class="container" style="background: teal;">
        <h1>Add Your Caravan</h1>
        <div class="form-container">
            <?php if ($error_message == "Please enter numeric mobile number!"): ?>
                <script>
                    alert("Invalid mobile number! Please enter only numeric digits (no alphabets or special characters).");
                </script>
            <?php endif; ?>
            <form id="add-caravan-form" action="addcaravan.php" method="POST">
                <input type="text" id="register-caravan-make" placeholder="Caravan Make" name="caravan_make" required>
                <input type="text" id="register-caravan-model" placeholder="Caravan Model" name="caravan_model" required>
                <input type="text" id="register-caravan-year" placeholder="Registration Year" name="caravan_year" required>
                <textarea id="caravan-details" placeholder="Caravan Details" name="caravan_details" rows="4" required style="width: 100%;"></textarea>
                <input type="url" id="caravan-image" placeholder="Caravan Image URL" name="caravan_image" required>
                <input type="numbers" id="mobile-number" placeholder="Mobile Number" name="mobile_number" required>
                <button type="submit">Add Caravan</button>
                <p id="add-caravan-error" class="error"></p>
            </form>
        </div>
    </div>
</body>
</html>