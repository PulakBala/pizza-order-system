<?php
include '../connection.inc.php';

function generateRandomStringx($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$order_status = '';
if(isset($_SESSION['Ord_sa_token'])){
$cart_session = $_SESSION['Ord_sa_token'];	
$bc_query = "SELECT order_status FROM orders  WHERE `order_token` = '$cart_session'";
$bc_cnc = mysqli_fetch_assoc(mysqli_query($con, $bc_query));
$order_status = $bc_cnc['order_status'];
//echo '<script>gen_js_notify("$ordrid - '.$order_status.' ","top","right","9720","","info","fa fa-user-minus","Product being subtracted from stock.")</script>';     
}

if(isset($_POST['ConfirmOrd'])) { 
$Discount = $_POST['Discount'];
$Paymentby = $_POST['Paymentby'];
$paymentNote = $_POST['paymentNote'];
$Given_amnt = $_POST['Given_amnt'];
$ordrid = $_POST['ordrid'];
$OrdPaybleAmnt = $_POST['OrdAmnt'];
$OrdPaybleAmnt = preg_replace("/[^0-9]/", "", $OrdPaybleAmnt);

if($Given_amnt >= $OrdPaybleAmnt){
$PaySts = 1;    
$OrdSts = 'Completed';    
}
else {
$PaySts = 2;  
$OrdSts = 'Completed'; 
}
send_insentive($cart_session,$ordrid);
//echo '<script>gen_js_notify("$Discount - '.$Discount.' ","top","right","9720","","info","fa fa-user-minus","Product being subtracted from stock.")</script>';  
//echo '<script>gen_js_notify("$Paymentby - '.$Paymentby.' ","top","right","9720","","info","fa fa-user-minus","Product being subtracted from stock.")</script>';  
//echo '<script>gen_js_notify("$paymentNote - '.$paymentNote.' ","top","right","9720","","info","fa fa-user-minus","Product being subtracted from stock.")</script>';  
//echo '<script>gen_js_notify("$Given_amnt - '.$Given_amnt.' ","top","right","9720","","info","fa fa-user-minus","Product being subtracted from stock.")</script>';  
//echo '<script>gen_js_notify("$ordrid - '.$ordrid.' ","top","right","9720","","info","fa fa-user-minus","Product being subtracted from stock.")</script>';  
//`amount_paid`, `amount_paid_by`, `amount_paid_note`, `amount_discount`

$item_update_query = "UPDATE orders SET amount_paid ='$OrdPaybleAmnt', amount_paid_by = '$Paymentby' , transaction_code = '$paymentNote' , amount_discount = '$Discount', user_pay_status = '$PaySts', order_status = '$OrdSts' WHERE id = '$ordrid'";
if(mysqli_query($con, $item_update_query)){
 echo '<script>gen_js_notify("Order Marked As Completed","top","right","720","","Success","fa fa-user-plus","Completed")</script>';  
} 

}


if(isset($_POST['quantity_up_form'])) { 
$bc =  $_POST['quantity_up_form'];  
 
$select_query = "SELECT * FROM products WHERE bar_code  = '$bc' OR id  = '$bc' limit 1";
$pdata = mysqli_fetch_array(mysqli_query($con, $select_query)); 

$img  = '<img onerror="this.src="https://img.icons8.com/cotton/64/upload--v1.png";" width="107px" height="122px" src="../upload/product-image/'.$pdata['product_thumbnail_image'].'" alt="current image">';

echo  ' <form method="post">
<div class="row">

<div class="col-6">
 <div class="form-group">
 '.$img .'
<h4>'.$pdata['product_name'].'</h4>


<label class="text-dark h6 mt-4"><h6>Product Stock</h6></label>
 <input type="text" class="form-control" placeholder="Enter product stock Amount" value="'.$pdata['product_stock'].'" name="product_stock" required>
 <input type="hidden" class="form-control" placeholder="" value="'.$pdata['id'].'" name="product_id" required>
   </div><!-- form-group -->
   


    <div class="form-group">
                <label class="text-dark h6 mt-4"><h6>Sale price </h6></label>
                <input  onclick="calc_pr();" onchange="calc_pr();" type="text" class="form-control" placeholder="Product_sale_price" value="'.$pdata['product_sale_price'].'" name="product_sale_price" id="product_sale_price" required>
              </div>
              
              
                 <div class="form-group">
                <label class="text-dark h6 mt-4"><h6>Purchase price <span class="sa_ratio" id="sa_ratio" >Profit Ratio - 0%</span>
                  <span class="sa_ratio" style="background: #3F51B5;" id="sa_net_ratio">Net Ratio - 0%</span></h6></label>
                <input  onclick="calc_pr();" onchange="calc_pr();" type="text" class="form-control" placeholder="Purchase price" value="'.$pdata['product_purchase_price'].'" name="product_purchase_price"  id="product_purchase_price" required>
              </div>
   
   				<div class="form-group" > 
               <label class="text-dark h6 mt-4"><h6>Incentive </h6></label>
              <div class="input-group p-0">
                  
              <span class="input-group-text">Self</span>
              <input onclick="calc_pr();" onchange="calc_pr();" type="number" name="Self" id="Self" value="'.$pdata['product_inc_self'].'" aria-label="Self" class="form-control" required>
              
			   <span class="input-group-text">Refer</span>
              <input onclick="calc_pr();" onchange="calc_pr();" type="number"  name="Refer" id="Refer" value="'.$pdata['product_inc_ref'].'" aria-label="Refer" class="form-control" required>
              
			   <span class="input-group-text">Donate</span>
              <input onclick="calc_pr();" onchange="calc_pr();" type="number"  name="Donate" id="Donate" value="'.$pdata['product_inc_dont'].'" aria-label="Donate" class="form-control" required>
              
			   <span class="input-group-text">Platform</span>
              <input onclick="calc_pr();" onchange="calc_pr();" type="number"  name="Platform" id="Platform" value="'.$pdata['product_inc_pltfrm'].'" aria-label="Platform" class="form-control" required>
             
			  
            </div>
            </div>
   
 <button type="submit" class="hidden-submit btn-success btn">Update</button>
</form>             
</div>
</div>

';
 
}
if(isset($_POST['ResetOrder'])) {
$_SESSION['Ord_sa_token'] = null;
$newX = generateRandomStringx();
$_SESSION['Ord_sa_token'] = $newX;
echo $newX;

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

}

if (isset($_POST['UserPhone'])) {
$Src = $_POST['UserPhone'];
$sql = "SELECT user_phone,user_name FROM users WHERE user_id = '$Src' OR user_phone LIKE '%$Src%' OR user_name LIKE '%$Src%'  limit 6";
$result = mysqli_query($con, $sql);
while($usf = $result->fetch_assoc()){
echo '<option value="'.$usf['user_phone'].'">-- '.$usf['user_name'].'</option>';	
}
}

if (isset($_POST['UpdateUser'])) {
$UpdateUserP = $_POST['UpdateUser'];
$cart_session = $_SESSION['Ord_sa_token'];	
$select_query = "SELECT user_id,user_name FROM users WHERE user_phone = '$UpdateUserP'";
$u_info = mysqli_fetch_assoc(mysqli_query($con, $select_query));	
$uid = $u_info['user_id'];
$uName = $u_info['user_name'];
if(isset($uid)){
$item_update_query = "UPDATE orders SET customer_id ='$uid', order_name = '$uName' WHERE order_token = '$cart_session'";
if(mysqli_query($con, $item_update_query)){
 echo '<script>gen_js_notify("Selected As a customer.","top","right","720","","info","fa fa-user-plus","'.$uName.'")</script>';  
}    
}else {
 echo '<script>gen_js_notify("Invalid Users","top","right","720","","danger","fa fa-user","User Add Faild!")</script>';   
}
 
}


function addStockLog( $sl_prdc_id, $sl_prdc_unit, $sl_type, $sl_prdc_date) {
global $con;
$sql = "INSERT INTO stok_log (sl_prdc_id, sl_prdc_unit, sl_type, sl_prdc_date) VALUES (?, ?, ?, ?)";
if ($stmt = $con->prepare($sql)) {
$stmt->bind_param("iiss", $sl_prdc_id, $sl_prdc_unit, $sl_type, $sl_prdc_date);
if ($stmt->execute()) {
//echo "Data added successfully!";
} else {
//echo "Error: " . $stmt->error;
}
$stmt->close();
} else {
//echo "Error: " . $con->error;
}
}



function cut_stock($product_id,$product_b_unit){
//get product data   
global $con,$ctime;
$product_stock = 0;
$bc_queryx = "SELECT product_stock FROM products  WHERE `id` = '$product_id'";
$bc_qty = mysqli_fetch_assoc(mysqli_query($con, $bc_queryx));
$product_stock = $bc_qty['product_stock'];

if($product_stock != 0){
if($product_stock >= $product_b_unit){
$product_New_stock = bcsub($product_stock,$product_b_unit,2) ;
 
$item_update_query = "UPDATE products SET product_stock ='$product_New_stock' WHERE id = '$product_id'";
if(mysqli_query($con, $item_update_query)){
echo '<script>gen_js_notify("New Stock - '.$product_New_stock.'","top","right","720","","info","fa fa-user-minus","Product being subtracted from stock.")</script>';  
addStockLog($product_id,$product_b_unit, '-',$ctime);
}
} 
return true;
}else {
 return false;   
}
}

function return_stock($product_id,$product_b_unit){
//get product data   
global $con,$ctime;
$product_stock = 0;
$bc_queryx = "SELECT product_stock FROM products  WHERE `id` = '$product_id'";
$bc_qty = mysqli_fetch_assoc(mysqli_query($con, $bc_queryx));
$product_stock = $bc_qty['product_stock'];

$product_New_stock = bcadd($product_stock,$product_b_unit,2) ;
 
$item_update_query = "UPDATE products SET product_stock ='$product_New_stock' WHERE id = '$product_id'";
if(mysqli_query($con, $item_update_query)){
echo '<script>gen_js_notify("New Stock - '.$product_New_stock.'","top","right","720","","info","fa fa-user-minus","Product being Return To stock.")</script>';  
addStockLog($product_id,$product_b_unit, '+',$ctime);
return true;
}else{return false;}
}

if (isset($_POST['RemoveFrmCrt'])) {
if($order_status != 'Completed'){     
$CartItmID = $_POST['RemoveFrmCrt'];
$cart_session = $_SESSION['Ord_sa_token'];	

// return cart item
$bc_queryxx = "SELECT c_buy_unit,product_id FROM cart  WHERE `id` = '$CartItmID'";
$bc_qtyx = mysqli_fetch_assoc(mysqli_query($con, $bc_queryxx));
$c_buy_unit = $bc_qtyx['c_buy_unit'];
$product_id = $bc_qtyx['product_id'];
if(return_stock($product_id,$c_buy_unit)){}  
//echo '<script>gen_js_notify("Items in the cart are being deleted","top","right","9720","","danger","fa fa-trash","'.$bc_queryxx.' - '.$c_buy_unit.'")</script>'; 


$bc_queryx = "DELETE FROM cart  WHERE `id` = '$CartItmID' AND cart_session = '$cart_session'";
if(mysqli_query($con, $bc_queryx)){
echo '<script>gen_js_notify("Items in the cart are being deleted","top","right","720","","danger","fa fa-trash","Cart Item Deleted")</script>';  
}

}else {echo '<script>gen_js_notify("Order Already Completed.","top","right","720","","danger","fa fa-plus","Warning")</script>';}
} 






if (isset($_POST['AddToPCart'])) { 
if($order_status != 'Completed'){    
$pid = $_POST['AddToPCart'];
$cart_session = $_SESSION['Ord_sa_token'];
// iten in cart alrdy  is exixst //
$bc_query = "SELECT count(id) as id FROM cart  WHERE `product_id` = '$pid' AND cart_session = '$cart_session'";
$bc_cnc = mysqli_fetch_assoc(mysqli_query($con, $bc_query));	

/// GEt Prduct Information
$select_query = "SELECT * FROM products WHERE id = '$pid'";
$product_info = mysqli_fetch_assoc(mysqli_query($con, $select_query));	
$pid = $product_info['id'];
$pname = $product_info['product_name'];	
$pprice = $product_info['product_sale_price'];	
$p_pr_price = $product_info['product_purchase_price'];	
$pimage = $product_info['product_thumbnail_image'];	
$pqty = 1;	
$total_price = $product_info['product_sale_price'];	
$pcode = $product_info['product_code'];	
$product_unit = $product_info['product_unit'];	
$nit_typ = $product_info['product_unit_typ'];

//$dsfjh = $bc_cnc['id'];


$product_New_stock = 0;
if(cut_stock($pid,$product_unit)){
if($bc_cnc['id'] > 0){
//echo $bc_cn['id'];
//get qty 
$bc_queryx = "SELECT c_buy_unit,qty,c_product_unit,product_price FROM cart  WHERE `product_id` = '$pid' AND cart_session = '$cart_session'  ";
$bc_qty = mysqli_fetch_assoc(mysqli_query($con, $bc_queryx));
$bcByu = $bc_qty['c_buy_unit'];
$bqty = $bc_qty['qty'];
$bc_product_unit = $bc_qty['c_product_unit'];
$bc_product_price = $bc_qty['product_price'];

$bqNew = (float)$bqty+1;	
$bqNewUnitPur = (float)$bc_product_unit*$bqNew;	
$ctp = $bqNewUnitPur/$bc_product_unit*$bc_product_price;
$item_update_query = "UPDATE cart SET c_buy_unit ='$bqNewUnitPur' , qty ='$bqNew' , total_price = '$ctp' WHERE product_id = '$pid' AND cart_session = '$cart_session'";
if(mysqli_query($con, $item_update_query)){
echo '<script>gen_js_notify("'.$pname.' Quantity updated.","top","right","720","","info","fas fa-box-open","'.$pname.'")</script>';  
}	
}else {
$insert_product_query = "INSERT INTO cart (
cart_session,product_id,product_name,product_price,product_purchase_price,product_image,qty,total_price,product_code,c_product_unit,c_buy_unit,c_product_unit_type)
VALUES ('$cart_session','$pid','$pname','$pprice','$p_pr_price','$pimage','$pqty','$total_price','$pcode','$product_unit','$product_unit','$nit_typ')";
if(mysqli_query($con, $insert_product_query)){
 echo '<script>gen_js_notify("Item Added","top","right","720","","success","fa fa-plus","'.$pname.'")</script>';   
}
}    
}else {
     echo '<script>gen_js_notify("Out Of Stock","top","right","720","","danger","fa fa-plus","Stock: '.$product_New_stock.'")</script>';
}
}else {echo '<script>gen_js_notify("Order Already Completed.","top","right","720","","danger","fa fa-plus","Warning")</script>';}
    
}


