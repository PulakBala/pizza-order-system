<?php
session_start();
$con = new mysqli('localhost', 'root', '', 'pizza');

if ($con->connect_errno > 0) {
    die('Unable to connect to database [' . $con->connect_error . ']');
    exit();
}
$con->set_charset('utf8');



// $con->set_charset('utf8');
date_default_timezone_set('Asia/Dhaka');
$np2con = $con;
$site_link = 'https://ebazar.com.bd';
//$site_link = 'http://localhost/ebazar';
$site_name = 'ShohozShop';

$ctime = date("Y-m-d H:i:s");
$cctime = date("Y-m-d");
$day = date('d');
$year = date('Y');
$month =  date('m');





////////////////////////////
include_once('functions.php');
if (isset($_SESSION['CurrentCartSession']) and $_SESSION['CurrentCartSession'] != null) {
} else {
    $_SESSION['CurrentCartSession'] = generateRandomString();
}

$_SESSION['np2_signd_in'] = true;
$_SESSION['np2_user_id'] = 1;
if (isset($_SESSION['np2_signd_in']) and $_SESSION['np2_signd_in'] == true) {
    $eb_user_id =  $_SESSION['np2_user_id'];

    $sql = "SELECT * FROM users WHERE user_id = '$eb_user_id'";

    $result = mysqli_query($con, $sql);
    $data = mysqli_fetch_array($result);
    $count = mysqli_num_rows($result);

    if ($count > 0) {
        $eb_user_id = $data['user_id'];
        $eb_user_full_name = $data['user_full_name'];
        $eb_user_name = $data['user_name'];
        $eb_user_email = $data['user_email'];
        $eb_user_phone = $data['user_phone'];
        $eb_user_pass = $data['user_password'];
        //$eb_user_city = $data['user_city'];
        //$eb_user_region = $data['user_region'];
        //$eb_user_location = $data['user_location'];
        $eb_user_level = $data['user_level'];
        $eb_user_type = $data['user_type'];
    }
}
function alert($msg = '', $type = 'success')
{
    return '<div class="alert alert-' . $type . '" role="alert">' . $msg . '</div>';
}


// function getProducts(){
//     global $con;
//     $stmt = $con->prepare("SELECT * FROM products");
//     $stmt->execute();
//     $result = $stmt->get_result();
//     $products = array();
//     while($row = $result->fetch_assoc()) {
//         $products[] = $row;
//     }
//     return $products;
// }

