<?
/*
### GENERAL ###
public_footer() - new footer (of Foundation pages)
public_footer2() - new footer (my pages, to avoid conflicts)
join_now_section() - above the footer on info pages (of Foundation)
lytebox_contact()
abs_shade() - gray-out for lytebox (xxx)
public_comp_page()
ribbon() - NEW / FEATURED ribbon use after td-div(relative)

### TRADEDOCS ###
invoice_square() - green squares on tradedocs
search_tradedocs() - search form on tradedocs
commodity_loader() - tradedocs: drop-down list of existing documents to load from (by ajax fn load_cmds) the list of commodities
draw_cell_2lines() - PDF trade docs: a cell with bold key and normal value
commodity_header() - PDF commodity header
commodity_body() - PDF commodity body (runs in cycle, $new_pos_y depends on number of lines of commodity name + gap)
get_cmd_height() - PDF commodity body - get height of multi-line text (commodity item) with inter-line gap (6)

### THEMEFOREST ###
forest_menu() - one piece of menu with submenus (Profile [Edit Company Profile, Change Password])
forest_menu_header() - grey background, headers like Tradeware, Communication
get_cookie_params() - to calc values for bubbles and other stuff
notif_item() - one piece of bell notification detail
forest_header() - the toppest strip
forest_top() - aggregates everything
forest_bottom() - some crap to close forest_top
forest_mail_menu() - inbox, sent, important - left column
forest_mail_contacts() - very right column

### OTHER ###
info_box() - (i)
zendesk() - chat, called in forest_header
video_icon() - youtube tutorial
bootsize() - for testing, echo xs, sm, md, lg screen size for bootstrap
*/
	
// CONTACT FORM (modal)
// Evoked by js function contact_form($to_id) in js.js
// Sending provided by js function check_send($to_id) in js.js through ajx_send_msg.php
// Closure provided by js function contact_hide($to_id) in js.js
// For gray matter see abs_shade() below
function lytebox_contact($from_memb_id, $to_memb_id, $to_personname, $prod_id=0, $product=""){
	$is_list = false;
	$to_memb_id_list = $to_memb_id;
	if (!is_numeric($to_memb_id)){	// send to memb_id list
		$is_list = true;
		$to_memb_id = 0;	// div identifier postfix
	}
	
	$is_in_contact_list = 1;
	if (!$is_list and $to_memb_id!=$from_memb_id){
		$result  = mysqli_query("SELECT COUNT(1) as cn FROM contacts WHERE memb_id='$from_memb_id' AND contact_id='$to_memb_id'");
		$row     = mysql_fetch_array($result, MYSQL_ASSOC);
		$is_in_contact_list = $row['cn'];
	}
	
	$product = str_replace("&#39;", "'", $product);
	?>
	<script>
	$(function(){
		<?if ($is_list==false and $product!=""){?>
		if ($("#subj_<?=$to_memb_id?>").val()=="") 
			$("#subj_<?=$to_memb_id?>").val("<?=$product?>");
		<?}?>
	});
	</script>
	<div id='contactform_<?=$to_memb_id?>' class='contactformq' style='qmargin:0px auto;'>
		<?if (isset($from_memb_id)){?>
		<div id='before_send_<?=$to_memb_id?>' style='display:block; float:left; width:100%;'>
			<table border=0 style='height:30px; width:100%;'>
			<tr align='left' valign='top'>
				<td width='45'><b>To:</b></td>
				<td>
					<div id='to_personname' style='max-height:55px; overflow-y:auto; width:90%' class='pull-left'>
						<?=$to_personname?>
						<?if ($is_in_contact_list==0){?>
						<button type='button' id='btn_add2clist' onClick='do_add2clist(<?=$to_memb_id?>)'>Add to Contact List</button>
						<span style='color:green; font-style:italic; display:none;' id='spn_add2clist'>Added!</span>
						<?}?>
					</div>
				</td>
			</tr>
			</table>
			
			<div class="form-group" style='width:100%;'>
				<select name='subj_dd_<?=$to_memb_id?>' id='subj_dd_<?=$to_memb_id?>' style='width:150px; float:left' class='form-control input-sm'>
					<option value=''>
					<option value='Sample Request'>Sample Request
					<option value='Product Inquiry'>Product Inquiry
					<option value='Price Request'>Price Request
				</select>
				<input name='subj_<?=$to_memb_id?>' placeholder='Subject' id='subj_<?=$to_memb_id?>' value='' maxlength=40
				style='width:66%; margin-left:5px;' class='form-control input-sm'>
			</div>
			
			<textarea rows="8" name='body_<?=$to_memb_id?>' id='body_<?=$to_memb_id?>' class='form-control' 
			style='resize:none; margin-top:4px; width:95%; amax-width:458px'></textarea>
			
			<div class='hidden-xs' style='height:10px'></div>
			<div class='visible-xs' style='height:4px'></div>
			
			<input type='submit' name='Send_<?=$to_memb_id?>' value='Send' onClick='return check_send(<?=$to_memb_id?>)'>
			
			<input type='hidden' name='memb_id_<?=$to_memb_id?>' value='<?=$to_memb_id_list?>' id='memb_id_<?=$to_memb_id?>'>
			<input type='hidden' name='regarding_prod_id' id='regarding_prod_id' value='<?=$prod_id?>'>
			<input type='hidden' name='prod_list' id='prod_list' value=''>
		</div>
		
		<div id='after_send_<?=$to_memb_id?>' style='display:none; text-align:center; font-size:16px; margin-top:50px; clear:both;'>
			Your message has been sent!
			<br/><br/><br/>
			<button data-dismiss="modal">Close</button>
			<br/><br/><br/>
		</div>
		<?
		}
		else{
			?>
			<div style='margin-top:50px; text-align:center;'>
				Please <a href='signin.php'><u>log in</u></a> to send a message.
				<br/><br/><br/>
				<button onClick='contact_hide(<?=$to_memb_id?>)'>Close</button>
			</div>
			<?
		}
		?>
	</div>
	<script>
	get_sellers4message();	// sourcing cart
	</script>
	<?
}
function abs_shade(){
	?>
	<script>
	$(function(){
		var body_height = $('body').height()+10;
		$("#shade").css('height', body_height);
	});
	</script>
	<div style='position:absolute; background-color:rgba(0,0,0,0.5); width:100%; display:none; z-index:100;' onClick='contact_hide("all")' id='shade'>
	</div>
	<?
}

// green squares on tradedocs
function invoice_square($inv_num, $country, $date, $partner_name, $pdf_link, $inv_id){
	// DOWNLOAD: pdf_link - tradedoc_commercial_invoice_view.php?iid=1&uid=2122442425&sid=3&dtid=1
	// iid - invoice_id; uid - md5(); sid - seller_id; dtid - [1..5]
	
	// EDIT: tradedoc_commercial_invoice?id=1
	$edit_link_arr = explode("_view", $pdf_link);
	$edit_link = $edit_link_arr[0].".php?id=".$inv_id;
	
	// SEND: my_mail_compose.php?fn=tradedoc_commercial_invoice_view&iid=1&uid=2122442425&sid=3&dtid=1&inum=10
	$send_link_arr = explode(".php?", $pdf_link);
	$send_link = "my_mail_compose.php?fn=".$send_link_arr[0]."&".$send_link_arr[1]."&inum=".$inv_num;
	
	// DELETE
	$dtid_arr = explode("&dtid=", $pdf_link);
	$dtid = $dtid_arr[1];
	?>
	<div class='invoice_download' style='border:1px solid #C6E5EA' id='square_<?=$inv_id?>_<?=$dtid?>'>
		<a href='<?=$edit_link?>'>
		<div class='invoice_square'>
			<div class='invoice_num'>#<?=$inv_num?></div>
			<div class='invoice_date' style='white-space:nowrap;'>
				<?=long_cut($country, 15)?><br/>
				<?=$date?><br/>
				<?=long_cut(unclean_data($partner_name), 15)?>
			</div>
		</div></a>
		
		<span style='font-size:16px' class='invoice_square_links'>
			<a href='<?=$pdf_link?>'><i class='fa fa-download' title='Download PDF'></i></a>
			<a href='<?=$send_link?>'><i class='fa fa-envelope-o' title='Send PDF'></i></a>
			<a href='javascript:void(0)' onClick="return drop_pdf(<?=$inv_id?>, <?=$dtid?>, 0)"><i class='fa fa-trash-o' title='Delete Document'></i></a>
		</span>
	</div>
	<?
}

// search form on tradedocs
function search_tradedocs($has_docselect, $srch_company="", $srch_date_from="", $srch_date_to="", $srch_num="", $srch_country="", $doc="", $header="INVOICES"){
	global $lang, $q_search;
	//echo bootsize();
	?>
	<section class="panel panel-default">
	<header class="panel-heading font-bold" onClick='tdoc_search_expand()' style='cursor:pointer'>
		<i class='fa fa-<?=($q_search=="" ? "plus" : "minus")?>-square-o' id='i_tdoc_search_expand'></i>&nbsp;&nbsp;
		<?=strtoupper($lang["SearchInvoices"])?> <!--Search Invoices-->
	</header>
	
	<div class="panel-body" id='div_tdoc_search' style='display:<?=($q_search=="" ? "none" : "block")?>'>
	<form method='GET' action='' id='search_form' class="form-inline" role="form">
	<div style='max-width:900px'>
		<?if ($has_docselect==1){?>
		<div class='row'>
			<div class='col-xs-3 col-sm-2 col-md-1'>
				<label><b><?=strtoupper($lang["Form"])?>&nbsp;</b></label> <!--Form-->
			</div>
			<div class='col-xs-9 col-sm-10 col-md-11'>
				<select name='doc' id='doc' style='width:190px' class='form-control'>
					<option value=''>--<?=$lang["PleaseSelect"]?>-- <!--Please Select-->
					<option value='proforma_invoice'><?=$lang["ProFormaInvoice"]?>
					<option value='purchase_order'><?=$lang["PurchaseOrder"]?>
					<option value='commercial_invoice'><?=$lang["CommercialInvoice"]?>
					<option value='packing_slip'><?=$lang["PackingSlip"]?>
					<option value='bol'><?=$lang["BillOfLadingBOL"]?>
				</select>
			</div>
		</div>
		<?} else{ ?>
		<input type='hidden' name='doc' id='doc' value='<?=$doc?>' />
		<?}?>
		
		<div class='row'>
			<div class='col-xs-12 col-md-4'>
			<div class='row'>
				<div class='col-xs-3 col-sm-2 col-md-3 col-lg-3 m-t' >
					<b><?=strtoupper($lang["Company"])?>&nbsp;</b> <!--Company-->
				</div>
				<div class='col-xs-9 col-sm-10 col-md-9 col-lg-9 m-t'>
					<input type='text' name='company' id='company' value='<?=$srch_company?>' style='qwidth:170px' class='form-control' />
				</div>
			</div>
			</div>
			<div class='col-xs-12 col-md-4'>	
			<div class='row'>
				<div class='col-xs-3 col-sm-2 col-md-3 col-lg-3 m-t'>
					<b><?=strtoupper($lang["Dates"])?>&nbsp;</b> <!--Dates-->
				</div>
				<div class='col-xs-9 col-sm-10 col-md-9 col-lg-9 m-t'>
					<input type='text' name='date_from' id='date_from' value='<?=$srch_date_from?>' class='form-control' placeholder='mm/dd/yyyy' />
				</div>
			</div>
			</div>
			<div class='col-xs-12 col-md-4'>
			<div class='row'>
				<div class='col-xs-3 col-sm-2 col-lg-2 m-t'>
					<b><?=strtoupper($lang["tdoc_to"])?>&nbsp;</b> <!--TO-->
				</div>
				<div class='col-xs-9 col-sm-10 col-lg-10 m-t'>
					<input type='text' name='date_to' id='date_to' value='<?=$srch_date_to?>' class='form-control' placeholder='mm/dd/yyyy' />
				</div>
			</div>
			</div>
		</div>
		
		<div class='row'>
			<div class='col-xs-12 col-md-4'>
			<div class='row'>
				<div class='col-xs-3 col-sm-2 col-md-3 col-lg-3 m-t' >
					<b style='white-space:nowrap'><?=strtoupper($lang["PONo"])?>&nbsp;</b> <!--P.O. No.-->
				</div>
				<div class='col-xs-9 col-sm-10 col-md-9 col-lg-9 m-t'>
					<input type='text' name='num' id='num' value='<?=$srch_num?>' class='form-control' style='qwidth:170px' />
				</div>
			</div>
			</div>
			
			<div class='col-xs-12 col-md-4'>
			<div class='row'>
				<div class='col-xs-3 col-sm-2 col-md-3 col-lg-3 m-t'>
					<b><?=strtoupper($lang["Country"])?>&nbsp;</b> <!--Country-->
				</div>
				<div class='col-xs-9 col-sm-10 col-md-9 col-lg-9 m-t'>
					<select name='country' id='country' style='width:260px'>
					<option value=''>--<?=$lang["PleaseSelect"]?>-- <!--Please Select-->
					<?
					$result3 = mysql_query("SELECT id, country FROM countries ORDER BY country");
					while($row3 = mysql_fetch_array($result3)){
						echo "<option value=" . $row3["id"];
						if ($row3["id"]==$srch_country) echo " selected";
						echo ">" . $row3["country"];
					}
					?>
					</select>
				</div>
			</div>
			</div>
		</div>
		
		<div class='row m-t'>
			<div class='col-xs-12'> <!--Search-->
				<input type='submit' name='search' value='<?=strtoupper($lang["Search"])?>' class='btn btn-primary pull-right' onClick='return check_srch()' />
			</div>
		</div>
	</div>
	</form>
	</div>
	</section>
	<?
}

