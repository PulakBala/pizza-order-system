<?php
$page_ttl = 'Edit Product';
$page_dsc = 'Update Product Information';
$thmblink = '<div class="ms-md-auto py-2 py-md-0"><a href="index.php" class="btn btn-label-info btn-round me-2">Dashboard</a></div>';
require('header.php');
$single_product_id = $_GET['id'];


 ?>
  <body>
    <div class="wrapper">
 
<?php require('sidebar.php') ?> 

      <div class="main-panel">
<?php require('main-header.php') ?>  
        <div class="container">
          <div class="page-inner">
  <?php echo dsb_brd($page_ttl,$page_dsc,$thmblink)?>

    
	   


<div class="col-md-12" >
                <div class="card">
                  <div class="card-header" >
                    <h4 class="card-title">Product Information</h4>
                  </div>
                  <div class="card-body">
      <form action="" method="POST" enctype="multipart/form-data">
  			
			<?php
			
	if(isset($_POST['product_id'])){
	$product_id = $_POST['product_id'];
    $main_category_name = $_POST['category_name'];
    $product_status = $_POST['product_status'];
    //$select_query = "SELECT id FROM categories WHERE category_name = '$main_category_name'";
    //$category_id = mysqli_fetch_array(mysqli_query($con, $select_query))['id'];
    $category_id = $main_category_name;

	
	if($_FILES['product_thumbnail_image']['name']){
	// Thumbnail image uploaded start
    $product_image = ($_FILES['product_thumbnail_image']['name']);
    $product_image_after_explode = explode(".",$product_image);
    $product_image_after_explode_extention = end($product_image_after_explode);
    $product_thumbnail_image = time() . "-" . rand(111,999) . "." . $product_image_after_explode_extention;

    //$product_image_tmp_location = ($_FILES['product_thumbnail_image']['tmp_name']);
    $product_image_new_location = "../upload/product-image/" . $product_thumbnail_image;
    //move_uploaded_file($product_image_tmp_location,$product_image_new_location);
	$imgN = 'product_thumbnail_image';
	if(isset($_FILES[$imgN]) && isset($_FILES[$imgN]['name'])){$filename = $_FILES[$imgN]["name"];if($filename !=''){$imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
	$target_file = ''.date('Ymd').'_'.rand(0000,9999);$thumb_image = $target_file.'.'.$imageFileType;									 
	image_thumb($_FILES[$imgN]['name'],$_FILES[$imgN]['size'],$_FILES[$imgN]['type'],
	$_FILES[$imgN]['tmp_name'],$product_thumbnail_image,'../upload/product-image/',$imgresize = '268x262',$imgquality = 97,$watermark ='');
	}}
	// old image deleted code
        $old_thumbnail_image_query = "SELECT product_thumbnail_image FROM products WHERE id = '$product_id'";
        $old_thumbnail_image_name = mysqli_fetch_array(mysqli_query($con, $old_thumbnail_image_query))['product_thumbnail_image'];
        unlink("../upload/product-image/" . $old_thumbnail_image_name);
	// Thumbnail image uploaded code End
    $product_update_query = "UPDATE products SET product_thumbnail_image = '$product_thumbnail_image' WHERE id = '$product_id'";
    $product_insert_result = mysqli_query($con, $product_update_query);
    // Thumbnail image uploaded code End
	echo alert("Thumbnail image updated!");
	}
	


	if($_FILES['product_featured_image']['name']){
	// Thumbnail image uploaded start
    $product_image = ($_FILES['product_featured_image']['name']);
    $product_image_after_explode = explode(".",$product_image);
    $product_image_after_explode_extention = end($product_image_after_explode);
    $product_featured_image = time() . "-" . rand(111,999) . "." . $product_image_after_explode_extention;

    //$product_image_tmp_location = ($_FILES['product_featured_image']['tmp_name']);
    $product_image_new_location = "../upload/product-image/" . $product_featured_image;
    //move_uploaded_file($product_image_tmp_location,$product_image_new_location);
	$imgN = 'product_featured_image';
	if(isset($_FILES[$imgN]) && isset($_FILES[$imgN]['name'])){$filename = $_FILES[$imgN]["name"];if($filename !=''){$imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
	$target_file = ''.date('Ymd').'_'.rand(0000,9999);$thumb_image = $target_file.'.'.$imageFileType;									 
	image_thumb($_FILES[$imgN]['name'],$_FILES[$imgN]['size'],$_FILES[$imgN]['type'],
	$_FILES[$imgN]['tmp_name'],$product_featured_image,'../upload/product-image/',$imgresize = '800x800',$imgquality = 97,$watermark ='');
	}}
	// old image deleted code
        $old_thumbnail_image_query = "SELECT product_featured_image FROM products WHERE id = '$product_id'";
        $old_thumbnail_image_name = mysqli_fetch_array(mysqli_query($con, $old_thumbnail_image_query))['product_featured_image'];
        unlink("../upload/product-image/" . $old_thumbnail_image_name);
	// Thumbnail image uploaded code End
    $product_update_query = "UPDATE products SET product_featured_image = '$product_featured_image' WHERE id = '$product_id'";
    $product_insert_result = mysqli_query($con, $product_update_query);
    // Thumbnail image uploaded code End
	echo alert("Featured image one updated!");
	}
    
	if($_FILES['product_featured_image_two']['name']){
	// Thumbnail image uploaded start
    $product_image = ($_FILES['product_featured_image_two']['name']);
    $product_image_after_explode = explode(".",$product_image);
    $product_image_after_explode_extention = end($product_image_after_explode);
    $product_featured_image_two = time() . "-" . rand(111,999) . "." . $product_image_after_explode_extention;

    //$product_image_tmp_location = ($_FILES['product_featured_image_two']['tmp_name']);
    $product_image_new_location = "../upload/product-image/" . $product_featured_image_two;
    //move_uploaded_file($product_image_tmp_location,$product_image_new_location);
	$imgN = 'product_featured_image_two';
	if(isset($_FILES[$imgN]) && isset($_FILES[$imgN]['name'])){$filename = $_FILES[$imgN]["name"];if($filename !=''){$imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
	$target_file = ''.date('Ymd').'_'.rand(0000,9999);$thumb_image = $target_file.'.'.$imageFileType;									 
	image_thumb($_FILES[$imgN]['name'],$_FILES[$imgN]['size'],$_FILES[$imgN]['type'],
	$_FILES[$imgN]['tmp_name'],$product_featured_image_two,'../upload/product-image/',$imgresize = '800x800',$imgquality = 97,$watermark ='');
	}}
	// old image deleted code
        $old_thumbnail_image_query = "SELECT product_featured_image_two FROM products WHERE id = '$product_id'";
        $old_thumbnail_image_name = mysqli_fetch_array(mysqli_query($con, $old_thumbnail_image_query))['product_featured_image_two'];
        unlink("../upload/product-image/" . $old_thumbnail_image_name);
	// Thumbnail image uploaded code End
    $product_update_query = "UPDATE products SET product_featured_image_two = '$product_featured_image_two' WHERE id = '$product_id'";
    $product_insert_result = mysqli_query($con, $product_update_query);
    // Thumbnail image uploaded code End
	echo alert("Featured image two updated!");
	}
	
	if($_FILES['product_featured_image_three']['name']){
	// Thumbnail image uploaded start
    $product_image = ($_FILES['product_featured_image_three']['name']);
    $product_image_after_explode = explode(".",$product_image);
    $product_image_after_explode_extention = end($product_image_after_explode);
    $product_featured_image_three = time() . "-" . rand(111,999) . "." . $product_image_after_explode_extention;

    //$product_image_tmp_location = ($_FILES['product_featured_image_three']['tmp_name']);
    $product_image_new_location = "../upload/product-image/" . $product_featured_image_three;
    //move_uploaded_file($product_image_tmp_location,$product_image_new_location);
	$imgN = 'product_featured_image_three';
	if(isset($_FILES[$imgN]) && isset($_FILES[$imgN]['name'])){$filename = $_FILES[$imgN]["name"];if($filename !=''){$imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
	$target_file = ''.date('Ymd').'_'.rand(0000,9999);$thumb_image = $target_file.'.'.$imageFileType;									 
	image_thumb($_FILES[$imgN]['name'],$_FILES[$imgN]['size'],$_FILES[$imgN]['type'],
	$_FILES[$imgN]['tmp_name'],$product_featured_image_three,'../upload/product-image/',$imgresize = '800x800',$imgquality = 97,$watermark ='');
	}}
	// old image deleted code
        $old_thumbnail_image_query = "SELECT product_featured_image_three FROM products WHERE id = '$product_id'";
        $old_thumbnail_image_name = mysqli_fetch_array(mysqli_query($con, $old_thumbnail_image_query))['product_featured_image_three'];
        unlink("../upload/product-image/" . $old_thumbnail_image_name);
	// Thumbnail image uploaded code End
    $product_update_query = "UPDATE products SET product_featured_image_three = '$product_featured_image_three' WHERE id = '$product_id'";
    $product_insert_result = mysqli_query($con, $product_update_query);
    // Thumbnail image uploaded code End
	echo alert("Featured image three updated!");
	}
    $sub_category_id = $_POST['sub_category_name'];
    // $sub_sub_category_name = $_POST['sub_sub_category_name'];
    $product_title = $_POST['product_name'];
   // $product_short_description = $_POST['product_short_description'];
    //$product_long_description = $_POST['product_long_description'];
    
    $product_short_description = htmlentities($_POST['product_short_description'], ENT_QUOTES, "UTF-8", false);
    $product_long_description = htmlentities($_POST['product_long_description'], ENT_QUOTES, "UTF-8", false);
    
    $regular_price = $_POST['product_regular_price'];
    $meta_title = $_POST['product_meta_title'];
    $meta_description = $_POST['product_meta_description'];
    $video_link = $_POST['product_video_link'];
    $product_stock = $_POST['product_stock'];
    $product_brand = $_POST['product_brand'];
    $sale_price = $_POST['product_sale_price'];
    $purchase_price = $_POST['product_purchase_price'];
    $product_code = "STY" . time() . "LI" . rand(111, 999) . "SH";
    $product_tag = $_POST['product_tag'];
    $product_unit = $_POST['product_unit'];
    $product_unit_typ = $_POST['product_unit_typ'];

	$KeyWords = $_POST['KeyWords'];
    $SearchTerms = $_POST['SearchTerms'];
    $Self = $_POST['Self'];
    $Refer = $_POST['Refer'];
    $Donate = $_POST['Donate'];
    $Platform = $_POST['Platform'];
    $bar_code = $_POST['bar_code'];
	
	$product_pre_ordr = 0;
	if(isset($_POST['product_pre_ordr'])){$product_pre_ordr = 1;}

    //$product_update_query = "UPDATE products SET category_id = '$category_id', sub_category_id = '', product_name = '$product_title', product_short_description = '$product_short_description', product_long_description = '$product_long_description', product_tag = '$product_tag', product_meta_title = '$meta_title', product_meta_description = '$meta_description', product_video_link = '$video_link', product_regular_price = '$regular_price', product_sale_price = '$sale_price', product_stock = '$product_stock', product_code = '$product_code', product_brand = '$product_brand' WHERE id = '$product_id'";
    $product_update_query = "UPDATE products SET category_id = '$category_id',sub_category_id = '$sub_category_id', product_name = '$product_title',product_short_description = '$product_short_description',product_long_description = '$product_long_description',product_tag = '$product_tag', product_meta_title = '$meta_title',product_meta_description = '$meta_description',product_video_link = '$video_link', product_regular_price = '$regular_price',product_purchase_price = '$purchase_price', product_sale_price = '$sale_price',product_unit = '$product_unit',product_unit_typ = '$product_unit_typ', 
	product_stock = '$product_stock', product_brand = '$product_brand',
	product_inc_self = '$Self', product_inc_ref = '$Refer',  product_inc_dont = '$Donate',  
	product_inc_pltfrm = '$Platform', product_keywords = '$KeyWords', product_src_trm = '$SearchTerms', product_pre_ordr = '$product_pre_ordr', bar_code = '$bar_code',product_status = '$product_status'
	WHERE id = '$product_id'";
    //$product_insert_result = mysqli_query($con, $product_update_query);
    
     if(mysqli_query($con,$product_update_query)){
    echo alert("This Product Information updated!");
    //echo  reloader('edit_product?id='.$product_id.'',0);
    }else {
    echo "Upload Faild!";  
    }
    
    echo("Error description: " . $con -> error);

			}
			
