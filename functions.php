<?php
function mailer($to, $subject, $body_title, $body_content)
{
	// message
	$messageh = '
<html>
<head>
<title>' . $subject . '</title>
</head>
<body>
<div>
<h1>ebazar.com</h1> 
<hr>
</div>
<div>
<p style="color:#08D;font-size:15px">Hello....</p>
<p style="color:#9E9E9E;font-size:15px">' . $body_content . '</p>
</div>
<br>
<div>
<center>
© 2018 ebazar Limited. All Rights Reserved.
<p style="color:#75787d;font-size:12px">
ebazar.com - Support Team</p>
<center>
</div>
</body>
</html>
';
	$messagestr = str_replace("\n.", "\n..", $messageh);
	$message = wordwrap($messagestr, 70, "\r\n");
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	// Additional headers
	$headers .= 'From: ebazar.com <info@ebazar.com>' . "\r\n";
	// Mail itmailer
	mail($to, $subject, $message, $headers);
	return true;
}


function get_dr_ref($uid, $np2con)
{
	$uresult = $np2con->query("SELECT * FROM users where user_id = '" . $uid . "' ", MYSQLI_USE_RESULT);
	if ($uresult) {
		while ($row = $uresult->fetch_assoc()) {
			$grt_name =  $row['user_name'];
		}
	}
	$resulttkt2 = $np2con->query("SELECT COUNT(user_id)  FROM `users` where user_refferred = '" . $grt_name . "' AND account_status != '0' ");
	$rowtkt2 = $resulttkt2->fetch_row();
	$total_ref = $rowtkt2[0];
	$resulttkt2->close();
	return $total_ref;
}

function get_under_ref($uid, $np2con)
{
	$rt = 0;
	// Get user Name or reff id	
	$uresult = $np2con->query("SELECT * FROM users where user_id = '" . $uid . "' ", MYSQLI_USE_RESULT);
	if ($uresult) {
		while ($row = $uresult->fetch_assoc()) {
			$grt_name =  $row['user_name'];
		}
	}
	// get original reff  number
	$resulttkt2 = $np2con->query("SELECT COUNT(user_id)  FROM `users` where user_refferred = '" . $grt_name . "' ");
	$rowtkt2 = $resulttkt2->fetch_row();
	$total_dr_ref = $rowtkt2[0];
	$resulttkt2->close();

	// get refferd user,s id name
	$dates = array(0 => "dl");
	unset($dates[0]);
	$uresult = $np2con->query("SELECT * FROM users where user_refferred = '" . $grt_name . "' ", MYSQLI_USE_RESULT);
	if ($uresult) {
		while ($row = $uresult->fetch_assoc()) {
			$dates['' . $row['user_id'] . ''] = $row['user_id'];
		}
	}
	foreach ($dates as $key => $value) {
		//return $rt;
		$rt = $rt + get_dr_ref($value, $np2con);
		//echo $value;
	}

	return $rt + $total_dr_ref;
}


function timeSince($dateFrom, $dateTo)
{
	// array of time period chunks
	$chunks = array(
		array(60 * 60 * 24 * 365, 'Year'),
		array(60 * 60 * 24 * 30, 'Month'),
		array(60 * 60 * 24 * 7, 'Week'),
		array(60 * 60 * 24, 'Day'),
		array(60 * 60, 'Hour'),
		array(60, 'Minute'),
	);

	$original = strtotime($dateFrom);
	$now      = strtotime($dateTo);
	$since    = $now - $original;
	$message  = ($now < $original) ? '-' : null;

	// If the difference is less than 60, we will show the seconds difference as well
	if ($since < 60) {
		$chunks[] = array(1, 'second');
	}

	// $j saves performing the count function each time around the loop
	for ($i = 0, $j = count($chunks); $i < $j; $i++) {

		$seconds = $chunks[$i][0];
		$name = $chunks[$i][1];

		// finding the biggest chunk (if the chunk fits, break)
		if (($count = floor($since / $seconds)) != 0) {
			break;
		}
	}

	$print = ($count == 1) ? '1 ' . $name : $count . ' ' . $name . '';

	if ($i + 1 < $j) {
		// now getting the second item
		$seconds2 = $chunks[$i + 1][0];
		$name2 = $chunks[$i + 1][1];

		// add second item if it's greater than 0
		if (($count2 = floor(($since - ($seconds * $count)) / $seconds2)) != 0) {
			$print .= ($count2 == 1) ? ', 1 ' . $name2 : ', ' . $count2 . ' ' . $name2 . '';
		}
	}
	return $message . $print;
}
// This function will take $_SERVER['REQUEST_URI'] and build a breadcrumb based on the user's current path
function breadcrumbs($separator = ' &raquo; ', $home = 'Home')
{
	// This gets the REQUEST_URI (/path/to/file.php), splits the string (using '/') into an array, and then filters out any empty values
	$path = array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));

	// This will build our "base URL" ... Also accounts for HTTPS :)
	//$base = ($_SERVER['HTTPS'] ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
	$base = 'http://localhost/';

	// Initialize a temporary array with our breadcrumbs. (starting with our home page, which I'm assuming will be the base URL)
	$breadcrumbs = array("<a href=\"$base\">$home</a>");

	// Find out the index for the last value in our path array
	$last = end(array_keys($path));

	// Build the rest of the breadcrumbs
	foreach ($path as $x => $crumb) {
		// Our "title" is the text that will be displayed (strip out .php and turn '_' into a space)
		$title = ucwords(str_replace(array('.php', '_'), array('', ' '), $crumb));

		// If we are not on the last index, then display an <a> tag
		if ($x != $last)
			$breadcrumbs[] = "<a href=\"$base$crumb\">$title</a>";
		// Otherwise, just display the title (minus)
		else
			$breadcrumbs[] = $title;
	}

	// Build our temporary array (pieces of bread) into one big string :)
	return implode($separator, $breadcrumbs);
}
function sendmail($to, $subject, $body_title, $body_content)
{

	// message
	$messageh = '
<html>
<head>
  <title></title>


</head>
<body>
<div style="background-image: linear-gradient(to bottom, #ACE7F2, #C1F5F1);
padding: 5px 14px;
border: 3px solid #1CCF1C;">

<a style="" href="http://varabazar.com"><img src="http://varabazar.com/img/logo.png" /></a><br>

</div>

<div style="background-image: linear-gradient(to bottom, #ACE7F2, #C1F5F1);
padding: 5px 14px;
border: 3px solid #1CCF1C;">

<p style="color:#08D;font-size:19px">Hallow....</p><br>
<p style="color:#08D;font-size:19px">' . $body_content . '</p>

</div>
<div style="background-image: linear-gradient(to bottom, #A2F396, #C1F5C2);
padding: 5px 14px;
border: 3px solid #1CCF1C;">

<p style="color:#08D;font-size:19px">শুভেচ্ছান্তে, <a href="http://varabazar.com">Varabazar.com</a> সাপোর্ট টিম</p>
<p style="color:#08D;font-size:17px">Varabazar.com - বাংলাদেশ-এর ভিতরে সুধুমাত্র ভাড়ার ওয়েবসাইট</p>

</div>
</body>
</html>
';
	$messagestr = str_replace("\n.", "\n..", $messageh);
	$message = wordwrap($messagestr, 70, "\r\n");
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	// Additional headers
	$headers .= 'From: varabazar.com <support@varabazar.com>' . "\r\n";

	// Mail it
	mail($to, $subject, $message, $headers);
	return true;
}

