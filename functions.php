<?
/*
my_setcookie() - hashed
my_getcookie() - hashed
rankup() - increase rank points for activity, used in search sorting
rank_tradedocs() -  rank points for generated tradedocs (3 points if reached 3 TD, 5 points for 10 TD, 10 points for 20+ TD; deleted TD don't count)
get_ip()
get_agent()
update_db_ip() - update `members` for IP
reg_visit() - to register visits of smb's pages for statistics (unique visitors this month, world map of visitors, etc)
cast_price() - 6,$ ==> $6.00 USD
cypher_pass() - see upper level folder scripts (db)
cypher_secret()- see upper level folder scripts (cookies)

commastrip($str, $n)
chopa($var, $dlina)
filled($var)
null2empty($var)
empty2null($var)
line($var)
line2br($var)
dmony($var) - d M Y
table_line($odd_line, $color1, $color2)
add_zero($var)
is_expired($exp_mo, $exp_yr)
long_cut($string, $cn_cut) - dsfdsf...

draw_paging($this_page, $ppp, $parameters)
do_paging()

is_ajax() - Function to check if the request is an AJAX request
search_func() - does effective search
sender() - sends email
sender_joinfor()
getExt() - file extension
twoimages() - bigger and smaller
get_small_prod($comp_id, $photo)
get_small_lead($comp_id, $photo)
get_avatar($comp_id, $photo, $logo, $size)
get_prodpic($comp_id, $photo, $size, $w=0, $h=0)
get_prodpic_wh($src)
fit_img($src, $box_width, $box_height) - fit img into [$w x $h] box
page_encode() - to get back to the same page after login
is_ie8()
mybrowser()
clean_data() - avoid SQL, JS and HTML injections
unclean_data() - to see pdf or ajax result without &#39;
is_date()
is_email()
get_company_name()
is_num_list()
is_my_product($prod_id)
get_product_name($prod_id)
is_my_group($group_id)
get_group_name($group_id)
get_group_id($group_name, $memb_id, $to_add) - Get group_id by its name and member_id. Add it if it doesn't exist.

is_comp_channel($comp_id, $str_id)	- check that this company possesses this channel structure
apply_channel_discount($channel_struct_id, $channel, $price_unit)
get_default_struct($comp_id)
is_superseded($prod_id, $comp_id, $struct_id, $role_id)
is_product_channelled(prod_id, struct_id) - to use in pricelist. Checks if the product falls under specific channel structure
get_superseded_price($prod_id, $comp_id, $struct_id, $role_id)
get_5channel_discounts($channel_struct_id, $price_init)	- asia, fob_price=$10 ==> array($10, $8, $7, $6, $2)
get_product_price() - final price - channelled (default channelled) and superseded (if any)
is_my_invoice($inv_id, $doc_type_id)
apply_volume_discount($prod_id, $qty, $price)
get_volume_discount($prod_id, $qty, $price)
get_pdf_link($doc_type_id, $invoice_id) - get tradedoc PDF link for downloading (in GB email)

get_id_by_url() - VoipConcept => 1
get_url_by_id() - 1 ==> VoipConcept
make_comp_url()	- Global-Voice Inc. ==> GlobalVoiceInc
check_comp_url() - return clean and unique comp_url
clean_filename - clean non-english and special characters
get_filename() - file.of.mine.jpg ==> file.of.mine
product_url() - 155,brown-rice ==> localhost:8888/product/155-brown-rice
clean_product_url - clean non-english and special characters, except dash
get_LG() - return en, cn
get_lang_field()  - get db field categ, categ_cn, categ_kr, categ_ru depending on cur. lang
get_lang_field($row, $row_name)	- get row[categ], row[categ_cn], row[categ_kr] depending on current lang
get_lang_column($row_name)	- get categ, categ_cn, categ_kr depending on current lang
import_prod_pic($photo_url, $comp_id, $prod_id) - import product picture from URL into db and file system (my_products_upload.php)
convert_utf8($var) - when importing a CSV file, some chars can be in different unicode, so convert it to UTF-8

fav_prod() - call js
follow() - call js
*/

$cookietime = 3600*24*1;	// 1 day

error_reporting(1);	// disable
error_reporting(E_ERROR | E_PARSE);

// Brain Tree Payment
$BT_test = 1;
if ($BT_test==1){
	$BT_public_key = "7m6wpd8xdzdr3v4m";
	$BT_private_key = "3e05794ebb299a5b34b73863aa56e247";
	$BT_merchant_id = "gjpct7sy3cb2fmrk";
	$BT_environment = "sandbox";
}
else{
	$BT_public_key = "7m6wpd8xdzdr3v4m";
	$BT_private_key = "3e05794ebb299a5b34b73863aa56e247";
	$BT_merchant_id = "gjpct7sy3cb2fmrk";
	$BT_environment = "production";
}

// Global Shopex iFrame Solution (login at http://globalshopex.com/loginMerchant.aspx)
$GSH_merchant_id = 2458626;
$GSH_test = 0;
if ($GSH_test==1)
	$GSH_checkout = "http://test.globalshopex.com/iframe/InternationalCheckout.aspx";
else
	$GSH_checkout = "https://globalshopex.com/iframe/InternationalCheckout.aspx";


if (get_LG()=="kr"){
	$arr_channels = array("소비자", "소매업체", "유통업체", "도매업체", "중개인/대리인");
}
elseif (get_LG()=="cn"){
	$arr_channels = array("顾客", "零售商", "经销商", "批发商", "代表");
}
else{
	$arr_channels = array("Consumer", "Retailer", "Distributor", "Wholesaler", "Broker/Rep");
}

$arr_ustates = Array("Alabama", "Alaska", "Arizona", "Arkansas", "California", "Colorado", "Connecticut", "District of Columbia", "Delaware", "Florida", "Georgia", "Hawaii", "Idaho",
					"Illinois", "Indiana", "Iowa", "Kansas", "Kentucky", "Louisiana", "Maine", "Maryland", "Massachusetts", "Michigan", "Minnesota", "Mississippi",
					"Missouri", "Montana", "Nebraska", "Nevada", "New Hampshire", "New Jersey", "New Mexico", "New York", "North Carolina", "North Dakota", "Ohio",
					"Oklahoma", "Oregon", "Pennsylvania", "Rhode Island", "South Carolina", "South Dakota", "Tennessee", "Texas", "Utah", "Vermont", "Virginia",
					"Washington", "West Virginia", "Wisconsin", "Wyoming");

$arr_us = Array("AL", "AK", "AZ", "AR", "CA", "CO", "CT", "DC", "DE", "FL", "GA", "HI", "ID", "IL", "IN", "IA", "KS", "KY", "LA", "ME", "MD", "MA", "MI", "MN", "MS", "MO",
				"MT", "NE", "NV", "NH", "NJ", "NM", "NY", "NC", "ND", "OH", "OK", "OR", "PA", "RI", "SC", "SD", "TN", "TX", "UT", "VT", "VA", "WA", "WV", "WI", "WY");

$ar_units = Array("Bag(s)", "Barrel(s)", "Bushel(s)", "Case(s)", "Cubic Meter", "Dozen", "Gallon", "Gram", "Kilogram", 
					"Kilometer", "Liter(s)", "Long Ton", "Meter", "Metric Ton", "Miligram", "Ounce", "Pair", "Pack(s)", 
					"Piece(s)", "Pound", "Set(s)", "Short Ton", "Square Meter", "Ton", "Unit(s)", "Yard(s)");
