<?php

require 'dbConnection.php';
require 'helpers.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  

    $email    = Clean($_POST['email']);
    $password = Clean($_POST['pass']);

    $errors = [];


    # Validate Email
    if (!Validate($email, 1)) {
        $errors['Email'] = 'Field Required';
    } elseif (!Validate($email, 2)) {
        $errors['Email'] = 'Invalid Email';
    }

    # Validate Password
    if (!Validate($password, 1)) {
        $errors['Password'] = 'Field Required';
    } elseif (!Validate($password, 3)) {
        $errors['Password'] = 'Length must be >= 6 chars';
    }

    if (count($errors) > 0) {
        # Print Errors
        Errors($errors);
    } else {
        

        $sql = "select * from student where email = '$email' and pass = '$password'";
        //echo $sql;
        $op  = mysqli_query($con,$sql);

        if(mysqli_num_rows($op) == 1){

           $data = mysqli_fetch_assoc($op);
           
           $_SESSION['student'] = $data;

           header("Location:  index.php");





        }else{
            echo '* Error in Email || Password Try Again !!!!';
        }



    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">
        <h2>Login</h2>


        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">


            <div class="form-group">
                <label for="exampleInputEmail">Email </label>
                <input type="text" class="form-control"  name="email" placeholder="Enter email">
            </div>

            <div class="form-group">
                <label for="exampleInputPassword">Password</label>
                <input type="password" class="form-control"  name="pass" placeholder="Password">
            </div>


            <button type="submit" class="btn btn-primary">Login</button>
        </form>



</body>

</html>
