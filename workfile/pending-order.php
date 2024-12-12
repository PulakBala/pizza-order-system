<?php
$page_ttl = 'Pending Order';
$page_dsc = 'Pending Order List';
$thmblink = '<div class="ms-md-auto py-2 py-md-0"><a href="index.php" class="btn btn-label-info btn-round me-2">Dashboard</a></div>';
require('header.php');
$select_query = "SELECT * FROM orders WHERE order_status = 'Pending'";
$select_pending_order_info = mysqli_query($con, $select_query);

 ?>
  <body>
    <div class="wrapper">
 
<?php require('sidebar.php') ?> 

      <div class="main-panel">
<?php require('main-header.php') ?>  
        <div class="container">
          <div class="page-inner">
  <?php echo dsb_brd($page_ttl,$page_dsc,$thmblink)?>


<div class="row row-card-no-pd">

<div class="col-sm-6 col-md-6">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-5">
                        <div class="icon-big text-center">
                          <i class="icon-hourglass  text-warning"></i>
                        </div>
                      </div>
                      <div class="col-7 col-stats">
                        <div class="numbers">
                          <p class="card-category">Pending Orders</p>
                          <h4 class="card-title"><?= $select_pending_order_info->num_rows ?> </h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-6 col-md-6">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-5">
                        <div class="icon-big text-center">
                          <i class="icon-wallet text-success"></i>
                        </div>
                      </div>
                      <div class="col-7 col-stats">
                        <div class="numbers">
                          <p class="card-category">Update info </p>
                          <h4 class="card-title">0</h4>
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
                   
				   <table class="table table-bordered text-center">
        

            <thead class="bg-primary">
                <tr>
                    <th class="text-center" scope="row">Order ID</th>
                    <th class="text-center" scope="row">Customer ID</th>
                    <th class="text-center" scope="row">Customer Name</th>
                    <th class="text-center" scope="col">Phone Number</th>
                    <th class="text-center" scope="col">Email Address</th>
                    <th class="text-center" scope="col">Order Details</th>
                    <th class="text-center" scope="col">Payment Status</th>
                    <th class="text-center" scope="col">Status</th>
                </tr>
            </thead>
            <tbody>

                <?php
                  while($order_info = $select_pending_order_info  ->fetch_assoc()){
                      
                      $customer_id = $order_info['customer_id'];
                      $query_customer = "SELECT * FROM `users` WHERE `user_id` = '$customer_id'";
                      $result_customer = mysqli_query($con,$query_customer);
                      $customer = mysqli_fetch_assoc($result_customer);
                      $cus_name = $customer['user_name'];
                      $cus_phone = $customer['user_phone'];
                      $cus_email = $customer['user_email'];

                    ?>
                      <tr>
                        <td class="text-dark"><?=$order_info['id']?></td>
                        <td id ="customer_id" class="text-dark"><?=$order_info['customer_id']?></td>
                        <td scope="row" class="text-dark"><?=$cus_name?></td>
                        <td class="text-dark"><?=$cus_phone?></td>
                        <td class="text-dark"><?=$cus_email?></td>
                        <td>
                          <a name="id" class="btn btn-sm btn-outline-info" href="order-details?id=<?=$order_info['id']?>">Order Details</a>
                        </td>
                        <td>
                          <!-- This colom make payment status paid or unpaid -->
                          <?php
                            if($order_info['user_pay_status'] == 0){

                              echo '<a class="badge badge-danger p-2 mt-2" href="#">Upaid</a>
                          </td>
                            ';
                          }
                          else{

                          echo '<a class="badge badge-success p-2 mt-2" href="#">Paid</a>
                          </td>
                              ';
                            }
                          ?>
                        <td>
                            <?php
                              if($order_info['order_status'] === "Pending"){
                                echo '<a class="badge badge-danger p-2 mt-2" href="#"> Pending </a>';
                                  
                              }
                              elseif($order_info['order_status'] === "On delivery")
                                {
                                echo '<a class="badge badge-warning text-white p-2 mt-2" href="#"> On delivery </a>';
                                  
                              }
                              elseif($order_info['order_status'] === "Delivered")
                                {
                                echo '<a class="badge badge-success p-2 mt-2" href="#"> Delivered </a>';
                                  
                              }elseif($order_info['order_status'] === "Canceled")
                                {
                                echo '<a class="badge badge-danger text-white p-2 mt-2"> Canceled </a>';
                                  
                              }
                            ?>
                        </td>
                      </tr>

                    <?php
                  }
                ?>
                
            </tbody>
        </table>

        <!-- Show Bootstrap Modal page Start -->
        <!-- Always try to place a modal's HTML code in a top-level position in your document to avoid other components affecting the modal's appearance and/or functionality. -->


        <!-- Show Bootstrap Modal page End -->

      </div><!-- sl-pagebody -->
    
				   </div>
                </div>
              </div>


		
            
           </div>
          </div>
        </div>

<?php //require('footer.php') ?> 