// tradedocs: drop-down list of existing documents to load from (by ajax fn load_cmds) the list of commodities
function commodity_loader($called_from_doc_type_id, $ini_cmd_lines){
	global $_COOKIE_memb_id, $_COOKIE_comp_id;
	$k = 0;
	$sql3 = "SELECT P.invoice_id, P.invoice_no, P.invoice_date, 'Pro Forma Invoice' as doc_name, 1 as doc_type_id
			FROM doc_commercial_invoice P 
			WHERE P.seller_id='".$_COOKIE_memb_id."' AND P.doc_type_id=1 AND 
					EXISTS(select 1 from doc_commodities where invoice_id=P.invoice_id and doc_type_id=1)
			UNION ALL 
			SELECT P.invoice_id, P.invoice_no, P.invoice_date, 'Purchase Order' as doc_name, 2 as doc_type_id
			FROM doc_purchase_order P 
			WHERE P.seller_id='".$_COOKIE_memb_id."' AND 
					EXISTS(select 1 from doc_commodities where invoice_id=P.invoice_id and doc_type_id=2)
			UNION ALL 
			SELECT P.invoice_id, P.invoice_no, P.invoice_date, 'Commercial Invoice' as doc_name, 3 as doc_type_id
			FROM doc_commercial_invoice P 
			WHERE P.seller_id='".$_COOKIE_memb_id."' AND P.doc_type_id=3 AND 
				  EXISTS(select 1 from doc_commodities where invoice_id=P.invoice_id and doc_type_id=3)
			UNION ALL 
			SELECT P.invoice_id, P.invoice_no, P.invoice_date, 'Packing Slip' as doc_name, 4 as doc_type_id
			FROM doc_packing_slip P 
			WHERE P.seller_id='".$_COOKIE_memb_id."' AND 
					EXISTS(select 1 from doc_commodities where invoice_id=P.invoice_id and doc_type_id=4)
			UNION ALL 
			SELECT P.invoice_id, P.invoice_no, P.invoice_date, 'Bill of Lading' as doc_name, 5 as doc_type_id
			FROM doc_bol P 
			WHERE P.seller_id='".$_COOKIE_memb_id."' AND 
					EXISTS(select 1 from doc_bol_commodities where invoice_id=P.invoice_id)
			";
	$result3 = mysql_query($sql3);
	while($row3 = mysql_fetch_array($result3)){
		$k++;
		if ($k==1){
			?>
			<select name='doc4cmd' id='doc4cmd' onChange='load_cmds(<?=$called_from_doc_type_id?>, <?=$ini_cmd_lines?>)' style='margin-left:30px'>
			<option value=''>--Load List of Commodities--</option>
			<?
		}
		$invoice_date = (is_date($row3["invoice_date"]) ? ", ".date("m/d/Y", strtotime($row3["invoice_date"])) : "");
		?>
		<option value='<?=$row3["invoice_id"].",".$row3["doc_type_id"]?>'>
			<?=$row3["doc_name"]." #".$row3["invoice_no"] . $invoice_date?>
		</option>
		<?
	}
	if ($k > 0) echo "</select>";
}
/***************************************************************************************************************/
/********************************** PUBLIC COMPANY PAGE ************************************************/
function public_comp_page($comp_id, $group_id, $menu_name){
	global $follow_button0, $follow_button1, $URL, $URL13, $URL_DD;
	global $_COOKIE_memb_id, $_COOKIE_comp_id, $lang;
	
	$sql = "SELECT C.name, C.main_image, C.header_image, C.introduction, C.supplier, C.buyer, C.comp_url, C.urls,
					C.city as ccity, C.state as cstate, COO.country as ccountry, COO.flag,
					M.id as memb_id, M.FirstName, M.LastName, M.phone, M.cell, M.fax, M.other, M.is_active
			FROM companies C
			JOIN members M ON M.id=C.user_id
			LEFT JOIN countries COO ON COO.id=C.country 
			WHERE C.id='$comp_id' ";
	$result  = mysql_query($sql);
	$row     = mysql_fetch_array($result, MYSQL_ASSOC);
	$comp_name =  $row['name'];
	$main_image =  $row['main_image'];
	$header_image =  $row['header_image'];
	$introduction =  $row['introduction'];
	$comp_url =  $row['comp_url'];
	$real_url =  $row['urls'];
	$supplier =  $row['supplier'];
	$buyer =  $row['buyer'];
	$ccity 		= $row["ccity"];
	$cstate  	= $row["cstate"];
	$ccountry 	= $row["ccountry"];
	$flag 	= $row["flag"];
	$memb_id 	= $row["memb_id"];
	$personname	= $row["FirstName"]." ".$row["LastName"];
	$phone 	= $row["phone"];
	$cell 	= $row["cell"];
	$fax 	= $row["fax"];
	$other 	= $row["other"];
	$is_active 	= $row["is_active"];
	
	if ($memb_id=="")
		echo "<script>window.location.href='".$URL13."company.php'</script>";
	
	$pure_buyer = ($buyer==1 and $supplier==0) ? true : false;
	
	$caddress = "";
	if (filled($ccity))		$caddress = $caddress . $ccity .", ";
	$caddress = ($ccountry=="United States") ? ($caddress . $cstate . ", " . $ccountry) : ($caddress . $ccountry);
	
	// count of blog posts
	$result  = mysql_query("SELECT COUNT(1) as cn FROM blog WHERE memb_id='$memb_id' AND blog_id IS NULL");
	$row     = mysql_fetch_array($result);
	$cn_blogposts = $row["cn"];
	
	// count of products
	$result  = mysql_query("SELECT COUNT(1) as cn FROM products WHERE comp_id='$comp_id' AND status=1");
	$row     = mysql_fetch_array($result);
	$cn_prods = $row["cn"];
	$cn_uploaded_docs = 0;
	if ($cn_prods==0){	// count of uploaded catalogs
		$query= "SELECT COUNT(1) as cn FROM catalogs WHERE comp_id='$comp_id'";
		$result  = mysql_query($query);
		$row     = mysql_fetch_array($result);
		$cn_uploaded_docs = $row["cn"];
	}
	$cn_catalogs = $cn_prods + $cn_uploaded_docs;
	
	// is follow company?
	$result  = mysql_query("SELECT COUNT(1) as cnp FROM blog_followers WHERE memb_object='$_COOKIE_memb_id' AND comp_subject='$comp_id'");
	$row     = mysql_fetch_array($result);
	$is_fav_comp = ($row['cnp']==0 ? false : true);
	if ($is_fav_comp)
		$follow_button = $follow_button0;
	else
		$follow_button = $follow_button1;
	
	// see functions.php (javascript func that adds/removes favorite prod via AJAX/jQuery ajx_product_fav.php)
	echo fav_prod();	// js/ajax for fav prod
	echo follow();		// js/ajax for following
	?>
	
	<?
	// activate (if not active and logged out)
	if ($is_active==0 and !isset($_COOKIE_comp_id)){
		?>
		<div style='position:fixed; bottom:0px; z-index:1000;'>
			<div style='width:1100px; height:160px; background-color:#FFF; border:1px solid #333;'>
				<div class='row' style='padding:20px; font-size:16px;'>
					<div class='col-xs-12 col-sm-3 text-left-xs text-center'>
						<div class='' style='font-weight:bold;'><?=$comp_name?></div>
						<div class='m-b'>Is this your business?</div>
						<a class='btn btn-primary' data-toggle='ajaxModal' href='<?=$URL?>modal_activate.php?id=<?=$memb_id?>' id='btn_activate'>
						Activate</a>
					</div>
					<div class='col-sm-9 hidden-xs' style='border-left:1px solid #333;'>
						Check out other seller pages
						<div class='row m-t'>
						<?
						$sql = "SELECT id, name, comp_url, header_image 
								FROM companies 
								WHERE id IN (7,9,13)";
						$result = mysql_query($sql);
						while($row = mysql_fetch_array($result)){
							$comp_pic_src = "Media/Stores/".$row["id"]."/profile/".$row["header_image"];
							$fit_img = fit_img($comp_pic_src, 100, 100);
							if ($row["header_image"]!="" and file_exists($comp_pic_src)){
								?>
								<div class='col-sm-4' style='text-align:center'>
								<a href='<?=$URL.$row["comp_url"]?>'>
									<div style='height:55px'>
										<img src="<?=$URL.$comp_pic_src?>" style='<?=$fit_img?>' border=0>
									</div>
									<?=$row["name"]?>
								</a>
								</div>
								<?
							}
						}
						?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?
		// if come from activate link, get the popup
		if (strstr($_SERVER['REQUEST_URI'], "activate") !== false){
			?>
			<script>
			$(window).load(function(){
				$("#btn_activate").click();
			});
			</script>
			<?
		}
	}
	?>
	
	<!--company name/about (top-left)-->
	<div class="row company-top-half">
	<div class="col-md-3 col-sm-3 col-xs-12 column">
		<?
		if ($real_url!=""){
			if (substr($real_url, 0, 4)!="http") $real_url = "http://".$real_url;
			echo "<a href='".$real_url."' class='public_comp_url' target='_blank' title='$real_url'>";
		}
		else
			echo "<a href='".$URL13.$comp_url."' class='public_comp_url'>";
			
		if (filled($header_image) and file_exists($URL_DD."Media/Stores/$comp_id/profile/$header_image"))
			echo "<img src='".$URL."Media/Stores/$comp_id/profile/$header_image' border=0 alt='$comp_name' class='company-header-image'></a>";
		else
			echo $comp_name."</a>";
		?>
		<br clear='all'>
		
		<?
		if ($introduction!=""){
			echo "".substr($introduction, 0, 140);
			if (strlen($introduction)>=140) echo "...<br/><a href='".$URL13.$comp_url."/about'><u>Read More</u></a>";
		}
		
		$from_id = isset($_COOKIE_memb_id) ? $_COOKIE_memb_id : 0;
		?>
		
		<div class="company-contact-buttons" style='margin-top:10px'>
			<button type='button' class='btn btn-gray' id='follow_button' onClick='return follow(<?=$comp_id?>)' style='font-size:12px'><?=$follow_button?></button>
			<button type='button' class='btn btn-gray' style='font-size:12px'
			onClick='contact_form(<?=$from_id?>, <?=$memb_id?>, "<?=$personname?>", "", "")'>MESSAGE</button>
		</div>
		<br clear='all' />

		<ul class="company-contact-info">
			<li class="list-title"><span>Contact Info</span></li>
			<li><span>Contact:</span> <?=$personname?></li>
			<?if ($phone!=""){?>
			<li><span><?=$lang["Phone"]?>:</span> <?=$phone?></li> <!--Phone-->
			<?}?>
			<?if ($fax!=""){?>
			<li><span><?=$lang["Fax"]?>:</span> <?=$fax?></li> <!--Fax-->
			<?}?>
			<?if ($other!=""){?>
			<li><?=$other?></li>
			<?}?>
		</ul>
	</div>
	
	<!--big logo (top-right)-->
	<div class="col-md-9 col-sm-9 col-xs-12 column">
		<?if (filled($main_image) and file_exists($URL_DD."Media/Stores/$comp_id/profile/$main_image")){
			$comp_pic_src = $URL."Media/Stores/".$comp_id."/profile/".$main_image;
			?>
			<img src='<?=$comp_pic_src?>' border=0 alt='<?=$comp_name?>' style='max-width:900px;' class='company-banner'>
		<?}else{?>
			<img src='<?=$URL?>Media/blanks/sample_logo.jpg' style='height:228px;' class='company-banner'>
		<?}?>
		
		<span class="company-address"><b>About <?=$comp_name?>:</b><br>
			<?
			$flag_path = "images/flags/".$flag.".png";
			if ($flag!="" and file_exists($URL_DD.$flag_path))
				echo "<img src='".$URL.$flag_path."' align='absmiddle'> ";
			echo $caddress;
			?>
		</span>
		
		<span class="company-type" id='scroll_to_here'><b><?=$lang["BusinessType"]?>:</b><br> <!--Business Type-->
			<?
			$query= "SELECT ".get_lang_column("B.typ")." as typp 
					FROM cc_business_types B 
					JOIN company2business C2B ON C2B.typ_id=B.id 
					JOIN companies C ON C.id=C2B.comp_id AND C.id='$comp_id'";
			$result = mysql_query($query);
			while($row = mysql_fetch_array($result)){
				echo $row["typp"]."<br/>";
			}
			?>
		</span>
		
		<br clear='all' /><br/>
		
		<ul class='company_menu clearfix' >
			<?if (!$pure_buyer){?>
			<li><a href='<?=$URL13.$comp_url?>'  	  <?if ($menu_name=="products") echo "class='underlined'"?>>
			<?=strtoupper($lang["Products"])?></a></li> <!--PRODUCTS-->
			<?}?>
			
			<?if ($introduction==""){?>
			<li><a href='javascript:void(0)' 		  <?if ($menu_name=="about") echo "class='underlined'"?> style='color:#AAAAAA' title='No info available'>
			<?}else{?>
			<li><a href='<?=$URL13.$comp_url?>/about' <?if ($menu_name=="about") echo "class='underlined'"?>>
			<?}?>
			<?=strtoupper($lang["Profile"])?></a></li> <!--PROFILE-->
			
			<?if ($cn_blogposts==0){?>
			<li><a href='javascript:void(0)' 		  		<?if ($menu_name=="tradefeed") echo "class='underlined'"?> style='color:#AAAAAA' title='No tradefeed posted'>
			<?}else{?>
			<li><a href='<?=$URL13.$comp_url?>/tradefeed' 	<?if ($menu_name=="tradefeed") echo "class='underlined'"?>>
			<?}?>
			<?=strtoupper($lang["Tradefeed"])?></a></li> <!--TRADEFEED-->
			
			<?if (!$pure_buyer){?>
				<?if ($cn_catalogs==0){?>
				<li><a href='javascript:void(0)' 				<?if ($menu_name=="catalog") echo "class='underlined'"?> style='color:#AAAAAA' title='No catalogs available'>
				<?}else{?>
				<li><a href='<?=$URL13.$comp_url?>/catalogs' 	<?if ($menu_name=="catalog") echo "class='underlined'"?>>
				<?}?>
				<?=strtoupper($lang["Catalogs"])?></a></li> <!--CATALOGS-->
			<?}?>
			
			<li><a href='<?=$URL13.$comp_url?>/contacts'	<?if ($menu_name=="contact") echo "class='underlined'"?>>
			<?=strtoupper($lang["Contacts"])?></a></li> <!--CONTACTS-->
		</ul>
	</div>
	</div>
	<span style='clear:both' /></span>
	
	<!--gray left column-->
	<style>
	.delimiter{
		border-top:1px solid #D9D9D9; 
		width:100%; 
		height:1px; 
		margin:10px 0 10px 0;
	}
	</style>

	<!-- narrow results desktop/mobile -->
	<div class="row">
	<div class="col-md-3 col-sm-3 col-xs-12 column search-bar">
		<div class="visible-xs narrow-results">
			<div>Narrow Results</div>
		</div>
		
		<div class="menu-container" style=' padding:10px; background-color:#F0F0F0;  margin-top:0px; line-height:18px;'>
			<b style='font-size:16px'><?=$comp_name?></b>
			<div class='delimiter'></div>
			
			<!--1.1-->
			<b>Shop By Category</b>
			<div style='height:5px;'></div>
			<?
			// count of products for this company not in any category
			$query = "SELECT COUNT(1) as cn FROM products 
					 WHERE comp_id='$comp_id' AND purpose=1 AND status=1 AND (group_id=0 or group_id IS NULL)";
			$result  = mysql_query($query);
			$row     = mysql_fetch_array($result, MYSQL_ASSOC);
			$c_nocateg = $row['cn'];
			
			// product groups
			$pg = 0;
			$caret0 = "&nbsp;&nbsp;";
			$caret1 = "<i class='fa fa-caret-right'></i> ";
			$query = "SELECT G.id as group_id, G.gruppa, COUNT(P.id) as pcount 
						FROM product_groups G 
						JOIN products P ON P.comp_id='$comp_id' AND P.group_id=G.id AND P.purpose=1 AND P.status=1 
						GROUP BY G.id, G.gruppa 
						ORDER BY G.gruppa";
			$result = mysql_query($query);
			while($row = mysql_fetch_array($result)){
				$pg = $pg + $row['pcount'];
				$caret = (isset($_GET["group_id"]) and $_GET["group_id"]==$row['group_id']) ? $caret1 : $caret0;
				echo $caret."<a href='".$URL13.$comp_url."/1/".$row["group_id"]."'>".$row["gruppa"]."</a> [".$row["pcount"]."]<br/>";
			}
			if ($c_nocateg !=0 ){
				$caret = (isset($_GET["group_id"]) and $_GET["group_id"]==0) ? $caret1 : $caret0;
				echo $caret."<a href='".$URL13.$comp_url."/1/0'>Others</a> [$c_nocateg]<br/>";
			}
			
			$caret = (isset($_GET["group_id"])) ? $caret0 : $caret1;
			echo $caret."<a href='".$URL13.$comp_url."'>All Products</a> [".($pg+$c_nocateg)."]<br/>";
			?>
			<div class='delimiter'></div>
		</div>

	</div>
	<?
}

