<?php
$page_ttl = 'Add User';
$page_dsc = 'Add New User Or Customer';
$thmblink = '<div class="ms-md-auto py-2 py-md-0"><a href="index.php" class="btn btn-label-info btn-round me-2">Dashboard</a></div>';
require('header.php');


 ?>
  <body>
    <div class="wrapper">
 
<?php require('sidebar.php') ?> 

      <div class="main-panel">
<?php require('main-header.php') ?>  
        <div class="container">
          <div class="page-inner">
  <?php echo dsb_brd($page_ttl,$page_dsc,$thmblink)?>


			
			
		<div class="card col-6">
                  <div class="card-header">
                    <h4 class="card-title">Information</h4>
                  </div>
                  <div class="card-body">	
				  
				  

		

			<div class="row">
			<div class="col-12">
			<div class="checkoutbox">
				<div class="contacta">
					<div class="bildet myfont">
					<form action="" method="POST">					
						      	<div class="page-content">     
						        	<div class="account-login">
						            		<div class="bildet myfont">
			
			<?php
			if(isset($_POST['name'])){
			$name = get_safe_value($con,htmlspecialchars($_POST['name']));
			$Phone = get_safe_value($con,htmlspecialchars($_POST['Phone']));
			$Email = get_safe_value($con,htmlspecialchars($_POST['Email']));
			$password = get_safe_value($con,htmlspecialchars($_POST['password']));
			$Type = get_safe_value($con,htmlspecialchars($_POST['type']));
			$lvl = 0;
			if($Type == 'customer'){$lvl = 0;}
			if($Type == 'product-manager'){$lvl = 2;}
			if($Type == 'order-manager'){$lvl = 3;}
			if($Type == 'admin'){$lvl = 1;}
			
			$passwordX = sha1($password);
			$user_join_date = date("Y-m-d");
			$day = date('d');
			$year = date('Y');
			$month =  date('m');
			
			//check Phone
			$sql = "SELECT user_id FROM users where user_phone = '$Phone'";
			$result = mysqli_query($con,$sql);
			$count = mysqli_num_rows($result);
			
			//check User ID
			$name = get_safe_value($con,htmlspecialchars($_POST['name']));
			$clean_name = preg_replace('/\\s+/', "-", trim(preg_replace('/[^A-Za-z0-9]/', " ", $name)));
			$sqln = "SELECT user_id FROM users where user_name = '$clean_name'";
			$resultn = mysqli_query($con,$sqln);
			$countn = mysqli_num_rows($resultn);
			if($countn > 0){$clean_name = $clean_name.rand(000,999);}
			
			if($count > 0){
				echo alert($sa_nfy = "এই নাম্বারে আগে থেকে একাউন্ট করা রয়েছে",'danger');
			}else {
				
	 	  $insertusert = "INSERT INTO 
			users (`user_full_name`, `user_name`, `user_email`, `user_email_ver`, `user_photo`, `user_password`, `user_country`, `user_phone`, `user_join_date`, `user_join_day`, `user_join_month`, 
			`user_join_year`, `user_level`, `user_type`, `user_refferred`, `account_status`, `user_rank`, `user_code`, `user_token`)
			 VALUES ('$name','$clean_name','$Email','','',  '$passwordX',  '','$Phone', '$user_join_date','$day','$month','$year', '$lvl', '$Type', 'eBazar',  '1', '0', '0', '')";
				if(mysqli_query($con,$insertusert)){
				echo alert($sa_nfy = "একাউন্ট ক্রিয়েট হয়েছে");	
				
				
				$txtMsg = 'Welcome to eBazar, Your Password is '.$password .'';
				sendGSMS('8809601001470',$Phone,$txtMsg,'C200022562c68264972b36.87730554','text&contacts');
				} 
	
			}
			}
			?>
			
			
			<div class="form-group m-auto">
			<label class="text-dark h6" for="name">Name</label>
			 <input class="form-control inptex" type="text" name="name" placeholder="Enter name" value="" required="">
			 </div>
			
			<div class="form-group m-auto">
			<label class="text-dark h6" for="Phone">Phone</label>
			<input class="form-control inptex" type="text" name="Phone" placeholder="Enter name" value="" required="">
			 </div>
			 
			<div class="form-group m-auto">
			<label class="text-dark h6" for="Email">Email</label>
			<input class="form-control inptex" type="text" name="Email" placeholder="Enter name" value="" >
			 </div> 
			 
			 <div class="form-group m-auto">
			<label class="text-dark h6" for="Email">User Type</label>
			<select name="type" class="form-control" required>
                  <option value="customer">Customer</option>
                  <option value="product-manager">Product Manager</option>
                  <option value="order-manager">Order Manager</option>
                  <option value="admin">Admin</option>
              </select>
			 </div> 
			 
			 
			<div class="form-group m-auto">
                  <label class="text-dark h6">Address</label>
                  <textarea rows="4" class="form-control" name="Address" cols="58" spellcheck="false"> </textarea>
                </div>
			
			<div class="form-group m-auto">
			<label class="text-dark h6" for="password">Password</label>
			<input class="form-control inptex" type="password" name="password" placeholder="enter password" 
			autocomplete="off"  value="" required>
			 </div>
		
			<div class="form-group m-auto">
			<input class="btn btn-success" name="passsubmit" type="submit" value="Create">
 </div>
			</div>
	</div>
</div>
					</form>
					</div>
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