function delete_file($path)
{
	if (file_exists($path)) {
		if (unlink($path)) {
			return true;
		}
	} else {
		return false;
	}
}

function uni_pagination($query, $per_page = 6, $page = 1, $url = '?', $str1 = 0, $str2 = 0, $str3 = 0, $str4 = 0)
{
	//$query = "SELECT COUNT(post_id) as `num` FROM {$query}";
	$other_st = '';
	if ($str1 != 0) {
		$other_st .= '&st1=' . $str1 . '';
	}
	if ($str2 != 0) {
		$other_st .= '&st2=' . $str2 . '';
	}
	if ($str3 != 0) {
		$other_st .= '&st3=' . $str3 . '';
	}
	if ($str4 != 0) {
		$other_st .= '&st4=' . $str4 . '';
	}
	//$row = mysql_fetch_array(mysql_query($query));
	$total = $query;
	$adjacents = "2";
	$page = ($page == 0 ? 1 : $page);
	$start = ($page - 1) * $per_page;

	$prev = $page - 1;
	$next = $page + 1;
	$lastpage = ceil($total / $per_page);
	$lpm1 = $lastpage - 1;

	$pagination = "";
	if ($lastpage > 1) {
		$pagination .= "<ul class='pagination'>";
		//$pagination .= "<li class='details'>Page $page of $lastpage</li>";
		if ($lastpage < 7 + ($adjacents * 2)) {
			for ($counter = 1; $counter <= $lastpage; $counter++) {
				if ($counter == $page)
					$pagination .= "<li><a class='current'>$counter</a></li>";
				else
					$pagination .= "<li><a href='{$url}page=$counter$other_st'>$counter</a></li>";
			}
		} elseif ($lastpage > 5 + ($adjacents * 2)) {
			if ($page < 1 + ($adjacents * 2)) {
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
					if ($counter == $page)
						$pagination .= "<li><a class='current'>$counter</a></li>";
					else
						$pagination .= "<li><a href='{$url}page=$counter$other_st'>$counter</a></li>";
				}
				$pagination .= "<li class='dot'>...</li>";
				$pagination .= "<li><a href='{$url}page=$lpm1$other_st'>$lpm1</a></li>";
				$pagination .= "<li><a href='{$url}page=$lastpage$other_st'>$lastpage</a></li>";
			} elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
				$pagination .= "<li><a href='{$url}page=1$other_st'>1</a></li>";
				$pagination .= "<li><a href='{$url}page=2$other_st'>2</a></li>";
				$pagination .= "<li class='dot'>...</li>";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
					if ($counter == $page)
						$pagination .= "<li><a class='current'>$counter</a></li>";
					else
						$pagination .= "<li><a href='{$url}page=$counter$other_st'>$counter</a></li>";
				}
				$pagination .= "<li class='dot'>..</li>";
				$pagination .= "<li><a href='{$url}page=$lpm1$other_st'>$lpm1</a></li>";
				$pagination .= "<li><a href='{$url}page=$lastpage$other_st'>$lastpage</a></li>";
			} else {
				$pagination .= "<li><a href='{$url}page=1$other_st'>1</a></li>";
				$pagination .= "<li><a href='{$url}page=2$other_st'>2</a></li>";
				$pagination .= "<li class='dot'>..</li>";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
					if ($counter == $page)
						$pagination .= "<li><a class='current'>$counter</a></li>";
					else
						$pagination .= "<li><a href='{$url}page=$counter$other_st'>$counter</a></li>";
				}
			}
		}

		if ($page < $counter - 1) {
			$pagination .= "<li><a href='{$url}page=$next$other_st'>Next</a></li>";
			$pagination .= "<li><a href='{$url}page=$lastpage$other_st'>Last</a></li>";
		} else {
			$pagination .= "<li><a class='current'>Next</a></li>";
			$pagination .= "<li><a class='current'>Last</a></li>";
		}
		$pagination .= "</ul>\n";
	}


	return $pagination;
}

//use--notifier('3','asasas',$type=0,$status=0,$priotity=0,$np2con);
/////////////////////////
/// Spot Earn 
/////////////////////////
function check_acc_active($uid, $np2con)
{
	$uresult = $np2con->query("SELECT * FROM users where user_id = '" . $uid . "' ", MYSQLI_USE_RESULT);
	if ($uresult) {
		while ($row = $uresult->fetch_assoc()) {
			$account_status =  $row['account_status'];
		}
	}
	if ($account_status == 0) {
		return 'inactive';
	} elseif ($account_status == 1) {
		return 'active';
	}
}
function check_user_rank($uid, $np2con)
{
	$uresult = $np2con->query("SELECT * FROM users where user_id = '" . $uid . "' ", MYSQLI_USE_RESULT);
	if ($uresult) {
		while ($row = $uresult->fetch_assoc()) {
			$account_status =  $row['user_rank'];
		}
	}
	return $account_status;
}

//////////  UPDATE RANK 