$ar_curr = Array("USD", "GBP", "RMB", "EUR", "AUD", "CAD", "CHF", "JPY", "HKD", "NZD", "SGD", "NTD", "Other");
$ar_curr2 = Array(	"USD"=>"$", 
					"GBP"=>"<i class='fa fa-gbp'></i>", 
					"RMB"=>"<i class='fa fa-rmb'></i>", 
					"EUR"=>"<i class='fa fa-eur'></i>", 
					"AUD"=>"$", "CAD"=>"$", "CHF", 
					"JPY"=>"<i class='fa fa-rmb'></i>", 
					"HKD"=>"$", "NZD"=>"$", "SGD"=>"$", "NTD"=>"$", "Other");
$ar_time = Array("Day", "Week", "Month", "Year");
$ar_expdate = Array("12 month", "6 month", "4 month", "2 month", "1 month", "2 week", "1 week");

$arr_incoterms = Array("CFR", "CIF", "CIP", "CPT", "DAT", "DAP", "DDP", "EXW", "FAS", "FCA", "FOB");

$arr_url_reserved = array("expowest", "join", "joinfor", "features", "tradeware", "tradefeed", "marketplace", 
						"about", "contact", "buyers", "sellers", "pricing", "terms", "privacy", "product",
						"index", "home", "globemart", "cpanel", "admin", "administrator");

$arr_lang = array(
		"en" => array("flag"=>"United-States.png", "language"=>"English", "lg"=>"en", "language_tr"=>""),
		"cn" => array("flag"=>"China.png", "language"=>"Chinese", "lg"=>"cn", "language_tr"=>"中文"),
		"kr" => array("flag"=>"South-Korea.png", "language"=>"Korean", "lg"=>"kr", "language_tr"=>"한국어")
);						

$MAX_FILE_SIZE = 1500000;	// in bytes, 1.5 Mb
$MAX_FILE_SIZE_KB = 1500;	// in kilobytes
$MAX_FILE_SIZE_MB = 1.5;	// in kilobytes

$photo_prod_text = "<i>JPG, JPEG, GIF, PNG only, $MAX_FILE_SIZE_MB Mb Max.</i>";
$photo_memb_text = "<i>JPG, JPEG, GIF, PNG only, $MAX_FILE_SIZE_MB Mb Max.</i>";
$photo_logo_text = "JPG, JPEG, GIF, PNG only, $MAX_FILE_SIZE_MB Mb Max.";
$doc_text = "<i>DOC, DOCX, XLS, XLSX and PDF only, $MAX_FILE_SIZE_MB Mb Max</i>";

$MAX_FILE_SIZE_ATTACHMENT = 5120000;	// 4.88 Mb
$arr_extens = array("doc", "docx", "xls", "xlsx", "pdf", "csv", "rtf", "txt", "vdx", "vsd", "vss", "vst",
					"jpg", "jpeg", "gif", "png", "psd", "tiff", "tif", "bmp", "zip", "rar",
					"pot", "potm", "potx", "ppa", "ppam", "pps", "ppsm", "ppsx", "ppt", "pptm", "pptx");
						
$ast = "<font color='red'>* </font>";
$admin = "Admin";	// admin name to be displayes in messages (from/to)
$ADMIN_EMAIL = "jaytsao8@gmail.com";

$URL = "";
$URL13 = "https://localhost:8888/globemart2013/";
$URL13 = $URL;
$URL_DD = "../";	// for file_exists
$URL_DD = "";	// for file_exists
$BLANK_PROD = $URL."Media/blanks/blank_prod.gif";

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
$headers .= 'From: Globemart <info@localhost:8888>' . "\r\n";

$LONG_NUMBER = 24841780;	// random number to make product ID in URL look longer as if we are big and cool

$CN_ADDL_CLMNS_PRCLST = 2;	// in pricelist, number of additional custom columns
$COMMOD_HINT = "<i class='fa fa-info-circle' data-toggle='tooltip' data-placement='top' title='Start typing a product name to see suggested products of seller/vendor' style='cursor:default'></i>";
$SLIDE_HINT = "<span class='hidden-lg hidden-md'><i class='fa fa-info-circle' style='color:blue'></i> Slide table to the left if it doesn't fit the screen.</span>";
$FA_COMMOD_POPUP = "<i class='fa fa-external-link-square' data-toggle='tooltip' data-placement='top' title='Pop up list of vendor&#39;s commodities'></i>";
$FA_CLIENTS_POPUP = "<i class='fa fa-external-link-square' data-toggle='tooltip' data-placement='top' title='Pop up list of your sellers and buyers'></i>";

$fav_prod_title0 = "Add to Favorites";
$fav_prod_title1 = "In Favorites. Click to Drop from Favorites.";
$fav_prod_color0 = "#AAAAAA";
$fav_prod_color1 = "red";
$follow_button0 = "<div style='white-space:nowrap'><i class='icon-eye-open' style='font-size:11px'></i><i class='fa fa-eye' style='font-size:11px'></i> FOLLOWING</div>";
$follow_button1 = "FOLLOW+";
// $follow_button0 - don't break this long line!

$R_MAIL_RESPONSE = 1;	// ranks
$R_FEED_POST = 1;
$R_FEED_COMMENT = 1;
$R_FOLLOWERS10 = 2;
$R_FOLLOWERS50 = 5;
$R_FOLLOWERS100 = 10;
$R_DAILY_LOGIN = 1;
$R_TRADEDOCS03 = 3;
$R_TRADEDOCS10 = 5;
$R_TRADEDOCS20 = 10;
$R_INVITED05 = 3;
$R_INVITED10 = 5;
$R_INVITED20 = 10;



function commastrip($str, $n){
	$len = strlen($str);
	if ($len > $n)
		return substr($str, 0, $len-$n);
}

function chopa($var, $dlina){
	if (strlen($var) > $dlina)
		return substr($var, 0, $dlina) . "...";
	else
		return $var;
}

function filled($var){
	$filled = false;
	if ($var != null){
		$var = trim($var);
		if ($var!="" and $var!="0")
			$filled = true;
	}
	return $filled;
}

function null2empty($var){
	return is_null($var) ? "" : $var;
}

function empty2null($var){
	return ($var=="") ? "NULL" : "'" . $var  . "'";
}

function line($var){
	for ($i=1; $i<=$var; $i++)
		echo "<tr><td>&nbsp;</td></tr>";
}

function line2br($var){
	return str_replace("\r\n", "<br>\r\n", $var);
}

function dmony($var){
	return date('d M Y', strtotime(date("Y-m-d", strtotime($var))));
}

function table_line($odd_line, $color1, $color2){
	global $odd_line;
	++$odd_line;
	echo ($odd_line % 2 == 0) ? $color1 : $color2;
}

function add_zero($var){
	return intval($var)<=9 ? "0".intval($var) : $var;
}

function is_expired($exp_mo, $exp_yr){		// (05,14) or (5,2014)
	if (is_numeric($exp_mo) && is_numeric($exp_yr)){
		$now_month = date("n");	// 4
		$now_year = ($exp_yr > 2000) ? date("Y") : date("y");	// 2011 : 11
		return ($now_year > $exp_yr or ($now_year == $exp_yr and $now_month > $exp_mo)) ? true : false;
	}
	else 
		return false;
}

function long_cut($string, $cn_cut){
	if (strlen($string) > $cn_cut)
		return substr($string, 0, $cn_cut)."...";
	else
		return $string;
}

