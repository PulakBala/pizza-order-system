<?php
$page_ttl = 'Category';
$page_dsc = 'Manage Category';
$thmblink = '<div class="ms-md-auto py-2 py-md-0"><a href="index.php" class="btn btn-label-info btn-round me-2">Dashboard</a></div>';
require('header.php');

$category_select_query = "SELECT * FROM categories";
$category_select_query_from_db = mysqli_query($con, $category_select_query);

$category_select_query = "SELECT * FROM sub_categories";
$sub_category_select_query_from_db = mysqli_query($con, $category_select_query);

$category_select_query = "SELECT * FROM sub_sub_categories";
$sub_sub_category_select_query_from_db = mysqli_query($con, $category_select_query);

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
              <div class="col-md-4">
                <div class="card card-secondary">
                  <div class="card-body skew-shadow">
                    <h1><?=$category_select_query_from_db->num_rows?></h1>
                    <h5 class="op-8">Total Category</h5>
                    <div class="pull-right">
                      <a style="position: relative;" 
					  class="btn btn-secondary btn-sm" 
					  href="add-category">
					  Add Category</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card card-secondary bg-secondary-gradient">
                  <div class="card-body bubble-shadow">
                    <h1><?=$sub_category_select_query_from_db->num_rows?></h1>
                    <h5 class="op-8">Sub Category</h5>
                    <div class="pull-right">
                      <a style="position: relative;"
					  class="btn btn-secondary btn-sm" 
					  href="add-sub-category">
					  Add Sub Category</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card card-secondary bg-secondary-gradient">
                  <div class="card-body curves-shadow">
                    <h1>0</h1>
                    <h5 class="op-8">Upload List</h5>
                    <div class="pull-right">
                      <a style="position: relative;" class="btn btn-primary btn-sm" 
					  href="add-category">
					  Create New</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

			
            <div class="row">
			<div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Category List</h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12 col-md-12">
                         <table class="table text-centerX table-bordered ">

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
                        <td class="text-right">
                          <a class="btn btn-sm btn-info" href="edit-category?id=<?=$category['id']?>"><i class="fas fa-edit"></i> Edit</a>
                          <button 
onclick="delete_item(<?=$category['id']?>,'remove-category?id=','Are you sure you want to delete <?=$category['category_name'] ?> category?')"
						class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Remove</button>
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
	  
           </div>
		   
		   
           </div>
          </div>
        </div>

<?php require('footer.php') ?> 