function update_rank($uid, $rank, $np2con)
{
	if ($rank == 2) {
		$uresult = $np2con->query("SELECT * FROM users where user_id = '" . $uid . "' ", MYSQLI_USE_RESULT);
		if ($uresult) {
			while ($row = $uresult->fetch_assoc()) {
				$account_status =  $row['user_rank'];
			}
		}
		if ($account_status < 2) {
			$set = 2;
			$stmt2 = $np2con->prepare("UPDATE `users` SET user_rank = ? Where user_id = ?");
			$stmt2->bind_param('ss', $set, $uid);
			if ($stmt2->execute()) {
				notifier($uid, 'You Are Now Enable To Generation Earn!!', $type = 0, $status = 0, $priotity = 0, $np2con);
				return true;
			}
		}
	}
	if ($rank == 3) {
		$uresult = $np2con->query("SELECT * FROM users where user_id = '" . $uid . "' ", MYSQLI_USE_RESULT);
		if ($uresult) {
			while ($row = $uresult->fetch_assoc()) {
				$account_status =  $row['user_rank'];
			}
		}
		if ($account_status < 3) {
			$set = '3';
			$amount = '7000';
			$type = '3';
			$stmt2 = $np2con->prepare("UPDATE `users` SET user_rank = ? Where user_id = ?");
			$stmt2->bind_param('ss', $set, $uid);
			if ($stmt2->execute()) {
				add_earn($uid, $amount, $type, $uid, $np2con, 0);
				notifier($uid, 'You Are Now Basic Member!! You Earn (TK.' . $amount . ') By Bonas!!', $type = 0, $status = 0, $priotity = 0, $np2con);
				return true;
			}
		}
	}

	if ($rank == 4) {
		$uresult = $np2con->query("SELECT * FROM users where user_id = '" . $uid . "' ", MYSQLI_USE_RESULT);
		if ($uresult) {
			while ($row = $uresult->fetch_assoc()) {
				$account_status =  $row['user_rank'];
			}
		}
		if ($account_status < 4) {
			$set = '4';
			$amount = '10000';
			$type = '3';
			$stmt2 = $np2con->prepare("UPDATE `users` SET user_rank = ? Where user_id = ?");
			$stmt2->bind_param('ss', $set, $uid);
			if ($stmt2->execute()) {
				add_earn($uid, $amount, $type, $uid, $np2con, 0);
				notifier($uid, 'You Are Now Prefrred Member!! You Earn (TK.' . $amount . ') By Bonas!!', $type = 0, $status = 0, $priotity = 0, $np2con);
				return true;
			}
		}
	}
	if ($rank == 5) {
		$uresult = $np2con->query("SELECT * FROM users where user_id = '" . $uid . "' ", MYSQLI_USE_RESULT);
		if ($uresult) {
			while ($row = $uresult->fetch_assoc()) {
				$account_status =  $row['user_rank'];
			}
		}
		if ($account_status < 5) {
			$set = '5';
			$amount = '12000';
			$type = '3';
			$stmt2 = $np2con->prepare("UPDATE `users` SET user_rank = ? Where user_id = ?");
			$stmt2->bind_param('ss', $set, $uid);
			if ($stmt2->execute()) {
				add_earn($uid, $amount, $type, $uid, $np2con, 0);
				notifier($uid, 'You Are Now Focus Member!! You Earn (TK.' . $amount . ') By Bonas!!', $type = 0, $status = 0, $priotity = 0, $np2con);
				return true;
			}
		}
	}
	if ($rank == 6) {
		$uresult = $np2con->query("SELECT * FROM users where user_id = '" . $uid . "' ", MYSQLI_USE_RESULT);
		if ($uresult) {
			while ($row = $uresult->fetch_assoc()) {
				$account_status =  $row['user_rank'];
			}
		}
		if ($account_status < 6) {
			$set = '6';
			$amount = '15000';
			$type = '3';
			$stmt2 = $np2con->prepare("UPDATE `users` SET user_rank = ? Where user_id = ?");
			$stmt2->bind_param('ss', $set, $uid);
			if ($stmt2->execute()) {
				add_earn($uid, $amount, $type, $uid, $np2con, 0);
				notifier($uid, 'You Are Now Premium Member!! You Earn (TK.' . $amount . ') By Bonas!!', $type = 0, $status = 0, $priotity = 0, $np2con);
				return true;
			}
		}
	}
	if ($rank == 7) {
		$uresult = $np2con->query("SELECT * FROM users where user_id = '" . $uid . "' ", MYSQLI_USE_RESULT);
		if ($uresult) {
			while ($row = $uresult->fetch_assoc()) {
				$account_status =  $row['user_rank'];
			}
		}
		if ($account_status < 7) {
			$set = '7';
			$amount = '20000';
			$type = '3';
			$stmt2 = $np2con->prepare("UPDATE `users` SET user_rank = ? Where user_id = ?");
			$stmt2->bind_param('ss', $set, $uid);
			if ($stmt2->execute()) {
				add_earn($uid, $amount, $type, $uid, $np2con, 0);
				notifier($uid, 'You Are Now Freedom Member!! You Earn (TK.' . $amount . ') By Bonas!!', $type = 0, $status = 0, $priotity = 0, $np2con);
				return true;
			}
		}
	}

	if ($rank == 8) {
		$uresult = $np2con->query("SELECT * FROM users where user_id = '" . $uid . "' ", MYSQLI_USE_RESULT);
		if ($uresult) {
			while ($row = $uresult->fetch_assoc()) {
				$account_status =  $row['user_rank'];
			}
		}
		if ($account_status < 8) {
			$set = '8';
			$amount = '77000';
			$type = '3';
			$stmt2 = $np2con->prepare("UPDATE `users` SET user_rank = ? Where user_id = ?");
			$stmt2->bind_param('ss', $set, $uid);
			if ($stmt2->execute()) {
				add_earn($uid, $amount, $type, $uid, $np2con, 0);
				notifier($uid, 'You Are Now Royel Member!! You Earn (TK.' . $amount . ') By Bonas!!', $type = 0, $status = 0, $priotity = 0, $np2con);
				return true;
			}
		}
	}
}



function get_name_by_id($uid, $np2con)
{
	$uresult = $np2con->query("SELECT * FROM users where user_id = '" . $uid . "' LIMIT 1 ", MYSQLI_USE_RESULT);
	if ($uresult) {
		while ($row = $uresult->fetch_assoc()) {
			$grt_name =  $row['user_name'];
		}
	}
	return $grt_name;
}

function get_id_by_name($u_name, $np2con)
{
	$uresult = $np2con->query("SELECT * FROM users where user_name = '" . $u_name . "' ", MYSQLI_USE_RESULT);
	if ($uresult) {
		while ($row = $uresult->fetch_assoc()) {
			$gt_id =  $row['user_id'];
		}
	}
	return $gt_id;
}

function get_referral_by_id($uid, $np2con)
{
	$uresult = $np2con->query("SELECT * FROM users where user_id = '" . $uid . "' ", MYSQLI_USE_RESULT);
	if ($uresult) {
		while ($row = $uresult->fetch_assoc()) {
			$user_refferred =  $row['user_refferred'];
		}
	}
	return $user_refferred;
}

