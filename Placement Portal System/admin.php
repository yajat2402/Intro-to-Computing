<?php

@include 'config.php';

if(isset($_POST['add_placement'])){
   $p_name = $_POST['p_name'];
   $p_role = $_POST['p_role'];
   $p_package = $_POST['p_package'];
   $p_image = $_FILES['p_image']['name'];
   $p_image_tmp_name = $_FILES['p_image']['tmp_name'];
   $p_image_folder = 'uploaded_img/'.$p_image;

   $insert_query = mysqli_query($conn, "INSERT INTO `placement`(name,role, package, image) VALUES('$p_name', '$p_role', '$p_package', '$p_image')") or die('query failed');

   if($insert_query){
      move_uploaded_file($p_image_tmp_name, $p_image_folder);
      $message[] = 'placement add succesfully';
   }else{
      $message[] = 'could not add the placement';
   }
};

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_query = mysqli_query($conn, "DELETE FROM `placement` WHERE id = $delete_id ") or die('query failed');
   if($delete_query){
      header('location:admin.php');
      $message[] = 'placement has been deleted';
   }else{
      header('location:admin.php');
      $message[] = 'placement could not be deleted';
   };
};

if(isset($_POST['update_placement'])){
   $update_p_id = $_POST['update_p_id'];
   $update_p_name = $_POST['update_p_name'];
   $update_p_role = $_POST['update_p_role'];
   $update_p_package = $_POST['update_p_package'];
   $update_p_image = $_FILES['update_p_image']['name'];
   $update_p_image_tmp_name = $_FILES['update_p_image']['tmp_name'];
   $update_p_image_folder = 'uploaded_img/'.$update_p_image;

   $update_query = mysqli_query($conn, "UPDATE `placement` SET name = '$update_p_name', role = '$update_p_role', package = '$update_p_package', image = '$update_p_image' WHERE id = '$update_p_id'");

   if($update_query){
      move_uploaded_file($update_p_image_tmp_name, $update_p_image_folder);
      $message[] = 'placement updated succesfully';
      header('location:admin.php');
   }else{
      $message[] = 'placement could not be updated';
      header('location:admin.php');
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Add Placement</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php

if(isset($message)){
   foreach($message as $message){
      echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
   };
};

?>

<?php include 'header.php'; ?>

<div class="container">

<section>

<form action="" method="post" class="add-placement-form" enctype="multipart/form-data">
   <h3>add a new placement</h3>
   <input type="text" name="p_name" placeholder="enter the placement company name" class="box" required>
   <input type="text" name="p_role" placeholder="enter the job role" class="box" required>
   <input type="number" name="p_package" min="0" placeholder="enter the placement package" class="box" required>
   <input type="file" name="p_image" accept="image/png, image/jpg, image/jpeg" class="box" required>
   <input type="submit" value="add the placement" name="add_placement" class="btn">
</form>

</section>

<section class="display-placement-table">

   <table>

      <thead>
         <th>placement image</th>
         <th>placement name</th>
         <th>placement role</th>
         <th>placement package</th>
         <th>action</th>
      </thead>

      <tbody>
         <?php
         
            $select_placement = mysqli_query($conn, "SELECT * FROM `placement`");
            if(mysqli_num_rows($select_placement) > 0){
               while($row = mysqli_fetch_assoc($select_placement)){
         ?>

         <tr>
            <td><img src="uploaded_img/<?php echo $row['image']; ?>" height="100" alt=""></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['role']; ?></td>
            <td>$<?php echo $row['package']; ?>/-</td>
            <td>
               <a href="admin.php?delete=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('are your sure you want to delete this?');"> <i class="fas fa-trash"></i> delete </a>
               <a href="admin.php?edit=<?php echo $row['id']; ?>" class="option-btn"> <i class="fas fa-edit"></i> update </a>
            </td>
         </tr>

         <?php
            };    
            }else{
               echo "<div class='empty'>no placement added</div>";
            };
         ?>
      </tbody>
   </table>

</section>

<section class="edit-form-container">

   <?php
   
   if(isset($_GET['edit'])){
      $edit_id = $_GET['edit'];
      $edit_query = mysqli_query($conn, "SELECT * FROM `placement` WHERE id = $edit_id");
      if(mysqli_num_rows($edit_query) > 0){
         while($fetch_edit = mysqli_fetch_assoc($edit_query)){
   ?>

   <form action="" method="post" enctype="multipart/form-data">
      <img src="uploaded_img/<?php echo $fetch_edit['image']; ?>" height="200" alt="">
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_edit['id']; ?>">
      <input type="text" class="box" required name="update_p_name" value="<?php echo $fetch_edit['name']; ?>">
      <input type="text" class="box" required name="update_p_role" value="<?php echo $fetch_edit['role']; ?>">
      <input type="number" min="0" class="box" required name="update_p_package" value="<?php echo $fetch_edit['package']; ?>">
      <input type="file" class="box" required name="update_p_image" accept="image/png, image/jpg, image/jpeg">
      <input type="submit" value="update the placement" name="update_placement" class="btn">
      <input type="reset" value="cancel" id="close-edit" class="option-btn">
   </form>

   <?php
            };
         };
         echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";
      };
   ?>

</section>

</div>
<script src="js/script.js"></script>

</body>
</html>