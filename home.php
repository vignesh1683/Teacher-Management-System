<?php
    include "connection.php";
    if (isset($_POST['submit'])) {
        $search = $_POST['search'];
        $sql = "SELECT * FROM `home` WHERE id LIKE '%$search%' OR name LIKE '%$search%' OR Gender LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%'";
    } elseif (isset($_GET['filter'])) {
        $filter = $_GET['filter'];
        switch ($filter) {
            case 'ageasc':
                $sql = "SELECT * FROM `home` ORDER BY age ASC";
                break;
            case 'agedesc':
                $sql = "SELECT * FROM `home` ORDER BY age DESC";
                break;
            case 'age20':
                $sql = "SELECT * FROM `home` WHERE age BETWEEN 20 AND 30";
                break;
            case 'age30':
                $sql = "SELECT * FROM `home` WHERE age BETWEEN 31 AND 40";
                break;
            case 'age40':
                $sql = "SELECT * FROM `home` WHERE age BETWEEN 41 AND 50";
                break;
            case 'classdesc':
                $sql = "SELECT * FROM `home` ORDER BY classes DESC";
                break;
            case 'classasc':
                $sql = "SELECT * FROM `home` ORDER BY classes ASC";
                break;
            default:
                $sql = "SELECT * FROM `home`";
        }
    } else {
        $sql = "SELECT * FROM `home`";
    }
    $result = mysqli_query($conn, $sql);
    if (isset($_POST['create'])) {
        $name = $_POST['name'];
        $age = $_POST['age'];
        $dob = $_POST['dob'];
        $gender = $_POST['Gender'];
        $classes = $_POST['classes'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        $phone_regex = "/^[0-9]{10}$/";
    
        if (!preg_match($phone_regex, $phone)) {
            echo '<script>alert("Please enter a valid 10-digit phone number.");</script>';
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo '<script>alert("Please enter a valid email address.");</script>';
            } else {
                $dob_regex = "/^\d{4}-\d{2}-\d{2}$/";
                if (!preg_match($dob_regex, $dob)) {
                    echo '<script>alert("Please enter a valid date of birth in the format YYYY-MM-DD.");</script>';
                } else {
                    $q = "INSERT INTO `home`(`name`, `age`, `dob`, `Gender`, `classes`, `email`, `phone`) VALUES ('$name', '$age', '$dob', '$gender', '$classes', '$email', '$phone')";
                    $query = mysqli_query($conn, $q);
    
                    if ($query) {
                        echo '<script>alert("Form submitted successfully.");</script>';
                        header("Location: home.php");  
                        exit();
                    } else {
                        echo '<script>alert("Error: Unable to submit data.");</script>';
                    }
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css"></script>
    <title>Dashboard</title>
</head>
<body>
    <div class="container-fluid">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.php">Teacher Management System</a>
            <form method="POST">
                <div class="form-group" style="padding-top: 10px;">
                    <input type="text" placeholder="search" name="search"><button class="ctn btn-dark btn-sm" name="submit">Search</button>
                </div>
            </form>
            <form action="" method="GET">
                <div class="form-group" style="padding-top: 10px;">
                    <div>
                        <select name="filter" class="form-select">
                            <option value="">Select</option>
                            <option value="ageasc"<?=isset($_GET['filter']) == true ? ($_GET['filter']=='ageasc' ? 'selected':''):''?>>AGE ASCENDING</option>
                            <option value="agedesc"<?=isset($_GET['filter']) == true ? ($_GET['filter']=='agedesc' ? 'selected':''):''?>>AGE DESCENDING</option>
                            <option value="age20"<?=isset($_GET['filter']) == true ? ($_GET['filter']=='age20' ? 'selected':''):''?>>AGE 20-30</option>
                            <option value="age30"<?=isset($_GET['filter']) == true ? ($_GET['filter']=='age30' ? 'selected':''):''?>>AGE 30-40</option>
                            <option value="age40"<?=isset($_GET['filter']) == true ? ($_GET['filter']=='age40' ? 'selected':''):''?>>AGE 40-50</option>
                            <option value="classasc"<?=isset($_GET['filter']) == true ? ($_GET['filter']=='classasc' ? 'selected':''):''?>>NO. OF CLASSES ASCENDING</option>
                            <option value="classdesc"<?=isset($_GET['filter']) == true ? ($_GET['filter']=='classdesc' ? 'selected':''):''?>>NO. OF CLASSES DESCENDING</option>
                        </select>
                        <button type="submit" class="ctn btn-dark btn-sm" name="submit">Submit</button>
                    </div>
                </div>
            </form>
            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#addTeacherModal">
            Add Teacher
            </button>
            <a href="home.php" class="btn btn-secondary">Reset</a>
            <form method="post"><input class="btn btn-secondary" type="submit" name="calculate" value="Average"></form>
            <a href="logout.php" class="btn btn-secondary">Log Out</a>
        </div>
    </nav>
    <div style="padding-bottom: 10px;padding-top: 10px;">List of Teachers</div>
    <table class="table" style="background: #F0ECE5">
        <thead>
            <tr style="background: #BBAB8C; color: #fff;">
                <th>ID</th>
                <th>NAME</th>
                <th>AGE</th>
                <th>DATE OF BIRTH</th>
                <th>GENDER</th>
                <th>No. of Class</th>
                <th>EMAIL</th>
                <th>PHONE</th>
                <th>JOINING DATE</th>
                <th>ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>
                                <td>' . $row["id"] . '</td>
                                <td>' . $row["name"] . '</td>
                                <td>' . $row["age"] . '</td>
                                <td>' . $row["dob"] . '</td>
                                <td>' . $row["Gender"] . '</td>
                                <td>' . $row["classes"] . '</td>
                                <td>' . $row["email"] . '</td>
                                <td>' . $row["phone"] . '</td>
                                <td>' . $row["join_date"] . '</td>
                                <td>
                                    <a type="button" href="edit.php?id=' . $row["id"] . '" class="btn btn-success"">Edit</a>
                                    <a class="btn btn-danger" href="delete.php?id=' . $row["id"] . '">Delete</a>
                                </td>
                            </tr>';
                    }
                } else {
                    echo '<tr><td colspan="10" class="text-danger">Data not found</td></tr>';
                }
            } else {
                echo '<tr><td colspan="10" class="text-danger">Error in query execution</td></tr>';
            }
            if (isset($_POST['calculate'])) {
                $sql = "SELECT AVG(classes) as average FROM home";
                $result = $conn->query($sql);
        
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $average = $row["average"];
        
                    echo "<script>alert('The average value is: $average');</script>";
                } else {
                    echo "<script>alert('No data available');</script>";
                }}
            ?>
        </tbody>
    </table>
    <div class="modal" id="addTeacherModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Teacher</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form method="post" action="">
                    <div class="modal-body">
                        <label> NAME: </label>
                        <input type="text" name="name" class="form-control"> <br>
                   
                        <label> AGE: </label>
                        <input type="number" name="age" class="form-control"> <br>
                    
                        <label> DATE OF BIRTH: </label>
                        <input type="int" placeholder="YYYY-MM-DD" name="dob" class="form-control"> <br>
                    
                        <label> GENDER: </label>
                        <input type="text" name="Gender" class="form-control"> <br>
                    
                        <label> No.of classes: </label>
                        <input type="int" name="classes" class="form-control"> <br>
                    
                        <label> EMAIL: </label>
                        <input type="text" name="email" class="form-control"> <br>
                    
                        <label> PHONE: </label>
                        <input type="text" name="phone" class="form-control"> <br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-success" type="submit" name="create"> Submit </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</body>
</html>