function draw_paging($this_page, $ppp, $parameters, $comp_url=""){
	global $URL;
	$href = "?page=".$ppp.$parameters;
	if ($comp_url!="")
		$href = $URL.$comp_url."/".$ppp.$parameters;
	echo "<li";
	if ($this_page==$ppp) echo " class='active'";
	echo "><a href='$href'>".$ppp."</a></li>";
}
function page_dots(){
	echo "<li><a href='javascript:void(0)'>...</a></li>";
}
function do_paging($page_count, $this_page, $cn_rec, $parameters, $comp_url=""){
	global $URL;
	if ($page_count>=2){
		echo "<div class='text-center'><ul class='pagination pagination'>";
		if ($this_page!=1) {	// previous
			$prev_page = $this_page-1;
			$href = "?page=".$prev_page.$parameters;
			if ($comp_url!="")
				$href = $URL.$comp_url."/".$prev_page.$parameters;
			echo "<li><a href='$href'><i class='fa fa-chevron-left'></i></a></li>";
		}
		
		// pages 1 [2] 3
		if (($this_page>=1 and $this_page<=5) or $page_count<=10){	// Start - 1 .. 10
			for ($ppp=1; $ppp<=($page_count>=10 ? 10 : $page_count); $ppp++){		
				draw_paging($this_page, $ppp, $parameters, $comp_url);
			}
			if ($page_count>10){
				echo page_dots();
				draw_paging($this_page, $page_count, $parameters, $comp_url);	// always last page
			}
		}
		
		if ($this_page>=6 and $this_page<=$page_count-6 and $page_count>10){	// Middle
			draw_paging($this_page, 1, $parameters, $comp_url);	// always first page
			if ($this_page >= 6+1) echo page_dots();
			for ($ppp=$this_page-4; $ppp<=$this_page+5; $ppp++){
				draw_paging($this_page, $ppp, $parameters, $comp_url);
			}
			if ($this_page <= $page_count-6-1) echo page_dots();
			draw_paging($this_page, $page_count, $parameters, $comp_url);	// always last page
		}
		
		if ($this_page > $page_count-6 and $page_count>10){	// End
			draw_paging($this_page, 1, $parameters, $comp_url);	// always first page
			echo page_dots();
			for ($ppp=$this_page-5; $ppp<=$page_count; $ppp++){
				draw_paging($this_page, $ppp, $parameters, $comp_url);
			}
		}

		if ($this_page!=$page_count){	// next
			$next_page = $this_page+1;
			$href = "?page=".$next_page.$parameters;
			if ($comp_url!="")
				$href = $URL.$comp_url."/".$next_page.$parameters;
			echo "<li><a href='$href'><i class='fa fa-chevron-right'></i></a></li>";
		}
		echo "</ul>";
		if ($cn_rec!="") echo "<br><p id='total_count'>$cn_rec results</p>";
		echo "</div>";
	}
}

// Function to check if the request is an AJAX request
function is_ajax() {
	return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
} 

// effective search
function search_func($param, $like_fields, $type="product"){
	$omit_arr = array("the", "an", "and", "not", "of", "with", "for", "from", "to", "as", "at", "by", "but", "in", "out", "on", "off", "or");
	$arraySearch2 = explode(" ", $param);					// string with spaces -- to array (hair and nails)
	$arraySearch = array_diff($arraySearch2, $omit_arr);	// clean array from needless words (hair, nails)
	$countSearch = count($arraySearch);	// 2
	
	$qu_search = "";
	$b = 0;
	while ($b <= $countSearch+1) {
		$piece = clean_data($arraySearch[$b]);	// separate word (hair, nails)
		$b++;
		
		$str_piece ="";
		if (strlen($piece)>=2){		// not a single letter
			// $like_fields - "P.product, P.keyword" ---turn-to--->  
			// " AND (  (P.product LIKE '%hair%' OR P.keyword LIKE '%hair%') OR 
			//			(P.product LIKE '%nails%' OR P.keyword LIKE '%nails%') )"
			$like_fields_arr = explode(", ", $like_fields);
			foreach ($like_fields_arr as $x){
				//$str_piece = $str_piece . " ($x LIKE '%$piece%') OR ";	// P.product LIKE '%$piece%' OR P.keyword LIKE '%$piece%' OR
				if ($type=="company")
					$str_piece = $str_piece ." ($x LIKE '% $piece%' or $x LIKE '$piece%') ";
				else
					$str_piece = $str_piece . " ($x='$piece' or $x LIKE '$piece %' or $x LIKE '$piece,%' or $x LIKE '% $piece' or $x LIKE '% $piece %' or $x LIKE '% $piece,%') OR ";	// P.product LIKE '%$piece%' OR P.keyword LIKE '%$piece%' OR
			}
			if (substr($str_piece, -4)==" OR ")	$str_piece = commastrip($str_piece, 4); // remove last inner OR 
				
			if ($str_piece!="")
				$qu_search = $qu_search . " (" . $str_piece . ") OR ";	// embrace with skobki and cyclic outer OR
		}
	}
	// remove last outer OR 	// e.g. (like or like) OR (like or like) OR 
	if (substr($qu_search, -4)==" OR ") $qu_search = commastrip($qu_search, 4);	
	
	// e.g. AND ((like or like) OR (like or like))
	$qu_search = ($qu_search=="") ? "" : " AND (" . $qu_search . ") ";		// embrace it all with BIG SKOBKI with leading main AND
	
	return $qu_search;
}

function sender($memb_id, $custom_subject, $custom_message, $msg_id, $is_ajax, $hash="", $arr_attachments="", $is_from_admin=0){
	global $URL, $URL13, $headers, $_COOKIE_comp_id, $_COOKIE_memb_id;
	if (is_numeric($memb_id)){
		$query   = "SELECT email, firstname, lastname, bell_messages FROM members WHERE id='$memb_id'";
		$result  = mysql_query($query);
		$row     = mysql_fetch_array($result, MYSQL_ASSOC);
		$toemail = $row['email'];
		$personname = $row['firstname'] . " " . $row['lastname'];
		$bell_messages = $row['bell_messages'];	// bell settings: wheather to notify him via his actual email
	}
	elseif (is_email($memb_id)){
		$toemail = $memb_id;
		$bell_messages = 1;
	}
	
	if ($bell_messages==1){
		if ($is_ajax==1)
			$custom_message = nl2br(urldecode($custom_message));	// js: encodeURIComponent
		else
			$custom_message = nl2br($custom_message);
		
		$attachments = "";
		if ($hash!="" and is_array($arr_attachments)){
			foreach ($arr_attachments as $x)
				$attachments.= "<a href='".$URL."Media/Stores/".$_COOKIE_comp_id."/attach/$hash/$x'>$x</a><br/><br/>";
			$attachments = "<br/><br/>".$attachments;
		}
		
		if ($is_from_admin==0){
			$avatar = get_avatar($_COOKIE_comp_id, $_COOKIE["photo"], "", "big");
			$subject = $_COOKIE["firstname"]." ".$_COOKIE["lastname"]." sent you a message";
			$head_colspan = 3;
		}
		else{
			$subject = $custom_subject;
			$head_colspan = 1;
		}
		
		// table header (blue strip with Globemart)
		$mail_body = "<table width=700>
						<tr><td colspan=$head_colspan style='background-color:#25313E; color:#FFFFFF; font-size:16px;' height=30 valing='middle' align='left'>
							&nbsp;&nbsp;<a href='$URL13' style='color:#FFF; text-decoration:none;'>Globemart</a>
						</td></tr>
						<tr><td colspan=$head_colspan>&nbsp;</td></tr>";
		
		if ($is_from_admin==0){
			// from: avatar, person name
			$mail_body.= "<tr align='left' valign='top'>
								<td width=120 rowspan=3>
									<a href='".$URL13.$_COOKIE["comp_url"]."'>
									<img src='$avatar' width=100 border=0></a>
								</td>
								<td width=65 style='color:#888888' height=20>
									From:
								</td>
								<td>
									<a href='".$URL13.$_COOKIE["comp_url"]."'>".$_COOKIE["firstname"]." ".$_COOKIE["lastname"]."</a>
								</td>
							</tr>";
			
			// subject		
			$mail_body.= "<tr align='left' valign='top'>
								<td style='color:#888888' height=20>
									Subject:
								</td>
								<td>$custom_subject</td>
							</tr>";
		}
		
		// body + attachemnts
		$mail_body.= "<tr align='left' valign='top'>";
		if ($is_from_admin==0){
			$mail_body.=	"<td style='color:#888888' height=20>
								Message:
							</td>";
		}
		$mail_body.= 	"<td>
							$custom_message
							$attachments
							<br><br>";
		
		if ($is_from_admin==0){
			// reply-to
			if ($msg_id>0){
				$mail_body.= 	"<a href='".$URL13."my_mail_read.php?msg_id=$msg_id&reply=1' style='text-decoration:none; color:#FFFFFF;'>
								<table style='background-color:#25313E; color:#FFFFFF; border-radius:5px;'>
									<tr><td align='center' height=20>&nbsp;Reply to ".$_COOKIE["firstname"]."&nbsp;</td></tr>
								</table></a>
								<br><br>";
			}
			
			// unsubscribe
			$mail_body.= 		"<span style='font-size:10px'>
								You can unsubscribe or change your email settings in your <a href='".$URL13."notifications_settings.php'>Notifications Settings</a>.
								</span>";
		}
		
		// close table
		$mail_body.= 	"</td>
					</tr>
					</table>";
		mail($toemail, $subject, $mail_body, $headers);
	}
}

