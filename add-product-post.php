<?php
include 'db_connection.php';

$main_category_name = $_POST['category_name'];

//$select_query = "SELECT id FROM categories WHERE category_name = '$main_category_name'";
$category_id = $main_category_name;

$sub_category_name = 'namesub';
$bar_code = $_POST['bar_code'];

// $sub_sub_category_name = $_POST['sub_sub_category_name'];
$product_title = $_POST['product_name'];
$product_short_description = mysqli_real_escape_string($con, $_POST['product_short_description']);
$product_long_description = mysqli_real_escape_string($con, $_POST['product_long_description']);
$product_status = mysqli_real_escape_string($con, $_POST['product_status']);
// Thumbnail image uploaded start
$product_image = ($_FILES['product_thumbnail_image']['name']);
$product_image_after_explode = explode(".", $product_image);
$product_image_after_explode_extention = end($product_image_after_explode);
$product_thumbnail_image = time() . "-" . rand(111, 999) . "." . $product_image_after_explode_extention;

//$product_image_tmp_location = ($_FILES['product_thumbnail_image']['tmp_name']);
$product_image_new_location = "upload/product-image/" . $product_thumbnail_image;
//move_uploaded_file($product_image_tmp_location,$product_image_new_location);
$imgN = 'product_thumbnail_image';
if (isset($_FILES[$imgN]) && isset($_FILES[$imgN]['name'])) {
    $filename = $_FILES[$imgN]["name"];
    if ($filename != '') {
        $imageFileType = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $target_file = '' . date('Ymd') . '_' . rand(0000, 9999);
        $thumb_image = $target_file . '.' . $imageFileType;
        image_thumb(
            $_FILES[$imgN]['name'],
            $_FILES[$imgN]['size'],
            $_FILES[$imgN]['type'],
            $_FILES[$imgN]['tmp_name'],
            $product_thumbnail_image,
            'upload/product-image/',
            $imgresize = '268x262',
            $imgquality = 95,
            $watermark = ''
        );
    }
}
// Thumbnail image uploaded code End

// Featured image uploaded start
$product_image = ($_FILES['product_featured_image']['name']);
$product_image_after_explode = explode(".", $product_image);
$feature_image_extention = end($product_image_after_explode);
$product_featured_image = time() . "-" . rand(111, 999) . "." . $feature_image_extention;

//$product_image_tmp_location = ($_FILES['product_featured_image']['tmp_name']);
$product_image_new_location = "upload/product-image/" . $product_featured_image;
//move_uploaded_file($product_image_tmp_location,$product_image_new_location);
$imgN = 'product_featured_image';
if (isset($_FILES[$imgN]) && isset($_FILES[$imgN]['name'])) {
    $filename = $_FILES[$imgN]["name"];
    if ($filename != '') {
        $imageFileType = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $target_file = '' . date('Ymd') . '_' . rand(0000, 9999);
        $thumb_image = $target_file . '.' . $imageFileType;
        image_thumb(
            $_FILES[$imgN]['name'],
            $_FILES[$imgN]['size'],
            $_FILES[$imgN]['type'],
            $_FILES[$imgN]['tmp_name'],
            $product_featured_image,
            'upload/product-image/',
            $imgresize = '800x800',
            $imgquality = 99,
            $watermark = ''
        );
    }
}
// Featured image uploaded code End

// Featured image TWO uploaded start
$feature_image_two = ($_FILES['product_featured_image_two']['name']);
$feature_image_two_explode = explode(".", $feature_image_two);
$feature_image_two_extention = end($feature_image_two_explode);
$feature_image_two = time() . "-" . rand(111, 999) . "." . $feature_image_two_extention;

//$feature_image_two_tmp_location = ($_FILES['product_featured_image_two']['tmp_name']);
$feature_image_two_new_location = "upload/product-image/" . $feature_image_two;
//move_uploaded_file($feature_image_two_tmp_location,$feature_image_two_new_location);
$imgN = 'product_featured_image_two';
if (isset($_FILES[$imgN]) && isset($_FILES[$imgN]['name'])) {
    $filename = $_FILES[$imgN]["name"];
    if ($filename != '') {
        $imageFileType = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $target_file = '' . date('Ymd') . '_' . rand(0000, 9999);
        $thumb_image = $target_file . '.' . $imageFileType;
        image_thumb(
            $_FILES[$imgN]['name'],
            $_FILES[$imgN]['size'],
            $_FILES[$imgN]['type'],
            $_FILES[$imgN]['tmp_name'],
            $feature_image_two,
            'upload/product-image/',
            $imgresize = '800x800',
            $imgquality = 99,
            $watermark = ''
        );
    }
}
// Featured image Two uploaded code End

// Featured image three uploaded start
$feature_image_three = ($_FILES['product_featured_image_three']['name']);
$feature_image_three_explode = explode(".", $feature_image_three);
$feature_image_three_extention = end($feature_image_three_explode);
$feature_image_three = time() . "-" . rand(111, 999) . "." . $feature_image_three_extention;

