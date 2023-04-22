<?php

@include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>User Apply</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

<section class="placement">

   <h1 class="heading">latest placements</h1>

   <div class="box-container">

      <?php
      $select_placement = mysqli_query($conn, "SELECT * FROM `placement`");
      if(mysqli_num_rows($select_placement) > 0){
         while($fetch_placement= mysqli_fetch_assoc($select_placement)){
      ?>
    <form action="" method="post">
         <div class="box">
            <img src="uploaded_img/<?php echo $fetch_placement['image']; ?>" alt="">
            <h3><?php echo $fetch_placement['name']; ?></h3>
            <h3><?php echo $fetch_placement['role']; ?></h3>
            <div class="package">$<?php echo $fetch_placement['package']; ?>/-</div>
            <input type="hidden" name="placement_name" value="<?php echo $fetch_placement['name']; ?>">
            <input type="hidden" name="placement_role" value="<?php echo $fetch_placement['role']; ?>">
            <input type="hidden" name="placement_package" value="<?php echo $fetch_placement['package']; ?>">
            <input type="hidden" name="placement_image" value="<?php echo $fetch_placement['image']; ?>">
            <input><a type="submit" href="only.php" class="btn" value="apply" name="apply">apply</a>
         </div>
      </form>
      <?php
         };
      };
      ?>

   </div>

</section>

</div>
<script src="js/script.js"></script>

</body>
</html>