function sender_joinfor($toemail, $custom_subject, $custom_message, $firstname, $comp_url, $login, $pwd, $arr_sections="", $memb_id){
	global $URL, $headers;
	if (is_array($arr_sections)){
		$section1 = $arr_sections[0];
		$section2 = $arr_sections[1];
		$section3 = $arr_sections[2];
		$section4 = $arr_sections[3];
		$section5 = $arr_sections[4];
		$section6 = $arr_sections[5];
		$section7 = $arr_sections[6];
	}
	else{
		$section1 = "Hello $firstname!
					<br/><br/>
					Potential buyers are viewing your company page at<br/>
					<a href='".$URL.$comp_url."' style='color:#1686A2;'>".$URL.$comp_url."</a><br/><br/>";
					
		$section2 = "Globemart is a global sourcing platform that brings new customers to sellers.<br/>
					To claim and update your company page, use the following link and login:";
					
		$section4 = "You can change your password in your Profile once you have activated your account.
					<br/><br/><br/>
					Your trusty sourcing platform,
					<br/><br/>
					Globemart Team
					<br/><br/>
					<a href='https://localhost:8888/about' style='color:#1686A2;'>Learn about Globemart</a>";
		$section5 = 1;		
		$section6 = "Have any questions? Please contact us at <span style='color:#1686A2;'>info@localhost:8888</span>";
	}
	
	$mail_body = "<table width=600 style='font-family:Arial; font-size:16px;' cellspacing=0 cellpadding=0>
	<tr align='left' >
		<td valign='middle' height=65 colspan=2 style='border-bottom:1px solid #CCC'>
			<a href='$URL' style='color:#47C1BE; font-weight:bold; font-size:34px; text-decoration:none;'>
			globemart</a>
		</td>
	</tr>";
	
	if ($section1.$section2 != ""){
		$mail_body.= "<tr align='left'><td colspan=2><br/>";
		if ($section1!=""){	// Hello {fname}, Potential buyers are viewing your company page at {comp_url}
			$mail_body.= "<span style='font-size:20px'>
							$section1
						</span>";
		}
		if ($section2!=""){	// Globemart is a global sourcing platform...
			$mail_body.= $section2."<br/><br/>";
		}
		$mail_body.= "</td></tr>";
	}
	
	// section 3 (unchanged) - login/password / Activate
	$mail_body.= "<tr align='left'>
		<td width='50%'>
			Login: $login<br/>
			Password: $pwd
		</td>
		<td width='50%'>
			<a href='".$URL.$comp_url."/activate' style='text-decoration:none; color:#FFFFFF;'>
			<table style='background-color:#47C1BE; color:#FFFFFF; border-radius:5px;'>
				<tr><td align='center' height=30 width=200>Activate Account</td></tr>
			</table></a>
		</td>
	</tr>";
	
	// section 4 (You can change your password... Globemart Team)
	if ($section4!=""){
		$mail_body.= "<tr align='left'>
			<td colspan=2>
				<br/><br/>
				$section4
				<br/><br/><br/>
			</td>
		</tr>";
	}
	
	// section 5 (expowest)
	if ($section5!=""){
		$mail_body.= "<tr align='center'>
			<td colspan=2 style='font-size:20px' height=120>
				<img src='https://localhost:8888/Media/home_ads/1768660578_ew15_faviconlogo.png' border=0 width=100 alt='ExpoWest' title='ExpoWest' align='absmiddle'>
				Sellers Join for Free!
			</td>
		</tr>";
	}
	
	// section 6 (Have any questions? Please contact us at ...)
	if ($section6!=""){
		$mail_body.= "<tr align='center' valign='middle' style='background-color:#E4E5E4;' height=70>
			<td colspan=2>
				$section6
			</td>
		</tr>";
	}
	
	// section 7 (Terms Privacy)
	$mail_body.= "<tr align='center' valign='middle' style='background-color:#47C1BE;' height=120>
		<td colspan=2>
			<a href='https://localhost:8888/terms' style='color:#FFF'>Terms</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a href='https://localhost:8888/privacy' style='color:#FFF'>Privacy</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a href='https://localhost:8888/notifications_settings.php' style='color:#FFF'>Unsubscribe</a>
		</td>
	</tr>";
	
	$mail_body.= "</table>";
	//echo $mail_body;
	
	// encode and save into database so that we can resend activation email via admin if client ignored 1st email
	$mail_body_encoded = base64_encode($mail_body);
	$sql = "UPDATE members SET welcome_email='$mail_body_encoded' WHERE id='$memb_id'";
	mysql_query($sql);
	
	mail($toemail, $custom_subject, $mail_body, $headers);
}

function getExt($str) {
	$str_arr1 = explode("?", $str);	// http://facebook.com/blahamuha.jpg?k=jdofigjdlogij ==> http://facebook.com/blahamuha.jpg
	$str = $str_arr1[0];
	
	$str_arr1 = explode(".", $str);	// http://facebook.com/blahamuha.jpg ==> jpg
	return strtolower($str_arr1[count($str_arr1)-1]);
}

