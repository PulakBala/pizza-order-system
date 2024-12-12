<?php
$page_ttl = 'Create Orders';
$page_dsc = 'Products Management';
$thmblink = '<div class="ms-md-auto py-2 py-md-0"><a href="index.php" class="btn btn-label-info btn-round me-2">Dashboard</a></div>';
require('header.php');

$generateRandomString = generateRandomString();

if (!isset($_GET['ccs'])) {
//echo reloader('add-orders.php?ccs='.$generateRandomString.'&newOrder',200);  
//die();   
}


if (!isset($_SESSION['Ord_sa_token'])) {
$_SESSION['Ord_sa_token'] = $generateRandomString;
//die();   
}

if (isset($_POST['editas'])) {
$_SESSION['Ord_sa_token'] = $_POST['editas'];    
}





if (isset($_POST['product_name'])) {
$search = htmlentities($_POST['product_name']);
$select_query = "SELECT * FROM products  WHERE `product_name` LIKE '%$search%' OR `product_brand` 
			LIKE '%$search%' OR `product_tag` LIKE '%$search%' 
			OR `product_meta_title` LIKE '%$search%' ORDER BY id DESC limit 3";
$product_info_from_db = mysqli_query($con, $select_query);			
			
  } else {
$select_query = "SELECT * FROM products ORDER BY id DESC limit 5";
$product_info_from_db = mysqli_query($con, $select_query);
  }

if (isset($_SESSION['Ord_sa_token'])) {
$cart_session = $_SESSION['Ord_sa_token'];	
$bc_query = "SELECT count(id) as id FROM orders  WHERE `order_token` = '$cart_session'";
$bc_cnc = mysqli_fetch_assoc(mysqli_query($con, $bc_query));	
if($bc_cnc['id'] > 0){
//echo 'old';	
}else {
	//echo 'new';
	// create new 
			$amount_to_pay = 0;
            $shipping_area = 'PickDhanmondi';
            $customerid = 1;
			$name = 'eBazar';
            $phone = '01721815960';
            $email = '';
            $address_billing = '';
			$address = '';
            //$pmode = get_safe_value($con,htmlspecialchars($_POST['pmode']));
            $pmode = 'Pay_Online';
			$order_status = "Pending";
            $coupon_code = '';
            
            $query_coupon = "SELECT * FROM coupon WHERE coupon_code = '$coupon_code'";
            $result_coupon = mysqli_query($con, $query_coupon);
            $coupon_data = mysqli_fetch_array($result_coupon);
            $count_coupon = mysqli_num_rows($result_coupon);	
	
$cctime = date("Y-m-d");
$insert_order_query = "INSERT INTO orders (customer_id,order_token,order_date,order_name, order_phone, 
order_email, order_shipping_address,address,shipping_area,pmode,amount_to_pay,order_status,reference) 
VALUES('1','$cart_session','$cctime','$name','$phone','$email','$address_billing','$address',
'$shipping_area','$pmode','$amount_to_pay','$order_status','$eb_user_id')";
if(mysqli_query($con,$insert_order_query)){
$sa_nfy = "New Order";
} 
}


}
		  



$cart_session = $_SESSION['Ord_sa_token'];
//echo $select_query;


 ?>
 
 <style>

.btn:focus, .btn:hover {
    box-shadow: 1px 4px 14px 2px #4444446e !important;
}


.loaderx { 
    width: 100%;
    margin: 0 auto;
    position: absolute;
    z-index: 9999;
    display:none;
}
.loaderxX:before {
  content:'';
  border:1px solid #fff; 
  border-radius:10px;
  position:absolute;
  top:-4px; 
  right:-4px; 
  bottom:-4px; 
  left:-4px;
}
.loaderx .loaderBarx { 
    position: absolute;
    border-radius: 15px;
    top: 0;
    right: 100%;
    bottom: 0;
    left: 0;
    background: #f25961;
    width: 0;
    animation: borealisBarx 2s linear infinite;
    height: 4px;
}

@keyframes borealisBarx {
  0% {
    left:0%;
    right:100%;
    width:0%;
  }
  10% {
    left:0%;
    right:75%;
    width:25%;
  }
  90% {
    right:0%;
    left:75%;
    width:25%;
  }
  100% {
    left:100%;
    right:0%;
    width:0%;
  }
}
 </style>
  <body>
    <div class="wrapper">
 
