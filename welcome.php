<!doctype HTML>
<html>

<head>
    <title>login</title>
    <link rel="stylesheet" href="welcome.css">
</head>

<body>
    <?php
    session_start();
    if (isset($_SESSION['od_requested'])) {
        echo "<script>alert('OD request sent');</script>";
        unset($_SESSION['od_requested']);
    }
    $dbhost = 'localhost';
    $dbname = 'OD';
    $dbusername = 'root';
    $dbpassword = '2003';
    $conn = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);
    $uname = $_SESSION['username'];
    $query = "SELECT name FROM login_data WHERE roll_no='$uname'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo "<h1>Welcome " . $row['name'] . "</h1>";
    } else {
        header("Location:login.php");
    }
    $query1 = "select * from od_info where roll_no='$uname';";
    if (mysqli_num_rows(mysqli_query($conn, $query1)) > 0) {
        echo "<h2>OD details</h2>";
        echo '<table>';
        $result = mysqli_query($conn, $query1);
        echo "<tr><td>Date</td>" . "<td>Event Name</td>" . "<td>Organising institution</td>. " . "<td>Class incharge/academic counsellor</td>" . "<td>HOD</td></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>" . $row["date"] . "</td>" . "<td>" . $row["event_name"] . "</td>" . "<td>" . $row["org_institution"] . "</td>" . "<td>" . $row["level1"] . "</td>" . "<td>" . $row["level2"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No OD details found";
    }
    ?>
    <button onclick="toggleForm()">Request New OD</button>
    <form class="form" id="od-form" method="POST">
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required><br>

        <label for="event-name">Event Name:</label>
        <input type="text" id="event-name" name="event-name" required><br>

        <label for="organizing-institution">Organizing Institution:</label>
        <input type="text" id="organizing-institution" name="organizing-institution" required><br>

        <input type="submit" value="Submit" onclick="alert('Request Sent')">
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $date = $_POST["date"];
        $event_name = $_POST["event-name"];
        $org_institution = $_POST["organizing-institution"];
        $query3 = "INSERT INTO od_info (date, event_name, org_institution, level1, level2, roll_no) VALUES ('$date', '$event_name', '$org_institution', 'no', 'no', '$uname')";
        if (mysqli_query($conn, $query3)) {
            // Insert successful, redirect to the same page
            $_SESSION['od_requested'] = true;
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit();
        } else {
            echo "OD request failed";
            echo mysqli_error($conn);
        }

    }
    ?>

    <script>
        function toggleForm() {
            var form = document.getElementById("od-form");
            if (form.style.display === "none") {
                form.style.display = "block";
            } else {
                form.style.display = "none";
            }
        }
    </script>

</body>

</html>