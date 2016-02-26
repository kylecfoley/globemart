//this function will show the content within the <div> tag
function toggleDiv(divName){
	var thisDiv = document.getElementById(divName);
	if (thisDiv)
		if (thisDiv.style.display == "none")	thisDiv.style.display = "block";
}

//this function will hide the content within the <div> tag
function toggleDiv2(divName){
	var thisDiv = document.getElementById(divName);
	if (thisDiv)
		if (thisDiv.style.display == "block")	thisDiv.style.display = "none";
}

// hide and show
function toggleDivz(id){
	var thisDiv = document.getElementById(id);
	if (thisDiv)
		thisDiv.style.display = thisDiv.style.display == "block" ? "none" : "block";
}

// OK-Cancel message
function ok_cancel(mesg){
	var r = confirm(mesg);
	if (r) return true
	else   return false;
}

// if element is empty then alert, focus and return false
function err_empty(element, mesg){
	alert(mesg);
	if (element!="") element.focus();
	return false;
}

// filename.Docx -> docx
function getExt(str){
	var str_arr1 = str.split("?");
	str = str_arr1[0];
	
	str_arr1 = str.split(".");
	return str_arr1[str_arr1.length-1].toLowerCase();
	
	//return stroka.substring(stroka.lastIndexOf(".")+1, stroka.length).toLowerCase();
}

// select/inverse select all the checkboxes
function check_all(forma){
	with(forma){
		for (var c = 0; c < elements.length; c++)
		  	if (elements[c].type == 'checkbox' && elements[c].disabled==false )
				elements[c].checked = !elements[c].checked;
	}
}

// is email
function is_email(address) {
   var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
   if (reg.test(address) == false)      return false;
   else return true;
}

/* Validate numeric or alphabetic value */
function IsNumAlph(sText, x){	
	var ValidChars
	if (x=="na")		// numeric and alphabetic  
		ValidChars = "0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
	else if (x=="a")	// alphabetic
		ValidChars = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM"
	else if (x=="n")	// numeric
		ValidChars = "0123456789"
	else if (x=="phone")	// phone
		ValidChars = "0123456789-"
	else if (x=="float")	// float
		ValidChars = "1234567890."	
	else if (x=="num_list")	// list of numbers
		ValidChars = "1234567890, "
		
	var IsNumber=true;
	var Char;
	dot = 0; 	// number of dots for float numbers
	dash = 0; 	dash_pos1 = 0; dash_pos2 = 0;	// number of dashes for phone numbers
	FirstChar = sText.charAt(0);
	LastChar  = sText.charAt(sText.length-1);
	for (i = 0; i < sText.length && IsNumber == true; i++) { 
		Char = sText.charAt(i); 
		if (ValidChars.indexOf(Char) == -1) 	IsNumber = false;
		if (x=="float" && Char==".")	dot++;
		if (x=="phone" && Char=="-"){
			if (i==3)	dash_pos1 = 3;
			if (i==7)	dash_pos2 = 7;
			dash++;
		}
	}
	
	if (x=="float" && (dot > 1 || LastChar==".")) 				IsNumber = false;	// more than 1 dot for float OR  last symbol is a dot (for float)
	if (x=="num_list" && (LastChar=="," || FirstChar==",")) 	IsNumber = false;
	
	if (x=="phone" && (dash!=2 || dash_pos1!=3 || dash_pos2!=7))	IsNumber = false;	// phone format XXX-XXX-XXXX
	
	return IsNumber; 
}



