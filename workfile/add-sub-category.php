<?php
$page_ttl = 'Sub Category';
$page_dsc = 'Add a Sub Category';
$thmblink = '<div class="ms-md-auto py-2 py-md-0"><a href="index.php" class="btn btn-label-info btn-round me-2">Dashboard</a></div>';
require('header.php');



if(isset($_POST['parent_category'])){
$sub_category_parent = $_POST['parent_category'];
$sub_category_description = $_POST['sub_category_description'];


// This two line code for send database main category id 
$main_category_id_selecet_query = "SELECT id FROM categories WHERE category_name = '$sub_category_parent'";
$main_category_id_from_db = mysqli_fetch_array(mysqli_query($con, $main_category_id_selecet_query))['id'];

$sub_category_name = $_POST['sub_category_name'];
// image uploaded code start
$sub_category_image = ($_FILES['sub_category_image']['name']);

$sub_category_image_after_explode = explode(".", $sub_category_image);
$sub_category_image_after_explode_extention = end($sub_category_image_after_explode);
$sub_category_image_new_name = time() . "-" . rand(111, 999) . "." . $sub_category_image_after_explode_extention;

$sub_category_image_tmp_location = ($_FILES['sub_category_image']['tmp_name']);
$sub_category_image_new_location = "../upload/category-image/" . $sub_category_image_new_name;
move_uploaded_file($sub_category_image_tmp_location, $sub_category_image_new_location);
// image uploaded code End

$insert_query = "INSERT INTO sub_categories(category_id, sub_category_name, sub_category_image, sub_category_description) VALUES ('$main_category_id_from_db', '$sub_category_name', '$sub_category_image_new_name', '$sub_category_description')";
$insert_query_from_db = mysqli_query($con, $insert_query);

echo alert("Sub Category Added Successfully!",'success');
$sa_nfy = "Sub Category Added Successfully!";
//header('location: add-sub-category.php');	
	
}

?>
  <body>
    <div class="wrapper">
 
<?php require('sidebar.php') ?> 

      <div class="main-panel">
<?php require('main-header.php') ?>  
        <div class="container">
          <div class="page-inner">
  <?php echo dsb_brd($page_ttl,$page_dsc,$thmblink)?>


	<div class="row">
			  
	  <div class="col-md-8">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Sub Category List</h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12 col-md-12">
                         
						  <table class="table text-centerX table-head-bg-success">
            <?php
              
if(isset($_GET['id']) AND $_GET['id'] != ''){
$sub_category_id = $_GET['id'];

$select_query = "SELECT sub_category_image,sub_category_name FROM sub_categories  WHERE id = '$sub_category_id'";
$c_info = mysqli_fetch_assoc(mysqli_query($con, $select_query));
$sd = mysqli_num_rows(mysqli_query($con, $select_query));
if($sd > 0){
delete_file('../upload/category-image/'.$c_info ['sub_category_image']);

$delete_query = "DELETE FROM sub_categories WHERE id = '$sub_category_id'";
$delet_category = mysqli_query($con, $delete_query);
$sa_nfy =  "Sub Category ".$c_info ['sub_category_name']." Deleted.";	
}
	



}

$select_query = "SELECT * FROM sub_categories";
$sub_category_select_from_db = mysqli_query($con, $select_query);
			  
			  ?>
            <thead >
                <tr>
                    <td>Serial No</td>
                    <td>Parent Category Name</td>
                    <td>Sub Category Name</td>
                    <td>Sub Category Image</td>
                    <td>Created at</td>
                    <td>Option</td>
                </tr>
            </thead>
            <tbody>

                <?php
                  $serial_no = 1;
                  foreach($sub_category_select_from_db as $sub_category){
                    ?>
                      <tr>
                      <td><?= $serial_no++ ?></td>
                        <td>
                          <?php
                            $category_id = $sub_category['category_id'];
                            $select_query = "SELECT category_name FROM categories WHERE id = '$category_id'";
                            $category_name = mysqli_fetch_array(mysqli_query($con, $select_query));
                            echo $category_name['category_name'];
                          ?>
                        </td>
                        <td><?=$sub_category['sub_category_name']?></td>
                        <td><img width="60" height="60" src="../upload/category-image/<?=$sub_category['sub_category_image']?>" alt="img not found"></td>
                        <td><?= $sub_category['created_at'] ?></td>
                        <td text-center>
                          <a class="btn btn-sm btn-info mt-2" href="edit-sub-category.php?id=<?=$sub_category['id']?>"><i class="fas fa-edit"></i> Edit</a>
                          <button id="subcategory_delete" 
					onclick="delete_item(<?=$sub_category['id']?>,'add-sub-category?id=','Are you sure you want to delete <?=$sub_category['sub_category_name'] ?> category?')"	  
						  class="btn btn-sm btn-danger mt-2"><i class="fas fa-trash-alt"></i> Remove</button>
                        </td>
                      </tr>
                      
                                           
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
			  
			  
      
	  <div class="col-md-4">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Add Category</h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12 col-md-12">
                          <table class="table table-bordered text-center">
          <form action="" method="POST" enctype="multipart/form-data">
            <div class="login-wrapper wd-430 wd-xs-430 pd-xs-30 bg-white m-auto">






      

                <div class="form-group">
                  <div class="row">
                    <div class="col-sm-12">
                      <label for="inputState"><h6>Select Main Category</h6></label>
                      <select id="inputState" class="form-control" name="parent_category">
                        <option class="selected">-- Select Category- -</option>
                        <?php
                          $category_select_query = "SELECT * FROM categories";
                          $category_select_query_from_db = mysqli_query($con, $category_select_query);

                          $category_count = mysqli_num_rows($category_select_query_from_db);

                          if($category_count>0){
                              foreach($category_select_query_from_db as $category){
                              echo '<option>'.$category['category_name'].'</option>';
                              } 
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>      

                <div class="form-group">
                  <label><h6>Sub-category Name:</h6></label>
                  <input type="text" class="form-control" placeholder="sub-category name" value="" name="sub_category_name" required>
                </div><!-- form-group -->
                
                <div class="form-group">
                  <label><h6>Sub-category Image</h6></label>
                  <input type="file" class="form-control" name="sub_category_image" required>
                </div><!-- form-group -->
                
                <div class="form-group">
                    <label><h6>Sub-category Description:</h6></label>
                    <textarea type="text" rows="4" class="form-control" placeholder="Sub-category description" name="sub_category_description" required></textarea>
                  </div><!-- form-group -->

                <div class="form-group mt-2">
                  <button type="submit" name="submit" class="btn btn-success"><i class="far fa-paper-plane"></i> Save Category</button>
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
  
            
           </div>
          </div>
        </div>

<?php require('footer.php') ?> 