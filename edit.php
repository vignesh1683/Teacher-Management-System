<?php
  include "connection.php";
  $id="";
  $name="";
  $age="";
  $dob="";
  $Gender="";           
  $classes="";
  $email="";
  $phone="";

  $error="";
  $success="Successfully Updated";

  if($_SERVER["REQUEST_METHOD"]=='GET'){
    if(!isset($_GET['id'])){
      header("location:/home.php");
      exit;
    }
    $id = $_GET['id'];
    $sql = "select * from home where id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    while(!$row){
      header("location: /home.php");
      exit;
    }
    $name=$row["name"];
    $age=$row["age"];
    $dob=$row["dob"];
    $Gender=$row["Gender"];
    $classes=$row["classes"];
    $email=$row["email"];
    $phone=$row["phone"];

  }
  else{
    $id = $_POST["id"];
    $name=$_POST["name"];
    $age=$_POST["age"];
    $dob=$_POST["dob"];
    $Gender=$_POST["Gender"];
    $classes=$_POST["classes"];
    $email=$_POST["email"];
    $phone=$_POST["phone"];

    $sql = "update home set name='$name', age='$age', dob='$dob', Gender='$Gender', classes='$classes', email='$email', phone='$phone' where id='$id'";
    $result = $conn->query($sql);
    
  }
  
?>
<!DOCTYPE html>
<html>
<head>
 <title>Edit</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" class="fw-bold">
      <div class="container-fluid">
        <a class="navbar-brand" href="home.php">Teacher Management System</a>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="home.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="create.php">Add New</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
 <div class="col-lg-6 m-auto">
 
 <form method="post">
 
 <br><br><div class="card">
 
 <div class="card-header bg-warning">
 <h1 class="text-white text-center">  Update Member </h1>
 </div><br>

 <input type="hidden" name="id" value="<?php echo $id; ?>" class="form-control"> <br>

 <label> NAME: </label>
 <input type="text" name="name" value="<?php echo $name; ?>" class="form-control"> <br>

 <label> AGE: </label>
 <input type="int" name="age" value="<?php echo $age; ?>" class="form-control"> <br>

 <label> DATE OF BITRH: </label>
 <input type="int" name="dob" value="<?php echo $dob; ?>" class="form-control"> <br>

 <label> GENDER: </label>
 <input type="text" name="Gender" value="<?php echo $Gender; ?>" class="form-control"> <br>

 <label> CLASSES: </label>
 <input type="int" name="classes" value="<?php echo $classes; ?>" class="form-control"> <br>

 <label> EMAIL: </label>
 <input type="text" name="email" value="<?php echo $email; ?>" class="form-control"> <br>

 <label> PHONE: </label>
 <input type="text" name="phone" value="<?php echo $phone; ?>" class="form-control"> <br>

 <a class="btn btn-success" type="submit" name="submit" href="home.php"> Submit </a><br>
 <a class="btn btn-info" type="submit" name="cancel" href="home.php"> Cancel </a><br>

 </div>
 </form>
 </div>
</body>
</html>