/* AJAX */
var xmlHttp;
var divID = "";
function ajax(str, page, divID){ 
	ajaxCheck();
	if (str!=""){
		ajaxdestination = divID;
		quest_or_amper = (page.indexOf("?")==-1 ? "?" : "&");
		var url = "http://globemart.com/ajax/" + page + quest_or_amper + "q=" + str + "&sid=" + Math.random();
		xmlHttp.onreadystatechange=stateChanged;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
	}
}
function ajaxCheck(){
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null) {
		alert ("Your browser does not support AJAX!");
		return;
	}
}
function stateChanged(){ 
	if (xmlHttp.readyState==4)
		document.getElementById(ajaxdestination).innerHTML=xmlHttp.responseText;
}
function GetXmlHttpObject(){
	var xmlHttp=null;
	try {xmlHttp=new XMLHttpRequest();} 	// Firefox, Opera 8.0+, Safari
	catch (e){	// Internet Explorer
		try 		{xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");}
		catch (e)   {xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");}
	}
	return xmlHttp;
}


// switch between states (for US-218) and provinces (for other countries)
function stprov(idname_country, idname_stat, idname_prov, idname_province){
	if (typeof(idname_country)==="undefined") 	idname_country = "country";
	if (typeof(idname_stat)==="undefined") 		idname_stat = "stat";
	if (typeof(idname_prov)==="undefined") 		idname_prov = "prov";
	if (typeof(idname_province)==="undefined") 	idname_province = "province";
	
	if (document.getElementById(idname_country).value==218){
		toggleDiv(idname_stat);
		toggleDiv2(idname_prov);
	}
	else{
		toggleDiv2(idname_stat);
		toggleDiv(idname_prov);
		document.getElementById(idname_province).value = "";
	}
}

// swith between existing product groups (gruppa1) and manually input new one (gruppa2)
function grup(){
	if (document.getElementById("gruppa1").value==""){
		document.getElementById("gruppa2").disabled = false; 
	}
	else{
		document.getElementById("gruppa2").value = ""; 
		document.getElementById("gruppa2").disabled = true; 
	}
}

function mailpage(){
	mail_str = "mailto:?subject=Check out " + document.title;
	mail_str += "&body=I thought you might be interested. ";
	mail_str += "You can view it at " + location.href;
	location.href = mail_str;
}

/********************************** NEW ERA ************************************/
//var URL13 = "https://globemart.com/globemart2013/";
var URL13 = "https://globemart.com/";

// blog comments
function main_comment(){
	if ($("#msg").val()=="") return err_empty($("#msg"), "Please enter your message");
}
function add_subpost(blog_id){
	if ($("#msg_"+blog_id).val()=="") 	
		return err_empty($("#msg_"+blog_id), "Please enter your message");
	
	$.ajax({
		type: "POST",
		url: URL13+"ajx_tradefeed_add_drop.php",
		data: {
			id: blog_id,
			act: "as",
			message: $("#msg_"+blog_id).val()
		},
		success: function(msg){
			if (msg==0)
				signin_show();
			else{
				$("#msg_"+blog_id).val("");
				$("#just_added_"+blog_id).append(msg);
				var rightcol = $('#rightcol').height();
				$('#rightcol_white_bg').css('height', rightcol);
			}
		}
	});
}
function drop_post(blog_id, act){
	$.ajax({
		type: "POST",
		url: URL13+"ajx_tradefeed_add_drop.php",
		data: {
			id: blog_id,
			act: act
		},
		success: function(msg){
			if (msg=="0")
				signin_show();
			else
				$("#post"+blog_id).hide();	
		}
	});
}
// end blog comments

// press enter
function enter_pressed(event){
	if (event.which == 13 || event.keyCode == 13)
        return true;
}

// sum of values of input with class name
function sumValues(class_calc_fields){
	var total = 0;
	$(class_calc_fields).each( function() {
		if (!isNaN($(this).val()) && $(this).val()!="")
			total += parseFloat($(this).val());
	});
	if (total==0)
		return "";
	else
		return Math.round(total * 100) / 100;
}

// load list of commodities
function load_cmds(called_from_doc_type_id, ini_cmd_lines){
	$(".tradedoc_enum input").val("");
	$(".tradedoc_enum input[type='checkbox']").prop("checked", false);
	$(".extra_lines").unbind().remove();
	
	var invoiceid_doctypeid = $("#doc4cmd").val();	// 201,2
	if (invoiceid_doctypeid!=""){
		var invoiceid_doctypeid_ar = invoiceid_doctypeid.split(",");
		var invoice_id = invoiceid_doctypeid_ar[0];
		var doc_type_id = invoiceid_doctypeid_ar[1];
		
		$.ajax({
			type: "POST",
			url: "tradedoc_load_cmds_ajx.php",
			data: {
				invoice_id: invoice_id,
				called_from: called_from_doc_type_id,
				doc_type_id: doc_type_id
			},
			success: function(msg){
				var longline_arr = msg.split("::");
				
				var data_string 	= longline_arr[0];	//
				var col_name_string = longline_arr[1];	// item_num,cmd_descr,qty,unit_price,total_price
				var rec_count 		= longline_arr[2];	// 3
				
				for (i=ini_cmd_lines+1; i<=rec_count; i++)
					add_new_line();
				
				var data_string_arr = data_string.split("^^");
				var col_name_arr = col_name_string.split(",");
				
				for (j=0; j<col_name_arr.length; j++){
					var one_specimen_str = data_string_arr[j];	// {potato~~carot~~onion~~} ^^ {15.2~~18.1~~19.8} ^^
					var one_specimen_arr = one_specimen_str.split("~~");
					for (i=0; i<one_specimen_arr.length; i++){
						var col_id = "#"+col_name_arr[j]+"_"+(i+1);	// #cmd_descr_1
						$(col_id).val(one_specimen_arr[i]);
						if (col_name_arr[j]=="hm" && one_specimen_arr[i]==1) $(col_id).prop("checked", true);	// BoL - hazardous material
					}
				}
				
				if ($("#subtotal"))  	$("#subtotal").val(sumValues(".calc_sub"));
				if ($("#total_value")) 	$("#total_value").val(sumValues(".calc_sum"));
			}
		});
	}
}

// contact form popup
function contact_form(from_id, to_id, personname, prod_id, product){
	if (typeof(prod_id)==="undefined") prod_id = "";
	if (typeof(product)==="undefined") product = "";
	if (from_id==0)
		signin_show();
	else{
		$.ajax({
			type: "POST",
			url: URL13+"ajx_check_cookie.php",
			success: function(msg){
				if (msg==1)
					contact_form_show(from_id, to_id, personname, prod_id, product);
				else
					signin_show();
			}
		});
	}
}

function contact_hide(to_id){	// xxx
	$("#shade").hide();
	if (to_id=="all")
		$(".contactform").hide();
	else
		$("#contactform_"+to_id).hide();
}
function signin_show(){
	var url = document.URL;
	//var res = url.split("/"); 
	//var this_page = res[res.length-1];
	//this_page = encodeURIComponent(this_page);
	this_page = encodeURIComponent(document.URL);
	$("<a>").attr("href", URL13+"signin_modal.php?pg_comefrom="+this_page+"&d=1").attr("data-toggle", "ajaxModal").appendTo("body").trigger("click");
}
function contact_form_show(from_id, to_id, personname, prod_id, product){
	if (typeof(prod_id)==="undefined") prod_id = "";
	if (typeof(product)==="undefined") product = "";
	personname = encodeURIComponent(personname);
	product = encodeURIComponent(product);
	var hrefa = URL13+"modal_contact.php?from_id="+from_id+"&to_id="+to_id+"&personname="+personname+"&prod_id="+prod_id+"&product="+product;
	$("<a>").attr("href", hrefa).attr("data-toggle", "ajaxModal").appendTo("body").trigger("click");
}

function check_send(to_id){
	var subj_template = $("#subj_dd_"+to_id).val();
	var subj_custom   = $("#subj_"+to_id).val();
	var subj = (subj_template=="") ? subj_custom : subj_template+". "+subj_custom;
	
	if (subj_template=="" && subj_custom=="") return err_empty($("#subj_"+to_id), "Please enter the subject");
	if ($("#body_"+to_id).val()=="") return err_empty($("#body_"+to_id), "Please enter your message");
	
	$.ajax({
		type: "POST",
		url: URL13+"ajx_send_msg.php",
		data: {
			memb_id: to_id,
			subj: subj,
			memb_id: $("#memb_id_"+to_id).val(),
			prod_id: $("#regarding_prod_id").val(),
			prod_list: $("#prod_list").val(),
			body: encodeURIComponent($("#body_"+to_id).val())
		},
		success: function(msg){
			$("#before_send_"+to_id).hide();
			$("#after_send_"+to_id).show();
			$("#subj_dd_"+to_id).val("");
			$("#subj_"+to_id).val("");
			$("#body_"+to_id).val("");
			//$("#body_"+to_id).val(msg);
		}
	});
}

function msg_star(msg_id){	// message important
	var menu_star = $("#menu_star").html();
	if (menu_star=="") menu_star = 0;
	menu_star = parseInt(menu_star);
	
	$.ajax({
		type: "POST",
		url: "ajx_msg_star.php",
		data: {
			msg_id: msg_id
		},
		success: function(msg){
			if (msg=="x")
				signin_show();
			else{
				if (msg==0){
					$("#star_"+msg_id).removeClass("fa-star-o star_blank").addClass("fa-star star_filled");
					var m = menu_star + 1;
					$("#menu_star").html(m);
				}
				else{
					$("#star_"+msg_id).removeClass("fa-star star_filled").addClass("fa-star-o star_blank");
					var m = menu_star - 1;
					if (m < 0) m = 0;
					$("#menu_star").html(m);
				}
			}
		}
	});
}

function do_add2clist(to_id){	// add to contact list
	$.ajax({
		type: "POST",
		url: URL13+"ajx_add2contactlist.php",
		data: {
			to_id: to_id
		},
		success: function(msg){
			if (msg==1){
				$("#btn_add2clist").hide();
				$("#spn_add2clist").show();
				$("#btn_add2clist_flat").hide();
				$("#spn_add2clist_flat").show();
			}
			else{
				signin_show();
			}
		}
	});
}
// end contact form

// disable buttons when no checkboxes checkedl; called on click of select all and individual chbox click
function chboxes_disables(chbox_class, button_class){
	if ($("."+chbox_class+":checked").length)
		$("."+button_class).removeAttr("disabled").removeClass("btn-gray").addClass("btn-green");
	else
		$("."+button_class).attr("disabled", "disabled").removeClass("btn-green").addClass("btn-gray");
}

// ========== Load product discounts ===================
// typ - volume, channel
function discount_change(typ, struct_id, act, is_name_shown, comp_id, price, struct_name, prod_id){
	if (act=="load"){
		$("#discount_"+typ+"_addl input").val("");
		$("#discount_"+typ+"_addl select").val("");
	}
	
	if (typ=="channel" && act=="load" && $("#new_chnl_dscnt").length)	// checkbox "--Create new discounts--"
		struct_id = $("#new_chnl_dscnt").is(":checked") ? 0 : -1;
	
	if (act=="loadcopy"){
		price = $("#fob_min_price_test").val();
		/*if (struct_id!=0){
			$("#hid_cur_struct_id").val(struct_id);
			$("#hid_cur_struct_name").val(struct_name);
		}*/
	}
	
	$.ajax({
		type: "POST",	
		data:{
			q: struct_id,
			act: act,
			is_name_shown: is_name_shown,
			comp_id: comp_id,
			price: price,
			struct_name: struct_name,
			prod_id: prod_id
		},
		url: "ajx_product_"+typ+"_change.php",
		success: function(msg){
			if (msg=="nope")
				signin_show();
			else{
				if (act=="load"){	// load empty table
					if (typ=="channel") $(".fa_arrow_discount").removeClass("fad_active");
					
					$("#discount_"+typ).html(msg);
					if (struct_id==0) 
						$("#discount_"+typ+"_addl").show();
					else 
						$("#discount_"+typ+"_addl").hide();
						
					if (is_name_shown==1)
						$("#hid_disc").val(struct_id);
				}
				else if (act=="copy"){	// copy from exsiting structure to editable table
					if (typ=="volume"){
						$("table.newdiscounts input[type='text']").val("");
						
						var ntt = msg.split("^");	// mins^maxs^dscnts^dtype
						qty_min_arr = ntt[0].split("~");
						qty_max_arr = ntt[1].split("~");
						discount_arr = ntt[2].split("~");
						$("#discount_type").val(ntt[3]);	// $ %
						
						for (i=0; i<qty_min_arr.length; i++){
							j = i + 1;
							$("#vol_qty_min_"+j).val(qty_min_arr[i]);
							$("#vol_qty_max_"+j).val(qty_max_arr[i]);
							$("#vol_discount_"+j).val(discount_arr[i]);
						}
					}
					else if (typ=="channel"){
						$("table.newchdisc input[type='text']").val("");
						
						var ntt = msg.split("^");	// line1^...^line5^
						if (ntt.length>=5){
							for (i=0; i<5; i++){
								line_content_arr = ntt[i].split("~");
								for (j=0; j<5; j++){
									$("#discount_"+(i+1)+(j+1)).val(line_content_arr[j]);
								}
							}
						}
					}
				}
				else if (act=="loadcopy"){
					$("#discount_"+typ).html(msg);
					$(".fa_arrow_discount").removeClass("fad_active");
					if (struct_id>0){	// clicked arrow
						$("#new_chnl_dscnt").removeAttr("checked");	// new discount stuff - hide
						$("#discount_"+typ+"_addl").hide();
						
						$("#arrow_"+struct_id).addClass("fad_active"); // green arrow
					}
				}
			}
		}
	});
}

// click refresh icon [fob price: $20] ===> Consumer=$20, Retailer=$18..
function recalc_discount4all_channels(){	
	var price = $("#fob_min_price_test").val();
	if (price!="" && !isNaN(price)){
		price = parseFloat(price);
		
		for (i=1; i<=5; i++){
			var this_price = price;
			for (j=1; j<=5; j++){
				percentage = $("#discount_"+j+i).val().replace("%", "");
				if (percentage!="" && !isNaN(percentage)){
					percentage = parseFloat(percentage);
					if (percentage>=0 && percentage<=100){
						if (i==5 && j==5)
							this_price = this_price*percentage/100;
						else
							this_price = this_price*(100-percentage)/100;
					}
				}
			}
			$("#discounted_price_"+i).html("$"+this_price.toFixed(2));
		}
	}
}

// product edit - save pulled-up channel structure on the fly
function save_channel_struct(struct_id, prod_id){
	var arr_p = new Array(6);
	var arr_s = new Array(6);
	for (i=1; i<=5; i++)
		arr_p[i] = new Array(6);
		
	for (i=1; i<=5; i++){
		for (j=1; j<=5; j++){
			arr_p[j][i] = $("#discount_"+j+i).val().replace("%", "");
		}
		arr_s[i] = $("#special_price_"+i).val().replace("$", "");
	}
	
	var ourObj = {};
	ourObj.prodid = prod_id;
	ourObj.structid = struct_id;
	ourObj.arrp = arr_p;
	ourObj.arrs = arr_s;
	
	$.ajax({
		type: "POST",	
		data:{
			"obj": JSON.stringify(ourObj)
		},
		url: "ajx_save_channel_structure.php",
		success: function(msg){
			if (msg=="nope")
				signin_show();
			else
				$("#txt_channel_saved").show();
		}
	});
	return false;
}

function copy_fob_price(){
	$("#fob_min_price_test").val($("#fob_min_price").val());
}

// ========== Load product case packs ===================
function casepack_change(case_id){
	$.ajax({
		type: "POST",	
		data:{
			q: case_id
		},
		url: "ajx_product_casepack_change.php",
		success: function(msg){
			$("#casepack_div").html(msg);
			if (case_id==0) $("#casepack_addl").show();
			else $("#casepack_addl").hide();
		}
	});
}

// ========== Drop additional columns for pricelist ===================
function drop_column(col_id, prod_cn){
	var ask_msg = "Drop this column? ";
	if (prod_cn>0)
		ask_msg += prod_cn + " product"+(prod_cn==1 ? "" : "s")+(prod_cn==1 ? " has a " : " have ") + 
					"non-empty value"+(prod_cn==1 ? "" : "s")+" for this column which will be removed.";
	if (ok_cancel(ask_msg)){
		$.ajax({
			type: "POST",
			data:{
				col_id: col_id
			},
			url: "ajx_drop_pricelist_column.php",
			success: function(msg){
				$("#col_name_"+col_id).val("");
				$("#col_value_"+col_id).val("");
				$("#col_id_"+col_id).val("");
				$("#val_id_"+col_id).val("");
			}
		});
	}
}

// ========== assign roles to buyers ===================
function save_buyer(bid, pid){	// buyer, permission
	var chd  = $("#chd_"+bid+"_"+pid).val();	// channel
	var role = $("#role_"+bid+"_"+pid).val();
	if (chd=="" && role!=0) 
		return err_empty($("#chd_"+bid+"_"+pid), "Please select channel")
	else{
		$.ajax({
			type: "POST",
			data:{
				bid: bid,
				pid: pid,
				chd: chd,
				role: role
			},
			url: "ajx_buyer_permissions_set.php",
			success: function(msg){
				if (msg==0)
					signin_show();
				else{
					$("#saved_"+bid+"_"+pid).hide().fadeIn("slow");
					$("#cancel_"+bid+"_"+pid).hide();
				}
			}
		});
	}
}

// search
function do_search(formname){
	var searchword = $("#"+formname+" #globesearch").val();
	if (searchword.trim().length<=2)
		return err_empty($("#"+formname+" #globesearch"), "Search parameter must be at least 3 characters");
	var searchtype = "";
	var srchtype = "";
	if ($("#globesearch_type").length!=0)
		searchtype = $("#globesearch_type").val();
	
	if (searchtype!="") srchtype = "&srchtype="+searchtype;
	window.location.href = URL13+"search.php?srch="+searchword+srchtype;
}
function do_search_enter(event, formname){
	if (formname == "signedout_desktop")
		$("#signedout_mobile #globesearch").val($("#signedout_desktop #globesearch").val());
	else if (formname == "signedout_mobile")
		$("#signedout_desktop #globesearch").val($("#signedout_mobile #globesearch").val());
		
	else if (formname == "signedin_desktop")
		$("#signedin_mobile #globesearch").val($("#signedin_desktop #globesearch").val());
	else if (formname == "signedin_mobile")
		$("#signedin_desktop #globesearch").val($("#signedin_mobile #globesearch").val());
	
	if (enter_pressed(event)) do_search(formname);
}
function globesearch_type_chng(){
	var globesearch_type = $("#globesearch_type").val();
	$("#signedout_desktop #globesearch").attr("placeholder", "Search "+globesearch_type);
	$("#signedin_desktop #globesearch").attr("placeholder", "Search "+globesearch_type);
}

// seen liked product or new follower in bell notification
function notif_seen(sname, id, ntfy_favprod, ntfy_following){
	if ($("#ni_"+sname+id).length>0)		// green tick in bell popup
		ni = "#ni_"+sname+id;
	else if ($("#ni2_"+sname+id).length>0)	// green tick in notification php page
		ni = "#ni2_"+sname+id;

	if ($(ni).is(":hidden")){
		var bell_number_n = $("#bell_number_n").html();
		bell_number_n = parseInt(bell_number_n);
	
		$.ajax({
			type: "POST",	
			data:{
				sname: sname,
				id: id
			},
			url: URL13+"ajx_notif_seen.php",
			success: function(msg){
				// row was actually updated and bell settings was on ==> decrease bell number
				if (msg!=0 && (ntfy_favprod==1 && sname=="favprod" || ntfy_following==1 && sname=="following") ){	
					var m = bell_number_n - 1;
					if (m < 0) m = 0;
					$("#bell_number_n").html(m);	// bell number in "You have m notifications"
					$("#bell_number").html(m);		// bell number in red circle
				}
				$("#ni_"+sname+id).show();		// green tick in bell popup
				$("#ni2_"+sname+id).show();		// green tick in notification php page
			}
		});
	}
}

// login page
function checklogin(){
	if ($("#email").val()=="") return err_empty($("#email"), "Please enter your email");
	if ($("#pwd").val()=="")   return err_empty($("#pwd"), "Please enter your password");
	$("#loginform").submit();
}
function enterd(event){
	if(event.keyCode == 13 || event.which == 13)
		return checklogin();
}

/*********************** TRADEDOCS autocomplete ******************************/
// autocomplete commodity field
function commod_autocomplete(){
	$(".cmd_descr").autocomplete({
		source: function(request, response) {
			if ($('#role').length>0)
				request.role = $('#role').val();	// to send additional parameter
			request.seller_comp_id = $('#seller_comp_id').val();
			$.getJSON( 'ajx_docs_product_search.php', request, function( data, status, xhr ) {
				response( data );
			});
		},
		minLength: 1,
		select: function(event, ui){
			if (ui.item.null==0)
				signin_show();
			else{
				var prod_id = ui.item.id;
				var price = ui.item.price;
				var line_num = this.id.replace("cmd_descr_", "");	// cmd_descr_1 ==> 1
				if ($("#item_num_"+line_num).length>0) 		 $("#item_num_"+line_num).val(ui.item.item_num);
				if ($("#unit_price_"+line_num).length>0) 	 $("#unit_price_"+line_num).val(price);
				if ($("#uom_"+line_num).length>0) 			 $("#uom_"+line_num).val(ui.item.min_unit);
				if ($("#hid_prod_id_"+line_num).length>0) 	 $("#hid_prod_id_"+line_num).val(prod_id);
				if ($("#hid_orig_price_"+line_num).length>0) $("#hid_orig_price_"+line_num).val(ui.item.orig_price);
				
				// external link to product edit
				/*prod_link = "product_details.php?prod_id="+prod_id;
				if ($('#seller_comp_id').val() == $('#my_comp_id').val())
					prod_link = "my_products_edit.php?prod_id="+prod_id;
				$("#prod_link_"+line_num).attr("href", prod_link).attr("title", "Click to open this product in new tab").show();*/
				
				if ($("#hid_doc_id").val()!=4 && $("#hid_doc_id").val()!=5)
					recalc_price_unit(line_num);
			}
		}
	});
}

// autocomplete seller/buyer/consignee name from the contact list
// cp - autocmpl_company/autocmpl_person
function seller_autocomplete(cp){
	$("."+cp).autocomplete({
		source: function(request, response) {
			request.caller_id = $(this.element.get(0)).attr('mytag');
			request.acp = cp;
			$.getJSON( 'ajx_docs_seller_search.php', request, function( data, status, xhr ) {
				response( data );
			});
		},
		minLength: 1,
		select: function(event, ui){
			if (ui.item.null==0)
				signin_show();
			else{
				var caller_id = ui.item.caller_id;
				var my_comp_id = $("#my_comp_id").val();
				if ($("#"+caller_id+"_company").length>0) 	$("#"+caller_id+"_company").val(ui.item.comp_name);
				if ($("#"+caller_id+"_name").length>0) 		$("#"+caller_id+"_name").val(ui.item.seller_name);
				$("#"+caller_id+"_address").val(ui.item.address);
				$("#"+caller_id+"_country").val(ui.item.country);
				if ($("#"+caller_id+"_phone").length>0) 	$("#"+caller_id+"_phone").val(ui.item.phone);
				if (caller_id=="seller")
					$("#seller_fax").val(ui.item.fax);
				
				if (caller_id=="consignee"){
					$("#consignee_comp_id").val(ui.item.comp_id);
					
					if ($("#role").length>0){
						$("#role").removeAttr("disabled");
						cgid = ui.item.ch_group_id;
						if (isNaN(cgid) || !cgid) cgid = 1;
						$("#role").val(cgid);
					}
					if ($("#channel").length>0){
						$("#channel").removeAttr("disabled");
						csid = ui.item.ch_struct_id;
						if (isNaN(csid) || !csid) csid = 0;
						$("#channel").val(csid);
					}
					recalc_price_unit(0);
				}
				else if (caller_id=="seller"){	// purchase order - diff.rule
					$("#seller_comp_id").val(ui.item.comp_id);
					
					if (ui.item.comp_id != my_comp_id){
						$("#role").attr("disabled", "disabled");
						$("#channel").attr("disabled", "disabled");
					}
				}
				else if (caller_id=="shipfrom" || caller_id=="shipto"){	// BoL
					$("#"+caller_id+"_address").val(ui.item.address_street);
					$("#"+caller_id+"_csz").val(ui.item.address_csz);
					if (caller_id=="shipfrom")
						$("#seller_comp_id").val(ui.item.comp_id);
				}
			}
		}
	});
}

function recalc_price_unit(line_num){
	var role = $("#role").val();	// 1-5
	var channel = $("#channel").val();	// asia, europe
	var arr_orig_price = [];
	var arr_counter = [];
	var arr_prod_id = [];
	for (var i=1; i<=pdt_max; i++){
		if (line_num==0 || line_num==i){	// apply to all lines or only to that one
			var prod_id = $("#hid_prod_id_"+i).val();
			var orig_price = $("#hid_orig_price_"+i).val();
			var field_price = $("#unit_price_"+i).val();
			if (!isNaN(prod_id) && !isNaN(orig_price) && prod_id!="" && orig_price!="" && field_price!=""){
				arr_orig_price.push(orig_price);
				arr_counter.push(i);
				arr_prod_id.push(prod_id);
			}
		}	
	}
	$.ajax({
		type: "POST",
		data:{
			role: role,
			channel: channel,
			arr_orig_price: arr_orig_price,
			arr_counter: arr_counter,
			arr_prod_id: arr_prod_id,
			seller_comp_id: $("#seller_comp_id").val(),
			consignee_comp_id: $("#consignee_comp_id").val()
		},
		url: "ajx_calc_channel_price.php",
		success: function(msg){
			var json_obj = $.parseJSON(msg);
			$.each(json_obj, function(key, new_price){
				new_price = parseInt(new_price*100) / 100;
				$("#unit_price_"+key).val(new_price.toFixed(2));
				//qty = $("#qty_"+key).val();
				//$("#total_price_"+key).val(Math.round(qty*new_price * 100) / 100);
				
				// hint
				orig_price = $("#hid_orig_price_"+key).val();
				if (orig_price!=new_price){
					percent = 0;
					if (orig_price!=0)
						percent = Math.round(100 * (100 - 100*new_price/orig_price)) / 100;
					
					$("#unit_price_explain_"+key).hide().attr("title", "");
					$("#unit_price_explain_"+key).show().attr("title", "Channel Discount: "+percent+"% of $"+orig_price);
				}
			});
			$("#total_value").val( sumValues(".calc_sum") );
		}
	});
}

function recal_price_volume(line_num){
	var arr_qty = [];
	var arr_prod_id = [];
	var arr_counter = [];
	for (var i=1; i<=pdt_max; i++){
		if (line_num==0 || line_num==i){
			var prod_id = $("#hid_prod_id_"+i).val();
			var qty = $("#qty_"+i).val();
			var unit_price = $("#unit_price_"+i).val();
			if (prod_id!="" && qty!="" && unit_price!="" && !isNaN(prod_id) && !isNaN(qty) && !isNaN(unit_price)){
				arr_qty.push(qty);
				arr_prod_id.push(prod_id);
				arr_counter.push(i);
			}
		}
	}
	$.ajax({
		type: "POST",
		data:{
			arr_qty: arr_qty,
			arr_prod_id: arr_prod_id,
			arr_counter: arr_counter
		},
		url: "ajx_calc_volume_price.php",
		success: function(msg){
			var json_obj = $.parseJSON(msg);
			$.each(json_obj, function(key, discount){
				var this_qty 		= parseFloat($("#qty_"+key).val());
				var this_unit_price = parseFloat($("#unit_price_"+key).val());
				var orig_total = this_qty * this_unit_price;
				var total_price = orig_total;
				var hint = "";
				discount = String(discount);
				if (discount.indexOf("$")>-1){ 
					discount = parseFloat(discount.replace("$", ""));
					dtype = "$";
					total_price = this_qty * (this_unit_price - discount);
					hint = "$"+discount+" off per unit; original total: "+orig_total;
				}
				else if (discount.indexOf("%")>-1){
					discount = parseFloat(discount.replace("%", ""));
					dtype = "%";
					total_price = this_qty * (this_unit_price - this_unit_price*discount/100);
					hint = discount+"%; original total: "+orig_total;
				}
					
				total_price = parseInt(total_price*100)/100;
				$("#total_price_"+key).val(total_price);
				
				// hint
				if (discount!=0){
					$("#total_price_explain_"+key).hide().attr("title", "");
					$("#total_price_explain_"+key).show().attr("title", "Voulme Discount: "+hint);
				}
			});
			$("#total_value").val( sumValues(".calc_sum") );
		}
	});
}

// icons Erase, Load Myself, Copy
function partner_erase(partner){
	$("#role").removeAttr("disabled");
	$("#channel").removeAttr("disabled");
	if ($("#"+partner+"_phone").length>0) 		$("#"+partner+"_phone").val("");
	if ($("#"+partner+"_fax").length>0) 		$("#"+partner+"_fax").val("");
	if ($("#"+partner+"_company").length>0) 	$("#"+partner+"_company").val("");
	$("#"+partner+"_name").val("");
	$("#"+partner+"_address").val("");
	$("#"+partner+"_country").val(218);
	if (partner=="seller"){
		$("#seller_comp_id").val($("#my_comp_id").val());
	}
	else if (partner=="shipfrom" || partner=="shipto"){
		$("#"+partner+"_csz").val("");
	}
	recalc_price_unit(0);
}
function partner_myself(partner){
	$("#role").removeAttr("disabled");
	$("#channel").removeAttr("disabled");
	if ($("#"+partner+"_phone").length>0) 		$("#"+partner+"_phone").val($("#my_phone").val());
	if ($("#"+partner+"_fax").length>0) 		$("#"+partner+"_fax").val($("#my_fax").val());
	if ($("#"+partner+"_company").length>0)		$("#"+partner+"_company").val($("#my_company").val());
	if ($("#"+partner+"_name").length>0)		$("#"+partner+"_name").val($("#my_name").val());
	$("#"+partner+"_address").val($("#my_address").val());
	$("#"+partner+"_country").val($("#my_country").val());
	if (partner=="seller")
		$("#seller_comp_id").val($("#my_comp_id").val());
	else if (partner=="consignee")
		$("#consignee_comp_id").val($("#my_comp_id").val());
	else if (partner=="shipfrom" || partner=="shipto")
		$("#"+partner+"_csz").val($("#my_csz").val());
	
	recalc_price_unit(0);
}
function partner_copy(p1, p2){
	$("#"+p2+"_company").val($("#"+p1+"_company").val());
	$("#"+p2+"_name").val($("#"+p1+"_name").val());
	$("#"+p2+"_address").val($("#"+p1+"_address").val());
	$("#"+p2+"_country").val($("#"+p1+"_country").val());
	if ($("#"+p2+"_phone").length>0) 
		$("#"+p2+"_phone").val($("#"+p1+"_phone").val());
}

// tradedocs: invoice num to be unique
function check_invoice_no(invoice_no, doc_type_id, invoice_id){
	if (invoice_no!=""){
		$.ajax({
			type: "POST",
			data:{
				invoice_no: invoice_no,
				doc_type_id: doc_type_id,
				invoice_id: invoice_id
			},
			url: "ajx_docs_check_invoice_no.php",
			success: function(msg){
				if (msg==0)
					signin_show();
				else{
					msg_ar = msg.split("~");
					var doc_type_names = msg_ar[0];
					var cn = msg_ar[1];
					var invoice_name = msg_ar[2];
					if (cn>0){
						$("#invoice_waring").show();
					}
					else
						$("#invoice_waring").hide();
				}
			}
		});
	}
}

// popup a modal with commodities
function modal_commod(line){
	var role = "";
	var channel = "";
	if ($("#role").length>0) 		role = $('#role').val();
	if ($("#channel").length>0) 	channel = $('#channel').val();
	var seller_comp_id = $("#seller_comp_id").val();
	
	var hrefa = "modal_tdoc_commodity.php?line_num="+line+"&vendor="+seller_comp_id+"&role="+role+"&channel="+channel;
	$("#a_"+line).attr("href", hrefa).trigger("click");
}

// unit_price_156 ==> 156
function get_underscored_id(name){
	var arr_name = name.split("_");
	return arr_name[arr_name.length-1];
}

function drop_pdf(invoice_id, doc_id, mode){
	// mode: 0-from overview; 1-from the document-edit
	if (ok_cancel("Delete this document?")){
		$.ajax({
			type: "POST",
			data:{
				invoice_id: invoice_id,
				doc_id: doc_id
			},
			url: "ajx_docs_drop.php",
			success: function(msg){
				if (msg==0)
					signin_show();
				else{
					if (mode==0)
						$("#square_"+invoice_id+"_"+doc_id).hide();
					else
						window.location.href = "my_tradedocs_more.php?doc="+msg;
				}
			}
		});
	}
}

// attach file
cn_atch = 0;
function call_attach(){
	var paperclip = "<i class='fa fa-paperclip'></i> ";
	var extens = ["doc", "docx", "xls", "xlsx", "pdf", "csv", "rtf", "txt", "vdx", "vsd", "vss", "vst",
				"jpg", "jpeg", "gif", "png", "psd", "tiff", "tif", "bmp", "zip", "rar",
				"pot", "potm", "potx", "ppa", "ppam", "pps", "ppsm", "ppsx", "ppt", "pptm", "pptx"]; 
	cn_atch++;
	$("#cn_files").val(cn_atch);
	var qqq = "<div id='divfile_"+cn_atch+"' style='display:none'>File1</div>"+
			  "<input type='file' name='file_"+cn_atch+"' id='file_"+cn_atch+"' style='display:none' />";
	$("#files").append(qqq);
	
	$("#file_"+cn_atch)[0].click();	// trigger dialog file chooser
	$("#file_"+cn_atch).change(function(){
		var filename = $(this).val();
		filename = paperclip + filename.replace("C:\\fakepath\\", "");
		if (extens.indexOf(getExt(filename))==-1)
			return err_empty("", "This file type is not allowed!");
		else{
			filename+= "&nbsp;&nbsp;&nbsp;&nbsp;";
			filename+= "<span class='fa fa-times' title='Drop File' onClick='drop_file_x("+cn_atch+")' style='cursor:pointer'></span>";
			$("#divfile_"+cn_atch).html(filename).show();
		}
		$(this).hide();	// otherwise doesn't work in safari, and ($id).trigger("click") too
	});
}
function drop_file_x(fid){	// drop just attached not yet saved file
	$("#file_"+fid).val("");
	$("#divfile_"+fid).hide();
}
function abs_shade(){	// xxx
	var body_height = $('body').height()+10;
	$("#shade").css('height', body_height);
}

// make visible stack of items one-by-one (attr-val, import photo from web)
function add_more_items(div_to_copy, div_add_more, s1, s2){
	for (i=s1; i <= s2; i++){
		if ($("#"+div_to_copy+i).is(":hidden")){
			$("#"+div_to_copy+i).show();
			break;
		}
	}
	if ($("#"+div_to_copy+s2).is(":visible"))
		$("#"+div_add_more).hide();
}

// add product -> change category -> load subcategs
function categ_change(categ_id, subcateg_idname){
	if (typeof(subcateg_idname)==='undefined') subcateg_idname = "txt_subcateg";
	$.ajax({
		type: "POST",	
		url: "ajx_subcateg.php?q="+categ_id,		
		success: function(msg){
			$("#"+subcateg_idname).html(msg);
		}
	});
}

function change_language(lg){
	$.ajax({
		type: "POST",	
		url: URL13+"ajx_lang_change.php?lg="+lg,		
		success: function(msg){
			window.location.href = window.location.href;
		}
	});
}