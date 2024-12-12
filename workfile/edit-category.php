<?php
$page_ttl = 'Edit Category';
$page_dsc = 'Manage Category Item';
$thmblink = '<div class="ms-md-auto py-2 py-md-0"><a href="index.php" class="btn btn-label-info btn-round me-2">Dashboard</a></div>';
require('header.php');
$user_id = $_GET['id'];
$select_query = "SELECT * FROM categories WHERE id='$user_id'";
$select_user_info = mysqli_query($con, $select_query);
$select_user_info_after_assoc = mysqli_fetch_array($select_user_info);


 ?>
  <body>
    <div class="wrapper">
 
<?php require('sidebar.php') ?> 

      <div class="main-panel">
<?php require('main-header.php') ?>  
        <div class="container">
          <div class="page-inner">
  <?php echo dsb_brd($page_ttl,$page_dsc,$thmblink)?>


			<div class="col-lg-6 m-auto">
          <table class="table table-bordered text-center">
            <form action="" method="POST" enctype="multipart/form-data">
              <div class="login-wrapper wd-500 wd-xs-500 pd-25 pd-xs-50 bg-white">
                  <div class="signin-logo tx-center tx-24 tx-bold tx-inverse">Edit Category</div>
                  <div class="tx-center mg-b-60"> Given Information</div>

			<?php
			echo "<script>Swal_fire('sasasa')</script>";
			if(isset($_POST['category_name'])){
$user_id = $_POST['id'];
$category_name = $_POST['category_name'];
// image uploaded code start
$category_image = ($_FILES['category_image']['name']);
$category_image_after_explode = explode(".", $category_image);
$category_image_after_explode_extention = end($category_image_after_explode);
$category_image_new_name = time() . "-" . rand(111, 999) . "." . $category_image_after_explode_extention;

$category_image_tmp_location = ($_FILES['category_image']['tmp_name']);
$category_image_new_location = "../upload/category-image/" . $category_image_new_name;
move_uploaded_file($category_image_tmp_location, $category_image_new_location);
// image uploaded code End

$update_query = "UPDATE categories SET category_name = '$category_name', category_image = '$category_image_new_name' WHERE id = '$user_id'";
$update_query_from_db = mysqli_query($con, $update_query);

echo alert("Category Edited Successfully!",'success');
			}
			
			
			?>



                  <div class="form-group">
                    <label><h6>Category Name:</h6></label>
                    <input type="hidden" class="form-control" value="<?=$select_user_info_after_assoc['id']?>" name="id">
                    <input type="text" class="form-control" placeholder="product name" value="<?=$select_user_info_after_assoc['category_name']?>" name="category_name" required>
                  </div><!-- form-group -->
                  
                  <div class="form-group">
                    <label><h6>Category Banner Image</h6></label><br>
                    <img class="mb-2" width="80" height="80" src="../upload/category-image/<?=$select_user_info_after_assoc['category_image']?>" alt="img not found">
                    <input type="file" class="form-control" value="" name="category_image" required>
                  </div><!-- form-group -->

                  <div class="text-center mt-5">
                    <button class="btn btn-success" >Save Now</button>
                  </div>
              </div>
            </form>
          </table>
        </div>
            
           </div>
          </div>
        </div>

<?php require('footer.php') ?> 