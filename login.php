<!DOCTYPE html>
<html>

<head>
    <title>login</title>
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <h1>Welcome</h1>
    <form action="" method="POST">
        <input type="text" name="username" placeholder="enter roll no" required>
        <input type="password" name="password" placeholder="password" required>
        <input type="submit" name="submit" value="submit">
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $dbhost = "localhost";
        $dbusername = "root";
        $dbpassword = "2003";
        $dbname = "OD";
        $conn = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);
        if (!$conn) {
            die("connection failed: " . mysqli_connect_error());
        }
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $query = "SELECT * FROM login_data WHERE roll_no='$username'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if ($password === $row['password']) {
                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['usertype'] = $row['usertype'];
                if ($row['usertype'] == 'admin') {
                    header("Location: http://localhost/test/admin.php");
                    exit();
                } else if ($row['usertype'] == 'user') {
                    header("Location: http://localhost/test/welcome.php");
                    exit();
                }
            } else {
                echo '<span style="color:red">Invalid password</span>';
            }
        } else {
            echo '<span style="color:red">Invalid username</span>';
        }
        mysqli_close($conn);
    }
    ?>
    <p>Not a member? <a href="register.php">Sign up now</a></p>
    <footer>
        <p>Created with <span class="heart-icon">&hearts;</span> by Jeyanth:</p>
        <a href="https://github.com/jeyanth-jr"><img src="https://img.icons8.com/color/48/000000/github--v1.png"
                alt="github" /></a>
        <a href="https://www.linkedin.com/in/jeyanth-v-643895194/"><img
                src="https://img.icons8.com/color/48/000000/linkedin.png" alt="linkedin" /></a>
        <a href="https://www.instagram.com/jeyanth__jr/"><img
                src="https://img.icons8.com/color/48/000000/instagram-new.png" alt="instagram" /></a>

    </footer>

</body>

</html>