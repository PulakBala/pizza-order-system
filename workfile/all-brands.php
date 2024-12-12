<?php
$page_ttl = 'All Brands';
$page_dsc = 'at a glance';
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


						<table class="table">
  <thead>
    <tr>

      <th scope="col">Name</th>
      <th scope="col">Company</th>
    </tr>
  </thead>
  <tbody id="get_src_data">
<?php
	$uresult = $np2con->query("SELECT * FROM brands ORDER BY b_id DESC limit 500");
if ($uresult) {
while ($row = $uresult->fetch_assoc()) {
echo '<tr>
      <th scope="row">#'.$row['b_name'].'</th>
      <td>'.$row['b_manufac'].'</td>
    </tr>';
}}
	?>
   
  </tbody>
</table>
            
           </div>
          </div>
        </div>

<?php require('footer.php') ?> 