// PDF trade docs: a cell with bold key and normal value
function draw_cell_2lines($key, $value, $this_margin_left, $this_margin_top, $this_width1, $this_height1){
	global $pdf, $font_size;
	$left_pad = 1;
	
	$pdf->SetXY($this_margin_left, $this_margin_top);	// border
	$pdf->drawTextBox("", $this_width1, $this_height1);
	
	$valY = 2;
	if ($key!=""){
		$pdf->SetFont("Arial", "B", $font_size);	// key
		$pdf->SetXY($this_margin_left+$left_pad, $this_margin_top+2);
		$pdf->drawTextBox($key, $this_width1, $this_height1, "L", "T", 0);
		$valY = 7;
	}
	
	$pdf->SetFont("Arial", "", $font_size);	// value
	$pdf->SetXY($this_margin_left+$left_pad, $this_margin_top+$valY);
	$pdf->drawTextBox($value, $this_width1-$left_pad*2, $this_height1, "L", "T", 0);
}

// PDF commodity header
function commodity_header($pos_y, $height4){
	global $pdf, $font_size, $cmd_arr_descr, $cmd_arr_posx, $cmd_arr_width, $cmd_arr_align;
	$pdf->SetFont("Arial", "B", $font_size);
	for ($i=0; $i<count($cmd_arr_posx); $i++){
		$pdf->SetXY($cmd_arr_posx[$i], $pos_y);
		$pdf->drawTextBox("\n".$cmd_arr_descr[$i], $cmd_arr_width[$i], $height4, $cmd_arr_align[$i]);
	}
}

// PDF commodity header (BOL)
function commodity_header_lined($pos_y, $height4, $id=""){
	global $pdf, $font_size, $cmd_arr_descr, $cmd_arr_posx, $cmd_arr_width, $cmd_arr_align, $fine_print;
	for ($i=0; $i<count($cmd_arr_posx); $i++){
		$pdf->SetFont("Arial", "B", $font_size);
		$pdf->SetXY($cmd_arr_posx[$i], $pos_y);		// render border
		$pdf->drawTextBox("", $cmd_arr_width[$i], $height4, $cmd_arr_align[$i], "T", 1);
		$pdf->SetXY($cmd_arr_posx[$i], $pos_y+1);	// render text, topped, with padding-top=1
		$pdf->drawTextBox($cmd_arr_descr[$i], $cmd_arr_width[$i], $height4, $cmd_arr_align[$i], "T", 0);
		
		if ($id==1 and $i==6){	// special text in fine print for Commodity Descr
			$pdf->SetFont("Arial", "", $fine_print);
			$cmd_text = "Commodities requiring special or additional care or attention in handling or stowing must be so marked and packaged as to ensure safe transportation with ordinary care. See Section 2(e) of NMFC item 360";
			$pdf->SetXY($cmd_arr_posx[$i], $pos_y+5);
			$pdf->drawTextBox($cmd_text, $cmd_arr_width[$i], $height4, $cmd_arr_align[$i], "T", 0);
		}
	}
}

// PDF commodity body (runs in cycle, $new_pos_y depends on number of lines of commodity name + gap)
function commodity_body($new_pos_y){
	global $pdf, $font_size, $cmd_arr_items, $cmd_arr_posx, $cmd_arr_width, $cmd_arr_align;
	
	$pdf->SetFont("Arial", "", $font_size);
	for ($i=0; $i<count($cmd_arr_posx); $i++){
		$pdf->SetXY($cmd_arr_posx[$i], $new_pos_y);
		$pdf->drawTextBox($cmd_arr_items[$i], $cmd_arr_width[$i], 0, $cmd_arr_align[$i], "T", 0);
	}
}

// PDF commodity body (BOL) - with lines
function commodity_body_lined($new_pos_y, $id=""){
	global $pdf, $font_size, $cmd_arr_items, $cmd_arr_posx, $cmd_arr_width, $cmd_arr_align;
	
	$pdf->SetFont("Arial", "", $font_size);
	for ($i=0; $i<count($cmd_arr_posx); $i++){
		$val = $cmd_arr_items[$i];
		$val01 = $val;
		if ($id==1 and ($i==3 or $i==4)){	// Pallet/Slip - circle Y or N
			if ($i==3) $val = "Y";
			if ($i==4) $val = "N";
			if (($val01==1 and $i==3) or ($val01==0 and $i==4)){
				$pdf->SetXY($cmd_arr_posx[$i]+4, $new_pos_y+0.7);
				$pdf->drawTextBox("", 3.1, 3.1, $cmd_arr_align[$i], "M", 1);
			}
		}
		$pdf->SetXY($cmd_arr_posx[$i], $new_pos_y);
		$pdf->drawTextBox($val, $cmd_arr_width[$i], 5, $cmd_arr_align[$i], "M", 1);
	}
}

// PDF commodity body - get height of multi-line text (commodity item) with inter-line gap (6)
function get_cmd_height($pdf, $cell_width, $cell_text){
	return 3*$pdf->GetMultiCellHeight($cell_width, 1, $cell_text) + 6;
}

// NEW / FEATURED ribbon use after td-div(relative)
function ribbon($var){
	if ($var=="f"){
		$title = "FEATURED*";
		$bgcolor = "#00B4C2";
		$triangle_color = "#085251";
	}
	elseif ($var=="n"){
		$title = "NEW*";
		$bgcolor = "#ED3205";
		$triangle_color = "#4C0D00";
	}
	?>
	<div style='position:absolute; top:-5px; left:-10px; height:26px; line-height:26px; z-index:100; color:#FFF; background-color:<?=$bgcolor?>; padding:0 10px;'>
	<?=$title?></div>
	<div style='position:absolute; top:21px; left:-10px; width:0px; height:0px;
				border-right:10px solid <?=$triangle_color?>; border-top:0px solid transparent; border-bottom: 4px solid transparent;'></div>
	<?
}