<?php require('sidebar.php') ?> 




<div class="loaderx"  id="loaderx">
  <div class="loaderBarx"></div>
</div>




      <div class="main-panel">
<?php require('main-header.php') ?>  
        <div class="container">
          <div class="page-inner">
  <?php //echo dsb_brd($page_ttl,$page_dsc,$thmblink)?>






      <!-- Bootstrap Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Users</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
       
         <div class="input-group p-0 mb-2">
              <span class="input-group-text">Name</span>
              <input type="text"  id="adn_user" name="adn_user" value="" aria-label="adn_user" class="form-control adn_user" required="">
			 </div>
		<div class="input-group p-0 mb-2">
              <span class="input-group-text">Phone</span>
              <input type="text" id="adn_phone" name="adn_phone" value="" aria-label="adn_phone" class="form-control adn_phone" required="">
			 </div>	 
			 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary onOrdAddUser">Save Users</button>
        </div>
      </div>
    </div>
  </div>
    
    

			  <div class="sl-pagebody"> 
        <div class="card" style="min-height: 950px;">



            <div class="card-header pd-20 bg-transparent bd-b bd-gray-200">
           
  
              <script>
        document.addEventListener("DOMContentLoaded", function () {
            let barcode = '';
            let timeout;

            document.addEventListener('keypress', function (e) {
                if (timeout) {
                    clearTimeout(timeout);
                }

                // If the key is Enter (barcode scan completion)
                if (e.key === 'Enter') {
                    processBarcode(barcode);
                    barcode = ''; // Clear the barcode after processing
                } else {
                    barcode += e.key; // Add each key to the barcode string
                }

                // Clear the barcode if there is no input for 200ms (common in scans)
                timeout = setTimeout(() => {
                    barcode = '';
                }, 200000);
            });

            function processBarcode(scannedCode) {
                //document.getElementById("output").innerText = "Scanned Barcode: " + scannedCode;
                
                // Additional processing logic can go here (e.g., sending the barcode to the server)
            }
        });
		
	function toggleFullScreen() {
  if (!document.fullscreenElement &&    // alternative standard method
      !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement ) {  // current working methods
    if (document.documentElement.requestFullscreen) {
      document.documentElement.requestFullscreen();
    } else if (document.documentElement.msRequestFullscreen) {
      document.documentElement.msRequestFullscreen();
    } else if (document.documentElement.mozRequestFullScreen) {
      document.documentElement.mozRequestFullScreen();
    } else if (document.documentElement.webkitRequestFullscreen) {
      document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
    }
  } else {
    if (document.exitFullscreen) {
      document.exitFullscreen();
    } else if (document.msExitFullscreen) {
      document.msExitFullscreen();
    } else if (document.mozCancelFullScreen) {
      document.mozCancelFullScreen();
    } else if (document.webkitExitFullscreen) {
      document.webkitExitFullscreen();
    }
  }
  
}



    </script>
	
	
	<?php
	
	$bc_queryx = "SELECT * 