function getProducts() {
    global $con;
    // SQL query with INNER JOIN to include category_name
    $stmt = $con->prepare("
        SELECT 
            products.*, 
            categories.category_name 
        FROM 
            products 
        INNER JOIN 
            categories 
        ON 
            products.category_id = categories.id
    ");
    $stmt->execute();
    $result = $stmt->get_result();
    $products = array();
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    return $products;
}



function image_thumb($im_name, $im_size, $im_type, $im_temp, $actual_image_name, $save_path, $imgresize = 'orginal', $imgquality = 95, $watermark = "")
{
    $max_size = 1080; //max image size in Pixels
    $destination_folder = $save_path;
    $image_name = $im_name; //file name
    $image_size = $im_size; //file size
    $image_type = $im_type; //file type
    $image_temp = $im_temp; //file temp
    //list($txt, $ext) = explode(".", $image_name);
    //$actual_image_name	= $actual_image_name.'.'.$ext;					
    switch (strtolower($image_type)) { //determine uploaded image type 
            //Create new image from file
        case 'image/png':
            $image_resource =  imagecreatefrompng($image_temp);
            break;
        case 'image/gif':
            $image_resource =  imagecreatefromgif($image_temp);
            break;
        case 'image/jpeg':
        case 'image/pjpeg':
            $image_resource = imagecreatefromjpeg($image_temp);
            break;
        default:
            $image_resource = false;
    }

    if ($image_resource) {
        //Copy and resize part of an image with resampling
        list($img_width, $img_height) = getimagesize($image_temp);


        if ($imgresize == 'orginal') {
            $new_image_width    = $img_width;
            $new_image_height   = $img_height;
            $new_canvas         = imagecreatetruecolor($new_image_width, $new_image_height);
        } else {
            $str = $imgresize;
            $hwds = (explode("x", $str));
            $new_image_height   = $hwds[0];
            $new_image_width    = $hwds[1];
            $new_canvas         = imagecreatetruecolor($new_image_width, $new_image_height);
        }
        //$image_scale        = min($max_size / $img_width, $max_size / $img_height); 
        //$new_image_width    = ceil($image_scale * $img_width);
        //$new_image_height   = ceil($image_scale * $img_height);
        //$new_canvas         = imagecreatetruecolor($new_image_width , $new_image_height);
        //Construct a proportional size of new image

        if ($image_type == 'image/png') {
            // Preserve transparency
            imagealphablending($new_canvas, false);
            imagesavealpha($new_canvas, true);
            $transparent = imagecolorallocatealpha($new_canvas, 255, 255, 255, 127);
            imagefilledrectangle($new_canvas, 0, 0, $new_image_width, $new_image_height, $transparent);
        }

        if (imagecopyresampled($new_canvas, $image_resource, 0, 0, 0, 0, $new_image_width, $new_image_height, $img_width, $img_height)) {

            if (!is_dir($destination_folder)) {
                mkdir($destination_folder); //create dir if it doesn't exist
            }

            //center watermark
            if ($watermark != '') {
                $pos = ($new_image_height * 2 / 100);
                $watermark_left = ($new_image_width / 2) - (300 / 2); //watermark left
                $watermark_bottom = ($new_image_height - 130); //watermark bottom
                $watermark_png_file = 'watermark.png';
                $watermark = imagecreatefrompng($watermark_png_file); //watermark image
                imagecopy($new_canvas, $watermark, $watermark_left, $watermark_bottom, 0, 0, 300, 100); //merge image
            }
            //output image direcly on the browser.
            //header('Content-Type: image/jpeg');
            //imagejpeg($new_canvas, NULL , 90);

            //Or Save image to the folder
            if ($image_type == 'image/png') {
                imagepng($new_canvas, $destination_folder . '/' . $actual_image_name);
            } else {
                imagejpeg($new_canvas, $destination_folder . '/' . $actual_image_name, $imgquality);
            }


            //free up memory
            imagedestroy($new_canvas);
            imagedestroy($image_resource);
            //die();


            //echo "<img src='".$destination_folder."".$actual_image_name."' alt='image'  value='".$actual_image_name."' class='preview'>";

            return true;
        }
    }
}

function chk_access($usr_id, $user_lvl, $have_accs_lvl, $have_accs_id)
{

    if (in_array("$user_lvl", $have_accs_lvl)) {
    } else {
        echo die('You are not permitted to access this section!!');
    }
}


function order_count($user, $cmd)
{
    global $con;
    if ($cmd == 'all') {
        $sql = "SELECT count(customer_id) as OrdC FROM orders WHERE customer_id = '$user'";
        $result = mysqli_query($con, $sql);
        $data = mysqli_fetch_array($result);
        return $data['OrdC'];
    }
}



function send_insentive($token, $order_id)
{
    global $con;
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
    $resultbn = mysqli_query($con, $sqlbn);

    $sprfself = 0;
    $sprfRef = 0;
    $sprfDonet = 0;
    $sprfPlatform = 0;

    $sprfselfTtl = 0;
    $sprfRefTtl = 0;
    $sprfDonetTtl = 0;
    $sprfPlatformTtl = 0;
    while ($cvb = $resultbn->fetch_assoc()) {

        $inc_self = $cvb['product_inc_self'];
        $inc_ref = $cvb['product_inc_ref'];
        $inc_dont = $cvb['product_inc_dont'];
        $inc_pltfrm = $cvb['product_inc_pltfrm'];

        $total_price =  calculatePrice($cvb['c_buy_unit'], $cvb['product_price'], $cvb['c_product_unit']);

        $ppurchase_price = $cvb['product_purchase_price'];
        $psale_price = $cvb['product_sale_price'];
        //$pprofit = $psale_price-$ppurchase_price; 
        //$pprofit_mrgn = $pprofit*100/$ppurchase_price;
        $sum_inctv = $inc_self + $inc_ref + $inc_dont + $inc_pltfrm;




        $sprfself = ($total_price * $inc_self / 100);
        $sprfRef = ($total_price * $inc_ref / 100);
        $sprfDonet = ($total_price * $inc_dont / 100);
        $sprfPlatform = ($total_price * $inc_pltfrm / 100);

        $sprfselfTtl = $sprfselfTtl + $sprfself;
        $sprfRefTtl = $sprfRefTtl + $sprfRef;
        $sprfDonetTtl = $sprfDonetTtl + $sprfDonet;
        $sprfPlatformTtl = $sprfPlatformTtl + $sprfPlatform;
    }

    $sds = "SELECT user_id,user_name,user_refferred,user_phone FROM 
	orders LEFT JOIN users ON
	orders.customer_id = users.user_id
	WHERE order_token = '$token'";
    $rsor = mysqli_query($con, $sds);
    while ($ordg = $rsor->fetch_assoc()) {
        $slf_user_id = $ordg['user_id'];
        $slf_user_phone = $ordg['user_phone'];
        $slf_user_name = $ordg['user_name'];
        $Ref_user_name = $ordg['user_refferred'];
    }

    $sdsx = "SELECT user_id from users WHERE user_name = '$Ref_user_name'";
    $rsorx = mysqli_query($con, $sdsx);
    while ($ordgx = $rsorx->fetch_assoc()) {
        $Ref_user_id = $ordgx['user_id'];
    }

    $ordr_id = 'O' . $order_id . '';
    //$priotity=0 =$ordr_id
    //Self 0

    notifier($slf_user_id, 'You Earned ' . $sprfselfTtl . 'TK', $type = 0, $status = 0, $ordr_id, $np2con);
    add_earn($slf_user_id, $sprfselfTtl, 0, 0, $ordr_id, $con);


    //Ref = 1
    notifier($Ref_user_id, 'Refer Earning ' . $sprfRefTtl . 'TK', $type = 0, $status = 0, $ordr_id, $np2con);
    add_earn($Ref_user_id, $sprfRefTtl, 1, 0, $ordr_id, $con);

    //Donation = 2
    notifier(33, 'Donation ' . $sprfDonetTtl . 'TK', $type = 0, $status = 0, $ordr_id, $np2con);
    add_earn(33, $sprfDonetTtl, 2, 0, $ordr_id, $con);


    //Platform = 3
    notifier(31, 'Platform ' . $sprfPlatformTtl . 'TK', $type = 0, $status = 0, $ordr_id, $np2con);
    add_earn(31, $sprfPlatformTtl, 3, 0, $ordr_id, $con);


    // $txtMsg = 'Apni Kroykrito Ponnor Upore '.$sprfselfTtl.'.TK incentive Peyecen - eBazar ';
    $txtMsg = 'আপনি ক্রয়ক্রিত পন্যের উপর ' . $sprfselfTtl . ' TK ইনসেন্টিভ পেয়েছেন   - eBazar ';
    sendGSMS('8809617620596', $slf_user_phone, $txtMsg, 'C200022562c68264972b36.87730554', 'text&contacts');


    $dahs = '
	<h4>Total Payable Incentive</h4>
	<div class="input-group p-0 mt-2" >
                  
              <span class="input-group-text">' . $slf_user_name . '' . $slf_user_id . '</span>
              <input type="text" name="Self" id="Self" value="' . $sprfselfTtl . ' TK" aria-label="Self" class="form-control" required="">
              
	   <span class="input-group-text">' . $Ref_user_name . '' . $Ref_user_id . '</span>
              <input type="text" name="Refer" id="Refer" value="' . $sprfRefTtl . ' TK" aria-label="Refer" class="form-control" required="">
              
	   <span class="input-group-text">Donation</span>
              <input type="text" name="Donate" id="Donate" value="' . $sprfDonetTtl . ' TK" aria-label="Donate" class="form-control" required="">
              
	   <span class="input-group-text">Platform</span>
              <input type="text" name="Platform" id="Platform" value="' . $sprfPlatformTtl . ' TK" aria-label="Platform" class="form-control" required="">
		</div>
	';
    $sa_nfy = "Updated Successfully! " . $txtMsg;
}




function calculatePrice($weightInGrams, $unitPrice, $unitWeight, $round = 0)
{
    // Calculate price
    $price = ($unitPrice / $unitWeight) * $weightInGrams;
    return round($price, $round); // Rounding to 2 decimal places for precision
}



$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
$limit = 20;
$startpoint = ($page * $limit) - $limit;


function wr_prd($products_info)
{
    global $con;


    $csession = $_SESSION['CurrentCartSession'];
    $cs_query = "SELECT product_id,qty FROM cart WHERE cart_session = '$csession' LIMIT 20";
    $cs_result = mysqli_query($con, $cs_query);
    //$cs_items = mysqli_num_rows($cs_result);
    $total_cart_amount = 0;
    $ckprevq = array();
    while ($rowcc = $cs_result->fetch_assoc()) {
        $ckprevq[$rowcc['product_id']] = $rowcc['qty'];
    }

    $sd = '';
    foreach ($products_info as $product) {
        $product_genrtnx = explode('-', $product['product_genrtn']);
        $product_genrtn = $product_genrtnx[0];
        $originalPrice = $product['product_regular_price'];
        $salePrice = $product['product_sale_price'];
        $discountPercentage = (($originalPrice - $salePrice) / $originalPrice) * 100;

        $discountPercentage = round($discountPercentage, 0);
        $sadas = '<div class="card-footer d-flex justify-content-between bg-light border" >
         <i class="fa fa-minus text-white py-1"></i> <span class="text-center text-white">Add More</span>
<i class="fa fa-plus pull-right text-white py-1"></i>
</div>';

        if (array_key_exists($product['id'], $ckprevq)) {
            $ctCol = 'background: rgb(246, 128, 198);';
        } else {
            $ctCol = '';
        }

        $deltxt = '';
        if ($originalPrice != $salePrice) {
            $deltxt = '<del>৳' . $originalPrice . '</del>';
        }

        echo  '
	 <div class="col-lg-2 col-md-6 col-6 pb-2 px-1 ">
   <div class="card h-100">
      <div class="productimage">
         <a href="details.php?id=' . $product['id'] . '">
            <img src="upload/product-image/' . $product['product_thumbnail_image'] . '" class="card-img-top" alt="..." height="100%">
         </a>
      </div>
      <div class="card-body text-center">
         <a href="details.php?id=' . $product['id'] . '">' . $product['product_name'] . '</a>
         <div class="d-flex justify-content-center">
            <h5>৳' . $salePrice . '</h5>
            <h6 class="text-muted ml-2">
               ' . $deltxt . '
            </h6>
         </div>
         <small>' . $product['product_unit'] . ' ' . $product['product_unit_typ'] . '</small>
         
         ' . ($discountPercentage > 3 ? '<button class="btn sa-des-tag">' . $discountPercentage . '% off</button>' : '') . '
      </div>
      <div class="card-footer d-flex justify-content-between bg-lightx border" style="' . $ctCol . '" id="Prs' . $product['id'] . '"> ';


        if (array_key_exists($product['id'], $ckprevq)) {

            echo ' 
		<i class="fa fa-minus text-white py-1 saf-sidecart-up" data-pid="' . $product['id'] . '" data-ctype="down"></i>
		<span class="text-center text-white saf_itm_cnt' . $product['id'] . '"">' . $ckprevq[$product['id']] . '</span>
		<i class="fa fa-plus pull-right text-white py-1 saf-sidecart-up" data-pid="' . $product['id'] . '" data-ctype="up"></i>
		';
        } else {
            echo  '<form action="" class="form-submit" method="POST" style="margin: 0 auto;">
            <input type="hidden" class="pid" value="' . $product['id'] . '">
            <input type="hidden" class="pname" value="' . $product['product_name'] . '">
            <input type="hidden" class="pqty" value="1">
            <input type="hidden" class="pprice" value="' . $product['product_regular_price'] . '">
            <input type="hidden" class="pimage" value="' . $product['product_thumbnail_image'] . '">
            <input type="hidden" class="pcode" value="' . $product['product_code'] . '">
            <input type="hidden" name="_token" value="2q9BkslArJlfUG9h09pPYVlXuoqzoG5MgY41rDnU">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="btn btn-sm text-dark p-0 add-to-cart addItemBtn ' . $ctCol . '">
               <i class="fas fa-bolt text-primary mr-1"></i> Add to bag
            </button>
         </form>';
        }

        echo  ' </div>
   </div>
</div>

	';
    }
}

function get_posts($args)
{
    global $np2con;
    $sql = "SELECT * FROM sa_pages WHERE spg_link = ?";
    $stmt = $np2con->prepare($sql);
    $stmt->bind_param("s", $args);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = array();
    while ($row = $result->fetch_assoc()) {
        $post['title'] = $row['spg_title'];
        $post['meta_title'] = $row['spg_meta_title'];
        $post['meta_discription'] = $row['spg_meta_discription'];
        $post['content'] = $row['spg_page_content'];
        $post['slug'] = $row['spg_slug'];
        $post['group'] = $row['spg_group'];
        $post['link'] = $row['spg_link'];
        $post['post_date'] = $row['spg_cret_date'];
        $post['status'] = $row['spg_status'];
    }
    return $post;
}


function get_post_item($post_array, $item)
{
    $tyju = $post_array[$item];
    $rtn = '';
    if (isset($post_array)) {
        if (isset($tyju)) {
            if ($tyju != '') {
                $rtn = $tyju;
            }
        }
    }

    return $rtn;
}

function get_sa_page_list($group, $style, $slug = '', $limit = 200)
{
    global $np2con;
    if ($slug != '') {
        $sql = "SELECT * FROM sa_pages WHERE spg_slug=? LIMIT 1";
        $stmt = $np2con->prepare($sql);
        $stmt->bind_param("s", $slug);
    } else {
        $sql = "SELECT * FROM sa_pages WHERE spg_group=?  LIMIT " . $limit . "";
        $stmt = $np2con->prepare($sql);
        $stmt->bind_param("s", $group);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $menu = '';
    while ($row = $result->fetch_assoc()) {
        $dsds = $row['spg_slug'];
        $spg_slug = str_replace('#SLUG#', $row['spg_slug'], $style);
        $spg_slug = str_replace('#TITLE#', $row['spg_title'], $spg_slug);
        $spg_slug = str_replace('#LINK#', $row['spg_link'], $spg_slug);
        $menu .= $spg_slug;
    }
    return $menu;
}




function ord_count($cmd, $cDay = 0, $cMonth = 0, $cYear = 0, $type = 'Completed')
{
    global $con;
    if ($cmd == 'TodayOrder') {
        $select_query = "SELECT count(id) as count FROM orders WHERE order_status = 'Completed' AND DATE(order_date) = CURRENT_DATE;";
    }

    if ($cmd == 'ThisMonth') {
        $select_query = "SELECT count(id) as count FROM orders WHERE order_status = 'Completed' AND YEAR(order_date) = YEAR(CURRENT_DATE)
AND MONTH(order_date) = MONTH(CURRENT_DATE);";
    }

    if ($cmd == 'PrevMonth') {
        $select_query = "SELECT count(id) as count FROM orders WHERE order_status = 'Completed' AND YEAR(order_date) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
AND MONTH(order_date) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH);";
    }

    if ($cmd == 'ThisYear') {
        $select_query = "SELECT count(id) as count FROM orders WHERE order_status = 'Completed' AND YEAR(order_date) = YEAR(CURRENT_DATE)";
    }
    if ($cmd == 'ByDate') {
        if ($cDay != '0') {
            $cd = "  AND DAY(order_date) = $cDay ";
        } else {
            $cd = "";
        }
        if ($cMonth != '') {
            $cm = "  AND MONTH(order_date) = $cMonth ";
        } else {
            $cm = "";
        }
        if ($cYear != '') {
            $cY = "  AND YEAR(order_date) = $cYear";
        } else {
            $cY = "";
        }
        if ($type == '0') {
            $ctp = " id > 0 ";
        } else {
            $ctp = " order_status = '{$type}' ";
        }
        $select_query = $select_query = "SELECT count(id) as count FROM orders WHERE {$ctp} {$cd} {$cm} {$cY}  ";
    }

    if ($cmd != '') {
        $ss = mysqli_query($con, $select_query);
        $ssr = mysqli_fetch_assoc($ss);
        return $ssr['count'];
    }
}

function product_count($cmd, $cDay = 0, $cMonth = 0, $cYear = 0, $type = 'Completed')
{
    global $con;
    if ($cmd == 'oos') {
        $select_query = "SELECT count(id) as count FROM products WHERE product_stock = '0'";
    }
    if ($cmd == 'instok') {
        $select_query = "SELECT count(id) as count FROM products WHERE product_stock > 0 ";
    }

    if ($cmd == 'instokPurcValuation') {
        $TotalAmnt = 0;
        $select_query = "SELECT product_purchase_price,product_stock  FROM products WHERE product_stock > 0 ";
        $ss = mysqli_query($con, $select_query);
        foreach ($ss as $cin) {
            $TotalAmnt +=  $cin['product_purchase_price'] * $cin['product_stock'];
        }
        return $TotalAmnt;
    }

    if ($cmd == 'instokSaleValuation') {
        $TotalAmnt = 0;
        $select_query = "SELECT product_sale_price,product_stock  FROM products WHERE product_stock > 0 ";
        $ss = mysqli_query($con, $select_query);
        foreach ($ss as $cin) {
            $TotalAmnt +=  $cin['product_sale_price'] * $cin['product_stock'];
        }
        return $TotalAmnt;
    }


    if ($cmd == 'oos' or $cmd == 'instok') {
        $ss = mysqli_query($con, $select_query);
        $ssr = mysqli_fetch_assoc($ss);
        return $ssr['count'];
    }
}


function Ord_Sum_Count($cmd)
{
    global $con;
    $TotalAmnt = 0;

    if ($cmd == 'ThisYear') {
        $select_query = "SELECT order_token  FROM orders WHERE order_status = 'Completed' AND YEAR(order_date) = YEAR(CURRENT_DATE);";
        $ss = mysqli_query($con, $select_query);
        foreach ($ss as $order_info) {
            $order_tkn =  $order_info['order_token'];

            $select_query = "SELECT product_price,qty  FROM cart WHERE cart_session = '{$order_tkn}'";
            $ss = mysqli_query($con, $select_query);
            foreach ($ss as $cin) {
                $TotalAmnt +=  $cin['product_price'] * $cin['qty'];
            }
        }
        return number_format($TotalAmnt);
    }
    if ($cmd == 'PrevMonth') {
        $select_query = "SELECT order_token  FROM orders WHERE order_status = 'Completed' AND YEAR(order_date) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
AND MONTH(order_date) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH);";
        $ss = mysqli_query($con, $select_query);
        foreach ($ss as $order_info) {
            $order_tkn =  $order_info['order_token'];

            $select_query = "SELECT product_price,qty  FROM cart WHERE cart_session = '{$order_tkn}'";
            $ss = mysqli_query($con, $select_query);
            foreach ($ss as $cin) {
                $TotalAmnt +=  $cin['product_price'] * $cin['qty'];
            }
        }
        return number_format($TotalAmnt);
    }

    if ($cmd == 'ThisMonth') {
        $select_query = "SELECT order_token  FROM orders WHERE order_status = 'Completed' AND YEAR(order_date) = YEAR(CURRENT_DATE)
AND MONTH(order_date) = MONTH(CURRENT_DATE);";
        $ss = mysqli_query($con, $select_query);
        foreach ($ss as $order_info) {
            $order_tkn =  $order_info['order_token'];

            $select_query = "SELECT product_price,qty  FROM cart WHERE cart_session = '{$order_tkn}'";
            $ss = mysqli_query($con, $select_query);
            foreach ($ss as $cin) {
                $TotalAmnt +=  $cin['product_price'] * $cin['qty'];
            }
        }
        return number_format($TotalAmnt);
    }

    if ($cmd == 'TodayOrder') {
        $select_query = "SELECT order_token  FROM orders WHERE order_status = 'Completed' AND DATE(order_date) = CURRENT_DATE;";
        $ss = mysqli_query($con, $select_query);
        foreach ($ss as $order_info) {
            $order_tkn =  $order_info['order_token'];

            $select_query = "SELECT product_price,qty  FROM cart WHERE cart_session = '{$order_tkn}'";
            $ss = mysqli_query($con, $select_query);
            foreach ($ss as $cin) {
                $TotalAmnt +=  $cin['product_price'] * $cin['qty'];
            }
        }
        return number_format($TotalAmnt);
    }
}

