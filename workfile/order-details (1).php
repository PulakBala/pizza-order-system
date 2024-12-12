<?php
$page_ttl = 'Order Details ';
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


if(isset($_POST['id'])){
$token = $order['order_token'];    
$ckorder_status = $order['order_status'];    
$getorder_id = $_POST['id'];
$payment_status_int = $_POST['payment_status'];
$delivery_status = $_POST['order_status'];

$transaction_code = $_POST['transaction_code']; 
$payment_amnt = $_POST['payment_amnt'];
$amount_paid_by = $_POST['amount_paid_by'];

if($ckorder_status == 'Completed'){
 $delivery_status = 'Completed';   
}



if(isset($_POST['MrkCom'])){
if($payment_status_int == 1){
if($ckorder_status == 'Delivered'){
$delivery_status = 'Completed';	
//echo $token;
//echo $order_id;
send_insentive($token,$order_id);
}
}
}

// amount_paid
// transaction_code
// amount_paid_by


$update_query = "UPDATE orders SET 
user_pay_status = '$payment_status_int',
amount_paid = '$payment_amnt',
transaction_code = '$transaction_code',
amount_paid_by = '$amount_paid_by',
order_status = '$delivery_status'
WHERE id = $getorder_id";
if(mysqli_query($con, $update_query)){
    $sa_nfy = 'Paymnet Status Updated.';
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
$sql = "SELECT * FROM cart WHERE cart_session = '$token'";
$result = mysqli_query($con,$sql);

$count = mysqli_num_rows($result);
if($count>0){
  while ($row = $result->fetch_assoc()) {
    $sub_total += $row['total_price'];
  }
}

}else {die();}	
}







									    
                    									    if($order['shipping_area']=='Inside Dhaka'){
                    					 //echo '৳ 60';
                    					 $ship_amnt = '50';
                    					}else if($order['shipping_area']=='Outside Dhaka'){
                    					//echo '৳ 120';
                    					$ship_amnt = '120';
                        				}else {
                        				 //echo '৳ 0';
                    					$ship_amnt = '0';
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
                    
                    
                    
					
			<?php
			

			//echo send_insentive($token);
			/*
			$sqlbn = "SELECT 
			products.product_name,
			products.product_inc_self,
			products.product_inc_ref ,
			products.product_inc_dont ,
			products.product_inc_pltfrm ,
			products.product_purchase_price,
			products.product_sale_price 
			FROM 
			cart 
			LEFT JOIN products
			ON products.id = cart.product_id
			WHERE cart_session = '$token'";
			$resultbn = mysqli_query($con,$sqlbn);
			
			$sprfselfTtl = 0;
			$sprfself = 0;
			$sprfRef = 0;
			$sprfDonet = 0;
			$sprfPlatform = 0;
			while($cvb = $resultbn  ->fetch_assoc()){
			echo $inc_self = $cvb['product_inc_self'];echo '-';
			echo $inc_ref = $cvb['product_inc_ref'];echo '-';
			echo $inc_dont = $cvb['product_inc_dont'];echo '-';
			echo $inc_pltfrm = $cvb['product_inc_pltfrm'];echo '-';echo '<br>';
			echo 'product_purchase_price'.$ppurchase_price = $cvb['product_purchase_price']; echo '<br>';
			echo 'product_sale_price'.$psale_price = $cvb['product_sale_price']; echo '<br>';
			echo 'Profit'.$pprofit = $psale_price-$ppurchase_price; echo '<br>';
			echo 'Profit margin'.$pprofit_mrgn = $pprofit*100/$ppurchase_price; echo '<br>';
			echo 'Sum of Inc'.$sum_inctv = $inc_self+$inc_ref+$inc_dont+$inc_pltfrm; echo '<br>';
			echo '<hr>';
			if($pprofit_mrgn > $sum_inctv){
			echo $sprfself = $sprfself+($pprofit*$inc_self/100);echo '<br>';
			echo $sprfRef = $sprfRef+($pprofit*$inc_ref/100);echo '<br>';
			echo $sprfDonet = $sprfDonet+($pprofit*$inc_dont/100);echo '<br>';
			echo $sprfPlatform = $sprfPlatform+($pprofit*$inc_pltfrm/100);echo '<br>';
			
			
			}
			
			}
			echo  'sprfself'.$sprfself.'bdt';echo '<br>';
			echo  'sprfRef'.$sprfRef.'bdt';echo '<br>';
			echo  'sprfDonet'.$sprfDonet.'bdt';echo '<br>';
			echo  'sprfPlatform'.$sprfPlatform.'bdt';echo '<br>';
			
			*/
			
			?>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Simulation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
	  
	  
         	<?php
			
			function sadghsa($txt,$ttl){
			return '<div class="input-group mb-3">
		<span class="input-group-text" id="basic-addon3">'.$ttl.'</span>
		<input type="text" class="form-control" value="'.$txt.'" id="basic-url" aria-describedby="basic-addon3">
		</div>';
			}
			
			
			
			$sqlbn = "SELECT 
			products.product_name,
			products.product_inc_self,
			products.product_inc_ref ,
			products.product_inc_dont ,
			products.product_inc_pltfrm ,
			cart.product_price,
			cart.c_buy_unit,
			cart.c_product_unit,
			cart.c_product_unit_type,
			products.product_sale_price 
			FROM 
			cart 
			LEFT JOIN products
			ON products.id = cart.product_id
			WHERE cart_session = '$token'";
			$resultbn = mysqli_query($con,$sqlbn);
			
			$sprfself = 0;
			$sprfRef = 0;
			$sprfDonet = 0;
			$sprfPlatform = 0;
			
			$sprfselfTtl = 0;
			$sprfRefTtl = 0;
			$sprfDonetTtl = 0;
			$sprfPlatformTtl = 0;
			while($cvb = $resultbn  ->fetch_assoc()){
			
			 $inc_self = $cvb['product_inc_self'];
			 $inc_ref = $cvb['product_inc_ref'];
			 $inc_dont = $cvb['product_inc_dont'];
			 $inc_pltfrm = $cvb['product_inc_pltfrm'];
			 
			$ppurchase_price = $cvb['product_price']; 
			$psale_price = $cvb['product_sale_price'];
			//$pprofit = $psale_price-$ppurchase_price; 
			//$pprofit_mrgn = $pprofit*100/$ppurchase_price;
			$sum_inctv = $inc_self+$inc_ref+$inc_dont+$inc_pltfrm;
			$total_price =  calculatePrice($cvb['c_buy_unit'],$cvb['product_price'],$cvb['c_product_unit']);
			echo sadghsa($cvb['product_name'],'Product Name');
			echo sadghsa($ppurchase_price,'Purchase Unit Price');
			echo sadghsa($cvb['c_buy_unit'],'Units Purchased ('.$cvb['c_product_unit_type'].')');	
			echo sadghsa($total_price.'','Purchased Amount');
		//	echo sadghsa($pprofit,'Profit');
		//	echo sadghsa($pprofit_mrgn.'%','Profit Margin');
			echo sadghsa($sum_inctv.'%','Total Incentive');
			
		
			
		
			
			echo '
			<div class="input-group p-0" >
                  
              <span class="input-group-text">Self</span>
              <input type="text" name="Self" id="Self" value="'.$inc_self.'" aria-label="Self" class="form-control" required="">
              
			   <span class="input-group-text">Refer</span>
              <input type="text" name="Refer" id="Refer" value="'.$inc_ref.'" aria-label="Refer" class="form-control" required="">
              
			   <span class="input-group-text">Donate</span>
              <input type="text" name="Donate" id="Donate" value="'.$inc_dont.'" aria-label="Donate" class="form-control" required="">
              
			   <span class="input-group-text">Platform</span>
              <input type="text" name="Platform" id="Platform" value="'.$inc_pltfrm.'" aria-label="Platform" class="form-control" required="">
				</div>
			';
			
			 //$sprfself = ($pprofit*$inc_self/100);
		//	 $sprfRef = ($pprofit*$inc_ref/100);
			 //$sprfDonet = ($pprofit*$inc_dont/100);
		//	 $sprfPlatform = ($pprofit*$inc_pltfrm/100);
			 
			 	 $sprfself = ($total_price*$inc_self/100);
			 $sprfRef = ($total_price*$inc_ref/100);
			 $sprfDonet = ($total_price*$inc_dont/100);
			 $sprfPlatform = ($total_price*$inc_pltfrm/100);
			 
			
			$sprfselfTtl = $sprfselfTtl+$sprfself;
			$sprfRefTtl = $sprfRefTtl+$sprfRef;
			$sprfDonetTtl = $sprfDonetTtl+$sprfDonet;
			$sprfPlatformTtl = $sprfPlatformTtl+$sprfPlatform;
			$tre = $sprfselfTtl+$sprfRefTtl+$sprfDonetTtl+$sprfPlatformTtl;
			echo '
			<div class="input-group p-0 mt-2" >
                  
              <span class="input-group-text">Self</span>
              <input type="text" name="Self" id="Self" value="'.$sprfself.' TK" aria-label="Self" class="form-control" required="">
              
			   <span class="input-group-text">Refer</span>
              <input type="text" name="Refer" id="Refer" value="'.$sprfRef.' TK" aria-label="Refer" class="form-control" required="">
              
			   <span class="input-group-text">Donate</span>
              <input type="text" name="Donate" id="Donate" value="'.$sprfDonet.' TK" aria-label="Donate" class="form-control" required="">
              
			   <span class="input-group-text">Platform</span>
              <input type="text" name="Platform" id="Platform" value="'.$sprfPlatform.' TK" aria-label="Platform" class="form-control" required="">
				</div>
			';
			
			echo '<hr>';
			
		
			
			
			}
			
            
            $sds = "SELECT user_id,user_name,user_refferred FROM 
	orders LEFT JOIN users ON
	orders.customer_id = users.user_id
	WHERE order_token = '$token'";
	$rsor = mysqli_query($con,$sds);
	while($ordg = $rsor  ->fetch_assoc()){
	$slf_user_id = $ordg['user_id'];
	$slf_user_name = $ordg['user_name'];
	$Ref_user_name = $ordg['user_refferred'];
	}	
		
	$sdsx = "SELECT user_id from users WHERE user_name = '$Ref_user_name'";
	$rsorx = mysqli_query($con,$sdsx);
	while($ordgx = $rsorx  ->fetch_assoc()){
	$Ref_user_id = $ordgx['user_id'];
	}
            
				echo '
	<h4>Total Payable Incentive ('.$tre.' TK)</h4>
	<div class="input-group p-0 mt-2" >
                  
              <span class="input-group-text">'.$slf_user_name.''.$slf_user_id.'</span>
              <input type="text" name="Self" id="Self" value="'.$sprfselfTtl.' TK" aria-label="Self" class="form-control" required="">
              
	   <span class="input-group-text">'.$Ref_user_name.''.$Ref_user_id.'</span>
              <input type="text" name="Refer" id="Refer" value="'.$sprfRefTtl.' TK" aria-label="Refer" class="form-control" required="">
              
	   <span class="input-group-text">Donation</span>
              <input type="text" name="Donate" id="Donate" value="'.$sprfDonetTtl.' TK" aria-label="Donate" class="form-control" required="">
              
	   <span class="input-group-text">Platform</span>
              <input type="text" name="Platform" id="Platform" value="'.$sprfPlatformTtl.' TK" aria-label="Platform" class="form-control" required="">
		</div>
	';
			
		
			
			
			?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
			
					
                    <div class="py-4 sa_order_stats">
                    <div class="row gutters-5 text-center aiz-steps">
                        <div class="col  active ">
                            <div class="icon">
                                <i style="color: #23bf08" class="tx-30 fas fa-dolly-flatbed fa-3x p-2" 
								aria-hidden="true"></i>
                            </div>
                            <div class="tx-secondary title fs-12">Order placed</div>
                        </div>
						
						<div class="col  active ">
                            <div class="icon">
                                <i style="<?php if($order['order_status'] == "Processing"){
                                    echo "color: #23bf08";
                                }else{ echo "color: #8694b3"; } ?>" class="tx-30 fas fa-box-open fa-3x p-2" aria-hidden="true"></i>
                            </div>
                            <div class="tx-secondary title fs-12">Order Processing</div>
                        </div>
						
                        <div class="col active">
                            <div class="icon">
                                <i style="<?php if($order['order_status'] == "On delivery"){
                                    echo "color: #ffa001";
                                }else{ echo "color: #8694b3"; } ?>" class="tx-30 fas fa-dove fa-3x p-2" aria-hidden="true"></i>
                            </div>
                            <div class="title fs-12 text-secondary">On delivery</div>
                        </div>
                        <div class="col active">
                            <div class="icon">
                                <i style="<?php if($order['order_status'] == "Delivered"){
                                    echo "color: #23bf08";
                                }else{ echo "color: #8694b3"; } ?>" class="tx-30 tx-30 fas fa-chalkboard-teacher fa-3x p-2" aria-hidden="true"></i>
                            </div>
                            <div class="title fs-12 text-secondary">Delivered</div>
                        </div>                        
                        <div class="col active">
                            <div class="icon">
                                <i style="<?php if($order['order_status'] == "Canceled"){
                                    echo "color: #f52244";
                                }else{ echo "color: #8694b3"; } ?>" class="tx-30 tx-30 fa fa-times fa-3x p-2" aria-hidden="true"></i>
                            </div>
                            <div class="title fs-12 text-secondary">Canceled</div>
                        </div>                        
                        <div class="col active">
                            <div class="icon">
                                <i style="<?php if($order['order_status'] == "Completed"){
                                    echo "color: #f52244";
                                }else{ echo "color: #8694b3"; } ?>" class="tx-30 tx-30 fab fa-font-awesome-alt fa-3x p-2" aria-hidden="true"></i>
                            </div>
                            <div class="title fs-12 text-secondary">Completed</div>
                        </div>
                    </div>
                    </div>

                    <div class="row">
					
					<div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Payment Status</h4>
                  </div>
                  <div class="card-body">
                   
				   <form action="order-details.php?id=<?=$_GET['id'];?>" method="POST">
                                    <div class="form-group">
                                        <div class="row">
                                            <!-- This input field catch for unique id -->
                                            <input type="hidden" value="<?=$order['id']?>" name="id">


           <div class="col-sm-3 mt-4 mb-4">
                                            <label class="text-dark h6" for="inputState">Paid Amount</label>
                                            <input type="text" value="<?php echo $order['amount_paid'] ?>" class="form-control" name="payment_amnt" />
                                            </div>
                                            
                                            
                                            
                                            
            <div class="col-sm-2 mt-4 mb-4"> 
                                            <label class="text-dark h6" for="inputState">Paid by</label>
                <select id="inputState" class="form-control" name="amount_paid_by">
           <option hidden selected><?php echo $order['amount_paid_by'] ?> </option>
			
                                                <option>Cash</option>
                                                <option>Bkash</option>
                                                <option>Nagad</option>
                                                
                                            </select> 
               
               
               
                                            </div>                                
                                            
                            <div class="col-sm-3 mt-4 mb-4">
        <label class="text-dark h6" for="transactionCode">Transaction/Payment Note</label>
        <input type="text" class="form-control" id="transactionCode" name="transaction_code" value="<?php echo $order['transaction_code'] ?>">
    </div>                


                                            <div class="col-sm-2 mt-4 mb-4">
                                            <label class="text-dark h6" for="inputState">Payment Status</label>
                                            <select id="inputState" class="form-control" name="payment_status">
                                               												<?php if($order['order_status'] == 'Completed') {}else {?>
                                               <option value="0" <?php if($order['user_pay_status'] == 0){echo 'selected';}?>>Unpaid</option>
                                                <option value="1" <?php if($order['user_pay_status'] == 1){echo 'selected';}?>>Paid</option>
                                                <option value="2" <?php if($order['user_pay_status'] == 2){echo 'selected';}?>>Due</option>
												<?php } ?>
                                            </select>
                                            </div>
                                            
                                            
                                            
                                            
                                            
                                            <div class="col-sm-2 mt-4 mb-4">
                                            <label class="text-dark h6" for="inputStatus">Delivery Status</label>
                                            <select id="inputStatus" class="form-control" name="order_status">
                                                <option hidden selected><?=$order['order_status']?></option>
												<?php if($order['order_status'] == 'Completed') {}else {?>
                                                <option>Pending</option>
                                                <option>Processing</option>
                                                <option>On delivery</option>
                                                <option>Delivered</option>
                                                <option>Canceled</option>
												<?php } ?>
                                            </select>
                                            </div>
                                        </div>
                                        </div>
									<?php if($order['order_status'] == 'Completed') {}else {?>	
									<a href="orders" type="submit" class="btn bg-danger text-white">Cancel</a>
                                <button type="submit" value="submit" class="btn btn-success">
                                    Save Change
                                </button>
								<?php if($order['order_status'] == "Delivered"){ ?>
								<button type="submit"  name="MrkCom" class="btn bg-info text-white"><i class="fas fa-check" aria-hidden="true"></i> Mark As Completed</button>	
								<?php } ?>
			<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Simulate Incentive
</button>
								<?php } ?>
									</form>	
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
    
   
        <div class="container-fluid" id="sads" style="display:none;">
        <div class="ticket" id="ticket">
            <p class="centered">
            <img height='45' src="../img/e-bazar-logo.png" alt="Logo"><br>
            <small>
                67/B, ADDL Tower(1st Floor), <br>
                Shankar ,Dhanmondi 1209,<br>
                Phone: +8801767083750<br>
            </small>
            </p>
            
            <p class="centeredX">Date: <?=date('d-m-Y')?>
                <br>Order ID: <?=$order['id']?>
                <br>Name: <?=$order['order_name']?>
                <br>Phone: <?=$order['order_phone']?>
                <br>Address: <?=$order['order_shipping_address']?>
                
                </p>
                
                
    
                
                
          <table style="width: 100%;">
              <thead>
            <tr>
                <th>Sr.</th>
                <th width="40%">Product</th>
                <th>Quantity</th>
                <th>U.Price</th>
                <th>T.Price</th>
            </tr>
              </thead>
              <tbody>
                <?php
  
  $sql = "SELECT * FROM cart WHERE cart_session = '$token'";
  $result = mysqli_query($con,$sql);
  
  
  
                $serial = 0;
                $ttg = 0;
                if($count>0){
                while($product = $result  ->fetch_assoc()){
                  $serial++;
                  $dfsd = $product['product_price']*$product['c_buy_unit'];
                  $ttg += $dfsd;
                  echo '<tr><td class="text-dark">'.$serial.'</td>';
                  
                  echo '<td>'.$product['product_name'].'</td>';
                  
                  echo '<td class="text-center text-dark">'.$product['qty'].'</td>';
                  
                  echo '<td class="text-dark">৳ '.$product['product_price'].'</td>';
                  
                  echo '<td class="text-dark">৳ '.$product['total_price'].'</td><tr>';
                  
                
                }
                
                $payable = $ttg+$ship_amnt; 
                $due  = $payable-$order['amount_paid'];
                
                
                echo '<tr><td style="text-align: right;" class="text-dark" colspan="3"><b>Delivery - </b></td>
                <td style="text-align: right; padding-right:11px" class="text-dark" colspan="2">৳ '.$ship_amnt.'</td></tr>';
                
                echo '<tr><td style="text-align: right;" class="text-dark" colspan="3"><b>Total - </b></td>
                <td style="text-align: right; padding-right:11px" class="text-dark" colspan="2">৳ '.$payable.'</td></tr>';
                
                 echo '<tr><td style="text-align: right;" class="text-dark" colspan="3"><b>Paid - </b></td>
                <td style="text-align: right; padding-right:11px" class="text-dark" colspan="2">৳ '.$order['amount_paid'].'</td></tr>';
                
                 echo '<tr><td style="text-align: right;" class="text-dark" colspan="3"><b>Due - </b></td>
                <td style="text-align: right; padding-right:11px" class="text-dark" colspan="2">৳ '.$due.'</td></tr>';
                
                
                  echo '<tr><td style="text-align: right;" class="text-dark" colspan="3"><b>Paid By  - </b></td>
                <td style="text-align: right; padding-right:11px" class="text-dark" colspan="2">'.$order['amount_paid_by'].'</td></tr>';
                }
                
                
                ?>
                
                
            </tr>
              </tbody>
          </table>     
          
           
                
 <p class="centered">Thanks for your purchase! </br>
 বিক্রয় কৃত পণ্য অফেরতযোগ্য 
                <br>ebazar.com.bd</p>
           
        </div>
        </div>
        

    
				
                    
					<div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Order Details</h4>
                  </div>
                  <div class="card-body bg-gray1">
                   <table id="ordert" class="table table-borderless table-responsive">
                                            <thead>
                                                <tr>
                                                    <th>Sr.</th>
                                                    <th width="40%">Product</th>
                                                    <th>Quantity</th>
                                                    <th>Unit Price</th>
                                                    <th>Total Price</th>
                                                    <th>Refund</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    <?php
													
													$sql = "SELECT * FROM cart WHERE cart_session = '$token'";
													$result = mysqli_query($con,$sql);
													
													
													
                                                    $serial = 0;
                                                    if($count>0){
                                                          while($product = $result  ->fetch_assoc()){
                                                            $serial++;
                                                            
                                                            echo '<tr><td class="text-dark">'.$serial.'</td>';
                                                            
                                                            echo '<td><a style="color: black" href="single_product?id='.$product['product_id'].'" target="_blank">'.$product['product_name'].'</a></td>';
                                                            
                                                            echo '<td class="text-center text-dark">'.$product['qty'].'</td>';
                                                            
                                                            echo '<td class="text-dark">৳ '.$product['product_price'].'</td>';
                                                            
                                                            echo '<td class="text-dark">৳ '.$product['total_price'].'</td>';
                                                            
                                                            echo '<td><button type="submit" class="btn btn-warning btn-sm pointer" onclick="send_refund_request()">Send</button></td></tr>';
                                                          
                                                          }
                                                    }
                                                    
                                                    
                                                    ?>
                                                    
                                                    
                                                </tr>
                                            </tbody>
                                        </table>
                                        
                      <button class="btn btn-info" onclick="printDiv()">Print</button>	                  
                                        
				   
				   </div>
				   
				   
				  
			
				   
                </div>
              </div>	
						
						
						
						
					<div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Order Amount</h4>
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
                                                    <span class="text-italic text-dark"><?php echo $ship_amnt?>.00</span>
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
                                                            <span>৳ <?=$payable?>.00</span>
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