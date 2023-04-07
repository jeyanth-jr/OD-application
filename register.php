<!DOCTYPE HTML>
<html>

<head>
	<title>Register</title>
	<link rel="stylesheet" href="register.css">
</head>

<body>
	<div class="container">
		<h1>Create a new account now!</h1>
		<form action="" method="POST">
			<div class="input-container">
				<input type="text" name="name" placeholder="Name" required>
			</div>
			<div class="input-container">
				<input type="email" name="mailid" placeholder="Email" required>
			</div>
			<div class="input-container">
				<input type="text" name="rollno" placeholder="Roll no" required>
			</div>
			<div class="input-container">
				<input type="password" name="password" placeholder="Password" required>
			</div>
			<div class="input-container">
				<input type="password" name="cpassword" placeholder="confirm Password" required>
			</div>
			<input type="submit" name="submit" value="Sign Up" class="submit-button">
		</form>

		<?php
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			// retrieve form data
			$name = $_POST['name'];
			$email = $_POST['mailid'];
			$roll_no = $_POST['rollno'];
			$password = $_POST['password'];
			$cpassword = $_POST['cpassword'];
			if ($password != $cpassword) {
				echo '<span style="color: red;">Password does not match</span>';
				exit();
			}
			// connect to database
			$dbhost = "localhost";
			$dbusername = "root";
			$dbpassword = "2003";
			$dbname = "OD"; // Replace with the name of your database
			$conn = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);
			if (!$conn) {
				die("Connection failed: " . mysqli_connect_error());
			}

			// check if username already exists
			$query = "SELECT * FROM login_data WHERE roll_no='$roll_no'";
			$result = mysqli_query($conn, $query);
			if (mysqli_num_rows($result) > 0) {
				echo '<span style="color: red;">Username already taken</span>';
			} else {
				// insert new user into database
				$query = "INSERT INTO login_data VALUES ('$name', '$password', '$email', 'user','$roll_no')";
				$result = mysqli_query($conn, $query);
				if ($result) {
					// redirect to welcome page
					header("Location: welcome.php");
					exit();
				} else {
					echo "Error: " . mysqli_error($conn);
				}
			}
			mysqli_close($conn);
		}

		?>
		<p>Already have an account? <a href="login.php">Log In</a></p>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
</body>

</html>