$select_query = "SELECT * FROM products WHERE id = '$single_product_id'";
$pdata = mysqli_fetch_array(mysqli_query($con, $select_query));
			
			?>


   <!-- This is Editor code for discription   -->
                <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
                <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
                <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>


          <div class="row">
            <div class="col-sm-6 mt-2">

              <div class="form-group">
                <label class="text-dark h6" for="main_category">Select Category</label>
                <select onchange="get_category('main_category','0','sub_category')" class="form-control" id="main_category" name="category_name">
               
                  <?php
                    $select_category = "SELECT * FROM categories";
                    $categories = mysqli_query($con, $select_category);

                    foreach($categories as $category){
					if($pdata['category_id'] == $category['id']){$McCat = 'selected';}else{$McCat = '';}
                  ?>
                    <option value="<?=$category['id']?>" <?=$McCat?>> <?=$category['category_name']?> </option>
                  <?php } ?>

                </select>
              </div>
              
              <div class="form-group" id="sub_category" class="form-group">
				
				<?php
				
$getCcategory_id = $pdata['category_id'];
$select_query = "SELECT id, sub_category_name FROM sub_categories WHERE category_id = '$getCcategory_id'";
$sub_category = mysqli_query($con, $select_query);

echo '<label class="text-secondary h6" for="exampleInputEmail1">Select Sub Category : </label><br>
<select class="form-control" name="sub_category_name" required>';
echo '<option value="">-- Select Sub-Category --</option>';
foreach($sub_category as $rowSd){
	if($rowSd['id'] == $pdata['sub_category_id']){$McCat = 'selected';}else{$McCat = '';}
	echo '<option value="'. $rowSd['id'].'" '.$McCat.'>'.$rowSd['sub_category_name'].'</option>';
}
echo '</select>';
				
				?>
				
				
              </div>

               <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript"></script>-->
              <script type="text/javascript">

                function get_category(em1,em2,rtn){
                var element = document.getElementById(em1).value;
                document.getElementById(rtn).innerHTML = '<center><img src="img/loader.gif" alt="Uploading...."/></center>';
                if(em1.length==0){return;}if(window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
                else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}xmlhttp.onreadystatechange=function()
                {if(xmlhttp.readyState==4&&xmlhttp.status==200)
                {document.getElementById(rtn).innerHTML=xmlhttp.responseText;}}
                xmlhttp.open("GET","get-category.php?cid="+element+"&cmd="+em2,true);
                xmlhttp.send();}
            
              </script>
              <br>
              <!-- This is Editor code for discription   -->

        

              <div class="form-group">
                <label class="text-dark h6">Product Title</label>
                <input type="hidden" class="form-control" value="<?=$pdata['id']?>" name="product_id">
                <input type="text" class="form-control" placeholder="Enter Product Title" value="<?=$pdata['product_name']?>" name="product_name" required>
              </div><!-- form-group -->
              <br>

              <div class="form-group m-auto"> 
                <option class="text-dark h6">Short Description</option>
                <textarea id="product_short_description" rows="4" name="product_short_description" cols="58" class="mytextarea"><?=$pdata['product_short_description']?> </textarea>
              </div>
              
                 <script>
                     $('#product_short_description').summernote({
                       placeholder: 'description',
                       tabsize: 2,
                       height: 200
                     });
                  </script>
              
              
              
                <br>

              <div class="form-group m-auto"> 
                <option class="text-dark h6">Long Description</option>
              
                <textarea rows="5" id="product_long_description" name="product_long_description" cols="58" class="mytextarea"><?=$pdata['product_long_description']?> </textarea>

              </div>
              
              <script>
                     $('#product_long_description').summernote({
                       placeholder: 'description',
                       tabsize: 2,
                       height: 200
                     });
                  </script>
              
                <br>

                
      
                <div class="form-group">
                <label class="text-dark h6"><h6>Reguler Price</h6></label>
                <input type="text" class="form-control" placeholder="regular price TK" value="<?=$pdata['product_regular_price']?>"  name="product_regular_price" required>
                </div>
                
                
                    <div class="form-group">
                <label class="text-dark h6 mt-4"><h6>Sale price </h6></label>
                <input onclick="calc_pr();" onchange="calc_pr();" type="text" class="form-control" placeholder="Product_sale_price" value="<?=$pdata['product_sale_price']?>" name="product_sale_price" id="product_sale_price" required>
              </div>
              
              
                  <div class="form-group">
                <label class="text-dark h6 mt-4"><h6>Purchase price <span class="sa_ratio" id="sa_ratio" >Profit Ratio - 0%</span>
                  <span class="sa_ratio" style="background: #3F51B5;" id="sa_net_ratio">Net Ratio - 0%</span></h6></label>
                <input onclick="calc_pr();" onchange="calc_pr();" type="text" class="form-control" placeholder="Purchase price" value="<?=$pdata['product_purchase_price']?>" name="product_purchase_price"  id="product_purchase_price" required>
              </div>
                
            
            
            <?php $p_un_typ = $pdata['product_unit_typ']?>
             <div class="form-group">
                 <label class="text-dark h6 mt-4"><h6>Product Unit </h6></label>
              <div class="input-group p-0">
              <span class="input-group-text">Unit</span>
              <input type="number"  name="product_unit" value="<?=$pdata['product_unit']?>" aria-label="Unit" class="form-control" required>
              <select  name="product_unit_typ" class="form-control" required>
                  <option value="">Select</option>
                  <option value="kg" <?=$p_un_typ == 'kg' ? ' selected="selected"' : '';?>>kg</option>
                  <option value="gm" <?=$p_un_typ == 'gm' ? ' selected="selected"' : '';?>>gm</option>
                  <option value="liter" <?=$p_un_typ == 'liter' ? ' selected="selected"' : '';?>>liter</option>
                  <option value="pcs" <?=$p_un_typ == 'pcs' ? ' selected="selected"' : '';?>>pcs</option>
                  <option value="ml" <?=$p_un_typ == 'ml' ? ' selected="selected"' : '';?>>ml</option>
              </select>
            </div>
            </div>
			<br>

				<div class="form-group" > 
               <label class="text-dark h6 mt-4"><h6>Incentive </h6></label>
              <div class="input-group p-0">
                  
              <span class="input-group-text">Self</span>
              <input onclick="calc_pr();" onchange="calc_pr();" type="number" name="Self" id="Self" value="<?=$pdata['product_inc_self']?>" aria-label="Self" class="form-control" required>
              
			   <span class="input-group-text">Refer</span>
              <input onclick="calc_pr();" onchange="calc_pr();" type="number"  name="Refer" id="Refer" value="<?=$pdata['product_inc_ref']?>" aria-label="Refer" class="form-control" required>
              
			   <span class="input-group-text">Donate</span>
              <input onclick="calc_pr();" onchange="calc_pr();" type="number"  name="Donate" id="Donate" value="<?=$pdata['product_inc_dont']?>" aria-label="Donate" class="form-control" required>
              
			   <span class="input-group-text">Platform</span>
              <input onclick="calc_pr();" onchange="calc_pr();" type="number"  name="Platform" id="Platform" value="<?=$pdata['product_inc_pltfrm']?>" aria-label="Platform" class="form-control" required>
             
			  
            </div>
            </div>
             
            <br>
            
			 <div class="form-group">
                  <label class="text-dark h6 mt-4"><h6>Barcode Ebazar ID</h6></label>
                  <img src="https://bwipjs-api.metafloor.com/?bcid=code128&text=<?=$pdata['id']?>&scale=2&height=6" alt="Barcode for <?php echo $product_id; ?>">
                </div>
                
                
                <div class="form-group">
                <label class="text-dark h6 mt-4"><h6>Product Barcode</h6></label>
                <input type="text" class="form-control" placeholder="Product bar code" value="<?=$pdata['bar_code']?>" name="bar_code" >
              </div><!-- form-group -->
                
				
              <div class="form-group">
                <label class="text-dark h6 mt-4"><h6>Product Brand</h6></label>
                <input type="text" list="browsBr" class="form-control" placeholder="Product brand name" value="<?=$pdata['product_brand']?>" name="product_brand" required>
              </div><!-- form-group -->