function twoimages($w1, $w2, $file_name, $file_temp, $path, $heightwise=0){
	$filename = stripslashes($file_name);
	$extension = getExt($filename);
	
	$uploadedfile = $file_temp;
	if($extension=="jpg" || $extension=="jpeg" )	$src = imagecreatefromjpeg($uploadedfile);
	elseif($extension=="png")						$src = imagecreatefrompng($uploadedfile);
	elseif($extension=="gif") 						$src = imagecreatefromgif($uploadedfile);
	
	list($width, $height) = getimagesize($uploadedfile);
	
	// make a smaller bigger picture
	if ($heightwise==0){	// first param is width
		if ($w1 > $width) $w1 = $width;	// if small pic uploaded
		$newheight1 = ($height/$width)*$w1;
	}
	else{	// first param is height
		if ($w1 > $height) $w1 = $height;
		$newheight1 = ($width/$height)*$w1;	// newheight1 is new width, w1 is height
		$temp = $w1;	// exchange it
		$w1 = $newheight1;
		$newheight1 = $temp;
	}
	$tmp1 = imagecreatetruecolor($w1, $newheight1);
	imagecopyresampled($tmp1,  $src, 0, 0, 0, 0, $w1, $newheight1, $width, $height);
	if (!is_dir($path))	mkdir($path);
	$filename1 = $path . "/" . $file_name;
	imagejpeg($tmp1, $filename1, 100);
	imagedestroy($tmp1);
	
	if ($w2!=0){	// make a smaller smaller picture
		if ($w2 > $width) $w2 = $width;			// if small pic uploaded
		$newheight2 = ($height/$width)*$w2;
		$tmp2 = imagecreatetruecolor($w2, $newheight2);
		imagecopyresampled($tmp2, $src, 0, 0, 0, 0, $w2, $newheight2, $width, $height);
		if (!is_dir($path . "/small"))	mkdir($path . "/small");
		$filename2 = $path . "/small/". $file_name;
		imagejpeg($tmp2, $filename2, 100);
		imagedestroy($tmp2);
	}
	imagedestroy($src);
}

function get_small_prod($comp_id, $photo){
	global $URL_DD;
	if (filled($photo))
		return file_exists($URL_DD."Media/Stores/$comp_id/small/$photo") ? $URL_DD."Media/Stores/$comp_id/small/$photo" : $URL_DD."Media/Stores/$comp_id/$photo";
	else 
		return get_prodpic($comp_id, $photo, "small");
}

function get_small_lead($comp_id, $photo){
	global $URL_DD;
	if (filled($photo))
		return file_exists($URL_DD."Media/Stores/$comp_id/Buying/small/$photo") ? $URL_DD."Media/Stores/$comp_id/Buying/small/$photo" : $URL_DD."Media/Stores/$comp_id/Buying/$photo";
	else 
		return get_prodpic($comp_id, $photo, "small");
}

function get_avatar($comp_id, $photo, $logo, $size){
	global $URL;
	$avatar = $URL."Media/Stores/$comp_id/";
	if (filled($photo))		$avatar.= $photo;
	elseif (filled($logo))	$avatar.= "profile/". $logo;
	else $avatar = ($size=="small" ? $URL."Media/blanks/blank_member_sm.gif" : $URL."Media/blanks/blank_member.gif");
	return $avatar;
}

function get_prodpic($comp_id, $photo, $size, $w=0, $h=0){
	global $URL;
	if ($w+$h==0){
		$avatar = $URL."Media/Stores/$comp_id/";
		if (filled($photo))		$avatar.= $photo;
		else $avatar = ($size=="small" ? $URL."Media/blanks/blank_prod_sm.gif" : $URL."Media/blanks/blank_prod.gif");
	}
	else{
		if (filled($photo)){
			$orig_path = $URL."Media/Stores/".$comp_id."/".$photo;
			$avatar = $URL."Media/timthumb.php?src=Stores/".$comp_id."/".$photo;
			list($width, $height) = getimagesize($orig_path);
			if ($w > $width)
				$avatar = $orig_path;
			else
				$avatar.= "&w=$w&h=$h&zc=1";
		}
		else{
			$avatar = ($size=="small" ? $URL."Media/timthumb.php?src=blanks/blank_prod_sm.gif" : $URL."Media/timthumb.php?src=blanks/blank_prod.gif");
			$avatar.= "&w=$w&h=$h&zc=1";
		}
	}
	return $avatar;
}

// get width and height of a picture either by timthumb parameters or by meta data
function get_prodpic_wh($src){
	if (strpos($src, 'timthumb.php') !== false){
		$src_arr = explode("&", $src);
		foreach ($src_arr as $x){
			if (substr($x, 0, 2)=="w=")		$width = substr($x, 2);
			if (substr($x, 0, 2)=="h=")		$height = substr($x, 2);
		}
	}
	else{
		list($width, $height) = getimagesize($src);
	}
	return array($width, $height);
}

// fit img into [$w x $h] box
function fit_img($src, $box_width, $box_height){
	list($pic_width, $pic_height) = getimagesize($src);
	
	$alt_width = $pic_width / ($pic_height/$box_height);	// when picH > picW
		
	if ($pic_width<=$box_width and $pic_height<=$box_height)	// img less than the box ==> don't change anything
		$ret = "width:".$pic_width;
	elseif ($pic_width>$box_width and $pic_height<=$box_height)	// pic width exceeds the box, height is ok ==> reduce pic width to box width
		$ret = "width:".$box_width;
	elseif ($pic_width<=$box_width and $pic_height>$box_height)	// pic height exceeds the box, width is ok ==> apply proportinal width
		$ret = "width:".$alt_width;
	elseif ($pic_width>$box_width and $pic_height>$box_height){	// img exceeds the box
		if ($pic_width >= $pic_height){
			$temp_width = $box_width;
			$factor = $pic_width / $box_width;
			$temp_height = $pic_height / $factor;
			if ($temp_height > $box_height){
				$factor = $temp_height / $box_height;
				$ret = "width:".$temp_width/$factor;
			}
			else
				$ret = "width:".$temp_width;
		}
		else
			$ret = "width:".$alt_width;
	}
	return $ret."px";
}

// to get back to the same page after login
function page_encode(){	// 	/product.php?rr=20 ----> bXlfZmF2X2ZvbGxvd2luZy5waHA=	- get current page with qs and url-encode it
	$pg_arr = explode("/", $_SERVER["PHP_SELF"]);
	$pg = end($pg_arr);
	if ($_SERVER["QUERY_STRING"]!="")
		$pg.= "?".$_SERVER["QUERY_STRING"];
	return base64_encode($pg);
}

function mybrowser(){
    if (preg_match('/MSIE/i', $_SERVER['HTTP_USER_AGENT'])) 	return "IE";
}
function is_ie8(){
	return (preg_match('/(?i)msie [1-8]/', $_SERVER['HTTP_USER_AGENT'])) ? true : false;
}

// avoid SQL, JS and HTML injections
function clean_data($val){
	$val = str_replace("'", "&#39;", $val);
	$val = str_replace("’", "&#39;", $val);
	$val = str_replace("\\", "&#92;", $val);
	return strip_tags(trim(mysql_real_escape_string($val)));
}
function unclean_data($val){	// to see pdf or ajax result without &#39;
	$val = str_replace("&#39;", "'", $val);
	$val = str_replace("&#92;", "\\", $val);
	return $val;
}

function is_date($in) {
	return (boolean) strtotime($in);
}
function is_email($email){
	return preg_match('|^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]{2,})+$|i', $email);
}

function get_company_name($comp_id){
	if (is_numeric($comp_id)){
		$result  = mysql_query("SELECT name FROM companies WHERE id='$comp_id'");
		$row     = mysql_fetch_array($result, MYSQL_ASSOC);
		return $row['name'];
	}
}

function is_num_list($list){
	$list_arr = explode(",", $list);
	$res = true;
	foreach ($list_arr as $x){
		if (!is_numeric(trim($x)) and $x!="")
			$res = false;
	}
	return $res;
}

function is_my_product($prod_id){
	global $_COOKIE_comp_id, $_COOKIE_memb_id;
	if (is_numeric($prod_id)){
		$result  = mysql_query("SELECT COUNT(1) as cn FROM products WHERE id='$prod_id' AND comp_id='$_COOKIE_comp_id'");
		$row     = mysql_fetch_array($result, MYSQL_ASSOC);
		return ($row['cn']==0) ? false : true;
	}
	else return false;
}

