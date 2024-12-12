<?php
$page_ttl = 'Today Order';
$page_dsc = 'Completed Order List';
$thmblink = '<div class="ms-md-auto py-2 py-md-0"><a href="index.php" class="btn btn-label-info btn-round me-2">Dashboard</a></div>';
require('header.php');


//order_date BETWEEN '2024-09-22' AND '2024-09-25'; st_date end_date
if(ISSET($_POST['st_date']) AND ISSET($_POST['end_date'])){
$st_date = $_POST['st_date'];	
$end_date = $_POST['end_date'];	
$select_query = "SELECT * FROM orders WHERE order_status = 'Completed' AND order_date BETWEEN '{$st_date}' AND '{$end_date}'";
$select_confirm_order_info = mysqli_query($con, $select_query);
	
}else {
$select_query = "SELECT * FROM orders WHERE order_status = 'Completed' AND MONTH(order_date) = MONTH(CURRENT_DATE) AND YEAR(order_date) = YEAR(CURRENT_DATE);";
$select_confirm_order_info = mysqli_query($con, $select_query);
	
}










 ?>
 
 <style>
 .wrapper {
    overflow: auto;
}
.table>tbody>tr>td, .table>tbody>tr>th {
    padding: 8px 5px !important;
}
 </style>
  <body>
    <div class="wrapper">
 
<?php require('sidebar.php') ?> 

      <div class="main-panel">
<?php require('main-header.php') ?>  
        <div class="container">
          <div class="page-inner">
  <?php echo dsb_brd($page_ttl,$page_dsc,$thmblink)?>





<div class="row">
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div class="icon-big text-center icon-primary bubble-shadow-small">
                          <i class="icon-energy"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Today Collection</p>
                          <h4 class="card-title"><?=Ord_Sum_Count('TodayOrder')?> .TK</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div class="icon-big text-center icon-info bubble-shadow-small">
                         <i class="icon-pie-chart"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Monthly Orders</p>
                          <h4 class="card-title"><?=Ord_Sum_Count('ThisMonth')?> .TK</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
			  <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div class="icon-big text-center icon-secondary bubble-shadow-small">
                          <i class="icon-calculator"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Previous Month</p>
                          <h4 class="card-title"><?=Ord_Sum_Count('PrevMonth')?> .TK</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div class="icon-big text-center icon-success bubble-shadow-small">
                          <i class="fas fa-luggage-cart"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">This Year</p>
                          <h4 class="card-title"><?=Ord_Sum_Count('ThisYear')?></h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
            </div>





<div class="row">
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div class="icon-big text-center icon-primary bubble-shadow-small">
                          <i class="fas fa-users"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Today Orders</p>
                          <h4 class="card-title"><?=ord_count('TodayOrder')?></h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div class="icon-big text-center icon-info bubble-shadow-small">
                          <i class="fas fa-user-check"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Monthly Orders</p>
                          <h4 class="card-title"><?=ord_count('ThisMonth')?></h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
			  <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div class="icon-big text-center icon-secondary bubble-shadow-small">
                          <i class="far fa-check-circle"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Previous Month</p>
                          <h4 class="card-title"><?=ord_count('PrevMonth')?></h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div class="icon-big text-center icon-success bubble-shadow-small">
                          <i class="fas fa-luggage-cart"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">This Year</p>
                          <h4 class="card-title"><?=ord_count('ThisYear')?></h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
            </div>

	

