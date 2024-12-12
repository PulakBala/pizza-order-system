<?php
$page_ttl = 'Add Brand';
$page_dsc = 'at a glance';
$thmblink = '<div class="ms-md-auto py-2 py-md-0"><a href="index.php" class="btn btn-label-info btn-round me-2">Dashboard</a></div>';
require('header.php');


 ?>
  <body>
    <div class="wrapper">
 
<?php require('sidebar.php') ?> 

      <div class="main-panel">
<?php require('main-header.php') ?>  
        <div class="container">
          <div class="page-inner">
  <?php echo dsb_brd($page_ttl,$page_dsc,$thmblink)?>


			<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
<fieldset>

<!-- Form Name -->
<?php

if(isset($_POST['singlebutton'])){

$brand_name = $_POST['brand_name'];
$manufacture = $_POST['manufacture'];


// $filename = $_FILES["p_img"]["name"];
// $imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
// $target_file = ''.date('Ymd').'_'.rand(0000,9999);
// $thumb_image = $target_file.'.'.$imageFileType;	
//$type = basename($_FILES['p_img']["type"]);
//echo $img_name1 = ''.rand(0,99999).''.rand(0,99999).'.'.$type;


//image_thumb($_FILES['p_img']['name'],$_FILES['p_img']['size'],$_FILES['p_img']['type'],$_FILES['p_img']['tmp_name'],$actual_image_name = $thumb_image,$save_path = '../upload/category/thumb/',$imgresize = 'orginal',$imgquality = 100,$watermark ='');
//image_thumb_png($_FILES['p_img']['name'],$_FILES['p_img']['size'],$_FILES['p_img']['type'],$_FILES['p_img']['tmp_name'],$actual_image_name = $thumb_image,$save_path = '../upload/category/orginal/',$imgresize = 'orginal',$imgquality = 1,$watermark ='');
//image_thumb_png($_FILES['p_img']['name'],$_FILES['p_img']['size'],$_FILES['p_img']['type'],$_FILES['p_img']['tmp_name'],$actual_image_name = $thumb_image,$save_path = '../upload/category/thumb/',$imgresize = '200x200',$imgquality = 1,$watermark ='');
$stmt = $np2con->prepare("INSERT INTO `brands` (`b_name`, `b_manufac`)
VALUES(?,?)");
$stmt->bind_param('ss',$brand_name,$manufacture);
if ($stmt->execute()) {
//
echo alert('Successfully Added!');
$sa_nfy = "Brand Added Successfully!";
  
 }	else {
	  echo ntf('Faild!',0);
	 
 }	
 
 
 


	 
 }

?>



<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="product_name">Brand name</label>  
  <div class="col-md-4">
  <input id="category_name" name="brand_name" placeholder="Brand NAME" class="form-control input-md" required="" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="product_name">Brand Company</label>  
  <div class="col-md-4">
  <input id="category_name" name="manufacture" placeholder="Brand manufacture" class="form-control input-md" required="" type="text">
    
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <button id="singlebutton" name="singlebutton" class="btn btn-success">Add</button>
  </div>
  </div>

</fieldset>
</form>
            
           </div>
          </div>
        </div>

<?php require('footer.php') ?> 