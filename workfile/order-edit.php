<?php
$page_ttl = 'Edit Order ';
$page_dsc = 'Details about the Order';
$thmblink = '<div class="ms-md-auto py-2 py-md-0"><a href="index.php" class="btn btn-label-info btn-round me-2">Dashboard</a></div>';
require('header.php');

if(isset($_GET['id'])){
$order_id = $_GET['id'];
$select_query = "SELECT order_token,order_status FROM orders WHERE id = '$order_id'";
$select_order_info = mysqli_query($con, $select_query);
$asdjasg = mysqli_num_rows($select_order_info);
$order = mysqli_fetch_array($select_order_info);
if($asdjasg > 0){}else {echo reloader('orders',1);die();}
}else {echo reloader('orders',1);die();}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
if (isset($_POST['product_price'])) {
    $order_id = $_GET['id'];
    // Capture form data
    $qty = $_POST['qty'];
    $product_price = $_POST['product_price'];
    $c_product_unit = $_POST['c_product_unit'];
    $c_product_unit_type = $_POST['c_product_unit_type'];
    $c_buy_unit = $_POST['c_buy_unit'];
    $total_price = $_POST['total_price'];
    $c_id = $_POST['c_id']; // This is the primary key or unique identifier for the product


    $total_price =  calculatePrice($c_buy_unit,$product_price,$c_product_unit);



   //$update_queryo = "UPDATE orders SET amount_to_pay = '$total_price' WHERE id = '$order_id'";
//$update_query_from_db = mysqli_query($con, $update_queryo);

    // Update query
    $query = "UPDATE cart SET 
              qty = ?, 
              product_price = ?, 
              c_product_unit = ?, 
              c_product_unit_type = ?, 
              c_buy_unit =?,
              total_price = ?
              WHERE id = ?";

    // Prepare statement
    if ($stmt = $con->prepare($query)) {
        // Bind parameters
        $stmt->bind_param("ssssssi", $qty, $product_price, $c_product_unit, $c_product_unit_type,$c_buy_unit, $total_price, $c_id);
        
        // Execute the statement
        if ($stmt->execute()) {
            $sa_nfy = "Updated successfully!";
        } else {
            //echo "Error updating record: " . $con->error;
        }
        
        // Close the statement
        //$stmt->close();
    } else {
        //echo "Error preparing statement: " . $con->error;
    }

   
}
}


// Assume you have already connected to the database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];
    $customer_id = $_POST['customer_id'];
    $coupon_id = $_POST['coupon_id'];
    $order_token = $_POST['order_token'];
    $order_date = $_POST['order_date'];
    $order_name = $_POST['order_name'];
    $order_phone = $_POST['order_phone'];
    $order_email = $_POST['order_email'];
    $order_shipping_address = $_POST['order_shipping_address'];
    $address = $_POST['address'];
    $shipping_area = $_POST['shipping_area'];
    $pmode = $_POST['pmode'];
    $amount_to_pay = $_POST['amount_to_pay'];
   // $user_pay_status = $_POST['user_pay_status'];
   // $order_status = $_POST['order_status'];
    $transaction_code = $_POST['transaction_code'];
    $reference = $_POST['reference'];

    // Update the order in the database
    $update_query = "UPDATE orders SET 
                        customer_id = '$customer_id',
                        coupon_id = '$coupon_id',
                        order_token = '$order_token',
                        order_date = '$order_date',
                        order_name = '$order_name',
                        order_phone = '$order_phone',
                        order_email = '$order_email',
                        order_shipping_address = '$order_shipping_address',
                        address = '$address',
                        shipping_area = '$shipping_area',
                        pmode = '$pmode',
                        amount_to_pay = '$amount_to_pay',
                        user_pay_status = '$user_pay_status',
                        order_status = '$order_status',
                        transaction_code = '$transaction_code',
                        reference = '$reference'
                    WHERE id = $order_id";

    if (mysqli_query($con, $update_query)) {
        $sa_nfy = "Order updated successfully!";
    } else {
       // echo "Error updating order: " . mysqli_error($con);
    }
}