<datalist id="browsBr">
<?php
                      $select_br= "SELECT * FROM brands";
                      $brands = mysqli_query($con, $select_br);
                      foreach($brands as $brand){
                    ?>
                      <option value="<?=$brand['b_name']?>"> <?=$brand['b_name']?> </option>
                    <?php } ?>


</datalist>
          

              <div class="form-group">
                  <label class="text-dark h6 mt-4"><h6>Product Tag</h6></label>
                  <input type="text" class="form-control" placeholder="Product tag" value="<?=$pdata['product_tag']?>" name="product_tag" required>
                </div>
				
				
				
			<div class="form-group">
                  <label class="text-dark h6">Key Words </label>
				  <textarea rows="2" class="form-control" name="KeyWords" cols="58"><?=$pdata['product_keywords']?></textarea>
                </div><br>
				
				
				 <div class="form-group">
                  <label class="text-dark h6">Search Terms </label>
				  <textarea rows="2" class="form-control" name="SearchTerms" cols="58"><?=$pdata['product_src_trm']?></textarea>
                </div><br>	
				
			
            </div>    

            <div class="col-sm-6 mt-2">
              <div class="form-group">
                <label class="text-dark h6">Meta Title</label>
                <input type="text" class="form-control " placeholder="write a meta title" value="<?=$pdata['product_meta_title']?>" name="product_meta_title" required>
              </div><!-- form-group -->

              <div class="form-group m-auto">
                <label class="text-dark h6 mt-4">Meta Desciption</label>
                <textarea id="product_meta_description" rows="4" name="product_meta_description" cols="58"><?=$pdata['product_meta_description']?> </textarea>
              </div><!-- form-group -->
                      
                  
           <script>
                     $('#product_meta_description').summernote({
                       placeholder: 'description',
                       tabsize: 2,
                       height: 200
                     });
                  </script>
                  
                  
                  
              <div class="form-group ">
                <label class="text-dark h6 mt-4" >Video Link</label><br>

                <input type="video/mp4" class="form-control" name="product_video_link" value="<?=$pdata['product_video_link']?>" placeholder="Video link http//:">
                <!-- <iframe class="mt-2" width="434" height="230" src="https://www.youtube.com/embed/gyGsPlt06bo" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->

              </div><!-- form-group -->

              <div class="form-group">
                <label class="text-dark h6 mt-4"><h6>Product Stock</h6></label>
                <input type="text" class="form-control" placeholder="Enter product stock Amount" value="<?=$pdata['product_stock']?>" name="product_stock" required>
              </div><!-- form-group -->


                <div class="form-group" > 
               <label class="text-dark h6 mt-4"><h6>Product Status </h6></label>
              <div class="input-group p-0">
              <select  name="product_status" class="form-control" required>
                  <option value="">Select</option>
                  <option value="1" <?php if($pdata['product_status'] == 1){echo 'selected';} ?>>Show</option>
                  <option value="0" <?php if($pdata['product_status'] == 0){echo 'selected';} ?>>Hide</option>
              </select>
            </div>
            </div><br>


                <div class="form-check">
              <input class="form-check-input" name="product_pre_ordr" <?php if($pdata['product_pre_ordr'] == 0){}else {echo 'checked';}?> type="checkbox" value="" id="product_pre_ordr">
              <label class="form-check-label" for="product_pre_ordr">
                Accept pre order
              </label>
            </div>
                
                
              <!-- <div class="form-group">
                <label class="text-dark h6 mt-4"><h6>New product Code</h6></label>
                <input type="text" class="form-control" placeholder="Enter Brand" name="product_code" required>
              </div> -->