//$type  0 =  self 1 = refer ;
function add_earn($user, $amount, $type, $request, $by, $np2con)
{
	global 	$day, $month, $year, $admin_id;
	$ctime = date("H:i:s");
	$stmt = $np2con->prepare("INSERT INTO `balance_cradit` (bc_user,bc_amount,bc_app_date,bc_day,bc_month,bc_year,bc_type,bc_request,bc_by)
VALUES(?,?,?,?,?,?,?,?,?)");
	$stmt->bind_param('sssssssss', $user, $amount, $ctime, $day, $month, $year, $type, $request, $by);
	if ($stmt->execute()) {
		$last_id = $stmt->insert_id;
		if ($last_id > 0) {
			return true;
		} else {
			return false;
		}
	}
}

$admin_id = "ebazar-admin";
function cut_balance($user, $type = '', $amount = '0', $note = '', $method = '')
{
	global 	$ctime, $day, $month, $year, $admin_id, $np2con;
	$stmt = $np2con->prepare("INSERT INTO `balance_debit` (bd_user,bd_type,bd_app_date,bd_amount,bd_by,bd_method)
VALUES(?,?,?,?,?,?)");
	$stmt->bind_param('sssdss', $user, $type, $ctime, $amount, $note, $method);
	if ($stmt->execute()) {
		$last_id = $stmt->insert_id;
		if ($last_id > 0) {
			return true;
		} else {
			return false;
		}
	}
}
//cut_balance($user,$type,$amount,$note)

function notifier($to, $msg, $type = 0, $status = 0, $priotity = 0, $np2con = 0)
{
	global $np2con;
	$ctime = '' . date("Y-m-d H:i:s") . '';
	if ($to != '' and $msg != '') {
		$stmt = $np2con->prepare("INSERT INTO `notification` 
(nt_for_user,nt_type,nt_date,nt_msg,nt_status,nt_priority)
VALUES(?,?,?,?,?,?)");
		$stmt->bind_param('ssssss', $to, $type, $ctime, $msg, $status, $priotity);
		if ($stmt->execute()) {
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}

function count_level($uid, $np2con)
{
	global $admin_uid;
	$amount = array(50, 10, 9, 8, 7, 6, 5, 4, 3, 2);
	$lv = 0;
	foreach ($amount as $key => $value) {
		$get_referral_name_by_id = get_referral_by_id($uid, $np2con);
		echo '-' . $get_referral_name_by_id . '<br>';
		if ($get_referral_name_by_id != $admin_uid) {
			$get_referraled_user_id_by_name = get_id_by_name($get_referral_name_by_id, $np2con);
			$uid = $get_referraled_user_id_by_name;
			if ($get_referraled_user_id_by_name != '') {
				$lv = $lv + 1;
			}
		}
	}


	return $lv;
}
function gen_earn3($uid, $np2con)
{
	$ct = 0;
	$myUid = get_name_by_id($uid, $np2con);
	$uresult = $np2con->query("SELECT * FROM users where user_refferred= '" . $myUid . "' ", MYSQLI_USE_RESULT);
	$rty = array();
	if ($uresult) {
		while ($row = $uresult->fetch_assoc()) {
			$rty['' . $row['user_id'] . ''] = $row['user_id'];
			echo $user_refferred =  $row['user_name'];
			echo '<br>';
			$ct++;
		}
	}
	///1
	foreach ($rty as $key => $value) {
		$ct++;
		$uio = get_name_by_id($value, $np2con);
		$uresult = $np2con->query("SELECT * FROM users where user_refferred= '" . $uio . "' ", MYSQLI_USE_RESULT);
		$rty = array();
		if ($uresult) {
			while ($row = $uresult->fetch_assoc()) {
				$rty['' . $row['user_id'] . ''] = $row['user_id'];
				echo $user_refferred =  $row['user_name'];
				echo '<br>';
			}
		}
	}
	///2
	foreach ($rty as $key => $value) {
		$ct++;
		$uio = get_name_by_id($value, $np2con);
		$uresult = $np2con->query("SELECT * FROM users where user_refferred= '" . $uio . "' ", MYSQLI_USE_RESULT);
		$rty = array();
		if ($uresult) {
			while ($row = $uresult->fetch_assoc()) {
				$rty['' . $row['user_id'] . ''] = $row['user_id'];
				echo $user_refferred =  $row['user_name'];
				echo '<br>';
			}
		}
	}
	///3
	foreach ($rty as $key => $value) {
		$ct++;
		$uio = get_name_by_id($value, $np2con);
		$uresult = $np2con->query("SELECT * FROM users where user_refferred= '" . $uio . "' ", MYSQLI_USE_RESULT);
		$rty = array();
		if ($uresult) {
			while ($row = $uresult->fetch_assoc()) {
				$rty['' . $row['user_id'] . ''] = $row['user_id'];
				echo $user_refferred =  $row['user_name'];
				echo '<br>';
			}
		}
	}
	///4
	foreach ($rty as $key => $value) {
		$ct++;
		$uio = get_name_by_id($value, $np2con);
		$uresult = $np2con->query("SELECT * FROM users where user_refferred= '" . $uio . "' ", MYSQLI_USE_RESULT);
		$rty = array();
		if ($uresult) {
			while ($row = $uresult->fetch_assoc()) {
				$rty['' . $row['user_id'] . ''] = $row['user_id'];
				echo $user_refferred =  $row['user_name'];
				echo '<br>';
			}
		}
	}
	///5
	foreach ($rty as $key => $value) {
		$ct++;
		$uio = get_name_by_id($value, $np2con);
		$uresult = $np2con->query("SELECT * FROM users where user_refferred= '" . $uio . "' ", MYSQLI_USE_RESULT);
		$rty = array();
		if ($uresult) {
			while ($row = $uresult->fetch_assoc()) {
				$rty['' . $row['user_id'] . ''] = $row['user_id'];
				echo $user_refferred =  $row['user_name'];
				echo '<br>';
			}
		}
	}
	///6
	foreach ($rty as $key => $value) {
		$ct++;
		$uio = get_name_by_id($value, $np2con);
		$uresult = $np2con->query("SELECT * FROM users where user_refferred= '" . $uio . "' ", MYSQLI_USE_RESULT);
		$rty = array();
		if ($uresult) {
			while ($row = $uresult->fetch_assoc()) {
				$rty['' . $row['user_id'] . ''] = $row['user_id'];
				echo $user_refferred =  $row['user_name'];
				echo '<br>';
			}
		}
	}
	///7
	foreach ($rty as $key => $value) {
		$ct++;
		$uio = get_name_by_id($value, $np2con);
		$uresult = $np2con->query("SELECT * FROM users where user_refferred= '" . $uio . "' ", MYSQLI_USE_RESULT);
		$rty = array();
		if ($uresult) {
			while ($row = $uresult->fetch_assoc()) {
				$rty['' . $row['user_id'] . ''] = $row['user_id'];
				echo $user_refferred =  $row['user_name'];
				echo '<br>';
			}
		}
	}
	///8
	foreach ($rty as $key => $value) {
		$ct++;
		$uio = get_name_by_id($value, $np2con);
		$uresult = $np2con->query("SELECT * FROM users where user_refferred= '" . $uio . "' ", MYSQLI_USE_RESULT);
		$rty = array();
		if ($uresult) {
			while ($row = $uresult->fetch_assoc()) {
				$rty['' . $row['user_id'] . ''] = $row['user_id'];
				echo $user_refferred =  $row['user_name'];
				echo '<br>';
			}
		}
	}
	///9
	foreach ($rty as $key => $value) {
		$ct++;
		$uio = get_name_by_id($value, $np2con);
		$uresult = $np2con->query("SELECT * FROM users where user_refferred= '" . $uio . "' ", MYSQLI_USE_RESULT);
		$rty = array();
		if ($uresult) {
			while ($row = $uresult->fetch_assoc()) {
				$rty['' . $row['user_id'] . ''] = $row['user_id'];
				echo $user_refferred =  $row['user_name'];
				echo '<br>';
			}
		}
	}
	echo $ct;
}

function gen_earn($uid, $np2con)
{
	global $admin_id;
	$uid = $uid;
	$amount = array(1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
	foreach ($amount as $key => $value) {
		if ($uid != '') {
			$spamount = $value;
			$get_referral_name_by_id = get_referral_by_id($uid, $np2con);
			if ($get_referral_name_by_id != '') {
				$get_referraled_user_id_by_name = get_id_by_name($get_referral_name_by_id, $np2con);
				$uid = $get_referraled_user_id_by_name;
				if (add_earn($uid, $spamount, '2', $uid, $np2con, 0)) {
					notifier($uid, 'You Earn  (TK.' . $spamount . ') By Generation', $type = 0, $status = 0, $priotity = 0, $np2con);
				} else {
					notifier($admin_id, 'Generation to User ' . $get_referral_name_by_id . ' (TK.' . $spamount . ')', $type = 0, $status = 0, $priotity = 0, $np2con);
				}
				//echo ''.$get_referral_name_by_id.''.$spamount.'<br>';
			}
		}
	}
}
function gen_earn56($uid, $np2con)
{
	$all_id = array();
	/////////////////////////          	
	//   level1  Start   ///
	////////////////////////	
	//me  $uid = sayed22

	// who reffer me (sayed21)
	$ref_1 =  get_referral_by_id($uid, $np2con);
	$ref_1_id = get_id_by_name($ref_1, $np2con);
	$all_id['' . $ref_1_id . ''] = $ref_1_id;
	//echo $ref_1;
	/// under refferel (sayed21)
	$uresult = $np2con->query("SELECT * FROM users where user_refferred= '" . $ref_1 . "' ", MYSQLI_USE_RESULT);
	if ($uresult) {
		// get my reffrel user id as array 	
		while ($row = $uresult->fetch_assoc()) {
			$all_id['' . $row['user_id'] . ''] = $row['user_id'];
			//echo $row['user_name'].'-';	
		}
	}


	$ref_2 =  get_referral_by_id($ref_1_id, $np2con);
	$ref_2_id = get_id_by_name($ref_2, $np2con);
	$all_id['' . $ref_2_id . ''] = $ref_2_id;
	//echo $ref_1;
	/// under refferel (sayed21)
	$uresult = $np2con->query("SELECT * FROM users where user_refferred= '" . $ref_2 . "' ", MYSQLI_USE_RESULT);
	if ($uresult) {
		// get my reffrel user id as array 	
		while ($row = $uresult->fetch_assoc()) {
			$all_id['' . $row['user_id'] . ''] = $row['user_id'];
			//echo $row['user_id'].'-';	
		}
	}


	$ref_3 =  get_referral_by_id($ref_2_id, $np2con);
	$ref_3_id = get_id_by_name($ref_3, $np2con);
	$all_id['' . $ref_3_id . ''] = $ref_3_id;
	//echo $ref_1;
	/// under refferel (sayed21)
	$uresult = $np2con->query("SELECT * FROM users where user_refferred= '" . $ref_3 . "' ", MYSQLI_USE_RESULT);
	if ($uresult) {
		// get my reffrel user id as array 	
		while ($row = $uresult->fetch_assoc()) {
			$all_id['' . $row['user_id'] . ''] = $row['user_id'];
			//echo $row['user_id'].'-';	
		}
	}

	$ref_4 =  get_referral_by_id($ref_3_id, $np2con);
	$ref_4_id = get_id_by_name($ref_4, $np2con);
	$all_id['' . $ref_4_id . ''] = $ref_4_id;
	//echo $ref_1;
	/// under refferel (sayed21)
	$uresult = $np2con->query("SELECT * FROM users where user_refferred= '" . $ref_4 . "' ", MYSQLI_USE_RESULT);
	if ($uresult) {
		// get my reffrel user id as array 	
		while ($row = $uresult->fetch_assoc()) {
			$all_id['' . $row['user_id'] . ''] = $row['user_id'];
			//echo $row['user_id'].'-';	
		}
	}

	$ref_5 =  get_referral_by_id($ref_4_id, $np2con);
	$ref_5_id = get_id_by_name($ref_5, $np2con);
	$all_id['' . $ref_5_id . ''] = $ref_5_id;
	//echo $ref_1;
	/// under refferel (sayed21)
	$uresult = $np2con->query("SELECT * FROM users where user_refferred= '" . $ref_5 . "' ", MYSQLI_USE_RESULT);
	if ($uresult) {
		// get my reffrel user id as array 	
		while ($row = $uresult->fetch_assoc()) {
			$all_id['' . $row['user_id'] . ''] = $row['user_id'];
			//echo $row['user_id'].'-';	
		}
	}

	$ref_6 =  get_referral_by_id($ref_5_id, $np2con);
	$ref_6_id = get_id_by_name($ref_6, $np2con);
	$all_id['' . $ref_6_id . ''] = $ref_6_id;
	//echo $ref_1;
	/// under refferel (sayed21)
	$uresult = $np2con->query("SELECT * FROM users where user_refferred= '" . $ref_6 . "' ", MYSQLI_USE_RESULT);
	if ($uresult) {
		// get my reffrel user id as array 	
		while ($row = $uresult->fetch_assoc()) {
			$all_id['' . $row['user_id'] . ''] = $row['user_id'];
			//echo $row['user_id'].'-';	
		}
	}

	$ref_7 =  get_referral_by_id($ref_6_id, $np2con);
	$ref_7_id = get_id_by_name($ref_7, $np2con);
	$all_id['' . $ref_7_id . ''] = $ref_7_id;
	//echo $ref_1;
	/// under refferel (sayed21)
	$uresult = $np2con->query("SELECT * FROM users where user_refferred= '" . $ref_7 . "' ", MYSQLI_USE_RESULT);
	if ($uresult) {
		// get my reffrel user id as array 	
		while ($row = $uresult->fetch_assoc()) {
			$all_id['' . $row['user_id'] . ''] = $row['user_id'];
			//echo $row['user_id'].'-';	
		}
	}

	$ref_8 =  get_referral_by_id($ref_7_id, $np2con);
	$ref_8_id = get_id_by_name($ref_8, $np2con);
	$all_id['' . $ref_8_id . ''] = $ref_8_id;
	//echo $ref_1;
	/// under refferel (sayed21)
	$uresult = $np2con->query("SELECT * FROM users where user_refferred= '" . $ref_8 . "' ", MYSQLI_USE_RESULT);
	if ($uresult) {
		// get my reffrel user id as array 	
		while ($row = $uresult->fetch_assoc()) {
			$all_id['' . $row['user_id'] . ''] = $row['user_id'];
			//echo $row['user_id'].'-';	
		}
	}


	$ref_9 =  get_referral_by_id($ref_8_id, $np2con);
	$ref_9_id = get_id_by_name($ref_9, $np2con);
	$all_id['' . $ref_9_id . ''] = $ref_9_id;
	//echo $ref_1;
	/// under refferel (sayed21)
	$uresult = $np2con->query("SELECT * FROM users where user_refferred= '" . $ref_9 . "' ", MYSQLI_USE_RESULT);
	if ($uresult) {
		// get my reffrel user id as array 	
		while ($row = $uresult->fetch_assoc()) {
			$all_id['' . $row['user_id'] . ''] = $row['user_id'];
			//echo $row['user_id'].'-';	
		}
	}

	$ref_10 =  get_referral_by_id($ref_9_id, $np2con);
	$ref_10_id = get_id_by_name($ref_10, $np2con);
	$all_id['' . $ref_10_id . ''] = $ref_10_id;
	//echo $ref_1;
	/// under refferel (sayed21)
	$uresult = $np2con->query("SELECT * FROM users where user_refferred= '" . $ref_10 . "' ", MYSQLI_USE_RESULT);
	if ($uresult) {
		// get my reffrel user id as array 	
		while ($row = $uresult->fetch_assoc()) {
			$all_id['' . $row['user_id'] . ''] = $row['user_id'];
			//echo $row['user_id'].'-';	
		}
	}

	/// Remove Own id 
	if (array_key_exists($uid, $all_id)) {
		unset($all_id['' . $uid . '']);
	}
	/// array_unique	
	array_unique($all_id);



	foreach ($all_id as $key => $value) {
		if (check_acc_active($value, $np2con) == 'active') {
			if (get_dr_ref($value, $np2con) > 6) {
				add_earn($value, '1', '2', $uid, $np2con, 0);
			}
		}
	}

	/////////////////////////          	
	//   level1  End    ///
	////////////////////////


}
function gen_earn_worked($uid, $np2con)
{
	global $admin_id;
	$amount = array(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
	foreach ($amount as $key => $value) {
		if ($uid != '') {
			$spamount = $value;
			$get_referral_name_by_id = get_referral_by_id($uid, $np2con);
			if ($get_referral_name_by_id != '') {
				$get_referraled_user_id_by_name = get_id_by_name($get_referral_name_by_id, $np2con);
				$uid = $get_referraled_user_id_by_name;
				if (add_earn($uid, $spamount, '2', $admin_id, $np2con, 0)) {
					notifier($uid, 'You Earn  (TK.' . $spamount . ') By Generation', $type = 0, $status = 0, $priotity = 0, $np2con);
				} else {
					notifier($admin_id, 'Generation Faild to User ' . $get_referral_name_by_id . ' (TK.' . $spamount . ')', $type = 0, $status = 0, $priotity = 0, $np2con);
				}
				//echo ''.$get_referral_name_by_id.''.$spamount.'<br>';
			}
		}
	}
}
function gen_earn2($uid, $np2con)
{
	$my_reffel_name  = get_referral_by_id($uid, $np2con);
	$my_reffel_id = get_id_by_name($my_reffel_name, $np2con);
	$check_his_dr_ref = get_dr_ref($my_reffel_id, $np2con);
	///get all reff id
	$uresult = $np2con->query("SELECT * FROM users where user_refferred= '" . $my_reffel_name . "' ", MYSQLI_USE_RESULT);
	$rty = array();
	if ($uresult) {
		while ($row = $uresult->fetch_assoc()) {
			$rty['' . $row['user_id'] . ''] = $row['user_id'];
			echo $user_refferred =  $row['user_name'];
			echo '<br>';
		}
	}
	foreach ($rty as $key => $value) {
		echo $my_reffel_name  = get_referral_by_id($value, $np2con);
		echo '<br>';
	}




	echo $check_his_dr_ref;
}



function royal_earn($uid, $np2con)
{
	global $royal_ref_bonas;
	$get_referral_name_by_id = get_referral_by_id($uid, $np2con);
	$get_referraled_user_id_by_name = get_id_by_name($get_referral_name_by_id, $np2con);
	if (add_earn($get_referraled_user_id_by_name, $royal_ref_bonas, '1', $uid, $np2con, 0)) {
		notifier($uid, 'You Earn  (TK.' . $royal_ref_bonas . ') By Your Under Ref Royal Membership', $type = 0, $status = 0, $priotity = 0, $np2con);
		return true;
	}
}

function royal_regestar_earn($uid)
{
	global $royal_regter_bonas, $np2con;
	$get_referral_name_by_id = get_referral_by_id($uid, $np2con);
	$get_referraled_user_id_by_name = get_id_by_name($get_referral_name_by_id, $np2con);
	if (chk_user_is_royal($get_referraled_user_id_by_name)) {
		if (add_earn($get_referraled_user_id_by_name, $royal_regter_bonas, '1', $uid, $np2con, 0)) {
			notifier($get_referraled_user_id_by_name, 'You Earn  (TK.' . $royal_regter_bonas . ') By Your Under Registration', $type = 0, $status = 0, $priotity = 0, $np2con);
			return true;
		}
	}
}


function chk_user_is_royal($uid)
{
	global $np2con;
	$user_rank = 0;
	$uresult = $np2con->query("SELECT user_rank FROM users where user_id = '" . $uid . "'", MYSQLI_USE_RESULT);
	if ($uresult) {
		while ($row = $uresult->fetch_assoc()) {
			$user_rank = $row['user_rank'];
		}
	}

	if ($user_rank == '2') {
		return true;
	} else {
		return false;
	}
}

function spot_earn($uid, $np2con)
{
	global $admin_id;
	$cuser = $uid;
	$amount = array(50, 10, 9, 8, 7, 6, 5, 4, 3, 2);
	foreach ($amount as $key => $value) {
		if ($uid != '') {
			$spamount = $value;
			$get_referral_name_by_id = get_referral_by_id($uid, $np2con);
			if ($get_referral_name_by_id != '') {
				$get_referraled_user_id_by_name = get_id_by_name($get_referral_name_by_id, $np2con);
				$uid = $get_referraled_user_id_by_name;
				if (add_earn($uid, $spamount, '1', $cuser, $np2con, 0)) {
					notifier($uid, 'You Earn  (TK.' . $spamount . ') By Spot Link', $type = 0, $status = 0, $priotity = 0, $np2con);
				} else {
					notifier($admin_id, 'Spot Earn Faild to User ' . $get_referral_name_by_id . ' (TK.' . $spamount . ')', $type = 0, $status = 0, $priotity = 0, $np2con);
				}
				//echo ''.$get_referral_name_by_id.''.$spamount.'<br>';
			}
		}
	}
}


function get_uid_by_order($order_id)
{
	global $con;
	$customer_id = 0;
	//get cutomer user id 
	$sqlus = "SELECT * FROM orders where id = '$order_id'";
	$resultus = mysqli_query($con, $sqlus);
	while ($rowo = mysqli_fetch_assoc($resultus)) {
		$customer_id = $rowo['customer_id'];
	}
	return  $customer_id;
}

function get_prdct_gen_text($product_id)
{
	global $con;
	$gen_txt = 0;
	//get cutomer user id 
	$sqlus = "SELECT product_genrtn FROM products where id = '$product_id'";
	$resultus = mysqli_query($con, $sqlus);
	while ($rowo = mysqli_fetch_assoc($resultus)) {
		$gen_txt = $rowo['product_genrtn'];
	}
	return  $gen_txt;
}





function product_gen_earn($uid, $prodc_gen)
{
	global $admin_id, $np2con;
	$prodc_gen = explode('-', $prodc_gen);
	$cuser = $uid;
	$fstGen = $prodc_gen[0];
	$tst = $uid . '~' . $fstGen . '<br>';
	//Fast gen income
	add_earn($uid, $fstGen, '1', $cuser, $np2con, 0);
	notifier($uid, 'You Earn  (TK.' . $fstGen . ') By Product Genaration Link', $type = 0, $status = 0, $priotity = 0, $np2con);
	//$tst = 'UsiD:'.$uid.'~RefName:'.$get_referral_name_by_id.'~Amount:'.$spamount.'<br>';

	array_shift($prodc_gen);
	$amount = $prodc_gen;
	foreach ($amount as $key => $value) {

		if ($uid != '') {
			$spamount = $value;
			$get_referral_name_by_id = get_referral_by_id($uid, $np2con);
			if ($get_referral_name_by_id != '') {
				$get_referraled_user_id_by_name = get_id_by_name($get_referral_name_by_id, $np2con);
				$uid = $get_referraled_user_id_by_name;
				//echo $uid.'<br>';
				$tst .= 'UsiD:' . $uid . '~RefName:' . $get_referral_name_by_id . '~Amount:' . $spamount . '<br>';
				if (add_earn($uid, $spamount, '1', $cuser, $np2con, 0)) {
					notifier($uid, 'You Earn  (TK.' . $spamount . ') Product Genaration Link', $type = 0, $status = 0, $priotity = 0, $np2con);
				} else {
					notifier($admin_id, 'Product Genaration Link Faild ' . $get_referral_name_by_id . ' (TK.' . $spamount . ')', $type = 0, $status = 0, $priotity = 0, $np2con);
				}
				//echo ''.$get_referral_name_by_id.''.$spamount.'<br>';
			}
		}
	}
	//return $tst;
	return true;
}

/////////////////////////
///
/////////////////////////	

function get_db_balance($uid, $np2con, $type)
{
	$balance_debit = 0;
	$resultmoneyd = $np2con->query("SELECT * FROM `balance_debit` where bd_user = '" . $uid . "'", MYSQLI_USE_RESULT);
	if ($resultmoneyd) {
		while ($row2 = $resultmoneyd->fetch_assoc()) {
			$balance_debit = $balance_debit + $row2['bd_amount'];
		}
	}
	return $balance_debit;
}


function get_balance($uid, $type = 0)
{
	$current_balance = 0;
	$balance_debit = 0;
	global $day, $month, $year, $np2con;

	if ($type == 'all') {
		$resultmoney = $np2con->query("SELECT * FROM `balance_cradit` where bc_user = '" . $uid . "'", MYSQLI_USE_RESULT);
		if ($resultmoney) {
			while ($row = $resultmoney->fetch_assoc()) {
				$current_balance = $current_balance + $row['bc_amount'];
			}
			$resultmoney->close(); // Move close() inside if block
		}

		$resultmoneyd = $np2con->query("SELECT * FROM `balance_debit` where bd_user = '" . $uid . "'", MYSQLI_USE_RESULT);
		if ($resultmoneyd) {
			while ($row2 = $resultmoneyd->fetch_assoc()) {
				$balance_debit = $balance_debit + $row2['bd_amount'];
			}
		}
		$currect_balance = $current_balance - $balance_debit;
		return $currect_balance;
	}
	// Remove the $resultmoney->close() from here
}

function get_wb($uid, $np2con)
{
	$current_wb = 0;
	$resultmoney = $np2con->query("SELECT * FROM `withdraw_balance` where wb_user = '$uid' AND wb_status = '0' ", MYSQLI_USE_RESULT);
	if ($resultmoney) {
		while ($row = $resultmoney->fetch_assoc()) {
			$current_wb = $current_wb + $row['wb_amount'];
		}
	}
	return $current_wb;
}


function get_ar($uid, $np2con)
{
	//$resultck = $np2con->query("SELECT COUNT(*)  FROM `account_activation` Where aa_user = '4'");
	//$row = $resultck->fetch_row();
	//$totalpin = $row[0];	
	//$resultck->close();

	if ($result = $np2con->query("SELECT * FROM product_request Where pr_user = '$uid'")) {

		/* determine number of rows result set */
		$row_cnt = $result->num_rows;
	}
	echo $uid;
}

function get_badge($np2_user_level)
{
	if ($np2_user_level == '1') {
		return '<span style="background: #FF9800;" class="dbadge">SUPER ADMIN</span>';
	} elseif ($np2_user_level == '2') {
		return '<span style="background: #8BC34A;" class="dbadge">GENERAL ADMIN</span>';
	} elseif ($np2_user_level == '0') {
		return '<span style="background: #00BCD4;" class="dbadge">MEMBER</span>';
	}
}

function get_acc_type($account_status)
{

	if ($account_status == '0') {
		return $notifi_panding = '<span class="badge msg_show_yallow"><i class="fa fa-check-circle"></i> InActive!!</span>';
	} elseif ($account_status == '1') {
		return $notifi_active = '<span class="badge msg_show_green"><i class="fa fa-check-circle"></i> Activeted!!</span>';
	} elseif ($account_status == '2') {
		return $notifi_ban = '<span class="badge msg_show_red"><i class="fa fa-ban"></i> Baned!!</span>';
	}
}

function subcount($us)
{
	$np2con = new mysqli('localhost', 'root', '', 'newproject');
	if ($np2con->connect_errno > 0) {
		die('Unable to connect to database [' . $np2con->connect_error . ']');
		exit();
	}
	$np2con->set_charset('utf8');

	$uresult = $np2con->query("SELECT (user_id) FROM users where referral_user = '$us'", MYSQLI_USE_RESULT);
	$dates = array(0 => "dl");
	unset($dates[0]);
	//$f = 'bb';
	if ($uresult) {
		while ($row = $uresult->fetch_assoc()) {
			$dates['' . $row['user_id'] . ''] = '' . $row['user_id'] . '';
			//$f .= ''.$row['user_id'].'';
		}
	}
	$sub_ref = count($dates);
	return 	$sub_ref;
}



function get_referral($uid, $type, $np2con)
{
	if ($type == 'orginal') {
		$resultreferral = $np2con->query("SELECT COUNT(user_id) FROM `users` where referral_user = '$uid'");
		$rowrf = $resultreferral->fetch_row();
		$totalrf = $rowrf[0];
		$resultreferral->close();
		return $totalrf;
	}

	if ($type == 'withsubed') {
		$resultreferral = $np2con->query("SELECT COUNT(user_id) FROM `users` where referral_user = '$uid' AND referral_status = '0' ");
		$rowrf = $resultreferral->fetch_row();
		$totalrf = $rowrf[0];

		$uresult = $np2con->query("SELECT (user_id) FROM users where referral_user = '$uid'", MYSQLI_USE_RESULT);
		$dates = array(0 => "dl");
		unset($dates[0]);
		//$f = 'bb';
		if ($uresult) {
			while ($row = $uresult->fetch_assoc()) {
				$dates['' . $row['user_id'] . ''] = '' . $row['user_id'] . '';
				//$f .= ''.$row['user_id'].'';
			}
		}
		$orginal_ref = count($dates);
		$sub = 0;
		foreach ($dates as $key => $value) {
			//echo df($value);
			$sub = $sub + subcount($value);
			//echo $value;
		}
		$resultreferral->close();
		return $orginal_ref + $sub;
	} elseif ($type == 'payable') {
		$resultreferral = $np2con->query("SELECT COUNT(user_id) FROM `users` where referral_user = '$uid' AND referral_status = '0' AND account_status = '1'  ");
		$rowrf = $resultreferral->fetch_row();
		$totalpayable = $rowrf[0];
		$resultreferral->close();
		return $totalpayable;
	}
}

function count_easyearn($type, $np2con)
{
	if ($type == 'youtube') {
		$ctype = 1;
	} elseif ($type == 'website') {
		$ctype = 2;
	}
	$resulttkt = $np2con->query("SELECT COUNT(ea_id)  FROM `earning_list` where ea_type = '" . $ctype . "'");
	$rowtkt = $resulttkt->fetch_row();
	$total_link = $rowtkt[0];
	$resulttkt->close();
	return $total_link;
}



function pr($arr)
{
	echo '<pre>';
	print_r($arr);
}

function prx($arr)
{
	echo '<pre>';
	print_r($arr);
	die();
}

function get_safe_value($con, $str)
{
	if ($str != '')
		return mysqli_real_escape_string($con, $str);
}

function get_safe_value_sa($key)
{
	// Retrieve the value from $_GET and sanitize it
	// $key = filter_input(INPUT_GET, $key, FILTER_SANITIZE_STRING);
	$key = htmlspecialchars($key, ENT_QUOTES, 'UTF-8'); // Convert special chars to HTML entities
	return $key;
}



function reverse_mysqli_real_escape_string($str)
{
	return html_entity_decode(stripslashes($str));
}


function reloader($link = '', $timer = 1000)
{
	global $actual_link;
	if ($link == '') {
		$link = $actual_link;
	}
	return '<script>setTimeout(function(){window.location = "' . $link . '"},' . $timer . ');</script>';
}


function generateRandomString($length = 10)
{
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}


function sendGSMS($senderID, $recipient_no, $message, $api_key, $sms_type = 'text&contacts')
{
	$senderID = "8809617620596";
	$api_key = "39|QEHGxxmparbleyM2yb3M2QNGX3hpIPT25TodHf2c";
	$message = $message;
	$url = "https://login.esms.com.bd/api/v3/sms/send";
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$headers = array(
		"Accept: application/json",
		"Authorization: Bearer  $api_key",
		"Content-Type: application/json",
	);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

	$data = [
		'recipient' => '88' . $recipient_no,
		'sender_id' => $senderID,
		'message' => urldecode($message),
	];

	curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
	//print_r $curl;
	//for debug only!
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

	$resp = curl_exec($curl);
	curl_close($curl);

	return $resp;
}


function pagination_all($countrow, $per_page = 6, $page = 1, $url = '?')
{
	//$query = "SELECT COUNT(*) as `num` FROM {$query}";
	//$row = mysql_fetch_array(mysql_query($query));
	$total = $countrow;
	$adjacents = "2";
	$page = ($page == 0 ? 1 : $page);
	$start = ($page - 1) * $per_page;

	$prev = $page - 1;
	$next = $page + 1;
	$lastpage = ceil($total / $per_page);
	$lpm1 = $lastpage - 1;

	$pagination = "";
	if ($lastpage > 1) {
		$pagination .= "<ul class='pagination'>";
		$pagination .= "<li class='details'>Page $page of $lastpage</li>";
		if ($lastpage < 7 + ($adjacents * 2)) {
			for ($counter = 1; $counter <= $lastpage; $counter++) {
				if ($counter == $page)
					$pagination .= "<li><a  href='{$url}page=$counter' class='current'>$counter</a></li>";
				else
					$pagination .= "<li><a href='{$url}page=$counter'>$counter</a></li>";
			}
		} elseif ($lastpage > 5 + ($adjacents * 2)) {
			if ($page < 1 + ($adjacents * 2)) {
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
					if ($counter == $page)
						$pagination .= "<li><a class='current'>$counter</a></li>";
					else
						$pagination .= "<li><a href='{$url}page=$counter'>$counter</a></li>";
				}
				$pagination .= "<li class='dot'>...</li>";
				$pagination .= "<li><a href='{$url}page=$lpm1'>$lpm1</a></li>";
				$pagination .= "<li><a href='{$url}page=$lastpage'>$lastpage</a></li>";
			} elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
				$pagination .= "<li><a href='{$url}page=1'>1</a></li>";
				$pagination .= "<li><a href='{$url}page=2'>2</a></li>";
				$pagination .= "<li class='dot'>...</li>";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
					if ($counter == $page)
						$pagination .= "<li><a class='current'>$counter</a></li>";
					else
						$pagination .= "<li><a href='{$url}page=$counter'>$counter</a></li>";
				}
				$pagination .= "<li class='dot'>..</li>";
				$pagination .= "<li><a href='{$url}page=$lpm1'>$lpm1</a></li>";
				$pagination .= "<li><a href='{$url}page=$lastpage'>$lastpage</a></li>";
			} else {
				$pagination .= "<li><a href='{$url}page=1'>1</a></li>";
				$pagination .= "<li><a href='{$url}page=2'>2</a></li>";
				$pagination .= "<li class='dot'>..</li>";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
					if ($counter == $page)
						$pagination .= "<li><a class='current'>$counter</a></li>";
					else
						$pagination .= "<li><a href='{$url}page=$counter'>$counter</a></li>";
				}
			}
		}

		if ($page < $counter - 1) {
			$pagination .= "<li><a href='{$url}page=$next'>Next</a></li>";
			$pagination .= "<li><a href='{$url}page=$lastpage'>Last</a></li>";
		} else {
			$pagination .= "<li><a class='current'>Next</a></li>";
			$pagination .= "<li><a class='current'>Last</a></li>";
		}
		$pagination .= "</ul>\n";
	}


	return $pagination;
}

function get_stuck_balance($c_user_id, $type)
{
	$current_balance = 0;
	$balance_debit = 0;
	global $day, $month, $year, $np2con;
	if ($type == 'all') {
		$fgsadhj = "SELECT * FROM `deposit_request` where `dr_user_id` = " . $c_user_id . " AND `dr_status` = 1";
		$resultmoney = $np2con->query($fgsadhj, MYSQLI_USE_RESULT);
		if ($resultmoney) {
			while ($row = $resultmoney->fetch_assoc()) {
				$current_balance = $current_balance + $row['dr_amount'];
			}
		}
		return $current_balance;
	}
}