FROM 
orders 
LEFT JOIN users 
on users.user_id = orders.customer_id
WHERE order_token = '$cart_session'";
$bc_qty = mysqli_fetch_assoc(mysqli_query($con, $bc_queryx));
	
	?>

              
          <div class="form-group"> 
          <form method="post"> 
              <div class="input-group p-0">
                  
              <span class="input-group-text">Search</span>
              
              <input type="text" autofocus id="product_name" name="product_name" value=""  style="min-width: 300px;"
			  aria-label="product_name" class="form-control product_name" required="">
			  
			  
              <input type="hidden" id="Token" name="Token" value="<?=$cart_session?>" 
			  aria-label="Token" class="form-control Token" required="">
			  
			  <span class="input-group-text">Customer</span>
			  <input list="datalistOptions" type="text" id="cu_phone" name="cu_phone" value="<?=$bc_qty['user_phone']?>" 
			  class="form-control cu_phone" required="">
			  
			   <a style="max-width: 80px;"
			  class="form-control btn btn-danger Customer_Plus"><i class="fa fa-user-plus"></i></a>
			  
				  
			  <datalist id="datalistOptions">
				<option value="<?=$bc_qty['user_phone']?>">-- <?=$bc_qty['user_name']?></option>
				</datalist>
			  
			  <div id="cusIdRtn" style="display:non"></div>
			  
			  <span class="input-group-text">Name</span>
              <input type="text" id="cu_name" name="cu_name" value="" 
			  class="form-control cu_name" required="">
			  
			  <span class="input-group-text">Balance</span>
              <input type="text" id="cu_balance" name="cu_balance" value="" 
			  class="form-control cu_balance" required="">
			  
			 
			  
			 	<button type="button"  style="max-width: 95px;" id="printButton"
			class="form-control btn btn-info"><i class="fas fa-print"></i> Print</button>
			 
		              <!--<a href="javascript:void()" style="max-width: 80px;"
			  class="form-control btn btn-info"><i class="fa fa-search"></i></a>-->
			  
			  <a href="javascript:void()" style="max-width: 80px;"
			  class="form-control btn btn-success" onclick="toggleFullScreen()"><i class="fa fa-expand"></i></a>
			  
            </div>
            </form>    
            </div>    
              