<div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Order List</h4>
		
                  </div>
                  <div class="card-body">
				  
				
					<div class="form-group mb-4"> 
          <form method="post" class="pull-right w-50 mb-4"> 
              <div class="input-group p-0">
                  
              <span class="input-group-text">From</span>
              
              <input type="date" autofocus="" id="st_date" name="st_date" value="<?php if(ISSET($st_date)){echo $st_date;}?>"  aria-label="st_date" 
			  class="form-control" required="">
			 
			  
           
			  <span class="input-group-text">To</span>
              <input type="date" id="end_date" name="end_date"  value="<?php if(ISSET($end_date)){echo $end_date;}?>"  class="form-control" required="">
			  
			 
              <button type="submit" style="max-width: 80px;" class="form-control btn btn-info"><i class="fa fa-search"></i></button>
			 
			  
            </div>
            </form>    
            </div>			  
				  
				  
				      <table class="table table-bordered text-center">
          


            <thead class="bg-primary">
                <tr>
                    <th class="text-center" scope="row">Order ID</th>
                    <th class="text-center" scope="row">Date</th>
                    <th class="text-center" scope="row">Customer ID</th>
                    <th class="text-center" scope="row">Customer Name</th>
                    <th class="text-center bg-info text-white" scope="col">Amount</th>
                    <th class="text-center bg-secondary  text-white" scope="col">F.Amount</th>
                    <th class="text-center bg-success  text-white" scope="col">Profit</th>
                    <th class="text-center" scope="col">Payment Status</th>
                    <th class="text-center" scope="col">Status</th>
                    <th class="text-center" scope="col">Order Details</th>
                </tr>
            </thead>
            <tbody>

                <?php
				
				$inTotal = 0;
				$inTotalWdlv = 0;
				
                  foreach($select_confirm_order_info as $order_info){
                      
                      $customer_id = $order_info['customer_id'];
                      $query_customer = "SELECT * FROM `users` WHERE `user_id` = '$customer_id'";
                      $result_customer = mysqli_query($con,$query_customer);
                      $customer = mysqli_fetch_assoc($result_customer);
					  $cus_name = $customer['user_name'];
                      $cus_phone = $customer['user_phone'];
                      $cus_email = $customer['user_email'];
					  
					  
					  $TotalAmnt = 0;
					  $order_tkn =  $order_info['order_token'];	

						$select_query = "SELECT product_price,qty,product_purchase_price  FROM cart WHERE cart_session = '{$order_tkn}'";
						$ss = mysqli_query($con, $select_query);
						foreach($ss as $cin){
						$TotalAmnt +=  $cin['product_price']*$cin['qty'];	;	
						$profit = $cin['product_price']-$cin['product_purchase_price'];
						}
						$inTotal += $TotalAmnt;
											  
					     if($order_info['user_pay_status'] == 0){
                                $bgg1 = '<a class="badge badge-danger p-2 text-white">upaid</a>';
                          }else{
                              $bgg1 = '<a class="badge badge-success p-2  text-white">Paid</a>';}
                          
                          if($order_info['shipping_area'] == 'PickDhanmondi'){
                          $bgg = '<a class="badge badge-info p-2 ms-1  text-white">'.$order_info['shipping_area'].'</a>';
                          $dvAm = 0;
                          }elseif($order_info['shipping_area'] == 'Inside Dhaka'){ 
                           $bgg = '<a class="badge badge-warning p-2 ms-1  text-white">'.$order_info['shipping_area'].'</a>';   
                           $dvAm = 50;
                          }else {
                             $bgg = '<a class="badge badge-warning p-2 ms-1  text-white">'.$order_info['shipping_area'].'</a>';   
                           $dvAm = 120;  
                          }
                            
                            $inTotalWdlv += $TotalAmnt;
                            $inTotalWdlv += $dvAm;
                            $Tprofit += $profit; 
                    ?>
                      <tr>
                        <td id ="customer_id" class="text-dark p-0"><?=$order_info['id']?></td>
                        <td id ="customer_id" class="text-dark p-0 text-left"><?=$order_info['order_date']?></td>
                        <td id ="customer_id" class="text-dark p-0"><?=$order_info['customer_id']?></td>
                        <td scope="row" class="text-dark p-0"><?=$cus_name?></td>
                        <td class="text-dark p-0 bg-info text-white"><?=$TotalAmnt?> .TK</td>
                        <td class="text-dark p-0 bg-secondary   text-white"><?=$TotalAmnt+$dvAm?> .TK</td>
                        <td class="text-dark p-0 bg-success  text-white">+<?=$profit?> .TK</td>
                        
						<td class="text-dark p-0"><?php echo $bgg1?><?php echo $bgg?></td>
						
                        <td class="text-dark p-0"><a class="badge badge-success p-2 ms-1  text-white"><?=$order_info['order_status']?></a></td>
						
                        <td class="text-dark p-0">
						<a name="id" class="badge badge-sm bg-primary text-white  p-2" href="order-details?id=<?=$order_info['id']?>">Order Details</a>
						</td>
                      </tr>
					  
					  
					   
                    <?php
                  }
				  
				  
				  
                ?>
				
				<tr>
                        <td class="text-dark p-0" colspan= "4">
                        <td class="text-dark p-0 bg-info text-white" ><?=$inTotal?> .TK</td>
                        <td class="text-dark p-0 bg-secondary text-white" ><?=$inTotalWdlv?> .TK</td>
                        <td class="text-dark p-0 bg-success text-white" ><?=$Tprofit?> .TK</td>
                        <td class="text-dark p-0 bg- text-white" colspan= "3"></td>
                      </tr>
                
            </tbody>
        </table>

      </div><!-- sl-pagebody -->
      

					</div>
    
				  
				  
                  </div><!-- sl-pagebody -->
    
				   </div>
                </div>
              </div>


		
            
           </div>
          </div>
        </div>

<?php require('footer.php') ?> 