function get_product_name($prod_id){
	if (is_numeric($prod_id)){
		$result  = mysql_query("SELECT product FROM products WHERE id='$prod_id'");
		$row     = mysql_fetch_array($result);
		return $row["product"];
	}
}

function is_my_group($group_id){
	global $_COOKIE_comp_id, $_COOKIE_memb_id;
	if (is_numeric($group_id)){
		if ($group_id==0) 
			return true;
		else{
			$result  = mysql_query("SELECT COUNT(1) as cn FROM product_groups WHERE id='$group_id' AND memb_id='$_COOKIE_memb_id'");
			$row     = mysql_fetch_array($result, MYSQL_ASSOC);
			return ($row['cn']==0) ? false : true;
		}
	}
	else return false;
}

function get_group_name($group_id){
	if (is_numeric($group_id)){
		if ($group_id==0) 
			return "Others";
		else{
			$result  = mysql_query("SELECT gruppa FROM product_groups WHERE id='$group_id'");
			$row     = mysql_fetch_array($result, MYSQL_ASSOC);
			return $row['gruppa'];
		}
	}
}

// Get group_id by its name and member_id. Add it if it doesn't exist.
function get_group_id($group_name, $memb_id, $to_add){
	$group_id = 0;
	if ($group_name!=""){
		$sql= "SELECT id AS group_id FROM product_groups WHERE memb_id='$memb_id' AND gruppa='$group_name'";
		$result  = mysql_query($sql);
		$row     = mysql_fetch_array($result);
		$group_id = $row["group_id"];
		if ($group_id=="" and $to_add==1){
			mysql_query("INSERT INTO product_groups(memb_id, gruppa) VALUES($memb_id, '$group_name')");
			$group_id = mysql_insert_id();
		}
	}
	return $group_id;
}

// apply channel discount
function apply_channel_discount($channel_struct_id, $role_id, $price_unit){
	// if channel_struct_id==0 (public pricelist) --> just return price_unit
	// role_id 1..5
	if (is_numeric($channel_struct_id) and is_numeric($role_id) and is_numeric($price_unit) and $price_unit!=0 and $channel_struct_id!=0){
		$sql2 = "SELECT group_id1, group_id2, discount 
				FROM channel_discounts 
				WHERE struct_id='$channel_struct_id' AND group_id1='$role_id' 
				ORDER BY group_id2";
		$result2 = mysql_query($sql2);
		while($row2 = mysql_fetch_array($result2)){
			$group_id1 = $row2["group_id1"];
			$group_id2 = $row2["group_id2"];
			$discount = $row2["discount"];
			
			if ($group_id1==5 and $group_id2==5)	// for broker 7% is not a discount, it's a piece of the last link (e.g. distributor's) profit 
				$price_unit = $price_unit*$discount/100;
			else
				$price_unit = $price_unit*(100-$discount)/100;
		}
	}
	return $price_unit;
}

// to use in pricelist. Checks if the product falls under specific channel structure
function is_product_channelled($prod_id, $str_id){
	if (is_numeric($prod_id) and is_numeric($str_id) and $str_id!=0){
		$sql = "SELECT COUNT(1) as cn FROM products2channels WHERE product_id='$prod_id' AND channel_struct_id='$str_id'";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		return ($row["cn"]>0) ? true : false;
			
	}
	else return false;
}

// check that this company possesses this channel structure
function is_comp_channel($comp_id, $str_id){
	if (is_numeric($comp_id) and is_numeric($str_id) and $str_id!=0){
		$sql = "SELECT COUNT(1) as cn FROM channel_structures WHERE struct_id='$str_id' AND company_id='$comp_id'";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		return ($row["cn"]==0) ? false : true;
		//return "SELECT COUNT(1) as cn FROM channel_structures WHERE struct_id='$str_id' AND company_id='$comp_id'";
	}
	else return false;
}

function get_default_struct($comp_id){
	$sql = "SELECT struct_id FROM channel_structures WHERE company_id='$comp_id' AND is_default=1";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	return $row["struct_id"];
}

function is_superseded($prod_id, $comp_id, $struct_id, $role_id){
	$sql = "SELECT COUNT(1) as cn FROM product_price_supersede 
			WHERE product_id='$prod_id' AND company_id='$comp_id' AND channel_struct_id='$struct_id' AND role_id='$role_id'";
	$result = mysql_query($sql);
	$row     = mysql_fetch_array($result);
	return ($row["cn"]>0) ? true : false;
}

function get_superseded_price($prod_id, $comp_id, $struct_id, $role_id){
	$sql = "SELECT price FROM product_price_supersede 
			WHERE product_id='$prod_id' AND company_id='$comp_id' AND channel_struct_id='$struct_id' AND role_id='$role_id'";
	$result = mysql_query($sql);
	$row     = mysql_fetch_array($result);
	return $row["price"];
}

// get all 5 discounts
// asia, fob_price=$10 ==> array($10, $8, $7, $6, $2)
function get_5channel_discounts($channel_struct_id, $price_init){
	$old_g1 = 0;
	if (is_numeric($channel_struct_id) and is_numeric($price_init) and $price_init!=0){
		$price_mod = $price_init;
		$sql2 = "SELECT group_id1, group_id2, discount 
				FROM channel_discounts 
				WHERE struct_id='$channel_struct_id'
				ORDER BY group_id1, group_id2";
		$result2 = mysql_query($sql2);
		while($row2 = mysql_fetch_array($result2)){
			$group_id1 = $row2["group_id1"];
			$group_id2 = $row2["group_id2"];
			$discount = $row2["discount"];
			
			if ($old_g1!=$group_id1)	// new group1 in loop ==> price:=initial_price
				$price_mod = $price_init;
		
			if ($group_id1==5 and $group_id2==5)	// for broker 7% is not a discount, it's a piece of the last link (e.g. distributor's) profit 
				$price_mod = $price_mod*$discount/100;
			else
				$price_mod = $price_mod*(100-$discount)/100;
			
			if ($group_id1==$group_id2)
				$arr_ch_discounts[$group_id1] = number_format($price_mod, 2);
			
			$old_g1 = $group_id1;
		}
	}
	return $arr_ch_discounts;
}

// final price - channelled (default channelled) and superseded (if any)
function get_product_price($prod_id, $comp_id, $str_id, $role_id, $price_unit){
	if (is_product_channelled($prod_id, $str_id)){
		$price_unit = apply_channel_discount($str_id, $role_id, $price_unit);
		$applied_struct = $str_id;
	}
	else{
		$def_struct_id = get_default_struct($comp_id);
		$price_unit = apply_channel_discount($def_struct_id, $role_id, $price_unit);
		$applied_struct = $def_struct_id;
	}
	
	if (is_superseded($prod_id, $comp_id, $applied_struct, $role_id))
		$price_unit = get_superseded_price($prod_id, $comp_id, $applied_struct, $role_id);
	
	return number_format($price_unit,2);
}

function apply_volume_discount($prod_id, $qty, $price){
	if (is_numeric($prod_id) and is_numeric($qty)){
		$sql = "SELECT VD.discount, VS.dtype
				FROM volume_discounts VD
				JOIN volume_structures VS ON VS.struct_id=VD.struct_id
				JOIN products P ON P.volume_struct_id=VS.struct_id AND P.id=$prod_id
				WHERE $qty BETWEEN VD.qty_min AND IFNULL(VD.qty_max, 1000000000)";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		$discount = $row["discount"];
		$dtype 	  = $row["dtype"];
		if (is_numeric($discount)){
			if ($dtype=="$")
				return $qty*($price - $discount);
			elseif ($dtype=="%")
				return $qty*($price - $price*$discount/100);
		}
		else
			return $qty*$price;
		
	}
}

