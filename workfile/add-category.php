<?php
$page_ttl = 'Add Category';
$page_dsc = 'at a glance';
$thmblink = '<div class="ms-md-auto py-2 py-md-0"><a href="index.php" class="btn btn-label-info btn-round me-2">Dashboard</a></div>';
require('header.php');
$category_select_query = "SELECT * FROM categories";
$category_select_query_from_db = mysqli_query($con, $category_select_query);


 ?>
  <body>
    <div class="wrapper">
 
<?php require('sidebar.php') ?> 

      <div class="main-panel">
<?php require('main-header.php') ?>  
        <div class="container">
          <div class="page-inner">
  <?php echo dsb_brd($page_ttl,$page_dsc,$thmblink)?>



			<div class="sl-mainpanel">

  
    <div class="col-lg-12 sl-pagebody m-auto">

      <div class="row">
	  
	  
	 <div class="col-md-7">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Category List</h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12 col-md-12">
                         <table class="table text-center table-bordered ">

            <?php
              if(isset($_SESSION['category_edited_status'])):
            ?>
              <div class="alert alert-success">
                  <?php
                  echo $_SESSION['category_edited_status']; 
                  unset($_SESSION['category_edited_status']);
                  ?>
              </div>
            <?php endif; ?>
            <thead class="bg-primary">
                <tr>
                    <td>Serial No</td>
                    <td>Category Name</td>
                    <td>Category Image</td>
                    <td>Option</td>
                </tr>
            </thead>
            <tbody>
             
                <?php
                  $serial_no = 1;
                  foreach($category_select_query_from_db as $category){
                    ?>
                      <tr>
                        <td><?= $serial_no++ ?></td>
                        <td><?= $category['category_name'] ?></td>
                        <td><img width="60" height="60" src="../upload/category-image/<?=$category['category_image']?>" alt="img not found"></td>
                        <td text-center>
                          <a class="btn btn-sm btn-info" href="edit-category?id=<?=$category['id']?>"><i class="fas fa-edit"></i> Edit</a>
                          <button 
onclick="delete_item(<?=$category['id']?>,'remove-category?id=','Are you sure you want to delete <?=$category['category_name'] ?> category?')"
						class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Delete</button>
                        </td>
                      </tr>
                      
                   
						
                        <!-- before delete sweetalert code End -->
                    
                    <?php
                  }
                ?>

            </tbody>
          </table>
        
                      </div>
                    
					
					</div>
                  </div>
                </div>
              </div> 
	  
	  <div class="col-md-5">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Add Category</h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12 col-md-12">
                           <table class="table table-bordered text-center">

            <form action="" method="POST" enctype="multipart/form-data">
              <div class="login-wrapper wd-430 wd-xs-430 pd-25 pd-xs-50 bg-white">
               
                  <?php
				  
				  
				  
                    if(isset($_POST['category_name'])){
					$category_name = $_POST['category_name'];
$category_description = $_POST['category_description'];


// image uploaded code start
$category_image = ($_FILES['category_image']['name']);
$category_image_after_explode = explode(".", $category_image);
$category_image_after_explode_extention = end($category_image_after_explode);
$category_image_new_name = time() . "-" . rand(111, 999) . "." . $category_image_after_explode_extention;

$category_image_tmp_location = ($_FILES['category_image']['tmp_name']);
$category_image_new_location = "../upload/category-image/" . $category_image_new_name;
move_uploaded_file($category_image_tmp_location, $category_image_new_location);
// image uploaded code End 

$insert_query = "INSERT INTO categories (category_name, category_image, category_description) VALUES ('$category_name', '$category_image_new_name', '$category_description')";
$insert_query_from_db = mysqli_query($con, $insert_query);

echo alert("Category Added Successfully!",'success');
$sa_nfy = "Category Added Successfully!";
					}			
					?>

                  <div class="form-group">
                    <label><h6>Category Name:</h6></label>
                    <input type="text" class="form-control" placeholder="Category name" value="" name="category_name" required>
                  </div><!-- form-group -->
                  
                  <div class="form-group">
                    <label><h6>Category Banner Image</h6></label>
                    <input type="file" class="form-control" name="category_image" required>
                  </div><!-- form-group -->
                  
                  <div class="form-group">
                    <label><h6>Category Description:</h6></label>
                    <textarea type="text" rows="4" class="form-control" placeholder="Category description" name="category_description" required></textarea>
                  </div><!-- form-group -->

                  <div class="form-group mt-2">
                    <button class="btn btn-success" ><i class="far fa-paper-plane"></i> Save Category</button>
                  </div>
              </div>
            </form>

          </table>
        
                      </div>
                    
					
					</div>
                  </div>
                </div>
              </div> 

      </div>

  </div><!-- sl-pagebody -->
</div>
            
           </div>
          </div>
        </div>

<?php require('footer.php') ?> 