<div class="form-group">
                  <label class="text-dark h6" ><h6>Add Thumbnail Image</h6></label>
                  <br>
					
					      <!-- When select image than show this image Code start -->
                  <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
                  <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>

				   <script>
                     function setFeaturedImage(input,trgt) {
                      if (input.files && input.files[0]) {
                          var reader = new FileReader();

                          reader.onload = function (e) {
                              $('#'+trgt)
                                .attr('src', e.target.result)
                                .width(110)
                                .height(120);
                          };
                          reader.readAsDataURL(input.files[0]);
                      }
                    }
                  </script>
					
                  <style>
                    article, aside, figure, footer, header, hgroup, 
                    menu, nav, section { display: block; }
                  </style>
                  
                  <?php if (file_exists('../upload/product-image/'.$pdata['product_thumbnail_image'])) { ?>
                    <img width="107px" height="122px" src="../upload/product-image/<?=$pdata['product_thumbnail_image']?>" alt="current image">
                    <?php } else { ?>
                    <img id="product_featured_image_two" class="img-sm mt-2 mb-2 ml-2" style="height:124px !important; border:1px solid #ddd;padding:2px; border-radius:2px 
					!important;" src="https://img.icons8.com/cotton/64/upload--v1.png" alt="your image" />
                    <?php } ?>
					
                    <img id="product_thumbnail_image" class="img-sm mt-2 mb-2 ml-2" style="height:124px !important; border:1px solid #ddd;padding:2px; border-radius:2px !important;" src="https://img.icons8.com/cotton/64/upload--v1.png" alt="your image" /><br>
                    <input class="form-control" type='file' onchange="setFeaturedImage(this,'product_thumbnail_image'); " name="product_thumbnail_image" />

 
				
				  
                  <!-- When select image than show this image Code End -->
                </div><!-- form-group -->
                <br>

			
              <div class="form-group">
                  <label class="text-dark h6" ><h6>Add Featured Image</h6></label>
                  <br>
              
                  <style>
                    article, aside, figure, footer, header, hgroup, 
                    menu, nav, section { display: block; }
                  </style>
                    <img width="107px" height="122px" src="../upload/product-image/<?=$pdata['product_featured_image']?>" alt="current image">
                    <img id="product_featured_image" class="img-sm mt-2 mb-2 ml-2" style="height:124px !important; border:1px solid #ddd;padding:2px;
					border-radius:2px !important;" src="https://img.icons8.com/cotton/64/upload--v1.png" alt="your image" /><br>
                    <input class="form-control" type='file' onchange="setFeaturedImage(this,'product_featured_image'); " name="product_featured_image" />

                 
                  <!-- When select image than show this image Code End -->
                </div><!-- form-group -->
                <br>
				
				
				<div class="form-group">
                  <label class="text-dark h6" ><h6>Add Featured Image 2</h6></label>
                  <br>
                  <!-- When select image than show this image Code start -->
                  <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
                  <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>

                  <style>
                    article, aside, figure, footer, header, hgroup, 
                    menu, nav, section { display: block; }
                  </style>
                  
                  <?php if (file_exists('../upload/product-image/'.$pdata['product_featured_image_two'])) { ?>
                    <img width="107px" height="122px" src="../upload/product-image/<?=$pdata['product_featured_image_two']?>" alt="current image">
                    <?php } else { ?>
                    <img id="product_featured_image_two" class="img-sm mt-2 mb-2 ml-2" style="height:124px !important; border:1px solid #ddd;padding:2px; border-radius:2px 
					!important;" src="https://img.icons8.com/cotton/64/upload--v1.png" alt="your image" />
                    <?php } ?>
					
                    <img id="product_featured_image_two" class="img-sm mt-2 mb-2 ml-2" style="height:124px !important; border:1px solid #ddd;padding:2px; border-radius:2px 
					!important;" src="https://img.icons8.com/cotton/64/upload--v1.png" alt="your image" /><br>
                    <input class="form-control" type='file' onchange="setFeaturedImage(this,'product_featured_image_two'); " name="product_featured_image_two" />

                  <script>
                   
                  </script>
                  <!-- When select image than show this image Code End -->
                </div><!-- form-group -->
                <br>
				
				
				<div class="form-group">
                  <label class="text-dark h6" ><h6>Add Featured Image 3</h6></label>
                  <br>
                  <!-- When select image than show this image Code start -->
                  <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
                  <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>

                  <style>
                    article, aside, figure, footer, header, hgroup, 
                    menu, nav, section { display: block; }
                  </style>
                  
                  <?php if (file_exists('../upload/product-image/'.$pdata['product_featured_image_three'])) { ?>
                    <img width="107px" height="122px" src="../upload/product-image/<?=$pdata['product_featured_image_three']?>" 
					alt="current image">
					<?php } else { ?>
                    <img id="product_featured_image_two" class="img-sm mt-2 mb-2 ml-2" style="height:124px !important; border:1px solid #ddd;padding:2px; border-radius:2px 
					!important;" src="https://img.icons8.com/cotton/64/upload--v1.png" alt="your image" />
                    <?php } ?>
                    <img id="product_featured_image_three" class="img-sm mt-2 mb-2 ml-2" style="height:124px !important; border:1px solid #ddd;padding:2px; border-radius:2px 
					!important;" src="https://img.icons8.com/cotton/64/upload--v1.png" alt="your image" /><br>
                    <input class="form-control" type='file' onchange="setFeaturedImage(this,'product_featured_image_three'); " name="product_featured_image_three" />

                  <script>
                   
                  </script>
                  <!-- When select image than show this image Code End -->
                </div><!-- form-group -->
                <br>
			

            </div>  
          </div>
      
          <div class="text-center">
            <button id="edit_product_info" type="submit" name="submit" value="submit" class="btn btn-success">Save Now </button>
            <a class="btn btn-danger" href="products">Cancel</a>
            
          </div>


  </form> 
</div>
</div>
</div>


			 

            
           </div>
          </div>
        </div>

<?php require('footer.php') ?> 