function get_volume_discount($prod_id, $qty, $price){
	if (is_numeric($prod_id) and is_numeric($qty)){
		$sql = "SELECT VD.discount, VS.dtype
				FROM volume_discounts VD
				JOIN volume_structures VS ON VS.struct_id=VD.struct_id
				JOIN products P ON P.volume_struct_id=VS.struct_id AND P.id=$prod_id
				WHERE $qty BETWEEN VD.qty_min AND IFNULL(VD.qty_max, 1000000000)";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		$discount = $row["discount"];
		$dtype 	  = $row["dtype"];
		if (is_numeric($discount)){
			return $discount.$dtype;
		}
		else
			return 0;
	}
}

// check that editted invoice is mine
function is_my_invoice($inv_id, $doc_type_id){
	global $_COOKIE_comp_id, $_COOKIE_memb_id;
	if ($inv_id!=""){
		if (is_numeric($inv_id)){
			$result  = mysql_query("SELECT table_name FROM doc_types WHERE doc_type_id='$doc_type_id'");
			$row = mysql_fetch_array($result);
			$table_name = $row["table_name"];
			
			$sql_13 = "";
			if ($doc_type_id==1 or $doc_type_id==3) $sql_13 = " AND doc_type_id='$doc_type_id'";
			$sql = "SELECT COUNT(1) as cn FROM $table_name WHERE invoice_id='$inv_id' AND seller_id='".$_COOKIE_memb_id."' ".$sql_13;
			$result  = mysql_query($sql);
			$row = mysql_fetch_array($result);
			if ($row["cn"]==0) 
				header("Location: my_tradedocs.php");
		}
		else
			header("Location: my_tradedocs.php");
	}
}

// get tradedoc PDF link for downloading (in GB email)
function get_pdf_link($doc_type_id, $invoice_id, $seller_id){
	if (is_numeric($doc_type_id) and is_numeric($invoice_id)){
		$result = mysql_query("SELECT doc_type_name, table_name, alias FROM doc_types WHERE doc_type_id='$doc_type_id'");
		$row = mysql_fetch_array($result);
		$doc_type_name = $row["doc_type_name"];
		$table_name = $row["table_name"];
		$alias = $row["alias"];
		
		$sql_a = "";
		if ($doc_type_id==1 or $doc_type_id==3)
			$sql_a = " AND doc_type_id=$doc_type_id";
		$sql = "SELECT uid, invoice_no FROM $table_name WHERE invoice_id='$invoice_id'".$sql_a;
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		$uid = $row["uid"];
		$invoice_no = $row["invoice_no"];
		$doc_name = $doc_type_name ." #".$invoice_no;
		
		$pdf_link = "<a href='tradedoc_".$alias."_view.php?iid=$invoice_id&uid=$uid&sid=$seller_id'>$doc_name</a>";
		return $pdf_link;
	}
	else return "";
}

// business url     VoipConcept => 1
function get_id_by_url($comp_url){
	if ($comp_url!=""){
		$result = mysql_query("SELECT id FROM companies WHERE comp_url='".clean_data($comp_url)."'");
		$row = mysql_fetch_assoc($result);
		return $row["id"];
	}
}

// business url      1 => VoipConcept
function get_url_by_id($comp_id){
	if (is_numeric($comp_id)){
		$result = mysql_query("SELECT comp_url FROM companies WHERE id='$comp_id'");
		$row = mysql_fetch_assoc($result);
		return $row["comp_url"];
	}
}

// Global-Voice Inc. ==> GlobalVoiceInc
function make_comp_url($comp_name){
	global $arr_url_reserved;
	$comp_url = $comp_name;
	$comp_url = preg_replace("/[^A-Za-z0-9]/", "", $comp_url);
	if (strlen($comp_url) <= 4 or in_array(strtolower($comp_url), $arr_url_reserved)) $comp_url.= rand(1000000, 9999999);
	if (is_numeric($comp_url)) $comp_url = md5(uniqid());
	return $comp_url;
}

function check_comp_url($comp_url, $companyname){
	global $arr_url_reserved;
	$comp_url = ($comp_url=="") ? make_comp_url($companyname) : preg_replace("/[^A-Za-z0-9]/", "", $comp_url);
	if (strlen($comp_url)>=5 and !is_numeric($comp_url) and !in_array(strtolower($comp_url), $arr_url_reserved)){
		$result = mysql_query("SELECT COUNT(1) as cn FROM companies WHERE comp_url='$comp_url'");
		$row = mysql_fetch_array($result);
		if ($row["cn"]!=0)
			$comp_url = $comp_url.rand(1000000, 9999999);
	}
	else
		$comp_url = $comp_url.rand(1000000, 9999999);
	return $comp_url;
}

function clean_filename($filename){	// clean non-english and special characters
	return preg_replace("/([^A-Za-z0-9\w\.\-]*)/", "", $filename);
}
function get_filename($filename_with_ext){	// file.of.mine.jpg ==> file.of.mine
	$filename = "";
	$f_arr = explode(".", $filename_with_ext);
	for ($i=0; $i<count($f_arr)-1; $i++)
		$filename.= $f_arr[$i].".";
	$filename = rtrim($filename, ".");
	return $filename;
}

// 155,brown-rice ==> localhost:8888/product/155-brown-rice ==> localhost:8888/product/217854836-brown-rice
function product_url($prod_id, $prod_url){	
	global $URL, $LONG_NUMBER;
	$prod_id+= $LONG_NUMBER;
	return $URL."product/".$prod_id."-".$prod_url;
}
function clean_product_url($product_url){	// clean non-english and special characters, except dash
	$product_url = preg_replace("/([^A-Za-z0-9\- ]*)/", "", $product_url);
	$product_url = str_replace(" ", "-", $product_url);
	$product_url = str_replace("------", "-", $product_url);
	$product_url = str_replace("-----", "-", $product_url);
	$product_url = str_replace("----", "-", $product_url);
	$product_url = str_replace("---", "-", $product_url);
	$product_url = str_replace("--", "-", $product_url);
	if ($product_url=="-") $product_url = "";
	return $product_url;
}

function get_LG(){	// gen en or cn - to include lang file
	if(isset($_GET['LG'])){
		$LG = $_GET['LG'];
		setcookie('LG', $LG, time() + 3600*24*30, "/", "localhost:8888", isset($_SERVER["HTTPS"]), true);
	}
	elseif (isset($_COOKIE["LG"]))
		$LG = $_COOKIE["LG"];
	else
		$LG = "en";

	if ($LG=="" or !in_array($LG, array("en", "cn", "kr")))
		$LG = "en";
	return $LG;
}
function get_flag(){
	global $arr_lang;
	$LG = get_LG();
	$flag = "United-States.png";
	foreach ($arr_lang as $x)
		if ($LG==$x["lg"]) 
			$flag = $x["flag"];
	return $flag;
}
function get_lang_field($row, $row_name){	// get row[categ], row[categ_cn], row[categ_kr] depending on current lang
	$LG = get_LG();
	if ($LG!="en" and $LG!="") return $row[$row_name."_".$LG];
	else return $row[$row_name];
}
function get_lang_column($row_name){	// get categ, categ_cn, categ_kr depending on current lang
	$LG = get_LG();
	if ($LG!="en" and $LG!="") return $row_name."_".$LG;
	else return $row_name;
}

// get content between [SECTION_1] and [/SECTION_1]
function get_section($haystack, $section_name){
	$section_name1 = "[".$section_name."]";
	$section_name2 = "[/".$section_name."]";
	$pos1 = strpos($haystack, $section_name1) + strlen($section_name1);
	$pos2 = strpos($haystack, $section_name2);
	if ($pos1!=0 and $pos2!=0)
		return substr($haystack, $pos1, $pos2-$pos1);
	else
		return "";
}