function prof_count($cmd, $user_id = 0, $day = 0, $month = 0, $year = 0)
{
    global $con;

    if ($cmd == 'Total-Montly-Credit') {
        $query_customer = "SELECT sum(bc_amount) as bc_amount FROM `balance_cradit` WHERE `bc_month` = '$month' AND  `bc_year` = '$year'";
        $result_customer = mysqli_query($con, $query_customer);
        $customer = mysqli_fetch_assoc($result_customer);
        return $customer['bc_amount'];
        //return $query_customer;
    }
    if ($cmd == 'Total-Credit') {
        $query_customer = "SELECT sum(bc_amount) as bc_amount FROM `balance_cradit`";
        $result_customer = mysqli_query($con, $query_customer);
        $customer = mysqli_fetch_assoc($result_customer);
        return $customer['bc_amount'];
        //return $query_customer;
    }

    if ($cmd == 'dit-Montly-Credit') {
        $query_customer = "SELECT sum(bc_amount) as bc_amount FROM `balance_cradit` WHERE `bc_user` = '31' AND `bc_month` = '$month' AND  `bc_year` = '$year'";
        $result_customer = mysqli_query($con, $query_customer);
        $customer = mysqli_fetch_assoc($result_customer);
        return $customer['bc_amount'];
        //return $query_customer;
    }

    if ($cmd == 'Donation-Montly-Credit') {
        $query_customer = "SELECT sum(bc_amount) as bc_amount FROM `balance_cradit` WHERE `bc_user` = '33' AND `bc_month` = '$month' AND  `bc_year` = '$year'";
        $result_customer = mysqli_query($con, $query_customer);
        $customer = mysqli_fetch_assoc($result_customer);
        return $customer['bc_amount'];
        //return $query_customer;
    }

    if ($cmd == 'ebazar-Montly-Credit') {
        $query_customer = "SELECT sum(bc_amount) as bc_amount FROM `balance_cradit` WHERE `bc_user` = '1' AND `bc_month` = '$month' AND  `bc_year` = '$year'";
        $result_customer = mysqli_query($con, $query_customer);
        $customer = mysqli_fetch_assoc($result_customer);
        return $customer['bc_amount'];
        //return $query_customer;
    }
}


$hide_stko_prd = 1;