/********** NOTEBOOK (THEMEFOREST)************/

// 1-visible_name, 2-short_name, 3-php_link, 4-circled number pulled right, 5-is_expandable, 6-fa_icon_name, 7-bg_name (danger, warning), 
// 8-array of submenus, 9-active_menu, 10-active_submenu, 11-array_submenu_number, 12-array_submenu_color
function forest_menu($menu_name, $menu_short, $menu_link, $menu_number, $is_expandable, 
$fa_icon_name, $bg_name, $array_submenus, $active_menu, $active_submenu, $array_submenu_number, $array_submenu_color){
	?>
	<li <?if ($menu_short==$active_menu) echo "class='active'"?>>
		<a href="<?=$menu_link?>"  >
			<?if ($menu_number!=""){
				if ($menu_short=="message") $bg_number = "warning";
				elseif ($menu_short=="cart") $bg_number = "primary";
				else $bg_number = "info";
				$bg_number = $bg_name;
				?>
				<b class="badge bg-<?=$bg_number?> pull-right" <?if ($menu_short=="message") echo "id='left_msg_bubble'; style='color:#333'"?>>
				<?=$menu_number?></b>
			 <?}?>
			<i class="fa <?=$fa_icon_name?> icon">
				<b class="bg-<?=$bg_name?>"></b>
			</i>
			<?if ($is_expandable==1){?>
			<span class="pull-right">
				<i class="fa fa-angle-down text"></i>
				<i class="fa fa-angle-up text-active"></i>
			</span>
			<?}?>
			<span><?=$menu_name?></span>
		</a>
		<?if ($is_expandable==1){?>
		<ul class="nav lt">
			<?
			$i = 0;
			if (is_array($array_submenus)){
				foreach ($array_submenus as $p_name => $p_link){
					$i++;
					?>
					<li <?if ($menu_short==$active_menu and $i==$active_submenu) echo "class='active'"?>>
						<a href="<?=$p_link?>" >                                                        
							<i class="fa fa-angle-right"></i>
							<span><?=$p_name?></span>
							<?
							// bubble with number (if applicable)
							if (is_array($array_submenu_number) and $array_submenu_number[$i-1]!=0){?>
							<b class="badge bg-<?=$array_submenu_color[$i-1]?> pull-right"><?=$array_submenu_number[$i-1]?></b>
							<?}?>
						</a>
					</li>
					<?
				}
			}
			?>
          </ul>
		  <?}?>
	 </li>
	<?
}

// Tradeware, Communication
function forest_menu_header($header_name){
	?>
	<li style='background-color:#888888;'>
		<a href='javascript:void(0)' style='cursor:default; color:#FFF !important;'>
		<span><?=$header_name?><span>
		</a>
	</li>
	<?
}

// This function calculates all names/numbers for the forest header and the left menu.
// Then the output is transferred to forest_top() as global serialized array.
// Since this function contains setcookie(), it must be called before "<!DOCTYPE html>": $serlzd_cookie_params = get_cookie_params();
// forest_top() is called inside the body, thus the cookies cannot be set there. Serialization rules.
function get_cookie_params(){
	global $cookietime;	// use cookies to maximally reduce database retrieval
	global $_COOKIE_comp_id, $_COOKIE_memb_id;
	
	// company info
	$my_comp_name 	= $_COOKIE["comp_name"];
	$my_comp_url 	= $_COOKIE["comp_url"];
	$firstname 		= $_COOKIE["firstname"];
	$lastname 		= $_COOKIE["lastname"];
	$user_photo 	= $_COOKIE["photo"];
		
	// number of fav products
	if (isset($_COOKIE["cn_fav_products"]) and $_COOKIE["cn_fav_products"]!=0){
		$cn_fav_products = $_COOKIE["cn_fav_products"];
	}
	else{
		$sql = "SELECT COUNT(1) as cn 
				FROM products P 
				JOIN members_favprod F ON F.memb_id='$_COOKIE_memb_id' AND F.prod_id=P.id 
				JOIN companies C ON C.id=P.comp_id 
				JOIN members M ON M.id=C.user_id";
		$result  = mysql_query($sql);
		$row     = mysql_fetch_array($result);
		$cn_fav_products = $row['cn'];
		setcookie("cn_fav_products", $cn_fav_products, time()+$cookietime, "/", "globemart.com", isset($_SERVER["HTTPS"]), true);
	}
	
	// number of followers (no cookies, the number doesn't depend on your activity)
	$result  = mysql_query("SELECT COUNT(1) AS cn FROM blog_followers WHERE comp_subject='$_COOKIE_comp_id'");
	$row     = mysql_fetch_array($result);
	$followers = $row['cn']; 

	// number of people i'm following
	if (isset($_COOKIE["following"]) and $_COOKIE["following"]!=0){
		$following = $_COOKIE["following"];
	}
	else{
		$result  = mysql_query("SELECT COUNT(1) AS cn FROM blog_followers WHERE memb_object='$_COOKIE_memb_id'");
		$row     = mysql_fetch_array($result);
		$following = $row['cn'];
		setcookie("following", $following, time()+$cookietime, "/", "globemart.com", isset($_SERVER["HTTPS"]), true);
	}
	
	// messages  (no cookies, the number doesn't depend on your activity)
	$result  = mysql_query("SELECT COUNT(1) AS cn FROM messages WHERE to_id='$_COOKIE_memb_id' AND is_read=0 AND to_del=0");
	$row     = mysql_fetch_array($result, MYSQL_ASSOC);
	$notif_msgs = $row['cn'];

	// tradefeed  (no cookies, the number doesn't depend on your activity)
	$result  = mysql_query("SELECT SUM(cn_notif) as cn FROM blog WHERE memb_id='$_COOKIE_memb_id' AND blog_id IS NULL");
	$row     = mysql_fetch_array($result, MYSQL_ASSOC);
	$notif_tfeed = $row["cn"];
	if ($notif_tfeed=="") $notif_tfeed = 0;
	
	// bell settings
	$sql = "SELECT bell_following, bell_favprod FROM members WHERE id='$_COOKIE_memb_id'";
	$result  = mysql_query($sql);
	$row     = mysql_fetch_array($result);
	$bell_following = $row["bell_following"];
	$bell_favprod   = $row["bell_favprod"];
	
	// notification of favorited products
	$notif_favprod = 0;
	if ($bell_favprod==1){
		$sql = "SELECT COUNT(1) as cn 
				FROM members_favprod F
				JOIN products P ON P.id=F.prod_id
				JOIN companies C ON C.id=P.comp_id AND C.id='$_COOKIE_comp_id'
				WHERE F.memb_id<>'$_COOKIE_memb_id' AND F.seen=0";
		$result  = mysql_query($sql);
		$row     = mysql_fetch_array($result);
		$notif_favprod = $row["cn"];
	}
	
	// notification of new follower
	$notif_following = 0;
	if ($bell_following==1){
		$sql = "SELECT COUNT(1) as cn 
				FROM blog_followers F
				WHERE F.comp_subject='$_COOKIE_comp_id' AND F.memb_object<>'$_COOKIE_comp_id' AND F.seen=0";
		$result  = mysql_query($sql);
		$row     = mysql_fetch_array($result);
		$notif_following = $row["cn"];
	}
	
	// count of products
	if (isset($_COOKIE["cn_products"]) and $_COOKIE["cn_products"]!=0){
		$cn_products = $_COOKIE["cn_products"];
	}
	else{
		$result  = mysql_query("SELECT COUNT(1) AS cn FROM products WHERE comp_id='$_COOKIE_comp_id' AND status=1 AND purpose=1");
		$row     = mysql_fetch_array($result);
		$cn_products = $row['cn'];
		setcookie("cn_products", $cn_products, time()+$cookietime, "/", "globemart.com", isset($_SERVER["HTTPS"]), true);
	}
	
	// count of products in sourcing cart
	/*if (isset($_COOKIE["notif_dollys"]) and $_COOKIE["notif_dollys"]!=0){
		$notif_dolly = $_COOKIE["notif_dollys"];
	}
	else{
		$sql = "SELECT COUNT(1) as cn FROM shopping_cart WHERE member_id='$_COOKIE_memb_id'";
		$result  = mysql_query($sql);
		$row     = mysql_fetch_array($result);
		$notif_dolly = $row["cn"];
		setcookie("notif_dollys", $notif_dolly, time()+$cookietime, "/", "globemart.com", isset($_SERVER["HTTPS"]), true);
	}*/
	
	$sql = "SELECT COUNT(1) as cn FROM shopping_cart WHERE member_id='$_COOKIE_memb_id' AND process_id IS NULL";
	$result  = mysql_query($sql);
	$row     = mysql_fetch_array($result);
	$notif_dolly = $row["cn"];
	
	$arr_cookie_params = array("my_comp_name"=>$my_comp_name, "my_comp_url"=>$my_comp_url, 
								"cn_fav_products"=>$cn_fav_products, "followers"=>$followers, "following"=>$following, 
								"notif_msgs"=>$notif_msgs, "notif_tfeed"=>$notif_tfeed, 
								"notif_favprod"=>$notif_favprod, "notif_following"=>$notif_following, 
								"cn_products"=>$cn_products, 
								"firstname"=>$firstname, "lastname"=>$lastname, "user_photo"=>$user_photo, "notif_dolly"=>$notif_dolly);
						
	$serlzd_cookie_params = serialize($arr_cookie_params);
	return $serlzd_cookie_params;
}

// bell notification details
function notif_item($ntf_id, $name, $link, $link_id, $avatar_pic1, $first_name, $last_name, $acted, $subject, $cut, $date_sent, $fa_icon, $src_pic=""){
	global $URL13;
	$nnn = "<a href='".$URL13.$link.$link_id."' class='media list-group-item' style='color:#1B252E' ";
	if ($name=="favprod" or $name=="following") $nnn.=" onMouseOver='notif_seen(\"$name\", $ntf_id, 1, 1)'";
	$nnn.= "><span class='pull-left thumb-sm'>
				<img src='$avatar_pic1' class='img-circle'>
			</span>
			<span class='";
	if ($name=="favprod") $nnn.= "pull-left ";
	$nnn.= "media-body block m-b-none'>
			<b>$first_name $last_name</b><br/>
			<i class='fa fa-$fa_icon'></i> $acted";	// acted: liked, started following
	if ($name=="favprod") $nnn.="'";
	$nnn.= long_cut($subject, $cut);
	if ($name=="favprod") $nnn.="'";
	$nnn.= "<br><small class='text-muted'>".date("d M Y @ h:ia", strtotime($date_sent))."</small>";	// timestamp
	if ($name=="favprod" or $name=="following") $nnn.= " <i class='fa fa-check' style='color:green; display:none;' title='Seen' id='ni_$name$ntf_id'></i>";
	$nnn.= "</span>";
	if ($name=="favprod"){	// product pic
		$nnn.= "<span class='pull-right thumb-sm'>
				<img src='$src_pic'></span>";
	}
	$nnn.= "</a>";
	return $nnn;
}