//$feature_image_three_tmp_location = ($_FILES['product_featured_image_three']['tmp_name']);
$feature_image_three_new_location = "upload/product-image/" . $feature_image_three;
//move_uploaded_file($feature_image_three_tmp_location,$feature_image_three_new_location);
$imgN = 'product_featured_image_three';
if (isset($_FILES[$imgN]) && isset($_FILES[$imgN]['name'])) {
    $filename = $_FILES[$imgN]["name"];
    if ($filename != '') {
        $imageFileType = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $target_file = '' . date('Ymd') . '_' . rand(0000, 9999);
        $thumb_image = $target_file . '.' . $imageFileType;
        image_thumb(
            $_FILES[$imgN]['name'],
            $_FILES[$imgN]['size'],
            $_FILES[$imgN]['type'],
            $_FILES[$imgN]['tmp_name'],
            $feature_image_three,
            'upload/product-image/',
            $imgresize = '800x800',
            $imgquality = 99,
            $watermark = ''
        );
    }
}
// Featured image Two uploaded code End

$regular_price = $_POST['product_regular_price'];
$purchase_price = $_POST['product_purchase_price'];
$meta_title = $_POST['product_meta_title'];
$meta_description = mysqli_real_escape_string($con, $_POST['product_meta_description']);
$video_link = $_POST['product_video_link'];
$product_stock = $_POST['product_stock'];
$product_brand = $_POST['product_brand'];
$sale_price = $_POST['product_sale_price'];
$product_code = substr("EBZ" . time() . "LI" . rand(1, 999) . "SH", 0, 8);
$product_tag = $_POST['product_tag'];
$Genaretion = $_POST['Genaretion'];
$Delivery_cost = $_POST['Delivery_cost'];



$KeyWords = $_POST['KeyWords'];
$SearchTerms = $_POST['SearchTerms'];
$Self = $_POST['Self'];
$Refer = $_POST['Refer'];
$Donate = $_POST['Donate'];
$Platform = $_POST['Platform'];
$product_dealer = $_POST['product_dealer'];


$product_unit = $_POST['product_unit'];
$product_unit_typ = $_POST['product_unit_typ'];

$coloring = '';
$sizing = '';
$pricing = '';
if (!empty($_POST['color'])) {

    foreach ($_POST['color'] as $color) {

        $colors[] = $color;
    }

    $coloring = implode(',', $colors);
}


if (!empty($_POST['size'])) {

    foreach ($_POST['size'] as $size) {

        $sizes[] = $size;
    }

    $sizing = implode(',', $sizes);
}


if (!empty($_POST['price'])) {

    foreach ($_POST['price'] as $price) {

        $prices[] = $price;
    }

    $pricing = implode(',', $prices);
}


$product_insert_query = "INSERT INTO products (`category_id`, `sub_category_id`, `product_name`, `product_color`, `product_size`, `product_size_price`, `product_thumbnail_image`, `product_featured_image`, `product_short_description`, `product_long_description`, `product_tag`, `product_meta_title`, `product_meta_description`, `product_video_link`, `product_purchase_price`, `product_regular_price`, `product_sale_price`, `product_unit`, `product_unit_typ`, `product_stock`, `product_code`, `product_brand`, `product_featured_image_two`, `product_featured_image_three`, `product_status`, `product_genrtn`, `product_dlv_cost`, `product_inc_self`, `product_inc_ref`, `product_inc_dont`, `product_inc_pltfrm`, `product_keywords`, `product_src_trm`, `bar_code`, `add_by`, `product_dealer`)

	VALUES ('$category_id','$sub_category_name','$product_title','$coloring','$sizing','$pricing','$product_thumbnail_image','$product_featured_image','$product_short_description','$product_long_description','$product_tag','$meta_title','$meta_description','$video_link',$purchase_price,'$regular_price','$sale_price','$product_unit','$product_unit_typ','$product_stock','$product_code','$product_brand','$feature_image_two','$feature_image_three','$product_status','$Genaretion',
	'$Delivery_cost','$Self','$Refer','$Donate','$Platform','$KeyWords','$SearchTerms','$bar_code','$eb_user_id','$product_dealer')";
// $product_insert_result = mysqli_query($con,$product_insert_query);
if (mysqli_query($con, $product_insert_query)) {
    echo "This Product successfully uploaded!";
    echo  reloader('products?sa_nfy=Product successfully uploaded!', 0);
} else {
    echo "Upload Faild!";
}

echo ("Error description: " . $con->error);


$stmt = $np2con->prepare("INSERT INTO `dealer` (`dl_name`, `dl_manufac`)
VALUES(?,?)");

$stmt->bind_param('ss', $product_dealer, $product_dealer);
if ($stmt->execute()) {
    //
    //echo alert('Successfully Added!');
    //$sa_nfy = "dealer Added Successfully!";
    header('location: add-product.php');
    exit;

}



$_SESSION['product_upload_status'] = "This Product successfully uploaded!";
//echo  reloader('add-product',0);
//header('location: add-product.php');