<style>
.table>tbody>tr>td, .table>tbody>tr>th {
    padding: 7px 5px !important;
}
.ssas {  
    
    font-size: 35px;
    background: #673AB7;
    padding: 16px 8px;
    color: white;
    display: grid;
    text-align: center;
}
</style>
              
              
              
              <?php
                  if(isset($_SESSION['product_edit_status'])):
                ?>
                  <div class="alert alert-success">
                      <?php
                      echo $_SESSION['product_edit_status']; 
                      unset($_SESSION['product_edit_status']);
                      ?>
                  </div>
              <?php endif; ?>
              <div class="search search-bar text-right">
                <!-- Create a search bar  -->
              </div>

            </div><!-- card-header -->

			
			
			<div class="card-body">
			<div class="row">
			<div class="col-md-8 p-2">
			  <div class="row">  
			  <div class="col-md-12">  
			    
			 <table class="table table-bordered table-white table-responsive mg-b-0 tx-12">
              
 			
 			<thead class="thead-dark">
             <tr>
                 <th>Sr.</th>
                 <th width="40%">Product</th>
                 <th class="text-center">Stock </th>
                 <th class="text-center">Unit&nbsp;Price</th>
                 <th class="text-center">Option</th>
             </tr>
         </thead>
 			
              <tbody id="result">


                <?php
                  $serial_no = 1;
                    $product_info_from_db = mysqli_query($con, $select_query);
                  while($product_info = $product_info_from_db  ->fetch_assoc()){
                      $category_id_for_name = $product_info['category_id'];
                      $select_query = "SELECT category_name FROM categories WHERE id = '$category_id_for_name'";
                      $category_name = mysqli_fetch_assoc(mysqli_query($con, $select_query));
                  ?>
				  
                    <tr>
                      <td class="pd-l-20 text-center text-dark"><?=$product_info['id']?> <?php ?></td>
                      <td class="text-centerX">
                        <a class="tx-inverse tx-12 tx-medium d-block"><?=$product_info['product_name']?></a>
                      </td>
                      
                      <td>
                        <a class="tx-inverse tx-12 tx-medium d-block text-center"><?=$product_info['product_stock']?></a>
                      </td>
                      <td class="text-center">
                        <a class="tx-inverse tx-12 tx-medium d-block"><?=$product_info['product_sale_price']?></a>
                      </td>

                      <td class="valign-middle text-center">
                        <button value="<?= $product_info['id'] ?>" type="button" title="" class="add_itm btn btn-sm btn-success px-3 py-1" data-original-title="Add">Add</button>
                      </td>
                    </tr>
                    
                

                    <?php
                  }
                ?>
              </tbody>
                
            </table>

			
			
			</div>
			
			<div class="col-md-12"> 
			<!-- cart Item -->
			 <table class="table table-borderless table-responsive">
         <thead class="table-primary">
             <tr>
                 <th>ck</th>
                 <th>Sr.</th>
                 <th width="40%">Product</th>
                 <th>Qunt</th>
                 <th>U&nbsp;Price</th>
                 <th>Unt&nbsp;&nbsp;&nbsp;</th>
                 <th>U.&nbsp;Purchased</th>
                 <th>T.&nbsp;Price</th>
                 <th>Option</th>
             </tr>
         </thead>
         <tbody id="OrCtem">
                 
                 <?php
        	
        
        	
        	$token = $_SESSION['Ord_sa_token'];
        	
        	$sql = "SELECT product_id,c_buy_unit,product_name,id ,qty,product_price,c_product_unit,c_product_unit_type,total_price FROM cart WHERE cart_session = '$token'";
	        $result = mysqli_query($con,$sql);
        	
                 $serial = 0;
                 $tm = 0;
                 if($count>0){
					 
				while($product = $result  ->fetch_assoc()){
                         $serial++;
						 
                         $tm += (float)$product['total_price'];
                         
                         
                     
                         
                         echo '
                         <form method="post" >
                         <tr>
                       <td class="p-0 text-center text-dark">
					  <input type="checkbox" />
					  </td>
                         <td class="text-dark">'.$serial.'</td>';
                         
                         echo '<td><a style="color: black" href="single_product?id='.$product['product_id'].'" target="_blank">'.$product['product_name'].'</a></td>';
                         
                       
                         echo '<td class="text-dark"><input type="text"  id="qty" name="qty" 
                         value="'.$product['qty'].'" aria-label="Refer" class="form-control  px-1 py-1 text-center" readonly required=""></td>';
                         
                         echo '<td class="text-dark"><input type="text" id="c_buy_unit_price'.$product['id'].'" name="product_price" value="'.trim($product['product_price']).'" aria-label="product_price" class="form-control  px-1 py-1 text-center" required=""></td>';
                         
                         
                         
                         echo '<td class="text-dark">
                          <div class="input-group p-0">
                         <input type="text" id="c_product_unit'.$product['id'].'" name="c_product_unit" value="'.$product['c_product_unit'].'" aria-label="Refer" class="form-control  px-1 py-1 text-center" readonly required="">
                         <span class="input-group-text">'.$product['c_product_unit_type'].'</span>
                         </div>
                         </td>';
                         
                      
                         
                     echo '<td class="text-dark">
                     <div class="input-group p-0">
                     <input type="text" id="c_buy_unit'.$product['id'].'" name="c_buy_unit" value="'.$product['c_buy_unit'].'" aria-label="Refer" class="form-control  px-1 py-1 text-center"  required="">
                     <span class="input-group-text">'.$product['c_product_unit_type'].'</span>
                     </div>
                     </td>';
                    
                          echo '<td class="text-dark"><input type="text" id="total_price" name="total_price" 
						  value="'.$product['total_price'].'.TK" aria-label="Refer" class="form-control  px-1 py-1 text-center" readonly required=""></td>';
                          
                         
                         
                           echo '<input type="hidden" id="c_id" name="c_id" value="'.$product['id'].'" aria-label="c_id" class="form-control  px-1 py-1 text-center" required="">';
                         
                         
                         echo '<td>
						 <button type="button"  value="'.$product['id'].'"   class="px-2 py-1 btn btn-success btn-sm ord_edt_btn"><i class="fa fa-edit"></i></button>
						 <button type="button" value="'.$product['id'].'"  
						 class="Remv_itm px-2 py-1 mx-1 btn btn-danger btn-sm "><i class="fa fa-trash"></i></button>
						 </td>
                         
                         </tr></form>';
                       
                       }
					   
					echo '
					<tr>
					<td colspan="6"></td>
					<td colspan="3" class="text-start">
					<input type="text" id="" name="" value="Total - '.$tm.' .TK" 
					 class="form-control  px-1 py-1 text-center" readonly="" >
					</td>
				  </tr>
					';   
					
                 }
                 
                 
                 ?>
                 
             </tr>
         </tbody>
     </table>
			
			</div>
			
			</div>
			</div>
			
			<div class="col-md-4 p-2">
			
			
			<div class="col-md-12 px-2">
			 <div class="row px-2">   
			<div class="col-md-6 p-2 pt-0 pe-0">
			  <span style="Background:#8BC34A" class="ssas r_token"><?=$_SESSION['Ord_sa_token']?></span>
			</div>
			<div class="col-md-6 p-2  pt-0 ps-0">
			  <span class="ssas cdOrd">00</span>
			</div>
			<div class="col-md-6 p-2  pt-0 pe-0">
			  <span style="Background:#FF9800" class="ssas cdAmnt">00.00</span>
			</div>
			<div class="col-md-6 p-2  pt-0 ps-0">
			  <span class="ssas cdItm">0</span>
			</div>
			</div>
			</div>
			
			
			<div class="col-md-12 p-2">
			<?php
            $bc_queryx = "SELECT * 
            FROM 
            orders 
            LEFT JOIN users 
            on users.user_id = orders.customer_id
            WHERE order_token = '$token'";
            $bc_qty = mysqli_fetch_assoc(mysqli_query($con, $bc_queryx));
            
            
            ?>
	        <table class="table table-bordered table-responsive table-dark">
             
                      <tbody id="cash_section" style="min-height: 509px;height: 509px;">
					  <!--<tr class="">
                          <td>Customer ID: </td>
                          <td><?=$bc_qty['customer_id']?></td>
                        </tr>
						<tr class="">
                          <td>Customer Name: </td>
                          <td><?=$bc_qty['user_name']?></td>
                        </tr>
						<tr class="">
                          <td>Customer Phone: </td>
                          <td><?=$bc_qty['user_phone']?></td>
                        </tr>
						<tr class="">
                          <td>Cart Amount: </td>
                          <td><?=$tm?></td>
                        </tr>
                        <tr>
                          <td>VAT+</td>
                          <td>00.00</td>
                        </tr>
                        <tr class="">
                          <td>Discount: </td>
                          <td>00.00</td>
                        </tr>
						<tr class="">
                          <td>Paid By: </td>
                          <td>00.00</td>
                        </tr>
						<tr class="">
                          <td>Given Amount: </td>
                          <td>00.00</td>
                        </tr>
						<tr class="">
                          <td>Change: </td>
                          <td>00.00</td>
                        </tr>
                        <tr class="table-info">
                          <td>Total Paid: </td>
                          <td>500.00</td>
                        </tr>
						<tr class="table-danger">
                          <td>Due: </td>
                          <td>00.00</td>
                        </tr>-->
                      </tbody>
                    </table>
                    
                    	  <script>
        function printDiv() {
            var divToPrint=document.getElementById('ticket');
            var newWin=window.open('','Print-Window');
            newWin.document.open();
            var printContent = '<html>';
                printContent    += '<head>';
                                   printContent    += '<link href="https://ebazar.com.bd/dashboard/as.css" rel="stylesheet">';
                    printContent    += '<style>';
                        printContent    += '.print_hide {display:none;}';
                    printContent    += '</style>';
                printContent    += '</head>';
                printContent    += '<body onload="window.print()">';
                    printContent    += '<div class="col-12">';
                        printContent    += divToPrint.innerHTML;
                    printContent    += '</div>';
                printContent    += '</body>';
            printContent    += '</html>';
            newWin.document.write(printContent);
            newWin.document.close();

            setTimeout(function(){newWin.close();}, 200);
        }
    </script>	
				
					
				<div class="row">	
					<div class="col-6  ps-1">	
				<button style="height: 100px;font-size: 35px;" type="button" id="newMkOrder" 
				class="btn btn-info btn-lg btn-block w-100"><i class="fas fa-plus"></i> New</button>
			</div>
			
			<div class="col-6  ps-1">	
				<button style="height: 100px;font-size: 35px;" type="button" id="ConfirmOrd" 
				class="btn btn-success btn-lg btn-block w-100"><i class="fas fa-check"></i> Confirm</button>
			</div>
			
			</div>
			
			</div>
			
			</div>
			
			</div>
			
			

			
			
			
			
			
			
			</div>
			</div>
			
			
			
			<div class="card-footer tx-12 pd-y-15 bg-transparent bd-t bd-b-200">
   
            </div><!-- card-footer -->
            
          </div><!-- card -->
      </div>
    
            
           </div>
       

<?php require('footer.php') ?> 