<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<?php
   if(isset($_FILES['image'])!=NULL){
      $errors= array();
      $file_name = $_FILES['image']['name'];
      $file_size =$_FILES['image']['size'];
      $file_tmp =$_FILES['image']['tmp_name'];
      $file_type=$_FILES['image']['type'];
      $array = explode('.', $_FILES['image']['name']);
      $file_ext=@strtolower(end($array));
      $expensions= array("jpeg","jpg","png");
      
      if(in_array($file_ext,$expensions)=== false){
         $errors[]="Don't accept image files with this extension, please choose JPEG or PNG.";
      }
      if($file_size > 2097152){
         $errors[]='File size should be 2MB';
      }

      if(empty($errors)==true){
         move_uploaded_file($file_tmp,"E:\\PTPMMaNguonMo\\htdocs\\img\\".$file_name);
         echo "Upload File successfully!!!";
      }
      else{
         print_r($errors);
      }
   }
?>
<html>
   <body>
      
      <form action="" method="POST" enctype="multipart/form-data">
         <input type="file" name="image" />
         <input type="submit"/>
			
         <ul>
            <li>File name: <?php echo $_FILES['image']['name'];  ?>
            <li>File size   : <?php echo $_FILES['image']['size'];  ?>
            <li>File type    : <?php echo $_FILES['image']['type'] ?>
         </ul>
          <img src="img/<?php echo $_FILES['image']['name'];?>" width="400">
      </form>
      
   </body>
</html>