if(isset($_GET['id'])){
$order_id = $_GET['id'];

$select_query = "SELECT * FROM orders WHERE id = '$order_id'";
$select_order_info = mysqli_query($con, $select_query);
$asdjasg = mysqli_num_rows($select_order_info);
$order = mysqli_fetch_array($select_order_info);

if($asdjasg > 0){
$coupon_id = $order['coupon_id'];
$coupon_query = "SELECT * FROM `coupon` WHERE `id` = '$coupon_id'";
$result_coupon = mysqli_query($con,$coupon_query);
$coupon = mysqli_fetch_array($result_coupon);
$cnt_cpn = mysqli_num_rows($result_coupon);
if($cnt_cpn == 0){$coupon_id = 0;}


$customer_id = $order['customer_id'];
$query_customer = "SELECT * FROM `users` WHERE `user_id` = '$customer_id'";
$result_customer = mysqli_query($con,$query_customer);
$customer = mysqli_fetch_array($result_customer);


$sub_total = 0;
$token = $order['order_token'];
$sql = "SELECT total_price FROM cart WHERE cart_session = '$token'";
$result = mysqli_query($con,$sql);

$count = mysqli_num_rows($result);
if($count>0){
  while ($row = $result->fetch_assoc()) {
    $sub_total += $row['total_price'];
  }
}

}else {die();}	
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


			<div class="col-lg-12 sl-pagebody m-auto">


			<?php 
			if($asdjasg > 0) {
			?>
            <!-- Show Bootstrap Modal page Start -->
            <div class="row m-auto">

                <div class="modal-body">
                    
                    
	
         

                    <div class="row">
					
					<div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Order Details</h4>
                  </div>
                  <div class="card-body">
                   
                   


                   
                   
	 <form action="order-edit.php?id=<?=$_GET['id'];?>" method="POST">

	<div class="row">				
    <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">

    <!-- Customer ID -->
    <div class="col-sm-6 mt-2 mb-2">
        <label class="text-dark h6" for="customerId">Customer ID</label>
        <input type="text" class="form-control" id="customerId" name="customer_id" value="<?php echo $order['customer_id']; ?>" readonly>
    </div>

    <!-- Coupon ID -->
    <div class="col-sm-6 mt-2 mb-2">
        <label class="text-dark h6" for="couponId">Coupon ID</label>
        <input type="text" class="form-control" id="couponId" name="coupon_id" value="<?php echo $order['coupon_id']; ?>">
    </div>

    <!-- Order Token -->
    <div class="col-sm-6 mt-2 mb-2">
        <label class="text-dark h6" for="orderToken">Order Token</label>
        <input type="text" readonly class="form-control" id="orderToken" name="order_token" value="<?php echo $order['order_token']; ?>">
    </div>

    <!-- Order Date -->
    <div class="col-sm-6 mt-2 mb-2">
        <label class="text-dark h6" for="orderDate">Order Date</label>
        <input type="date" class="form-control" id="orderDate" name="order_date" value="<?php echo $order['order_date']; ?>">
    </div>

    <!-- Order Name -->
    <div class="col-sm-6 mt-2 mb-2">
        <label class="text-dark h6" for="orderName">Order Name</label>
        <input type="text" class="form-control" id="orderName" name="order_name" value="<?php echo $order['order_name']; ?>">
    </div>

    <!-- Order Phone -->
    <div class="col-sm-6 mt-2 mb-2">
        <label class="text-dark h6" for="orderPhone">Order Phone</label>
        <input type="text" class="form-control" id="orderPhone" name="order_phone" value="<?php echo $order['order_phone']; ?>">
    </div>

    <!-- Order Email -->
    <div class="col-sm-6 mt-2 mb-2">
        <label class="text-dark h6" for="orderEmail">Order Email</label>
        <input type="email" class="form-control" id="orderEmail" name="order_email" value="<?php echo $order['order_email']; ?>">
    </div>

    <!-- Order Shipping Address -->
    <div class="col-sm-6 mt-2 mb-2">
        <label class="text-dark h6" for="orderShippingAddress">Order Shipping Address</label>
        <textarea class="form-control" id="orderShippingAddress" name="order_shipping_address"><?php echo $order['order_shipping_address']; ?></textarea>
    </div>

    <!-- Address -->
    <div class="col-sm-6 mt-2 mb-2">
        <label class="text-dark h6" for="address">Address</label>
        <textarea class="form-control" id="address" name="address"><?php echo $order['address']; ?></textarea>
    </div>

    <!-- Shipping Area -->
    <div class="col-sm-6 mt-2 mb-2">
        <label class="text-dark h6" for="shippingArea">Shipping Area</label>
      
        <select name="shipping_area" class="form-control">
         <option hidden value="<?php echo $order['shipping_area']; ?>" selected=""><?php echo $order['shipping_area']; ?></option>
         <option value="Inside Dhaka">Inside Dhaka</option>
         <option value="Outside Dhaka">Outside Dhaka</option>
          <option value="PickDhanmondi">Pick Point(Dhanmondi)</option>
           </select>
        
        
    </div>

    <!-- Payment Mode -->
    <div class="col-sm-6 mt-2 mb-2">
        <label class="text-dark h6" for="pmode">Payment Mode</label>
        <input type="text" class="form-control" id="pmode" name="pmode" value="<?php echo $order['pmode']; ?>">
    </div>

    <!-- Amount to Pay -->
    <div class="col-sm-6 mt-2 mb-2">
        <label class="text-dark h6" for="amountToPay">Amount to Pay</label>
        <input type="text"  class="form-control" id="amountToPay" name="amount_to_pay" value="<?php echo $order['amount_to_pay']; ?>">
    </div>

    <!-- Payment Status 
    <div class="col-sm-6 mt-2 mb-2">
        <label class="text-dark h6" for="inputState">Payment Status</label>
        <select id="inputState" class="form-control" name="user_pay_status">
            <option hidden selected>
                <?php
                //if($order['user_pay_status'] == 1){
                  //  echo "Paid";
               // }
               // else{
                //    echo "Unpaid";
              //  }
                ?>
            </option>
            <?php if($order['order_status'] != 'Completed') { ?>
                <option value="0">Unpaid</option>
                <option value="1">Paid</option>
            <?php } ?>
        </select>
    </div>

     Order Status
    <div class="col-sm-6 mt-2 mb-2">
        <label class="text-dark h6" for="orderStatus">Order Status</label>
        <input type="text" class="form-control" id="orderStatus" name="order_status" value="<?php echo $order['order_status']; ?>">
    </div> -->

    <!-- Transaction Code -->
    <div class="col-sm-6 mt-2 mb-2">
        <label class="text-dark h6" for="transactionCode">Transaction/Payment Note</label>
        <input type="text" class="form-control" id="transactionCode" name="transaction_code" value="<?php echo $order['transaction_code']; ?>">
    </div>

    <!-- Reference -->
    <div class="col-sm-6 mt-2 mb-2">
        <label class="text-dark h6" for="reference">Reference</label>
        <input readonly type="text" class="form-control" id="reference" name="reference" value="<?php echo $order['reference']; ?>">
    </div>

    <!-- Submit Button -->
    <div class="col-sm-12 mt-2 mb-2">
        <button type="submit" class="btn btn-primary">Update Order</button>
    </div>
    </div>
</form>
	
 </div>
				   </div>
                </div>

					
		<div class="col-md-10">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Order Details</h4>
                  </div>
                  
     
                  <div class="card-body bg-gray1">
                   <table class="table table-borderless table-responsive">
         <thead>
             <tr>
                 <th>Sr.</th>
                 <th width="40%">Product</th>
                 <th>Quantity</th>
                 <th>Unit&nbsp;Price</th>
                 <th>Unit&nbsp;&nbsp;&nbsp;</th>
                 <th>Unit&nbsp;type</th>
                 <th>Units&nbsp;Purchased</th>
                 <th>Total&nbsp;Price</th>
                 <th>Option</th>
             </tr>
         </thead>
         <tbody>
                 
                 <?php
        	
        	
        	
        	
        



        	
        	
        	
        	
        	
        	
        	
        	
        	
        	
        	
        	
        	$sql = "SELECT c_buy_unit,product_name,id ,qty,product_price,c_product_unit,c_product_unit_type,total_price FROM cart WHERE cart_session = '$token'";
	        $result = mysqli_query($con,$sql);
        	
        	/*
        	c_id 
        	qty
        	product_price
        	c_product_unit
        	c_product_unit_type
        	total_price
        	*/
        	
        	
                 $serial = 0;
                 if($count>0){
                       while($product = $result  ->fetch_assoc()){
                         $serial++;
                         
                         echo '
                         <form method="post">
                         <tr>
                         
                         <td class="text-dark">'.$serial.'</td>';
                         
                         echo '<td><a style="color: black" href="single_product?id='.$product['product_id'].'" target="_blank">'.$product['product_name'].'</a></td>';
                         
                       
                         echo '<td class="text-dark"><input type="text" id="qty" name="qty" 
                         value="'.$product['qty'].'" aria-label="Refer" class="form-control  px-1 py-1 text-center" required=""></td>';
                         
                         echo '<td class="text-dark"><input type="text" id="product_price" name="product_price" value="'.trim($product['product_price']).'" aria-label="product_price" class="form-control  px-1 py-1 text-center" required=""></td>';
                         
                         
                         
                         echo '<td class="text-dark"><input type="text" id="c_product_unit" name="c_product_unit" value="'.$product['c_product_unit'].'" aria-label="Refer" class="form-control  px-1 py-1 text-center" readonlyX required=""></td>';
                         
                         echo '<td class="text-dark"><input type="text" id="c_product_unit_type" name="c_product_unit_type" value="'.$product['c_product_unit_type'].'" aria-label="Refer" readonly class="form-control  px-1 py-1 text-center" required=""></td>';
                         
                     echo '<td class="text-dark"><input type="text" id="c_buy_unit" name="c_buy_unit" value="'.$product['c_buy_unit'].'" aria-label="Refer" class="form-control  px-1 py-1 text-center" required=""></td>';
                    
                          echo '<td class="text-dark"><input type="text" id="total_price" name="total_price" value="'.$product['total_price'].'" aria-label="Refer" class="form-control  px-1 py-1 text-center" readonly required=""></td>';
                          
                         
                         
                           echo '<input type="hidden" id="c_id" name="c_id" value="'.$product['id'].'" aria-label="c_id" class="form-control  px-1 py-1 text-center" required="">';
                         
                         
                         echo '<td><button type="submit"  class=" btn btn-success btn-sm ">Update</button></td>
                         
                         </tr></form>';
                       
                       }
                 }
                 
                 
                 ?>
                 
             </tr>
         </tbody>
     </table>
				   
				   </div>
				   
				   
				  
			
				   
                </div>
              </div>				
					
					
					
					
					
					
			<div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Order Summary (ID : <?= "" . $order['id']?>)</h4>
                  </div>
                  <div class="card-body">
                   
				       <div class="cardX mt-0">
                    
                        <div class="card-body bg-white">
                            <div class="row">
       <div class="col-lg-6">
 <table class="table table-borderless">
     <tbody>
     <tr>
         <td class="w-50 fw-600 h6">Order Date:</td>
         <td class="text-dark"><?=$order['order_date']?></td>
     </tr>
     <tr>
         <td class="w-50 fw-600 h6">Order Token:</td>
         <td class="text-dark"><?=$order['order_token']?></td>
     </tr>
     <tr>
         <td class="w-50 fw-600 h6">Order Amount:</td>
         <td class="text-dark">৳ <?=$order['amount_to_pay']?></td>
     </tr>
     <tr>
         <td class="w-50 fw-600 h6">Order status:</td>
         <td class="text-dark"><?=$order['order_status']?></td>
     </tr> 
    				
    				
     <tr>
         <td class="w-50 fw-600 h6">Discount:
    					<?php if($cnt_cpn > 0 ) {echo $coupon['coupon_type'];}?> </td>
         <td class="text-dark">
    					<?php 
    					if($cnt_cpn >0) {
    					if($coupon['coupon_type'] == 'Fixed'){
        echo '৳ '.$coupon['coupon_discount'];}else{
        	echo $coupon['coupon_discount'].' %';}
        	}else {echo 'Not Found';}?></td>
     </tr> 
            	
     <tr>
         <td class="w-50 fw-600 h6">Payment Method:</td>
         <td class="text-dark"><?=$order['pmode']?></td>
     </tr>
      <tr>
         <td class="w-50 fw-600 h6">Payment status:</td>
             <td class="text-dark"><?php if($order['user_pay_status']==true){echo 'Paid';}else{echo 'Unpaid';}?></td>
     </tr> 
    				
     <tr class="table-info">
         <td class="w-50 fw-600 h6">Order Name:</td>
         <td class="text-dark"><?=$order['order_name']?></td>
     </tr> 
     <tr class="table-info">
         <td class="w-50 fw-600 h6">Phone:</td>
         <td class="text-dark"><?=$order['order_phone']?></td>
     </tr> 
     <tr class="table-info">
         <td class="w-50 fw-600 h6">Email:</td>
         <td class="text-dark"><?=$order['order_email']?></td>
     </tr> 
     <tr class="table-info">
         <td class="w-50 fw-600 h6">Shipping address:</td>
         <td class="text-dark"><?=$order['order_shipping_address']?></td>
     </tr> 
     <tr class="table-info">
         <td class="w-50 fw-600 h6">Address:</td>
         <td class="text-dark"><?=$order['address']?></td>
     </tr>  
     <tr class="table-info">
         <td class="w-50 fw-600 h6">Shipping area:</td>
         <td class="text-dark"><?=$order['shipping_area']?></td>
     </tr> 
    				
 </tbody>
 </table>
       </div>
       <div class="col-lg-6">
 <table class="table table-borderless">
     <tbody>
     <tr>
         <td class="w-50 fw-600 h6">Customer Name:</td>
         <td class="text-dark"><?=$customer['user_name']?></td>
     </tr>
     <tr>
         <td class="w-50 fw-600 h6">Customer Email:</td>
         <td class="text-dark"><?=$customer['user_email']?></td>
     </tr>
     <tr>
         <td class="w-50 fw-600 h6">Customer Phone:</td>
         <td class="text-dark"><?=$customer['user_phone']?></td>
     </tr>
     <tr>
         <td class="w-50 fw-600 h6">Shipping address:</td>
         <td class="text-dark"><?=$order['address']?></td>
     </tr>
     <tr>
         <td class="w-50 fw-600 h6">Coupone Code: </td>
         <td class="text-dark">
    					<?php if($cnt_cpn > 0 ) { echo $coupon['coupon_code']?>
    					<?php }else {echo 'Not found';}?>
    					</td>
     </tr> 
     <tr>
         <td class="w-50 fw-600 h6">Reference:</td>
         <td class="text-dark"><?php if($order['pmode']=='Bkash'){echo $order['reference'];}else{echo 'N/A';}?></td>
     </tr>
     <tr>
         <td class="w-50 fw-600 h6">Transaction Code:</td>
         <td class="text-dark"><?php if($order['pmode']=='Bkash'){echo $order['transaction_code'];}else{echo 'N/A';}?></td>
     </tr>
     </tbody>
 </table>
       </div>
                            </div>
                            </div>
                        </div>
                    
				   </div>
                </div>
              </div>
					
					
                    
					
    
    
    
    
					<div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Order Ammount</h4>
                  </div>
                  <div class="card-body bg-gray1">
                   
				   <table class="table table-bordered">
         <tbody>
             <tr>
                 <td class="w-50 fw-600 text-dark">Subtotal</td>
                 <td class="text-right">
                     <span class="strong-600 text-dark">৳ <?=$sub_total?></span></span>
                 </td>
             </tr>
             <tr>
                 <td class="w-50 fw-600 text-dark">Shipping</td>
                 <td class="text-right text-dark">
                 <span class="text-italic text-dark">
                 <?php 
    			    
                        			    if($order['shipping_area']=='Inside Dhaka'){
                    					 echo '৳ 60';
                    					 $ship_amnt = '60';
                    					}else if($order['shipping_area']=='Outside Dhaka'){
                    					echo '৳ 120';
                    					$ship_amnt = '120';
                        				}else {
                        				 echo '৳ 0';
                    					$ship_amnt = '0';
        			}
                        				
                        		    ?>
                    .00</span>
                 </td>
             </tr>
             <tr>
                 <td class="w-50 fw-600 text-dark">Discount</td>
                 <td class="text-right text-dark">
                    <span class="text-italic text-dark">
        	   <?php 
        	   if($cnt_cpn >0) {
    					if($coupon['coupon_type'] == 'Fixed'){
        echo '৳ '.$coupon['coupon_discount'];}else{
        	echo $coupon['coupon_discount'].' %';}
        	}else {echo 'Not Found';}
        	?></span>
                 </td>
             </tr>
             <tr>
                 <td class="w-50 fw-600 text-dark">Bkash</td>
                 <td class="text-right text-dark">
                     <span class="text-italic text-dark">
                 <?php
                        		    if($order['pmode'] == 'Bkash'){
                        		        $payable_amount =  (int)$order['amount_to_pay'];
                        				$bkash = ($payable_amount*2)/100;
                        		        
                            		    echo '৳ '.$bkash;
                        		    }else{
                        		        echo 'N/A';
                        		    }
                        		
                        		?>
                     </span>
                 </td>
             </tr>
             <tr>
                 <td class="w-50 fw-600 text-dark">Total</td>
                 <td class="text-right text-dark">
                     <strong>
                         <span>৳ <?=$order['amount_to_pay']+$ship_amnt?>.00</span>
                     </strong>
                 </td>
             </tr>
         </tbody>
     </table>
				   </div>
                </div>
              </div>	
    
    
    
				 </div>	
    
			
        
   
                           
       
                            
                  
                    <!-- .modal-footer -->

                </div><!-- .modal-body -->
               </div>
			   
			<?php  }else {echo 'Select a order please...';} ?>
            </div><!-- /.modal-dialog -->
            <!-- Show Bootstrap Modal page End -->

        </div><!-- sl-pagebody -->
            
           </div>
          </div>
       

<?php require('footer.php') ?> 