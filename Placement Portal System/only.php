<?php

@include 'config.php';

if(isset($_POST['add_student'])){
   $s_name = $_POST['s_name'];
   $s_email = $_POST['s_email'];
   $s_mobile = $_POST['s_mobile'];
   $s_college = $_POST['s_college'];
   $insert_query = mysqli_query($conn, "INSERT INTO `student`(name,email, mobile,college) VALUES('$s_name', '$s_email', '$s_mobile','$s_college')") or die('query failed');
   if($insert_query){
      $message[] = 'student apply succesfully';
   }else{
      $message[] = 'could not apply the student';
   }
};

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_query = mysqli_query($conn, "DELETE FROM `student` WHERE id = $delete_id ") or die('query failed');
   if($delete_query){
      header('location:only.php');
      $message[] = 'student application been deleted';
   }else{
      header('location:only.php');
      $message[] = 'student application could not be deleted';
   };
};

if(isset($_POST['update_student'])){
   $update_s_id = $_POST['update_s_id'];
   $update_s_name = $_POST['update_s_name'];
   $update_s_email = $_POST['update_s_email'];
   $update_s_mobile = $_POST['update_s_mobile'];
   $update_s_college = $_POST['update_s_college'];
   $update_query = mysqli_query($conn, "UPDATE `student` SET name = '$update_s_name', email = '$update_s_email', mobile = '$update_s_mobile', college = '$update_s_college',image = '$update_s_image' WHERE id = '$update_s_id'");

   if($update_query){
      move_uploaded_file($update_s_image_tma_name, $update_s_image_folder);
      $message[] = 'student application updated succesfully';
      header('location:only.php');
   }else{
      $message[] = 'student application could not be updated';
      header('location:only.php');
   }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>User Application</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/application.css">
</head>
<body>
   
<?php

if(isset($message)){
   foreach($message as $message){
      echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
   };
};

?>

<?php include 'stud header.php'; ?>

<div class="container">

<section>

<form action="" method="post" class="add-student-form" enctype="multipart/form-data">
   <h3>student application</h3>
   <input type="text" name="s_name" placeholder="enter the name" class="box" required>
   <input type="text" name="s_email" placeholder="enter email" class="box" required>
   <input type="number" name="s_mobile" min="0" placeholder="enter mobile number" class="box" required>
   <input type="text" name="s_college" placeholder="enter college name" class="box" required>
   <input type="submit" value="submit" name="add_student" class="btn">
</form>
<script src="js/application.js"></script>

</body>
</html>