if (isset($_POST['RefreashCash'])) { 
$cart_session = $_SESSION['Ord_sa_token'];

/// get order info 
$bc_queryx = "SELECT * 
FROM 
orders 
LEFT JOIN users 
on users.user_id = orders.customer_id
WHERE order_token = '$cart_session'";
$bc_qty = mysqli_fetch_assoc(mysqli_query($con, $bc_queryx));


//get cart info 
$sql = "SELECT product_id,c_buy_unit,product_name,id ,qty,product_price,c_product_unit,c_product_unit_type,total_price FROM 
cart WHERE cart_session = '$cart_session'";
$result = mysqli_query($con,$sql);
$cntIt = mysqli_num_rows($result);
$tm = 0;
while($product = $result  ->fetch_assoc()){
$tm += (float)$product['c_buy_unit'] / (float)$product['c_product_unit']*(float)$product['product_price'];

}

$get_balance = get_balance($bc_qty['user_id'],'all');
echo '<tr class="">
                          <td>Customer ID: </td>
                          <td>'.$bc_qty['customer_id'].'</td>
                        </tr>
						<tr class=""  style="display:none;">
                          <td>Order ID: </td>
                          <td id="ordid">'.$bc_qty['id'].'</td>
                          <td style="display:none;" id="ordItm">'.$cntIt.'</td>
                        </tr>
                        <tr class="">
                          <td>Customer Name: </td>
                          <td id="OrdUserName">'.$bc_qty['user_name'].'</td>
                        </tr>
						<tr class="" style="display:none;">
                          <td>Customer Phone: </td>
                          <td>'.$bc_qty['user_phone'].'</td>
                        </tr>
						<tr class="">
                          <td>Customer Balance: </td>
                          <td id="OrdUserBlnc">'.$get_balance.' .TK</td>
                        </tr>
                        <tr class="">
                          <td>Cart Amount: </td>
                          <td id="OrdAmnt">'.$tm.' .TK</td>
                        </tr>
                        <tr>
                          <td>VAT+</td>
                          <td>00.00</td>
                        </tr>
                        <tr class="">
                          <td>Discount: </td>
                          <td><input type="text" id="Discount" name="Discount" value="0" class="form-control Discount px-1 py-1 text-center"  ></td>
                        </tr>
						<tr class="">
                          <td>Paid By: </td>
                          <td>
						  
						  <select id="inputState" class="form-control px-1 py-1" name="amount_paid_by">
						  <option value="">Select</option>
					    <option value="cash">Cash</option>
                         <option value="bkash">Bkash</option>
                        <option value="nagad">Nagad</option>
                        <option value="bank">Bank</option>
                        </select>
                        
                        <input type="text" name="paymentNote" class="form-control px-1 py-1" placeholder="Payments Details"  ID="paymentNote" style="display:none;"/>
                        
											</td>
                        </tr>
						<tr class="">
                          <td>Given Amount: </td>
                          <td>
						  <input type="text" id="Given_amnt" name="Given_amnt" value="0" class="form-control Given_amnt px-1 py-1 text-center"  >
						  <input type="hidden" id="paybl_amnt" name="paybl_amnt" value="'.$tm.'" class="form-control paybl_amnt px-1 py-1 text-center"  >
						  </td>
                        </tr>
						<tr class="">
                          <td>Change: </td>
                          <td id="amChange">00.00</td>
                        </tr>
                        <tr class="table-info">
                          <td>Total Paid: </td>
                          <td>00.00</td>
                        </tr>
						<tr class="table-danger">
                          <td>Due: </td>
                          <td>00.00</td>
                        </tr>
                        
        <div class="container-fluid" id="sads" style="display:nogfne;">
        <div class="ticket" id="ticket">
        
         <p class="centered">
            <img height=\'45\' src="../img/e-bazar-logo.png" alt="Logo"><br>
        
            </p>
           </div>
        </div>';
        
                        
                        
}
if (isset($_POST['RefreashCart'])) { 
//echo $cart_session = $_SESSION['Ord_sa_token'];

$token = $_SESSION['Ord_sa_token'];
        	
        	$sql = "SELECT product_id,c_buy_unit,product_name,id ,qty,product_price,c_product_unit,c_product_unit_type,total_price FROM cart WHERE cart_session = '$token'";
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
                 $tm = 0;
                 if($count>0){
					 
				
                       while($product = $result  ->fetch_assoc()){
                         $serial++;
                         $tm += (float)$product['c_buy_unit'] / (float)$product['c_product_unit']*(float)$product['product_price'];
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
                    
                          echo '<td class="text-dark"><input type="text" id="total_price" name="total_price" value="'.$product['total_price'].'.TK" aria-label="Refer" class="form-control  px-1 py-1 text-center" readonly required=""></td>';
                          
                         
                         
                           echo '<input type="hidden" id="c_id" name="c_id" value="'.$product['id'].'" aria-label="c_id" class="form-control  px-1 py-1 text-center" required="">';
                         
                         
                           echo '<td>
						 <button type="button"  value="'.$product['id'].'"  class="px-2 py-1 btn btn-success btn-sm  ord_edt_btn"><i class="fa fa-edit"></i></button>
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
}


if (isset($_POST['barcode'])) { 
if($order_status != 'Completed'){     
$str = $_POST['barcode'];
$cart_session = $_SESSION['Ord_sa_token'];
$search = htmlentities($_POST['barcode']);  
 // bar code is exixst //
$bc_query = "SELECT count(id) as id FROM products  WHERE (`bar_code` = '$search'  AND bar_code != '') or  id = '$search'";
$bc_cn = mysqli_fetch_assoc(mysqli_query($con, $bc_query));	

//$shg = $bc_cn['id'];

if($bc_cn['id'] > 0){
//echo $bc_cn['id'];
$select_query = "SELECT * FROM products WHERE bar_code = '$search' or id = '$search'";
$product_info = mysqli_fetch_assoc(mysqli_query($con, $select_query));	
$pid = $product_info['id'];
$pname = $product_info['product_name'];	
$pprice = $product_info['product_sale_price'];	
$p_pr_price = $product_info['product_purchase_price'];	
$pimage = $product_info['product_thumbnail_image'];	
$pqty = 1;	
$total_price = $product_info['product_sale_price'];	
$pcode = $product_info['product_code'];	
$product_unit = $product_info['product_unit'];	
$nit_typ = $product_info['product_unit_typ'];	
	
// iten in cart alrdy  is exixst //
$bc_queryx = "SELECT count(id) as id FROM cart  WHERE `product_id` = '$pid' AND cart_session = '$cart_session'  ";
$bc_cnc = mysqli_fetch_assoc(mysqli_query($con, $bc_queryx));

		
if($bc_cnc['id'] > 0){
 
if(cut_stock($pid,1)){
 //get qty 
$bc_queryx = "SELECT c_buy_unit,qty FROM cart  WHERE `product_id` = '$pid' AND cart_session = '$cart_session'  ";
$bc_qty = mysqli_fetch_assoc(mysqli_query($con, $bc_queryx));
$bqty = $bc_qty['c_buy_unit'];	
$qty = $bc_qty['qty'];	
//echo $bc_cn['id'];	
$bqty = (float)$qty+1;	
$bqtyUnit = (float)$bqty*$product_unit;	
$ctp = $bqty*$pprice;	
$item_update_query = "UPDATE cart SET c_buy_unit ='$bqtyUnit' ,qty ='$bqty' , total_price = '$ctp' WHERE product_id = '$pid' AND cart_session = '$cart_session'";
if(mysqli_query($con, $item_update_query)){	
echo '<script>gen_js_notify("'.$pname.' Quantity updated.","top","right","720","","info","fas fa-box-open","'.$pname.'")</script>';   
} 


}else {echo '<script>gen_js_notify("Out Of Stock","top","right","720","","danger","fa fa-plus","Not found")</script>';}
}else {


if(cut_stock($pid,$product_unit)){
$insert_product_query = "INSERT INTO cart (
cart_session,product_id,product_name,product_price,product_purchase_price,product_image,qty,total_price,product_code,c_product_unit,c_buy_unit,c_product_unit_type)
VALUES ('$cart_session','$pid','$pname','$pprice','$p_pr_price','$pimage','$pqty','$total_price','$pcode','$product_unit','$product_unit','$nit_typ')";
if(mysqli_query($con, $insert_product_query)){
echo '<script>gen_js_notify("Item Added","top","right","720","","success","fa fa-plus","'.$pname.'")</script>';      
} 

}else {echo '<script>gen_js_notify("Out Of Stock","top","right","720","","danger","fa fa-plus","Not found")</script>';}
}	

echo '<script>document.getElementById("product_name").value = "";</script>';
}   
}else {echo '<script>gen_js_notify("Order Already Completed.","top","right","720","","danger","fa fa-plus","Warning")</script>';}
}



if (isset($_POST['ord_edt_btn'])) { 
if($order_status != 'Completed'){       
$str = $_POST['ord_edt_btn'];
$c_buy_unit_price = $_POST['c_buy_unit_price'];
$c_product_unit = $_POST['c_product_unit'];
$ord_buy_unit = $_POST['ord_edt_buy_unit'];
$cart_session = $_SESSION['Ord_sa_token'];

$total_price = $c_buy_unit_price*$ord_buy_unit;

$unit_weight = $c_product_unit; // in grams
$unit_price = $c_buy_unit_price; // in taka

// New weight
$new_weight = $ord_buy_unit; // in grams

// Calculate the price for the new weight
$new_price = ($unit_price / $unit_weight) * $new_weight;

/// get product id from cart 
$bc_queryx = "SELECT product_id,c_buy_unit FROM cart  WHERE `id` = '$str'";
$bc_qty = mysqli_fetch_assoc(mysqli_query($con, $bc_queryx));
$product_id= $bc_qty['product_id'];
$Oldc_buy_unit= $bc_qty['c_buy_unit'];

$newc_buy_unit = bcsub($ord_buy_unit,$Oldc_buy_unit);


$sql = "SELECT product_stock FROM products WHERE id = '$product_id'";
$result = mysqli_fetch_assoc(mysqli_query($con,$sql));
$cntproduct_stock = $result['product_stock'];



//echo '<script>gen_js_notify(" Stock:'.$cntproduct_stock .'  Old Unit:'.$Oldc_buy_unit .'  New Unit:'.$newc_buy_unit .'  Stock:'.$cntproduct_stock .' ","top","right","9720","","secondary","fas fa-check-double","'.$ord_buy_unit .'")</script>';  

if(cut_stock($product_id,$newc_buy_unit)){

if($cntproduct_stock >= $newc_buy_unit){
      // Update query
    $query = "UPDATE cart SET 
              qty = ?, 
              c_buy_unit =?,
              total_price = ?
              WHERE id = ?";

    // Prepare statement
    if ($stmt = $con->prepare($query)) {
        // Bind parameters
        $stmt->bind_param("sssi", $ord_buy_unit,$ord_buy_unit, $new_price, $str);
        
        // Execute the statement
        if ($stmt->execute()) {
            //$sa_nfy = "Updated successfully!";
            echo '<script>gen_js_notify("Updated to '.$ord_buy_unit.'","top","right","720","","secondary","fas fa-check-double","Quantity updated")</script>';  
        } else {
            //echo "Error updating record: " . $con->error;
        }
        
        // Close the statement
        //$stmt->close();
    } else {
        //echo "Error preparing statement: " . $con->error;
    }  
}   
}else { echo '<script>gen_js_notify("Out Of Stock!","top","right","720","","danger","fas fa-check-double","Out Of Stock!")</script>';    } 

}else {echo '<script>gen_js_notify("Order Already Completed.","top","right","720","","danger","fa fa-plus","Warning")</script>';}
}

if (isset($_POST['str'])) { 
$str = $_POST['str'];
$cart_session = $_SESSION['Ord_sa_token'];
$search = htmlentities($_POST['str']);
 $select_query = "SELECT * FROM products  WHERE `product_name` LIKE '%$search%' OR `product_brand` 
			LIKE '%$search%' OR `id` LIKE '%$search%' 
			OR `product_meta_title` LIKE '%$search%' 
			OR `bar_code` LIKE '%$search%' ORDER BY id DESC limit 5";
$product_info_from_db = mysqli_query($con, $select_query);			





                  $serial_no = 1;
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
 }?>

