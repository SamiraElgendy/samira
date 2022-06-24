<?php
require 'dbConnection.php';
require 'helpers.php';
require 'checkLogin.php';

$id = $_GET['id'];

$sql = "select * from student where id = $id";
$op = mysqli_query($con, $sql);

if (mysqli_num_rows($op) == 1) {
    // code .....
    $UserData = mysqli_fetch_assoc($op);
} else {
    $_SESSION['Message'] = ['Message' => 'Invalid Id'];
    header('Location: index.php');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname      = Clean($_POST['fname']);
    $lname      = Clean($_POST['lname']);
    $email     = Clean($_POST['email']);
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
    if (!Validate($email, 1)) {
        $errors['Email'] = 'Field Required';
    } elseif (!Validate($email, 2)) {
        $errors['Email'] = 'Invalid Email';
    }

   

    # Validate Image
    if (Validate($_FILES['images']['name'], 1)) {
        $ImgTempPath = $_FILES['images']['tmp_name'];
        $ImgName = $_FILES['images']['name'];

        $extArray = explode('.', $ImgName);
        $ImageExtension = strtolower(end($extArray));

        if (!Validate($ImageExtension, 4)) {
            $errors['Image'] = 'Invalid Extension';
        } else {
            $FinalName = time() . rand() . '.' . $ImageExtension;
        }
    }

    if (count($errors) > 0) {
        Errors($errors);
    } else {
        // DB CODE .....
$Message=[];
        if (Validate($_FILES['images']['name'], 1)) {
            $disPath = './upload/' . $FinalName;

            if (!move_uploaded_file($ImgTempPath, $disPath)) {
                $Message = ['Message' => 'Error  in uploading Image  Try Again '];
            } else {
                unlink('./upload/' . $UserData['images']);
            }
        } else {
            $FinalName = $UserData['images'];
        }
    
        if (count($Message) == 0) {
            $sql = "update student set f_name='$fname',l_name='$lname' , email='$email' , addresses = '$address' , images ='$FinalName' where id = $id";

            $op = mysqli_query($con, $sql);

            if ($op) {
                $Message = ['Message' => 'Raw Updated'];
            } else {
                $Message = ['Message' => 'Error Try Again ' . mysqli_error($con)];
            }
        }
        # Set Session ......
        $_SESSION['Message'] = $Message;
        header('Location: index.php');
        exit();
    }
    $_SESSION['Message'] = $Message;
}
?>



<main>
   

                <form action="edit.php?id=<?php echo $UserData['id']; ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                        <label for="exampleInputName">First Name</label>
                        <input type="text" class="form-control" id="exampleInputName" name="fname" aria-describedby=""
                            placeholder="Enter Name"value="<?php echo $UserData['f_name']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputName">Last Name</label>
                        <input type="text" class="form-control" id="exampleInputName" name="lname" aria-describedby=""
                            placeholder="Enter Name"value="<?php echo $UserData['l_name']; ?>">
                    </div>


                    <div class="form-group">
                        <label for="exampleInputEmail">Email address</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="email"
                            aria-describedby="emailHelp" placeholder="Enter email" value="<?php echo $UserData['email']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputName">Image</label>
                        <input type="file" name="images">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword">Address</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" name="address"
                            placeholder="Address" value="<?php echo $UserData['addresses']; ?>">
                    </div>

                    <img src="upload/<?php echo $UserData['images']; ?>" alt="" height="50px" width="50px"> <br>


                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>


</main>