function forest_header($go_after_sign_to_the_same_page=""){
	global $URL, $URL13, $_COOKIE_comp_id, $_COOKIE_memb_id, $lang, $arr_lang, $LONG_NUMBER;
	$pgencode = ($go_after_sign_to_the_same_page=="") ? page_encode() : "";	// default yes
	
	$is_signin_page = (strpos($_SERVER["PHP_SELF"], "signin.php")) ? true : false;
	
	$called_from_forest_top = false;	
	if (isset($_COOKIE_comp_id)){
		global $serlzd_cookie_params;
		$arr_cookie_params = unserialize($serlzd_cookie_params);
		foreach ($arr_cookie_params as $key => $value)	// set the original name of the variable and its value
			$$key = $value;
		
		$filter_notif = ($notif_tfeed>0) ? "?newcm=1" : "";
		$avatar_pic = get_avatar($_COOKIE_comp_id, $user_photo, "", "small");
		$bell_notif = $notif_msgs + $notif_tfeed + $notif_favprod + $notif_following;
		
		// define where this toppest strip was called from
		$backtrace = debug_backtrace();
		if (isset($backtrace[1]['function']) and $backtrace[1]['function'] == "forest_top")
			$called_from_forest_top = true;
	}
	
	$srchtype = isset($_GET["srchtype"]) ? $_GET["srchtype"] : "";
	$srch = isset($_GET["srch"]) ? $_GET["srch"] : "";
	$srch_placeholder = ($srchtype=="") ? "Search Product" : "Search ".$srchtype;
	
	$arr_info = array($URL13."features"=>$lang["Features"], $URL13."marketplace"=>$lang["Marketplace"], 
					$URL13."sellers"=>$lang["Sellers"], $URL13."buyers"=>$lang["Buyers"]);
	if (!isset($_COOKIE_comp_id))
		$arr_info = array_merge($arr_info, array($URL13."tradeware"=>$lang["Tradeware"], $URL13."tradefeed"=>$lang["Tradefeed"]));
	$arr_info = array_merge($arr_info, array($URL13."pricing"=>$lang["Pricing"]));
	
	$arr_info = array_map('strtoupper', $arr_info);
	
	echo zendesk();
	?>
	<header class="bg-dark dk header navbar navbar-fixed-top">
		<!-- GLOBEMART LOGO / Mobile View -->
		<div class="navbar-header aside-md" >
			<?
			// signed in (mobile view)
			if (isset($_COOKIE_comp_id)){?>
				<div class="btn visible-xs" style='padding-left:0px'>
					<?if ($called_from_forest_top){?>
					<a data-toggle="class:nav-off-screen,open" data-target="#nav,html" class='icons_inline'>
					<?}else{?>
					<a href='<?=$URL13?>main.php' class='icons_inline'>
					<?}?>
						<i class="fa fa-bars"></i>
					</a>
					
					<span class='dropdown'>	<!--info (signedin_mobile)-->
						<a href="#" class="dropdown-toggle icons_inline" data-toggle="dropdown" ><i class="fa fa-info-circle"></i></a>
						<ul class="dropdown-menu animated fadeInUp" style='margin-top:12px'>
							<?
							foreach ($arr_info as $link=>$name){
								echo "<li><a href='$link'>$name</a></li>";
							}
							?>
						</ul>
					</span>
					
					<!--search (signedin_mobile)-->
					<span class='dropdown'>
						<a href="#" class="dropdown-toggle icons_inline" data-toggle="dropdown"><i class="fa fa-search"></i></a>
						<section class="dropdown-menu aside-xl animated fadeInUp" style='width:250px; margin-top:12px'>
						<section class="panel bg-white">
							<form role="search" onSubmit='do_search("signedin_mobile")' id='signedin_mobile'>
							<div class="form-group wrapper m-b-none">
							  <div class="input-group">
								<input type="text" class="form-control" id='globesearch' placeholder="<?=$srch_placeholder?>" value='<?=$srch?>'
								onKeyUp='do_search_enter(event, "signedin_mobile")' name='srch'>
								<span class="input-group-btn">
								  <button type="button" class="btn btn-info btn-icon" onClick='do_search("signedin_mobile")'><i class="fa fa-search"></i></button>
								</span>
							  </div>
							</div>
							</form>
						</section>
						</section>
					</span>
				</div>
				
				<!-- logo -->
				<a href="<?=$URL13?>" class="navbar-brand"><img src="<?=$URL13?>images/logo.svg" class="m-r-sm" id='logo_signedin'></a>
				
				<!-- cart/bell/settings (signed-in mobile) -->
				<div class="btn visible-xs" style='padding-right:0px'>
					<a href="<?=$URL13?>my_cart.php" class='icons_inline'>
						<i class="fa fa-shopping-cart"></i>
						<?if ($notif_dolly!=0){?>
						<span class="badge badge-sm up bg-primary m-l-n-sm count"><?=$notif_dolly?></span>
						<?}?>
					 </a>
					 
					 <a href="<?=$URL13?>notifications.php" class='icons_inline'>
						<i class="fa fa-bell"></i>
						<?if ($bell_notif!=0){?>
						<span class="badge badge-sm up bg-danger m-l-n-sm count" id='bell_number'><?=$bell_notif?></span>
						<?}?>
					 </a>
					 
					 <a data-toggle="dropdown" data-target=".nav-user" class='icons_inline'>
					 <i class="fa fa-cog"></i></a>
				</div>
			<?
			}
			else{	// signed out (mobile view)
				?>
				<a href="<?=$URL13?>" class="navbar-brand pull-left "><img src="<?=$URL13?>images/logo.svg" id='logo_signedout' class="m-r-sm"></a>
				
				<ul class='nav navbar-nav pull-right visible-xs ' style='margin-top:16px;'>
					<a href="<?=$URL13?>pricing" ><?=strtoupper($lang["Join"])?></a>
					&nbsp;&nbsp;&nbsp;
					<?if ($is_signin_page){?>
					<a href='javascript:void(0)'><?=strtoupper($lang["Signin"])?></a>
					<?}else{?>
					<a href="<?=$URL13?>signin_modal.php?pg_comefrom=<?=$pgencode?>" data-toggle="ajaxModal"><?=strtoupper($lang["Signin"])?></a>
					<?}?>
					&nbsp;&nbsp;&nbsp;
					<a href="#" class="dropdown-toggle icons_inline" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
					<ul class="dropdown-menu animated fadeInUp" style='margin-top:10px'> <!--info-->
						<?foreach ($arr_info as $link=>$name){?>
						<li><a href="<?=$link?>"><?=$name?></a></li>
						<?}?>
					</ul>
					&nbsp;&nbsp;&nbsp;
				</ul>
				
				<!-- FLAG -->
				<span class='dropdown visible-xs pull-right' style='margin-top:13px; margin-right:25px;'>
					<a href="#" class="dropdown-toggle dk" data-toggle="dropdown">
					<img src='<?=$URL?>images/flags/<?=get_flag()?>' border=0 style='margin-top:-4px'></a>
					<ul class="dropdown-menu animated fadeInRight" style='margin-top:16px'>
						<?
						foreach ($arr_lang as $x){
							?>
							<li><a href="javascript:void(0)" onClick='change_language("<?=$x["lg"]?>")'>
							<img src='<?=$URL?>images/flags/<?=$x["flag"]?>' border=0> 
							<?=$x["language"]. ($x["language_tr"]=="" ? "" : " / ".$x["language_tr"])?></a></li>
							<?
						}
						?>
					</ul>
				</span>
					
				<!--search (signed out, mobile)-->
				<span class='dropdown visible-xs pull-right' style='margin-top:13px; margin-right:5px;'>
					<a href="#" class="dropdown-toggle icons_inline" data-toggle="dropdown"><i class="fa fa-search"></i></a>
					<section class="dropdown-menu aside-xl animated fadeInUp" style='width:250px; margin-top:16px; margin-right:-130px;'>
					<section class="panel bg-white">
						<form role="search" onSubmit='do_search("signedout_mobile")' id='signedout_mobile'>
						<div class="form-group wrapper m-b-none">
						  <div class="input-group">
							<input type="text" class="form-control" id='globesearch' placeholder="<?=$srch_placeholder?>" value='<?=$srch?>'
							onKeyUp='do_search_enter(event, "signedout_mobile")' name='srch'>
							<span class="input-group-btn">
							  <button type="button" class="btn btn-info btn-icon" onClick='do_search("signedout_mobile")'><i class="fa fa-search"></i></button>
							</span>
						  </div>
						</div>
						</form>
					</section>
					</section>
				</span>
				<?
			}
			?>
		</div>
	  
	  <!-- ACTIVITY -->
	  <?if (isset($_COOKIE_comp_id)){?>
      <ul class="nav navbar-nav hidden-xs hidden-sm hidden-md">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle dker" data-toggle="dropdown">
            <i class="fa fa-building-o"></i> 
            <span class="font-bold">Activity</span>
          </a>
          <section class="dropdown-menu aside-xl on animated fadeInLeft no-borders lt">
            <div class="wrapper lter m-t-n-xs">
              <a href="<?=$URL13?>my_contact.php" class="thumb pull-left m-r">
                <img src="<?=$avatar_pic?>" class="img-circle" style='max-height:80px'>
              </a>
              <div class="clear">
                <a href="<?=$URL13?>my_contact.php"><span class="text-white font-bold"><?=$firstname." ".$lastname?></a></span>
                <a href='<?=$URL13.$my_comp_url?>'><small class="block"><?=$my_comp_name?></small></a>
				<br/><br/>
              </div>
            </div>
            <div class="row m-l-none m-r-none m-b-n-xs text-center">
              <a href='<?=$URL13?>my_fav_followers.php'>
			  <div class="col-xs-6">
                <div class="padder-v">
                  <span class="m-b-xs h4 block text-white"><?=$followers?></span>
                  <small class="text-muted"><?=$lang["Followers"]?></small> <!--Followers-->
                </div>
              </div></a>
			  
			   <a href='<?=$URL13?>my_products.php'>
				<div class="col-xs-6 dk">
                <div class="padder-v">
                  <span class="m-b-xs h4 block text-white"><?=$cn_products?></span>
                  <small class="text-muted">Uploaded Products</small>
                </div>
				</div></a>
            </div>
          </section>
        </li>
      </ul>
	  
		<!-- SEARCH (logged in, desktop) -->
		<style>
		@media (min-width:768px) { #wrap_div_globesearch {margin-left:-50px !important} }
		@media (min-width:800px) { #wrap_div_globesearch {margin-left:-10px !important;} }
		</style>
		<div role="search" onSubmit='do_search("signedin_desktop")' id='signedin_desktop'>
		<div class="form-inline nav navbar-nav navbar-left hidden-xs" id='wrap_div_globesearch' style='padding-top:6px; padding-left:50px'>
			<div class="input-group"  >
			<select id='globesearch_type' name='globesearch_type' class="form-control globesearch_type_logged_in_desk" onChange='globesearch_type_chng()'>
				<option value='Product' <?if ($srchtype=="Product" or $srchtype=="") echo "selected"?>><?=$lang["Products"]?>
				<option value='Seller' <?if ($srchtype=="Seller") echo "selected"?>><?=$lang["Sellers"]?>
				<option value='Buyer' <?if ($srchtype=="Buyer") echo "selected"?>><?=$lang["Buyers"]?>
				<?if (isset($_COOKIE_comp_id)){?>
				<option value='Lead' <?if ($srchtype=="Lead") echo "selected"?>><?=$lang["BuyingLeads"]?>
				<?}?>
			</select>
			 </div>
			<div class="input-group">
				<input type="text" class="form-control globesearch_logged_in_desk" style='height:34px;' id='globesearch' name='srch'
				placeholder="<?=$srch_placeholder?>" onKeyUp='do_search_enter(event, "signedin_desktop")' value='<?=$srch?>'>
				<span class="input-group-btn">
					<button type="button" class="btn btn-info btn-icon" onClick='do_search("signedin_desktop")'><i class="fa fa-search"></i></button>
				</span>
			</div>
		</div>
		</div>
	  
      <ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user">
		<!-- FLAG -->
		<li class="dropdown hidden-xs">
			<a href="#" class="dropdown-toggle dk" data-toggle="dropdown">
			<img src='<?=$URL?>images/flags/<?=get_flag()?>' border=0 style='margin-top:-5px'></a>
			<ul class="dropdown-menu animated fadeInRight">
				<?
				foreach ($arr_lang as $x){
					?>
					<li><a href="javascript:void(0)" onClick='change_language("<?=$x["lg"]?>")'>
					<img src='<?=$URL?>images/flags/<?=$x["flag"]?>' border=0> 
					<?=$x["language"]. ($x["language_tr"]=="" ? "" : " / ".$x["language_tr"])?></a></li>
					<?
				}
				?>
			</ul>
		</li>
		
		<!-- CART -->
		<li class="hidden-xs" title='<?=$notif_dolly?> product<?=($notif_dolly==1?"":"s")?> in your Shopping Cart'>
			<a href="<?=$URL13?>my_cart.php">
            <i class="fa fa-shopping-cart"></i>
			<?if ($notif_dolly!=0){?>
			<span class="badge badge-sm up bg-primary m-l-n-sm count"><?=$notif_dolly?></span>
			<?}?>
			</a>
		</li>
		
		<!-- NOTIFICATION BELL -->
        <li class="hidden-xs">
          <a href="#" class="dropdown-toggle dk" data-toggle="dropdown">
            <i class="fa fa-bell"></i>
			<?if ($bell_notif!=0){?>
			<span class="badge badge-sm up bg-danger m-l-n-sm count" id='bell_number'><?=$bell_notif?></span>
			<?}?>
          </a>
          <section class="dropdown-menu aside-xl">
            <section class="panel bg-white">
              <header class="panel-heading b-light bg-light">
                <strong>You have <span class="count" id='bell_number_n'><?=$bell_notif?></span> notification<?=($bell_notif==1)?"":"s"?></strong>
              </header>
			  <?if ($bell_notif!=0){?>
              <div class="list-group list-group-alt animated fadeInRight">
				<?
				$arr_notif = array();
				if ($notif_msgs!=0){	// emails
					$sql = "SELECT M.id, M.subject, M.date_sent,
									A.id as memb_id, A.firstname, A.lastname, A.photo, C.id as comp_id, C.header_image
							FROM messages M 
							JOIN members A ON A.id=M.from_id
							JOIN companies C ON C.user_id=A.id 
							WHERE M.to_id='".$_COOKIE_memb_id."' AND M.is_read=0 AND M.to_del=0
							ORDER BY M.date_sent DESC";
					$result = mysql_query($sql);
					while($row = mysql_fetch_array($result)){
						$date_sent = $row["date_sent"];
						$avatar_pic1 = get_avatar($row["comp_id"], $row["photo"], $row["header_image"], "small");
						
						$n = notif_item($row["id"], "message", "my_mail_read.php?msg_id=", $row["id"], $avatar_pic1, $row["firstname"], $row["lastname"], 
										"", $row["subject"], 29, $date_sent, "envelope-o");
						$arr_notif[$date_sent] = $n;
					}
				}
				if ($notif_tfeed!=0){	// tradefeed
					$sql = "SELECT BB.id, B.body, BB.dateleft, 
									A.id as memb_id, A.firstname, A.lastname, A.photo, C.id as comp_id, C.header_image
							FROM blog B
							JOIN blog BB ON BB.blog_id=B.id AND BB.memb_id<>'".$_COOKIE_memb_id."' AND BB.cn_notif=1
							JOIN members A ON A.id=BB.memb_id
							JOIN companies C ON C.user_id=A.id 
							WHERE B.memb_id='".$_COOKIE_memb_id."' AND B.cn_notif<>0 AND B.blog_id IS NULL
							ORDER BY BB.dateleft DESC";
					$result = mysql_query($sql);
					while($row = mysql_fetch_array($result)){
						$date_sent = $row["dateleft"];
						$avatar_pic1 = get_avatar($row["comp_id"], $row["photo"], $row["header_image"], "small");
						
						$n = notif_item($row["id"], "tradefeed", "my_tradefeed.php?msg_id=", $row["id"], $avatar_pic1, $row["firstname"], $row["lastname"], 
									"replied to ", $row["body"], 24, $date_sent, "comments-o");
						$arr_notif[$date_sent] = $n;
					}
				}
				if ($notif_following!=0){	// following
					$sql = "SELECT F.id, F.date_followed,
									A.id as memb_id, A.firstname, A.lastname, A.photo, C.id as comp_id, C.header_image
							FROM blog_followers F
							JOIN members A ON A.id=F.memb_object
							JOIN companies C ON C.user_id=A.id 
							WHERE F.comp_subject='$_COOKIE_comp_id' AND F.memb_object<>'$_COOKIE_comp_id' AND F.seen=0";
					$result = mysql_query($sql);
					while($row = mysql_fetch_array($result)){
						$date_sent = $row["date_followed"];
						$avatar_pic1 = get_avatar($row["comp_id"], $row["photo"], $row["header_image"], "small");
						
						$n = notif_item($row["id"], "following", "my_fav_followers.php", "", $avatar_pic1,  $row["firstname"], $row["lastname"], 
									"started following you.", "", 0, $date_sent, "eye");
						$arr_notif[$date_sent] = $n;
					}
				}
				if ($notif_favprod!=0){	// fav prod
					$sql = "SELECT F.id, F.date_favored, H.photo as prod_photo, P.id as prod_id, P.product, P.product_url,
									A.id as memb_id, A.firstname, A.lastname, A.photo, CC.id as comp_id, CC.header_image
							FROM members_favprod F
							JOIN products P ON P.id=F.prod_id
							JOIN companies C ON C.id=P.comp_id AND C.id='$_COOKIE_comp_id'
							JOIN members A ON A.id=F.memb_id
							JOIN companies CC ON CC.user_id=A.id 
							LEFT JOIN product_photo H ON H.prod_id=P.id and H.is_main=1 AND H.photo_video='p' 
							WHERE F.memb_id<>'$_COOKIE_memb_id' AND F.seen=0";
					$result = mysql_query($sql);
					while($row = mysql_fetch_array($result)){
						$date_sent = $row["date_favored"];
						$prod_photo = $row["prod_photo"];
						$prod_id = $row["prod_id"];
						$product_url = $row["product_url"];
						$avatar_pic1 = get_avatar($row["comp_id"], $row["photo"], $row["header_image"], "small");
						$prod_id+= $LONG_NUMBER;
						
						$src_pic = $URL."Media/Stores/".$_COOKIE_comp_id."/small/$prod_photo";
						if ($prod_photo=="") $src_pic = $BLANK_PROD;
						
						$n = notif_item($row["id"], "favprod", "product/$prod_id-$product_url", "", $avatar_pic1, $row["firstname"], $row["lastname"], 
									"liked ", $row["product"], 13, $date_sent, "heart-o", $src_pic);
						$arr_notif[$date_sent] = $n;
					}
				}
				
				krsort($arr_notif);	// sort by key(date) in reversed order
				$i = 0;
				foreach ($arr_notif as $key => $val){
					$i++;
					if ($i<=6)	echo $val;
				}
				?>
			  </div>
              <footer class="panel-footer text-sm">
                <a href="<?=$URL13?>notifications_settings.php" class="pull-right" style='color:#1B252E'><i class="fa fa-cog"></i></a>
                <a href="<?=$URL13?>notifications.php" style='color:#1B252E'>See all the notifications</a>
              </footer>
			 <?}?>
            </section>
          </section>
        </li>
		
		<!-- LOG OUT / SETTINGS -->
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <span class="thumb-sm avatar pull-left hidden-xs">
              <img src="<?=$avatar_pic?>">
            </span>
            <?=$firstname." ".$lastname?> <b class="caret"></b>
          </a>
          <ul class="dropdown-menu animated fadeInRight">
            <span class="arrow top"></span>
			<li><a href="<?=$URL13?>main.php">My Dashboard</a></li>
			<li><a href="<?=$URL13.$my_comp_url?>">My Site</a></li>
			<?if ($_COOKIE_memb_id==1 or $_COOKIE_memb_id==3 or $_COOKIE_memb_id==15){?>
			<li><a href="<?=$URL13?>my_billing_info.php">Billing Info</a></li>
			<?}?>
			<li><a href="<?=$URL13?>my_company.php"><?=$lang["EditCompanyProfile"]?></a></li> <!--Edit Company Profile-->
			<li class='visible-xs'>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<?
				foreach ($arr_lang as $x){
					?>
					<img src='<?=$URL?>images/flags/<?=$x["flag"]?>' style='cursor:pointer' onClick='change_language("<?=$x["lg"]?>")'>&nbsp;&nbsp;
					<?
				}
				?>
			</li>
            <li class="divider"></li>
			
			<?foreach ($arr_info as $link=>$name){?>	<!--info-->
			<li class='hidden-xs'><a href="<?=$link?>"><?=ucfirst(strtolower($name))?></a></li>
			<?}?>
			<li class="divider hidden-xs"></li>
			
            <li><a href="<?=$URL13?>signout.php">Logout</a></li>
          </ul>
        </li>
      </ul>     
		<?
		}
		else{	// signed out (desktop): [search][links]
			?>
			<style>
			@media (min-width:939px) { #signedout_desktop #globesearch {width:320px;} }
			@media (min-width: 768px) and (max-width:938px) { #signedout_desktop #globesearch {width:210px;} #div_signedout_desktop{margin-left:-70px}}
			</style>
			<div role="search" onSubmit='do_search("signedout_desktop")' id='signedout_desktop'>
			<div class="form-inline nav navbar-nav navbar-left hidden-xs" style='padding-top:8px;' id='div_signedout_desktop'>
				<div class="input-group"  >
				<select id='globesearch_type' name='globesearch_type' class="form-control" onChange='globesearch_type_chng()'>
					<option value='Product' <?if ($srchtype=="Product" or $srchtype=="") echo "selected"?>><?=$lang["Products"]?>
					<option value='Seller' <?if ($srchtype=="Seller") echo "selected"?>><?=$lang["Sellers"]?>
					<option value='Buyer' <?if ($srchtype=="Buyer") echo "selected"?>><?=$lang["Buyers"]?>
					<?if (isset($_COOKIE_comp_id)){?>
					<option value='Lead' <?if ($srchtype=="Lead") echo "selected"?>><?=$lang["BuyingLeads"]?>
					<?}?>
				</select>
				 </div>
				<div class="input-group">
					<input type="text" class="form-control" style='height:34px;' id='globesearch' name='srch'
					placeholder="<?=$srch_placeholder?>" onKeyUp='do_search_enter(event, "signedout_desktop");' value='<?=$srch?>'>
					<span class="input-group-btn">
						<button type="button" class="btn btn-info btn-icon" onClick='do_search("signedout_desktop")'><i class="fa fa-search"></i></button>
					</span>
				</div>
			</div>
			</div>
			
			<ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user">
				<!-- FLAG -->
				<li class="dropdown hidden-xs">
					<a href="#" class="dropdown-toggle dk" data-toggle="dropdown">
					<img src='<?=$URL?>images/flags/<?=get_flag()?>' border=0 style='margin-top:-4px'></a>
					<ul class="dropdown-menu animated fadeInRight">
						<?
						foreach ($arr_lang as $x){
							?>
							<li><a href="javascript:void(0)" onClick='change_language("<?=$x["lg"]?>")'>
							<img src='<?=$URL?>images/flags/<?=$x["flag"]?>' border=0> 
							<?=$x["language"]. ($x["language_tr"]=="" ? "" : " / ".$x["language_tr"])?></a></li>
							<?
						}
						?>
					</ul>
				</li>
		
				<?
				// info 1,2 visible on lg
				$i = 0;
				foreach ($arr_info as $link=>$name){
					$i++;
					if ($i>=1 and $i<=2){
					?>
					<li class='visible-lg'><a href="<?=$link?>"><?=$name?></a></li>
					<?}
				}?>
				<li class="dropdown">  <!--More-->
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=strtoupper($lang["More"])?> <span class="caret"></span></a>
					<ul class="dropdown-menu animated">
						<?
						// info 1,2 hidden on lg
						$i = 0;
						foreach ($arr_info as $link=>$name){
							$i++;
							?>
							<li <?if ($i>=1 and $i<=2) echo "class='hidden-lg'"?>><a href="<?=$link?>"><?=$name?></a></li>
						<?}?>
					</ul>
				</li>
				<li><a href="<?=$URL13?>pricing"><?=strtoupper($lang["Join"])?></a></li> <!--Join-->
				<?if ($is_signin_page){?>
				<li><a href='javascript:void(0)'><?=strtoupper($lang["Signin"])?></a></li> <!--Sign in-->
				<?}else{?>
				<li><a href="<?=$URL13?>signin_modal.php?pg_comefrom=<?=$pgencode?>" data-toggle="ajaxModal"><?=strtoupper($lang["Signin"])?></a></li>
				<?}?>
			</ul>  
			<?
		}
		?>
    </header>
	<?
}

$FA_MAIN = "fa-dashboard";
$FA_SELL = "fa-money";
$FA_BUY = "fa-ticket";
$FA_PROFILE = "fa-user";
$FA_FAVORITE = "fa-heart";
$FA_FOLLOWERS = "fa-users";
$FA_FOLLOWING = "fa-eye";
$FA_PRICELIST = "fa-table";
$FA_TRADEDOCS = "fa-file-pdf-o";
$FA_MESSAGE = "fa-envelope-o";
$FA_BOOK = "fa-book";
$FA_TRADEFEED = "fa-comments-o";
$FA_CART = "fa-shopping-cart";
$FA_INVITE = "fa-paper-plane-o";
function forest_top($active_menu, $active_submenu){
	global $serlzd_cookie_params, $BLANK_PROD, $lang, $_COOKIE_comp_id;
	global 	$FA_MAIN, $FA_SELL, $FA_BUY, $FA_PROFILE, $FA_FAVORITE, $FA_FOLLOWERS, $FA_FOLLOWING, 
			$FA_PRICELIST, $FA_TRADEDOCS, $FA_MESSAGE, $FA_BOOK, $FA_TRADEFEED, $FA_CART, $FA_INVITE;
			
	$arr_cookie_params = unserialize($serlzd_cookie_params);
	foreach ($arr_cookie_params as $key => $value)	// set the original name of the variable and its value
		$$key = $value;
	
	// if in welcome mode (?w=1), gray out left menu
	$w = isset($_GET["w"]) ? $_GET["w"] : "";
	if ($w==1){
		$has_user_photo = ($user_photo=="") ? 0 : 1;
		
		$result = mysql_query("SELECT main_image, header_image FROM companies WHERE id='$_COOKIE_comp_id'");
		$row = mysql_fetch_array($result);
		$main_image = $row["main_image"];
		$header_image = $row["header_image"];
		$has_company_images = ($main_image!="" and $header_image!="") ? 1 : 0;
	}
	?>
<section class="vbox">
	<?=forest_header()?>
	
	<style>
	@media (min-width:768px){ #under_header {padding-top:0} }
	@media (max-width:767px){ #under_header {padding-top:50px} }
	</style>
    <section id='under_header'>
	
	<!-- L E F T  M E N U -->
	<section class="hbox stretch">
        <aside class="bg-light lter b-r <?if ($active_menu=="message" or $active_menu=="contacts") echo "nav-xs"?> aside-md hidden-print hidden-xs" id="nav">          
			
			<!--grayed-out for welcome page-->
			<section class="vbox" style='background-color:#576471; color:#FFF; padding:10px; font-size:16px; <?if ($w=="") echo "display:none"?>'>
				<br><br>
				Before you begin:
				<br><br><br>
				
				<?if ($active_menu=="profile" and $active_submenu==1){?>
				<i class='fa fa-arrow-right'></i>
				<?}?>
				1. Verify your company profile.
				<?if ($has_company_images==0){?>
				Upload your logo and header image.
				<?}?>
				<?if ($active_menu=="profile" and $active_submenu==1){?>
				&nbsp;&nbsp;<a href='my_contact.php?w=1' style='color:#FFF; font-size:12px;'><u>Skip</u></a>
				<?}?>
				<br><br>
				
				<?if ($active_menu=="profile" and $active_submenu==2){?>
				<i class='fa fa-arrow-right'></i>
				<?}?>
				2. Check your contact info.
				<?if ($has_user_photo==0){?>
				Upload your profile photo.
				<?}?>
				<?if ($active_menu=="profile" and $active_submenu==2){?>
				&nbsp;&nbsp;<a href='my_products.php' style='color:#FFF; font-size:12px;'><u>Skip</u></a>
				<?}?>
				<br><br>
				
				3. Verify list of your products or add a new product.
				<br><br><br><br><br><br>
			</section>
		  
		  <section class="vbox" style='<?if ($w==1) echo "display:none"?>'>
            <header class="header bg-info lter text-center clearfix">
              <div class="btn-group">
                <div class="btn-group hidden-nav-xs">
					<a href='<?=$my_comp_url?>'>
                  <button type="button" class="btn btn-sm btn-info" style='max-width:185px'>
                    <?=$my_comp_name?>
                  </button></a>
                </div>
              </div>
            </header>

            <section class="w-f scrollable">
              <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">
                
				<nav class="nav-primary hidden-xs">
				<ul class="nav">
					<?
					$arr_sell = array(	$lang["ManageProducts"]=>"my_products.php", $lang["AddNewProduct"]=>"my_products_add.php", 
												$lang["ManageGroups"]=>"my_products_groups.php", $lang["BatchUploadProducts"]=>"my_products_upload.php", 
												$lang["ManageCatalogs"]=>"my_products_catalogs.php");
					$arr_buy = array($lang["ManageBuyingLeads"]=>"my_buying.php", $lang["PostNewLead"]=>"my_buying_add.php");
					$arr_profile = array($lang["EditCompanyProfile"]=>"my_company.php", 
										"Edit Contact Profile"=>"my_contact.php", 
										"Change Login/Email"=>"my_contact_login.php", 
										$lang["ChangePassword"]=>"my_contact_pwd.php");
					
					if ($_COOKIE["sb"]=="b")
						$arr_pricelist_mgt = array($lang["PricelistsSharedWithMe"]=>"my_products_pricelists_shared.php");
					else
						$arr_pricelist_mgt = array($lang["ChannelDiscounts"]=>"my_products_discounts_channels.php",
													$lang["VolumeDiscounts"]=>"my_products_discounts_volume.php",
													"Manage Casepacks"=>"my_products_discounts_casepacks.php",
													$lang["ManageBuyers"]=>"my_products_buyers.php",
													$lang["MyPricelists"]=>"my_products_pricelists.php",
													$lang["PricelistsSharedWithMe"]=>"my_products_pricelists_shared.php");
												
					$arr_tradedocs = array( $lang["TradeDocsOverview"]=>"my_tradedocs.php",
											$lang["ProFormaInvoice"]=>"my_tradedocs.php?doc=proforma_invoice", 
											$lang["PurchaseOrder"]=>"my_tradedocs.php?doc=purchase_order", 
											$lang["CommercialInvoice"]=>"my_tradedocs.php?doc=commercial_invoice", 
											$lang["PackingSlip"]=>"my_tradedocs.php?doc=packing_slip", 
											$lang["BillOfLadingBOL"]=>"my_tradedocs.php?doc=bol", 
											"About TradeDocs"=>"info-tradeware.php");
					
					// general
					echo forest_menu("Summary", "main", "main.php", "", 0, $FA_MAIN, "success", "", $active_menu, $active_submenu);
					if ($_COOKIE["sb"]!="b")
						echo forest_menu("Selling", "sell", "#selling", "", 1, $FA_SELL, "success", $arr_sell, $active_menu, $active_submenu);
					echo forest_menu("Buying", "buy", "#buying", "", 1, $FA_BUY, "success", $arr_buy, $active_menu, $active_submenu);
					echo forest_menu("Profile", "profile", "#profile", "", 1, $FA_PROFILE, "success", $arr_profile, $active_menu, $active_submenu);
					echo forest_menu($lang["FavoriteProducts"], "favorite", "my_fav_products.php", $cn_fav_products, 0, $FA_FAVORITE, "success", "", $active_menu, $active_submenu);
					
					// tradeware
					echo forest_menu_header("<i class='fa $FA_PRICELIST'></i> ".$lang["Tradeware"]);
					echo forest_menu("PriceList", "pricelist", "#pricelist_mgmt", "", 1, $FA_PRICELIST, "primary", $arr_pricelist_mgt, $active_menu, $active_submenu);
					echo forest_menu("TradeDocs", "tradedocs", "#tradedocs", "", 1, $FA_TRADEDOCS, "primary", $arr_tradedocs, $active_menu, $active_submenu);
					echo forest_menu($lang["SourcingCart"], "cart", "my_sourcing_cart.php", $notif_dolly, 0, $FA_CART, "primary", "", $active_menu, $active_submenu);
					
					// tradefeed
					echo forest_menu_header("<i class='fa $FA_TRADEFEED'></i> ".$lang["Tradefeed"]);
					echo forest_menu($lang["MyTradefeed"], "tradefeed", "my_tradefeed.php", "", 0, $FA_TRADEFEED, "info", "", $active_menu, $active_submenu);
					echo forest_menu($lang["Followers"], "followers", "my_fav_followers.php", $followers, 0, $FA_FOLLOWERS, "info", "", $active_menu, $active_submenu);
					echo forest_menu($lang["Following"], "following", "my_fav_following.php", $following, 0, $FA_FOLLOWING, "info", "", $active_menu, $active_submenu);
					
					// communication
					echo forest_menu_header("<i class='fa $FA_MESSAGE'></i> Communication");
					echo forest_menu($lang["Messages"], "message", "my_mail.php", $notif_msgs, 0, $FA_MESSAGE, "warning", "", $active_menu, $active_submenu);
					echo forest_menu("Contacts", "contacts", "my_mail_contacts.php", "", 0, $FA_BOOK, "warning", "", $active_menu, $active_submenu);
					echo forest_menu($lang["invite_InviteUser"], "invite", "my_invite.php", "", 0, $FA_INVITE, "warning", "", $active_menu, $active_submenu);
					?>
				</ul>
                </nav>
              </div>
            </section>
			
			<footer class="footer lt hidden-xs b-t b-light">
				<a href="#nav" data-toggle="class:nav-xs" class="pull-right btn btn-sm btn-default btn-icon">
					<i class="fa fa-angle-left text"></i>
					<i class="fa fa-angle-right text-active"></i>
				</a>
			</footer>
			
          </section>
        </aside>
		
		<section id="content">
	<?
	if ($active_menu == "favorite")
		return $cn_fav_products;
	elseif ( ($active_menu == "tradefeed" and $active_submenu==2) or $active_menu=="main" or $active_menu=="followers")
		return $followers;
	elseif ($active_menu=="tradefeed" and $active_submenu==3 or $active_menu=="following")
		return $following;
	elseif ($active_menu == "message" or $active_menu == "contacts")
		return $notif_msgs;
	elseif ($active_menu=="cart")
		return $notif_dolly;
}

function forest_bottom(){
	?>
		<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen, open" data-target="#nav,html"></a>
        </section>
		
		<aside class="bg-light lter b-l aside-md hide" id="notes">
			<div class="wrapper">Notification</div>
		</aside>
		</section>
	</section>
</section>
	<?
}

// mail -> left piece
function forest_mail_menu($active_mail_menu, $cn_inbox){
	global $_COOKIE_comp_id, $_COOKIE_memb_id, $lang;
	$result = mysql_query("SELECT COUNT(1) as cn FROM messages WHERE to_id='".$_COOKIE_memb_id."' AND is_important=1");
	$row = mysql_fetch_array($result);
	$cn_starred = $row["cn"];
	?>
	<aside class="aside aside-md bg-white">
      <section class="vbox">
        <header class="dk header">
          <a href='my_mail_compose.php'>
		  <button class="btn btn-icon btn-default btn-sm pull-right" style='margin-top:10px' data-toggle="tooltip" data-placement="left" data-title="Compose">
		  <i class="fa fa-plus"></i></button></a>
		  
          <button class="btn btn-icon btn-default btn-sm pull-right visible-xs m-r-xs" data-toggle="class:show" data-target="#mail-nav"><i class="fa fa-bars"></i></button>
          <p class="h4"><?=$lang["Mailbox"]?></p> <!--Mailbox-->
        </header>
        <section>
          <section>
            <section id="mail-nav" class="hidden-xs">
              <ul class="nav nav-pills nav-stacked no-radius">
				<li <?if ($active_mail_menu=="inbox") echo "class='active'"?>>
                  <a href="my_mail.php">
                    <span class="badge pull-right" id='menu_inbox'><?=$cn_inbox?></span> 
                    <i class="fa fa-fw fa-inbox"></i>
                    <?=$lang["Inbox"]?> <!--Inbox-->
                  </a>
                </li>
                <li <?if ($active_mail_menu=="sent") echo "class='active'"?>>
                  <a href="my_mail.php?sent=sent">
                    <i class="fa fa-fw fa-envelope-o"></i>
                    <?=$lang["SentMail"]?> <!--Sent mail-->
                  </a>
                </li>
				<li <?if ($active_mail_menu=="important") echo "class='active'"?>>
                  <a href="my_mail.php?show=important">
                    <span class="badge pull-right" id='menu_star'><?if ($cn_starred!=0) echo $cn_starred?></span> 
                    <i class="fa fa-fw fa-star"></i>
                    <?=$lang["Important"]?> <!--Important-->
                  </a>
                </li>
				 <li <?if ($active_mail_menu=="contacts") echo "class='active'"?>>
                  <a href="my_mail_contacts.php">
                    <i class="fa fa-fw fa-book"></i>
                    <?=$lang["ManageContacts"]?> <!--Manage Contacts-->
                  </a>
                </li>
              </ul>
            </section>
          </section>
        </section>
      </section>
    </aside>
	<?
}

// mail -> right piece
function forest_mail_contacts(){
	global $_COOKIE_comp_id, $_COOKIE_memb_id;
	$fn = isset($_GET['fn']) 	 ? $_GET['fn']   : '';	// tradedoc_commercial_invoice_view
	$iid = isset($_GET['iid']) 	 ? $_GET['iid']  : '';	// invoice id
	$uid = isset($_GET['uid']) 	 ? $_GET['uid']  : '';	// random string
	$sid = isset($_GET['sid']) 	 ? $_GET['sid']  : '';	// seller id
	$inum = isset($_GET['inum']) ? $_GET['inum'] : '';	// invoice number
	$dtid = isset($_GET['dtid']) ? $_GET['dtid'] : '';	// doc_type_id [1..5]
	$pdf_link = "";
	if ($fn!="")
		$pdf_link = "&fn=$fn&iid=$iid&uid=$uid&sid=$sid&dtid=$dtid&inum=$inum";
	?>
	<aside class="aside-sm b-l">
       <section class="vbox">
         <header class="bg-light dk header">
           <p><a href='my_mail_contacts.php'>Contacts (<span id='cn_contacts'></span>)</a></p>
         </header>            
         <section class="scrollable bg-white" >
           <div class="list-group list-group-alt no-radius no-borders">
			<?
			$cn_contacts = 0;
			$query= "SELECT M.id as memb_id, M.firstname, M.lastname, M.gender, M.photo, COMP.id as comp_id, COMP.header_image 
					FROM members M 
					JOIN contacts C ON C.contact_id=M.id AND C.memb_id='$_COOKIE_memb_id' 
					JOIN companies COMP ON COMP.user_id=M.id 
					ORDER BY M.firstname";
			$result = mysql_query($query);
			while($row = mysql_fetch_array($result)){
				$tmemb_id = $row["memb_id"];
				$first_name = $row["firstname"];
				$last_name = $row["lastname"];
				$gender = $row["gender"];
				$photo = $row["photo"];
				$header_image = $row["header_image"];
				$tcomp_id = $row["comp_id"];
				$cn_contacts++;
				
				$cmps_link = "my_mail_compose.php?memb_id=".$tmemb_id;
				if ($pdf_link!="")
					$cmps_link.= $pdf_link;
				?>
				<a class="list-group-item" href="<?=$cmps_link?>" style='clear:both'
					><div style='width:32px; height:40px; float:left; aborder:1px solid red; position:relative; margin-right:5px;'>
					<img src='<?=get_avatar($tcomp_id, $photo, $header_image, "big")?>' width=30 border=0 align='left' 
					style='position:absolute; top:0; bottom:0; margin:auto;'>
					</div>
					<div style='float:left; aborder:1px solid green; width:60px; height:40px;'>
						<?=$first_name."<br/>".$last_name?>
					</div>
				</a>
				<?
			}
			?>
           </div>
         </section>
         <!--<footer class="footer text-center b-t">
           <button class="btn btn-success btn-sm"><i class="fa fa-plus"></i> New contact</button>
         </footer>-->
       </section>
     </aside>
	<script>
	$("#cn_contacts").html(<?=$cn_contacts?>);
	</script>
	<?
}

function public_footer(){
	public_footer2();
}
function public_footer2(){
	global $URL13, $lang, $arr_lang;
	?>
	<br clear='all'>
	<footer style='background-color:#333; color:#FFF;'>
	<div style='height:40px'></div>
    <div class="row" style='padding:0 40px; max-width:1200px; margin:0 auto;'>
		<div class="row">
			<div class="col-xs-6 col-sm-3">
				<ul style='list-style-type: none;' class='footer_links'>
					<span class='footer_header'><?=$lang["Platform"]?></span>
					<br/><br/>
					<li><a href='<?=$URL13?>features'><?=$lang["Features"]?></a></li>
					<li><a href='<?=$URL13?>tradeware'><?=$lang["Tradeware"]?></a></li>
					<li><a href='<?=$URL13?>tradefeed'><?=$lang["Tradefeed"]?></a></li>
					<li><a href='<?=$URL13?>marketplace'><?=$lang["Marketplace"]?></a></li>
				</ul>
			</div>
			<div class="col-xs-6 col-sm-3">
				<ul style='list-style-type: none;' class='footer_links'>
					<span class='footer_header'><?=$lang["Company"]?></span>
					<br/><br/>
					<li><a href='<?=$URL13?>about'><?=$lang["AboutUs"]?></a></li>
					<li><a href='javascript:void(0)'><?=$lang["Press"]?></a></li>
					<li><a href='javascript:void(0)'><?=$lang["Affiliates"]?></a></li>
					<li><a href='<?=$URL13?>contact'><?=$lang["ContactUs"]?></a></li>
				</ul>
			</div>
			<div class="col-xs-6 col-sm-3">
				<ul style='list-style-type: none;' class='footer_links'>
					<span class='footer_header'><?=$lang["Members"]?></span>
					<br/><br/>
					<li><a href='<?=$URL13?>buyers'><?=$lang["Buyers"]?></a></li>
					<li><a href='<?=$URL13?>sellers'><?=$lang["Sellers"]?></a></li>
					<li><a href='<?=$URL13?>pricing'><?=$lang["Pricing"]?></a></li>
					<li><a href='<?=$URL13?>pricing'><?=$lang["JoinNow"]?></a></li>
				</ul>
			</div>
			<div class="col-xs-6 col-sm-3">
				<span class='footer_header'><?=$lang["Followus"]?></span>
				<br/><br/>
				
				<a href='https://www.facebook.com/GlobemartHQ' target='_blank'>
				<img src="<?=$URL13?>images/social_facebook_BTN.png" border=0></a>
				
				<a href='https://twitter.com/GlobemartHQ' target='_blank'>
				<img src="<?=$URL13?>images/social_twitter_BTN.png" border=0></a>
				
				<a href='https://pinterest.com/Globemart' target='_blank'>
				<img src="<?=$URL13?>images/social_pinterest_BTN.png" border=0></a>
				
				<a href='https://www.youtube.com/channel/UCm1BwVqc0iRMW_Yz4wI1BRA' target='_blank'>
				<img src="<?=$URL13?>images/social_youtube_BTN.png" border=0></a>
			</div>
		</div>
		
		<div class="row m-t">
			<div class="col-xs-12" style='text-align:left'>
				&copy; <?=date("Y")?> Globemart -
				<a href='<?=$URL13?>terms' target='_blank' style='color:#FFF'><u><?=$lang["Terms"]?></u></a> -
				<a href='<?=$URL13?>privacy' target='_blank' style='color:#FFF'><u><?=$lang["Privacy"]?></u></a> - 
				<a href='https://globemart.zendesk.com/hc/en-us/requests/new' target='_blank' style='color:#FFF'><u><?=$lang["Support"]?></u></a>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<?
				// flags
				foreach ($arr_lang as $x){
					?>
					<a href='javascript:void(0)' onClick='change_language("<?=$x["lg"]?>")' style='color:#FFF'>
					<!--<img src='<?=$URL13?>images/flags/<?=$x["flag"]?>' border=0>--> <u><?=$x["language"]?></u></a>&nbsp;&nbsp;
					<?
				}
				?>
			</div>
		</div>
    </div>
	<div style='height:25px'></div>
	</footer>
	<?
}
function join_now_section($is_index=0){
	global $_COOKIE_comp_id, $_COOKIE_memb_id, $lang;
	$phrase = "Ready to checkout what globemart has to offer?";
	$col = 9;
	if ($is_index==1){
		$phrase = $lang["StartYourFreeGBtoday"];
		$col = 8;
	}
	
	if (!isset($_COOKIE_memb_id)){
	?>
	<section id="signup-cta-home" class="home-module">
	<div class="row">
		<div class="signup-cta-container large-<?=$col?> large-centered columns">
			<h2><?=$phrase?></h2>
			<div class="row">
			<div class="small-12 large-5 large-centered columns">
				<a class="button postfix" href="pricing"><?=$lang["JoinNow"]?></a>
			</div>
		</div>
		</div>
	</div>
	</div>
	</section>
	<?
	}
}

// Nice Info-Box. 		// color - info, danger, warning, success
function info_box($text, $color, $video=""){
	$ar_color_icons = array("info"=>"fa-info-circle", "danger"=>"fa-exclamation-circle", "warning"=>"fa-warning", "success"=>"fa-check");
	?>
	<div class="alert alert-<?=$color?>" style='font-size:13px;'>
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<i class="fa <?=$ar_color_icons[$color]?>" style='font-size:14px'></i>&nbsp;&nbsp;<?=$text?>
		<?
		if ($video!="")	video_icon($video);
		?>
	</div>
	<?
}

// Globemart Zendesk Widget script
function zendesk(){
	if (1==2 and $_SERVER["PHP_SELF"]!="/my_mail.php" and $_SERVER["PHP_SELF"]!="/my_mail_compose.php"){
	?>
	<script>/*<![CDATA[*/window.zEmbed||function(e,t){var n,o,d,i,s,a=[],r=document.createElement("iframe");window.zEmbed=function(){a.push(arguments)},window.zE=window.zE||window.zEmbed,r.src="javascript:false",r.title="",r.role="presentation",(r.frameElement||r).style.cssText="display: none",d=document.getElementsByTagName("script"),d=d[d.length-1],d.parentNode.insertBefore(r,d),i=r.contentWindow,s=i.document;try{o=s}catch(c){n=document.domain,r.src='javascript:var d=document.open();d.domain="'+n+'";void(0);',o=s}o.open()._l=function(){var o=this.createElement("script");n&&(this.domain=n),o.id="js-iframe-async",o.src=e,this.t=+new Date,this.zendeskHost=t,this.zEQueue=a,this.body.appendChild(o)},o.write('<body onload="document._l();">'),o.close()}("//assets.zendesk.com/embeddable_framework/main.js","globemart.zendesk.com");/*]]>*/</script>
	<?
	}
}

function video_icon($youtube_link){
	?>
	<a href='modal_video.php?v=<?=$youtube_link?>' data-toggle='ajaxModal'>
	<i class='fa fa-youtube-play m-l' data-toggle='tooltip' data-placement='top' title='Video Tutorial' style='font-size:24px; color:#E7493F;'></i></a>
	<?
}

function get_youtube_id($youtube_link){
	if ($youtube_link!=""){
		if (strpos($youtube_link, "youtube.com/watch?v=")){	// https://www.youtube.com/watch?v=unqdslL1IkI&list=dfgdgty
			$youtube_link_arr = explode("?v=", $youtube_link);
			$youtube_id = $youtube_link_arr[1];
			$youtube_link_arr = explode("&", $youtube_id);	//unqdslL1IkI&list=dfgdgty
			$youtube_id = $youtube_link_arr[0];
		}
		elseif (strpos($youtube_link, "youtu.be/")){	// https://youtu.be/unqdslL1IkI
			$youtube_link_arr = explode("youtu.be/", $youtube_link);
			$youtube_id = $youtube_link_arr[1];
		}
		return $youtube_id;
	}
}

function youtube_iframe($youtube_link, $w=420, $h=315){
	if ($youtube_link!=""){
		if (strlen($youtube_link)>=7 and strlen($youtube_link)<=15)
			$youtube_id = $youtube_link;
		else
			$youtube_id = get_youtube_id($youtube_link);
		?>
		<div class="embed-responsive embed-responsive-4by3">
		<iframe src="https://www.youtube.com/embed/<?=$youtube_id?>" class="embed-responsive-item" frameborder="0" allowfullscreen></iframe>
		</div>
		<?
	}
}

// testing function
function bootsize($hid=0){
	?>
	<div id='boot_xs' class='visible-xs'><?if ($hid==0) echo "xs"?></div>
	<div id='boot_sm' class='visible-sm'><?if ($hid==0) echo "sm"?></div>
	<div id='boot_md' class='visible-md'><?if ($hid==0) echo "md"?></div>
	<div id='boot_lg' class='visible-lg'><?if ($hid==0) echo "lg"?></div>
	<?
}
?>