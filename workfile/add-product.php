<?php
$page_ttl = 'Add product';
$page_dsc = 'Add new product';
$thmblink = '<div class="ms-md-auto py-2 py-md-0"><a href="index.php" class="btn btn-label-info btn-round me-2">Dashboard</a></div>';
require('header.php');

//1 = admin / 0 = user
$have_accs_lvl = array("1","2");$have_accs_id = array("1");
echo chk_access($eb_user_id,$eb_user_level,$have_accs_lvl,$have_accs_id);

 ?>
  <body>
    <div class="wrapper">
 
<?php require('sidebar.php') ?> 

      <div class="main-panel">
<?php require('main-header.php') ?>  
        <div class="container">
          <div class="page-inner">
  <?php echo dsb_brd($page_ttl,$page_dsc,$thmblink)?>


<div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Product Information</h4>
                  </div>
                  <div class="card-body">
                    
                    <form action="add-product-post" method="POST" enctype="multipart/form-data">
        <div class="d-flex align-items-center  bg-sl-white ht-50v">
          <div class="login-wrapper wd-500 wd-xs-1000 pd-25 pd-xs-50 bg-white m-auto custom-class">
    
            <?php
              if(isset($_SESSION['product_upload_status'])):
              ?>
              <div class="alert alert-success">
                  <?php
                    echo $_SESSION['product_upload_status'];
                    unset($_SESSION['product_upload_status']);
                  ?>
              </div>
            <?php endif; ?>

            <div class="row">
                
              <div class="col-sm-6 mt-2">

                <div class="form-group">
                  <label class="text-dark h6" for="main_category">Select Category</label>
                  <select class="form-control" id="main_category" name="category_name" onchange="get_category('main_category','1','sub_category')" required>
                    <option>-- select Category --</option>
                    <?php
                      $select_category = "SELECT * FROM categories";
                      $categories = mysqli_query($con, $select_category);
                      foreach($categories as $category){
                    ?>
                      <option value="<?=$category['id']?>"> <?=$category['category_name']?> </option>
                    <?php } ?>

                  </select>
                </div>
                
                <div class="form-group" id="sub_category">
            
                </div>

                <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript"></script>-->
                  <script type="text/javascript">
                  
                  
	   
    function calc_pr(){
    var pr_pric = document.getElementById('product_purchase_price').value;   
    var sl_pric = document.getElementById('product_sale_price').value;
    var Self = document.getElementById('Self').value;
    var Platform = document.getElementById('Platform').value;
    var Refer = document.getElementById('Refer').value;
    var Donate = document.getElementById('Donate').value;
    var Inc = Number(Self)+Number(Platform)+Number(Refer)+Number(Donate);
    var prof = (sl_pric)-(pr_pric);
    var ratio = Math.round((prof)*(100)/(pr_pric));
    var NetPrfRat = (ratio)-(Inc);
    if(NetPrfRat < 15){
     document.getElementById('sa_net_ratio').style.background = "#ed0000";   
    }else {
     document.getElementById('sa_net_ratio').style.background = "green";   
    }
    document.getElementById('sa_ratio').innerHTML = 'Profit Ratio - '+ratio+'%';
    document.getElementById('sa_net_ratio').innerHTML = 'Net Ratio - '+NetPrfRat+'%';
    }
                    
                    
                    function get_category(em1,em2,rtn){
                    var element = document.getElementById(em1).value;
                    document.getElementById(rtn).innerHTML = '<center><img src="../img/spinner.gif" alt="Uploading...."/></center>';
                    if(em1.length==0){return;}if(window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
                    else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}xmlhttp.onreadystatechange=function()
                    {if(xmlhttp.readyState==4&&xmlhttp.status==200)
                    {document.getElementById(rtn).innerHTML=xmlhttp.responseText;}}
                    xmlhttp.open("GET","get-category.php?cid="+element+"&cmd="+em2,true);
                    xmlhttp.send();}
                  </script>
                <br>

                <div class="form-group">
                  <label class="text-dark h6">Product Title</label>
                  <input type="text" class="form-control" placeholder="Enter Product Title" name="product_name" required>
                </div>

                <div class="form-group">
                  <label class="text-dark h6"><h6>Reguler Price</h6></label>
                  <input type="text" class="form-control" placeholder="regular price TK" name="product_regular_price" required>
                </div>


                <div class="form-group" >
                  <label class="text-dark h6"><h6>Sale price </h6></label>
                  <input onclick="calc_pr();" onchange="calc_pr();" type="text" class="form-control" placeholder="Product sale price" name="product_sale_price" id="product_sale_price" required>
                </div><br>
                
                <div class="form-group" >
                  <label class="text-dark h6"><h6>Purchase price  <span class="sa_ratio" id="sa_ratio" >Profit Ratio - 0%</span>
                  <span class="sa_ratio" style="background: #3F51B5;" id="sa_net_ratio">Net Ratio - 0%</span>
                  </h6></label>
                  <input onclick="calc_pr();" onchange="calc_pr();" type="text" class="form-control" placeholder="Purchase price" name="product_purchase_price" id="product_purchase_price" required>
                </div>
                
               <div class="form-group" > 
               <label class="text-dark h6 mt-4"><h6>Product Unit </h6></label>
              <div class="input-group p-0">
                  
              <span class="input-group-text">Unit</span>
              <input type="text"  name="product_unit" value="1" aria-label="Unit" class="form-control" required>
              <select  name="product_unit_typ" class="form-control" required>
                  <option value="">Select</option>
                  <option value="kg">kg</option>
                  <option value="gm">gm</option>
                  <option value="liter">liter</option>
                  <option value="pcs">pcs</option>
                  <option value="ml">ml</option>
              </select>
            </div>
            </div>
             
             
                

            
            
                
                <div class="form-group" style="display:none">
                  <label class="text-dark h6"><h6>Genaretion </h6></label>
                  <input   placeholder="Ex. 5-2-5-4-1-6-3-7-3-9" type="text" class="form-control"
				  name="Genaretion" >
                </div>
				
               <div class="form-group">
                  <label class="text-dark h6">Delivery Cost:</label>
                  <input type="text" class="form-control" placeholder="Delivery Cost" name="Delivery_cost" >
                </div>
			
		<div class="form-group" > 
               <label class="text-dark h6 mt-4"><h6>Incentive </h6></label>
              <div class="input-group p-0">
                  
              <span class="input-group-text">Self</span>
              <input  onclick="calc_pr();" onchange="calc_pr();" type="text"  id="Self" name="Self" value="0" aria-label="Self" class="form-control" required>
              
			   <span class="input-group-text">Refer</span>
              <input  onclick="calc_pr();" onchange="calc_pr();" type="text"  id="Refer" name="Refer" value="0" aria-label="Refer" class="form-control" required>
              
			   <span class="input-group-text">Donate</span>
              <input  onclick="calc_pr();" onchange="calc_pr();" type="text"   id="Donate" readonly name="Donate" value="1" aria-label="Donate" class="form-control" required>
              
			   <span class="input-group-text">Platform</span>
              <input  onclick="calc_pr();" onchange="calc_pr();" type="text"   id="Platform" readonly name="Platform" value="1" aria-label="Platform" class="form-control" required>
             
			  
            </div>
            </div>
				
				

                <div class="form-group">
                  <label class="text-dark h6">Meta Title</label>
                  <input type="text" class="form-control" placeholder="write a meta title" name="product_meta_title" required>
                </div>

                <div class="form-group m-auto">
                  <label class="text-dark h6">Meta Desciption</label>
                  <textarea rows="4" class="form-control" name="product_meta_description" cols="58"> </textarea>
                </div>
				
				
				 <div class="form-group">
                  <label class="text-dark h6">Key Words </label>
				  <textarea rows="2" class="form-control" name="KeyWords" cols="58"> </textarea>
                </div>
				
				
				 <div class="form-group">
                  <label class="text-dark h6">Search Terms </label>
				  <textarea rows="2" class="form-control" name="SearchTerms" cols="58"> </textarea>
                </div>
				
				

                <div class="form-group">
                  <label class="text-dark h6"><h6>Product Brand</h6></label>
                  <input type="text" list="browsBr" class="form-control" placeholder="Product brand name" name="product_brand" >
                </div>
				
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
                  <label class="text-dark h6"><h6>Product Dealer</h6></label>
                  <input type="text" list="browsDlr" class="form-control" placeholder="Product Dealer" name="product_dealer" >
                </div>
		<datalist id="browsDlr">
