<?php
$page_ttl = 'Edit Sub-Category';
$page_dsc = 'Update Info';
$thmblink = '<div class="ms-md-auto py-2 py-md-0"><a href="index.php" class="btn btn-label-info btn-round me-2">Dashboard</a></div>';
require('header.php');




if(ISSET($_POST['id'])){
					$user_id = $_POST['id'];

				$main_category = $_POST['main_category'];
				$category_name = $_POST['sub_category_name'];
				$old__image_name = $_POST['old__image_name'];
				// image uploaded code start
				$category_image = ($_FILES['sub_category_image']['name']);
				$category_image_after_explode = explode(".", $category_image);
				$category_image_after_explode_extention = end($category_image_after_explode);
				$category_image_new_name = time() . "-" . rand(111, 999) . "." . $category_image_after_explode_extention;
				
				
				$update_query = "UPDATE sub_categories SET sub_category_name = '$category_name', category_id = '$main_category' WHERE id = '$user_id'";
				$update_query_from_db = mysqli_query($con, $update_query);
				$sa_nfy = "Sub-Category Edited Successfully!";
				
				
				if($_FILES['sub_category_image']['tmp_name'] AND $_FILES['sub_category_image']['tmp_name'] != ''){
				$category_image_tmp_location = ($_FILES['sub_category_image']['tmp_name']);
				$category_image_new_location = "../upload/category-image/" . $category_image_new_name;
				move_uploaded_file($category_image_tmp_location, $category_image_new_location);
				// image uploaded code End
				 unlink("../upload/category-image/" . $old__image_name);
				$update_query = "UPDATE sub_categories SET  sub_category_image = '$category_image_new_name' WHERE id = '$user_id'";
				$update_query_from_db = mysqli_query($con, $update_query);
				$sa_nfy = "Sub-Category image Edited Successfully!";
				}
				
				}

$user_id = $_GET['id'];
$select_query = "SELECT * FROM sub_categories WHERE id ='$user_id'";
$select_user_info = mysqli_query($con, $select_query);
$dataSub = mysqli_fetch_array($select_user_info);
 ?>
  <body>
    <div class="wrapper">
 
<?php require('sidebar.php') ?> 

      <div class="main-panel">
<?php require('main-header.php') ?>  
        <div class="container">
          <div class="page-inner">
  <?php echo dsb_brd($page_ttl,$page_dsc,$thmblink)?>


			
			
		<div class="card">
                  <div class="card-header">
                    <h4 class="card-title"><?=$dataSub['sub_category_name']?></h4>
                  </div>
                  <div class="card-body">	
				  
				  <div class="sl-mainpanel">

    <div class="col-lg-12 sl-pagebody m-auto">
      <div class="row">
        
        <div class="col-lg-6 m-auto">
          <table class="table table-bordered text-center">
            <form action="" method="POST" enctype="multipart/form-data">
              <div class="login-wrapper wd-500 wd-xs-500 pd-25 pd-xs-50 bg-white">
         
				<?php
				
				?>
		 
		 
				<div class="form-group">
                  <label class="text-dark h6" for="main_category">Select Category</label>
                  <select class="form-control" id="main_category" name="main_category" >
                    <option>-- select category --</option>
                    <?php
                      $select_category = "SELECT * FROM categories";
                      $categories = mysqli_query($con, $select_category);
                      foreach($categories as $category){
						  if($category['id'] == $dataSub['category_id']){$sj = 'Selected';}else{$sj = '';}
                    ?>
                      <option value="<?=$category['id']?>" <?=$sj?>> <?=$category['category_name']?> </option>
                    <?php } ?>

                  </select>
                </div>
		 
                  <div class="form-group">
                    <label><h6>Sub Category Name:</h6></label>
                    <input type="hidden" class="form-control" value="<?=$dataSub['id']?>" name="id">
                    <input type="hidden" class="form-control" value="<?=$dataSub['sub_category_image']?>" name="old__image_name">
                    <input type="text" class="form-control" placeholder="product name" value="<?=$dataSub['sub_category_name']?>" name="sub_category_name" required>
                  </div><!-- form-group -->
                  
                  <div class="form-group">
                    <label><h6>Sub Category Image</h6></label><br>
                    <img class="mb-3" width="80" height="80" src="../upload/category-image/<?=$dataSub['sub_category_image']?>" alt="img not found" required>
                    <input type="file" class="form-control" value="" name="sub_category_image">
                  </div><!-- form-group -->

                  <div class="text-center mt-5">
                    <button type="submit" name="submit" class="btn btn-success" >Save Now</button>
                  </div>
              </div>
            </form>
          </table>
        </div>
      </div>

  </div><!-- sl-pagebody -->
</div>
			</div>
			</div>
			
			
			
            
           </div>
          </div>
        </div>

<?php require('footer.php') ?> 