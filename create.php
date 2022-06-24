<?php
require 'dbConnection.php';
require 'helpers.php';
require 'checkLogin.php';

# Code .....

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname      = Clean($_POST['fname']);
    $lname      = Clean($_POST['lname']);
    $email     = Clean($_POST['email']);
    $password  = Clean($_POST['pass']); 
    $address  = Clean($_POST['address']); 


    # Validate name ....
    $errors = [];

    if (!Validate($fname, 1)) {
        $errors['Name'] = 'Required Field';
    } elseif (!Validate($fname, 5)) {
        $errors['Name'] = 'Invalid String';
    }

    if (!Validate($lname, 1)) {
        $errors['Name'] = 'Required Field';
    } elseif (!Validate($lname, 5)) {
        $errors['Name'] = 'Invalid String';
    }

    if (!Validate($address, 1)) {
        $errors['Address'] = 'Required Field';
    } elseif (!Validate($address, 5)) {
        $errors['Address'] = 'Invalid String';
    }

    # Validate Email
    if (!Validate($email,1)) {
        $errors['Email'] = 'Field Required';
    } elseif (!Validate($email,2)) {
        $errors['Email'] = 'Invalid Email';
    }


    # Validate Password
    if (!Validate($password,1)) {
        $errors['Password'] = 'Field Required';
    } elseif (!Validate($password,3)) {
        $errors['Password'] = 'Length must be >= 6 chars';
    }

    
   
    # Validate Image
    if (!Validate($_FILES['images']['name'],1)) {
        $errors['Image'] = 'Field Required';
    }else{

         $ImgTempPath = $_FILES['images']['tmp_name'];
         $ImgName     = $_FILES['images']['name'];

         $extArray = explode('.',$ImgName);
         $ImageExtension = strtolower(end($extArray));

         if (!Validate($ImageExtension,4)) {
            $errors['Image'] = 'Invalid Extension';
         }else{
             $FinalName = time().rand().'.'.$ImageExtension;
         }

    }


    if (count($errors) > 0) {
        Errors($errors);
    } else {
        // DB CODE .....

       $disPath = './upload/'.$FinalName;


       if(move_uploaded_file($ImgTempPath,$disPath)){

        $sql = "insert into student(f_name,l_name,email,images,addresses,pass) values ('$fname','$lname','$email','$FinalName','$address','$password')";
        $op = mysqli_query($con, $sql);

        if ($op) {
            $Message = ['Message' => 'Raw Inserted'];
        } else {
            $Message = ['Message' => 'Error Try Again ' . mysqli_error($con)];
        }
    
       }else{
        $Message = ['Message' => 'Error  in uploading Image  Try Again ' ];
       }
    
    }
    # Set Session ......
   // $_SESSION['Message'] = $Message;
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

        <h2>Create</h2>

<main>

                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="exampleInputName">First Name</label>
                        <input type="text" class="form-control" id="exampleInputName" name="fname" aria-describedby=""
                            placeholder="Enter Name">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputName">Last Name</label>
                        <input type="text" class="form-control" id="exampleInputName" name="lname" aria-describedby=""
                            placeholder="Enter Name">
                    </div>


                    <div class="form-group">
                        <label for="exampleInputEmail">Email address</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="email"
                            aria-describedby="emailHelp" placeholder="Enter email">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword">New Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="pass"
                            placeholder="Password">
                    </div>


                    <div class="form-group">
                        <label for="exampleInputName">Image</label>
                        <input type="file" name="images">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword">Address</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" name="address"
                            placeholder="Address">
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>


</main>

</div>
</body>

</html>