// cut_between("Category Name: Nut Bar Category Path: sdsdff", "Category Name:", "Category Path:") ====> Nut Bar
function cut_between($order_summary, $txt1, $txt2){
	$pos1 = strpos($order_summary, $txt1);
	if ($pos1!==false){
		$pos2 = strpos($order_summary, $txt2, $pos1);
		$a = trim(substr($order_summary, $pos1, $pos2-$pos1));
		$a = trim(str_replace($txt1, "", $a));
		$a = str_replace("$", "", $a);
		return trim($a);
	}
}

// import product picture
function import_prod_pic($photo_url, $comp_id, $prod_id){
	if ($photo_url!="" and is_numeric($comp_id) and is_numeric($prod_id)){
		$path = "Media/Stores/".$comp_id;
		$ext = getExt($photo_url);
		if ($ext=="jpg" || $ext=="jpeg" || $ext=="gif" || $ext=="png"){
			$photoname = mt_rand().".".$ext;
			$tmp_path = $path."/".$photoname;
			$content = file_get_contents($photo_url);
			if ($content){
				$fp = fopen($tmp_path, "w");
				$w = fwrite($fp, $content);
				fclose($fp);
				if ($w){
					twoimages(560, 160, $photoname, $tmp_path, $path);
					mysql_query("INSERT INTO product_photo(prod_id, photo, is_main, photo_video, source_url) ".
								"VALUES('$prod_id', '$photoname', 1, 'p', '".clean_data($photo_url)."')");
				}
			}
		}
	}
}

function generateRandomString($length = 10) {
    $characters = '0123456789ABCDEFGHIJKLMNPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function lbs2kg($weight_lbs){
	return round($weight_lbs*0.453592, 2);
}
function kg2lbs($weight_kg){
	return round($weight_kg*2.20462, 2);
}

// (2015-08-13, 2015-09-10) ==> 0; (2015-08-13, 2015-09-13) ==> 1; (2015-08-13, 2015-10-10) ==> 1; 
function whole_months_diff($d1, $d2){
	$date1 = new DateTime($d1);
	$date2 = new DateTime($d2);
	$diff = $date1->diff($date2);
	return (($diff->format('%y') * 12) + $diff->format('%m'));
}

function get_payment_plan($memb_id){
	if (is_numeric($memb_id)){
		$sql = "SELECT P.plan_id, P.plan_name, P.cost
				FROM memberships P
				JOIN members M ON M.plan_id=P.plan_id
				WHERE M.id='$memb_id'";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		$plan_id = $row["plan_id"];
		$plan_name = $row["plan_name"];
		$cost = $row["cost"];
		return array($plan_id, $plan_name, $cost);
	}
}

function convert_utf8($var){
	if (function_exists('mb_detect_encoding') && is_callable('mb_detect_encoding')) 
		$charset = mb_detect_encoding($var, 'UTF-8,ASCII,ISO-8859-1,ISO-8859-15', TRUE);
	
	if ($charset != '' && $charset != 'UTF-8'){
		$var = mb_convert_encoding($var, 'UTF-8', $charset);
		$var = str_replace("Ûª", "&#39;", $var);
		$var = str_replace("Û¢", "•", $var);
		$var = str_replace("åÊ", " ", $var);
		$var = str_replace("ã¢", "™", $var);
		$var = str_replace("ÛÓ", "&mdash;", $var);
		//$var = str_replace(chr(0x89), "", $var);
		//$var = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $var); 
	}
	//$var = iconv("ISO-8859-1", 'utf-8', $var);
	//$var = utf8_encode($var);
	
	/*
	 $map = array(
        chr(0x8A) => chr(0xA9),
        chr(0x8C) => chr(0xA6),
        chr(0x8D) => chr(0xAB),
        chr(0x8E) => chr(0xAE),
        chr(0x8F) => chr(0xAC),
        chr(0x9C) => chr(0xB6),
        chr(0x9D) => chr(0xBB),
        chr(0xA1) => chr(0xB7),
        chr(0xA5) => chr(0xA1),
        chr(0xBC) => chr(0xA5),
        chr(0x9F) => chr(0xBC),
        chr(0xB9) => chr(0xB1),
        chr(0x9A) => chr(0xB9),
        chr(0xBE) => chr(0xB5),
        chr(0x9E) => chr(0xBE),
        chr(0x80) => '&euro;',
        chr(0x82) => '&sbquo;',
        chr(0x84) => '&bdquo;',
        chr(0x85) => '&hellip;',
        chr(0x86) => '&dagger;',
        chr(0x87) => '&Dagger;',
        chr(0x89) => '&permil;',
        chr(0x8B) => '&lsaquo;',
        chr(0x91) => '&lsquo;',
        chr(0x92) => '&rsquo;',
        chr(0x93) => '&ldquo;',
        chr(0x94) => '&rdquo;',
        chr(0x95) => '&bull;',
        chr(0x96) => '&ndash;',
        chr(0x97) => '&mdash;',
        chr(0x99) => '&trade;',
        chr(0x9B) => '&rsquo;',
        chr(0xA6) => '&brvbar;',
        chr(0xA9) => '&copy;',
        chr(0xAB) => '&laquo;',
        chr(0xAE) => '&reg;',
        chr(0xB1) => '&plusmn;',
        chr(0xB5) => '&micro;',
        chr(0xB6) => '&para;',
        chr(0xB7) => '&middot;',
        chr(0xBB) => '&raquo;',
    );
    return html_entity_decode(mb_convert_encoding(strtr($text, $map), 'UTF-8', 'ISO-8859-2'), ENT_QUOTES, 'UTF-8');
	*/
	return $var;
}

function fav_prod(){
	global $fav_prod_color0, $fav_prod_color1, $fav_prod_title0, $fav_prod_title1, $URL13;
	global $_COOKIE_comp_id, $_COOKIE_memb_id;
	?>
	<script>
	function fav_prod(prod_id){
		<?if (isset($_COOKIE_memb_id)){?>
		$.ajax({
			type: "POST",
			url: "<?=$URL13?>ajx_product_fav.php",
			data: {
				id: prod_id
			},
			success: function(msg){
				if (msg==0)
					signin_show();
				else{
					if (msg=="added"){
						new_color = "<?=$fav_prod_color1?>";
						new_title = "<?=$fav_prod_title1?>";
					}
					else if (msg=="dropped"){
						new_color = "<?=$fav_prod_color0?>";
						new_title = "<?=$fav_prod_title0?>";
					}
					$("#prod_heart_"+prod_id).css("color", new_color).attr("title", new_title);
				}
			}
		});
		<?}else{?>
		signin_show();
		<?}?>
	}
	</script>
	<?
}
function follow(){
	global $follow_button0, $follow_button1, $URL13, $URL;
	global $_COOKIE_comp_id, $_COOKIE_memb_id;
	?>
	<script>
	function follow(comp_id){
		<?if (isset($_COOKIE_memb_id)){?>
		$.ajax({
			type: "POST",
			url: "<?=$URL13?>ajx_tradefeed_follow.php",
			data: {
				id: comp_id
			},
			success: function(msg){
				if (msg==0)
					signin_show();
				else{
					if (msg=="added")
						$("#follow_button").html("<?=$follow_button0?>");
					else if (msg=="dropped")
						$("#follow_button").html("<?=$follow_button1?>");
				}
			}
		});
		<?}else{?>
		signin_show();
		<?}?>
	}
	</script>
	<?
}
?>