<?php
                      $select_br= "SELECT * FROM dealer";
                      $brands = mysqli_query($con, $select_br);
                      foreach($brands as $brand){
                    ?>
                      <option value="<?=$brand['dl_name']?>"> <?=$brand['dl_name']?> </option>
                    <?php } ?>


</datalist>




                <div class="form-group">
                  <label class="text-dark h6"><h6>Product Tag</h6></label>
                  <input type="text" class="form-control" placeholder="Product tag" name="product_tag" >
                </div>

				<div class="form-group">
                  <label class="text-dark h6 mt-4"><h6>Product Stock</h6></label>
                  <input type="number" class="form-control" placeholder="Product stock amount" name="product_stock" required>
                </div>
                
                
                       <div class="form-group" > 
               <label class="text-dark h6 mt-4"><h6>Product Status </h6></label>
              <div class="input-group p-0">
              <select  name="product_status" class="form-control" required>
                  <option value="">Select</option>
                  <option value="1">Show</option>
                  <option value="0">Hide</option>
              </select>
            </div>
            </div>
            
            
            <div class="form-group">
                <label class="text-dark h6 mt-4"><h6>Product Barcode</h6></label>
                <input type="text" class="form-control" placeholder="Product bar code" value="" name="bar_code">
              </div>
            
                
				
                <div class="form-group">
                  <label class="text-dark h6" >Video Link</label>
                  <input type="video/mp4" class="form-control" name="product_video_link" placeholder="Paste your video link">
                </div>

                
              </div>

              <div class="col-sm-6">

                <div class="form-group">
                  <label class="text-dark h6" ><h6>Add Thumbnail Image <span class="text-secondary p"> (width: 268 X height: 268)</span></h6></label>
                  <br>
                  <style>
                    article, aside, figure, footer, header, hgroup, 
                    menu, nav, section { display: block; }
                  </style>
                    <img id="imgone" class="img-sm mt-2 mb-4" style="height:124px !important; border:1px solid #ddd;padding:2px; border-radius:2px !important;" src="https://img.icons8.com/cotton/64/upload--v1.png" alt="upload--v1" alt="your image" /><br>
                    <input class="form-control" type='file' onchange="setThumbnail_Image(this); " name="product_thumbnail_image" />
                  <script>
                    function setThumbnail_Image(input) {
                      if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                        $('#imgone')
                          .attr('src', e.target.result)
                          .width(110)
                          .height(120);
                        };
                        reader.readAsDataURL(input.files[0]);
                      }
                    }
                  </script>
                  <!-- When select image than show this image Code End -->
                </div>
                <br>

                <div class="form-group">
                  <label class="text-dark h6" ><h6>Add Featured Image One <span class="text-secondary p"> (800X800)</span></h6></label>
                  <br>
                  <!-- When select image than show this image Code start -->
                  <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
                  <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>

                  <style>
                    article, aside, figure, footer, header, hgroup, 
                    menu, nav, section { display: block; }
                  </style>

                    <img id="imgtwo" class="img-sm mt-2 mb-4" style="height:124px !important; border:1px solid #ddd;padding:2px; border-radius:2px !important;" src="https://img.icons8.com/cotton/64/upload--v1.png" alt="upload--v1" alt="your image" /><br>
                    <input class="form-control" type='file' onchange="setFeaturedImage(this); " name="product_featured_image" />

                  <script>
                    function setFeaturedImage(input) {
                      if (input.files && input.files[0]) {
                          var reader = new FileReader();

                          reader.onload = function (e) {
                              $('#imgtwo')
                                .attr('src', e.target.result)
                                .width(110)
                                .height(120);
                          };
                          reader.readAsDataURL(input.files[0]);
                      }
                    }
                  </script>
                  <!-- When select image than show this image Code End -->
                </div>
                <br>

                <div class="form-group">
                  <label class="text-dark h6" ><h6>Add Featured Image Two <span class="text-secondary p"> (800X800)</span></h6></label>
                  <br>
                  <!-- When select image than show this image Code start -->
                  <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
                  <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>

                  <style>
                    article, aside, figure, footer, header, hgroup, 
                    menu, nav, section { display: block; }
                  </style>

                    <img id="imgthree" class="img-sm mt-2 mb-4" style="height:124px !important; border:1px solid #ddd;padding:2px; border-radius:2px !important;" src="https://img.icons8.com/cotton/64/upload--v1.png" alt="upload--v1" alt="your image" /><br>
                    <input class="form-control" type='file' onchange="setFeaturedImageTwo(this); " name="product_featured_image_two" />

                  <script>
                    function setFeaturedImageTwo(input) {
                      if (input.files && input.files[0]) {
                          var reader = new FileReader();

                          reader.onload = function (e) {
                              $('#imgthree')
                                .attr('src', e.target.result)
                                .width(110)
                                .height(120);
                          };
                          reader.readAsDataURL(input.files[0]);
                      }
                    }
                  </script>
                  <!-- When select image than show this image Code End -->
                </div>

                <div class="form-group">
                  <label class="text-dark h6" ><h6>Add Featured Image Three <span class="text-secondary p"> (800X800)</span></h6></label>
                  <br>
                  <!-- When select image than show this image Code start -->
                  <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
                  <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>

                  <style>
                    article, aside, figure, footer, header, hgroup, 
                    menu, nav, section { display: block; }
                  </style>

                    <img id="imgfour" class="img-sm mt-2 mb-4" style="height:124px !important; border:1px solid #ddd;padding:2px; border-radius:2px !important;" src="https://img.icons8.com/cotton/64/upload--v1.png" alt="upload--v1" alt="your image" /><br>
                    <input class="form-control" type='file' onchange="setFeaturedImageThree(this); " name="product_featured_image_three" />

                  <script>
                    function setFeaturedImageThree(input) {
                      if (input.files && input.files[0]) {
                          var reader = new FileReader();

                          reader.onload = function (e) {
                              $('#imgfour')
                                .attr('src', e.target.result)
                                .width(110)
                                .height(120);
                          };
                          reader.readAsDataURL(input.files[0]);
                      }
                    }
                  </script>
                  <!-- When select image than show this image Code End -->
                </div>

              </div>
              <div class="col-sm-6">
                  <div class="col-sm-12">
                <div class="form-group" style="display:none;">
                  <label class="text-dark h6 mt-4"><h6>Product Size</h6></label>
                  <table  style="margin-left: 15px" id="productsize">
                   <tr class="table-success">
                        <th class="pl-3">Size</th>
                        <th class="pl-3">Price</th>
                        <th><input class="btn btn-success" type="button" id="add" value="Add New"></th>
                    </tr>
                    <tr>
                        <td><input class="form-control mb-1 mt-1" type="text" placeholder="size or scale" name="size[]"></td>
                        <td><input class="form-control mb-1 mt-1" type="number" placeholder="price" name="price[]"></td>
                        
                    </tr>
                  </table>
                 </div>

                  
                  
                  <script>
                                            
                    jQuery(document).ready(function(){
                    
                    var html = '<tr><td><input class="form-control mb-1" type="text" placeholder="size or scale" name="size[]"></td><td><input class="form-control mb-1" type="number" placeholder="price" name="price[]"></td></tr>';
                     
                        
                            $('#add').click(function (e){
                            e.preventDefault(e);
    
                            $("#productsize").append(html);
    	                   });
                        
                        
                    });
                </script>
                
                   <style>
                    #choiceColor ul li{
                          display: inline;
                          margin-right:10px;
                        }
                        
                        #colors{
                          background: #c0c0c0;
                          height: 50px;
                          padding: 15px;
                        }
                        
                                            
                </style>
                
                  <div class="form-group" id="choiceColor" style="display:none;">
                  <label class="text-dark h6 mt-4"><h6>Product Color</h6></label>
                  <div id="colors">
                <ul>
                   <li><input type="checkbox" name="color[]" value="Green"> Greeen <i class="fa fa-square" style="color: #17a05d;" aria-hidden="true"></i></li>
                   <li><input type="checkbox" name="color[]" value="Black"> Black <i class="fa fa-square" style="color: #000000;" aria-hidden="true"></i></li>
                   <li><input type="checkbox" name="color[]" value="Yellow"> Yellow <i class="fa fa-square" style="color: #ffff00;" aria-hidden="true"></i></li>
                   <li><input type="checkbox" name="color[]" value="White"> White <i class="fa fa-square" style="color: #ffffff;" aria-hidden="true"></i></li>
                   <li><input type="checkbox" name="color[]" value="Orange"> Orange <i class="fa fa-square" style="color: #ff8000;" aria-hidden="true"></i></li>
                   <li><input type="checkbox" name="color[]" value="Navy Blue"> Navy Blue <i class="fa fa-square" style="color: #000080;" aria-hidden="true"></i></li>
                   <li><input type="checkbox" name="color[]" value="Red"> Red <i class="fa fa-square" style="color: #ff0000;" aria-hidden="true"></i></li>
                   <li><input type="checkbox" name="color[]" value="Coffee"> Coffee <i class="fa fa-square" style="color: #800000;" aria-hidden="true"></i></li>
                   <li><input type="checkbox" name="color[]" value="Purple"> Purple <i class="fa fa-square" style="color: #8000ff;" aria-hidden="true"></i></li>
                </ul>
                  </div>

                </div>
                <br>
                
             <!-- This is Editor code for discription   -->
                <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
                <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
                <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
                
                <div class="form-group m-auto"> 
                  <option class="text-dark h6">Product Short Description</option>
                  <textarea id="summernote" rows="4" name="product_short_description" cols="58" class="mytextarea"> </textarea>
                </div>
                <br><br>

                  <script>
                     $('#summernote').summernote({
                       placeholder: 'Design your website',
                       tabsize: 2,
                       height: 200
                     });
                     
                  </script>
                  
                  <div class="form-group m-auto"> 
                  <option class="text-dark h6">Product Long Description</option>
                  <textarea id="summernotetwo" rows="5" name="product_long_description" cols="58" class="mytextarea"> </textarea>
                  </div>
                  
                  <script>
                     
                     $('#summernotetwo').summernote({
                       placeholder: 'Design your website',
                       tabsize: 2,
                       height: 400
                     });
                  
                  </script>
                  
                <br><br>

              </div>
            </div>
      
            <div class="text-left ml-4">
              <button type="submit" name="submit" value="submit" class="btn btn-success">Upload Product </button>
              <a class="btn btn-danger" href="products">Cancel</a>
            </div>

        </div><!-- login-wrapper -->
      </div><!-- d-flex -->
    </form>
            
           </div>
          
		  
                  </div>
                </div>
              </div>

			
		  </div>
        </div>

<?php require('footer.php') ?> 