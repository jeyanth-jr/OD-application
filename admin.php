<!DOCTYPE html>
<html>

<head>
    <title>Admin</title>
    <link rel="stylesheet" href="admin.css">
</head>

<body>
    <?php
    session_start();
    if (!isset($_SESSION['username']) || $_SESSION['usertype'] !== 'admin') {
        header("Location: login.php");
        exit();
    }
    $uname = $_SESSION['username'];
    $dbhost = "localhost";
    $dbusername = "root";
    $dbpassword = "2003";
    $dbname = "OD";
    $conn = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);
    if (!$conn) {
        die("connection failed:" . mysqli_connect_error());
    }
    $query = "SELECT name FROM login_data WHERE roll_no='$uname'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo "<h1>Welcome to admin page <br>" . $row['name'] . "</h1>";
    }
    $query2 = "SELECT * FROM od_info ORDER BY DATE ASC";
    $result2 = mysqli_query($conn, $query2);
    if (mysqli_num_rows($result2) > 0) {
        echo "<table><tr><th>OD ID</th><th>DATE</th><th>NAME</th><th>REASON</th><th>CLASS INCHARGE/COUNSELLOR</th><th>HOD</th><th>roll no</th></tr>";
        while ($row2 = mysqli_fetch_assoc($result2)) {
            $level1 = $row2['level1'];
            $level2 = $row2['level2'];
            $levelNotGranted = false;
            if ($level1 !== 'granted' || $level2 !== 'granted') {
                $levelNotGranted = true;
                echo "<tr class='level-not-granted'>";
            } else {
                echo "<tr>";
            }
            echo "<td>" . $row2['od_id'] . "</td><td>" . $row2['date'] . "</td><td>" . $row2['event_name'] . "</td><td>" . $row2['org_institution'] . "</td><td>" . $level1 . "</td><td>" . $level2 . "</td><td>" . $row2['roll_no'] . "</td></tr>";
        }

        echo "</table>";
        echo "<form method='POST' class='form-container'>
              <label for='od_id'>OD ID:</label>
              <input type='text' id='od_id' name='od_id' required><br>
              <br>
              <label for='permission_type'>Permission Type:</label>
              <select id='permission_type' name='permission_type'>
                  <option value='class_incharge'>Class Incharge/Counsellor</option>
                  <option value='hod'>HOD</option>
              </select>
              <br>
              <label for='permission'>Permission:</label>
              <select id='permission' name='permission'>
                  <option value='grant'>Grant</option>
                  <option value='revoke'>Revoke</option>
              </select>
              <br>
              <input type='submit' name='submit' value='Update'>
              </form>";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['submit'])) {
                $od_id = $_POST['od_id'];
                $permission_type = $_POST['permission_type'];
                $permission = $_POST['permission'];
                if ($permission_type == 'class_incharge') {
                    if ($permission == 'grant') {
                        $query3 = "UPDATE od_info SET level1='granted' WHERE od_id='$od_id'";
                        $result3 = mysqli_query($conn, $query3);
                        if ($result3) {
                            echo "Updated";
                        } else {
                            echo "Error";
                        }
                    } else {
                        $query3 = "UPDATE od_info SET level1='revoked' WHERE od_id='$od_id'";
                        $result3 = mysqli_query($conn, $query3);
                        if ($result3) {
                            echo "Updated";
                        } else {
                            echo "Error";
                        }
                    }
                } else if ($permission_type == 'hod') {
                    if ($permission == 'grant') {
                        $query3 = "UPDATE od_info SET level2='granted' WHERE od_id='$od_id'";
                        $result3 = mysqli_query($conn, $query3);
                        if ($result3) {
                            echo "Updated";
                        } else {
                            echo "Error";
                        }
                    }
                } else {
                    $query3 = "UPDATE od_info SET level2='revoked' WHERE od_id='$od_id'";
                    $result3 = mysqli_query($conn, $query3);
                    if ($result3) {
                        echo "Updated";
                    } else {
                        echo "Error";
                    }
                }
            }
        }
    } else {
        echo "No OD Data Found";
    }
    ?>
</body>