
<?php 
 require 'dbConnection.php';
 require 'checkLogin.php';

 $sql     = "select * from student";
 $objData = mysqli_query($con,$sql);

?>

<!DOCTYPE html>
<html>

<head>
    <title>User Card</title>

    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />

    <!-- custom css -->
    <style>
        .m-r-1em {
            margin-right: 1em;
        }
        
        .m-b-1em {
            margin-bottom: 1em;
        }
        
        .m-l-1em {
            margin-left: 1em;
        }
        
        .mt0 {
            margin-top: 0;
        }
    </style>

</head>

<body>

    <!-- container -->
    <div class="container">
 

        <div class="page-header">
            <h1>Students </h1> 
            <br>

          <?php 
          
          echo 'Welcome , '.$_SESSION['student']['f_name'];


          ?>


        </div>

    <a href="create.php">+ Account</a> 

        <table class='table table-hover table-responsive table-bordered'>
            <!-- creating our table heading -->
            <tr>
            <th>ID</th>
            <th>first Name</th>
            <th>Last name</th>
            <th>Email</th>
            <th>Images</th>
            <th>Address</th>
            <th>Password</th>
            <th>Action</th>    
            </tr>

       <?php 
       
            while($data = mysqli_fetch_assoc( $objData) ){
       ?>
           <tr>
                 <td><?php echo $data['id'];?></td>
                 <td><?php echo $data['f_name'];?></td>
                 <td><?php echo $data['l_name'];?></td>
                 <td><?php echo $data['email'];?></td>
                 <td><img src="upload/<?php echo $data['images']; ?>" alt="" height="50px" width="50px"><?php echo $data['images'];?></td>
                 <td><?php echo $data['addresses'];?></td>
                 <td><?php echo $data['pass'];?></td>
                 <td>
                 <a href='delete.php?id=<?php echo $data['id'];?>' class='btn btn-danger m-r-1em'>Delete</a>
                 <a href='edit.php?id=<?php echo $data['id'];?>' class='btn btn-primary m-r-1em'>Edit</a>           
                </td> 
           </tr> 
    
       <?php } ?>
            <!-- end table -->
        </table>

    </div>
    <!-- end .container -->


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

    <!-- Latest compiled and minified Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- confirm delete record will be here -->

</body>

</html>

