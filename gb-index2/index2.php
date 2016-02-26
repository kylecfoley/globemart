<?
include_once("mysql.php");
include_once("func_build.php");
include_once("functions.php");
include_once("lang/lang.".get_LG().".php");

$serlzd_cookie_params = get_cookie_params();
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
  <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Globemart - a platform for all your B2B needs</title>
  
  <link href='//fonts.googleapis.com/css?family=Open+Sans:400,600,300,700' rel='stylesheet' type='text/css'>
  <link href='//fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
  
  <link rel="stylesheet" type="text/css" media="all" href="fonts/font-awesome-4.2.0/css/font-awesome.css">
  <link rel="stylesheet" href="themeforest/css/bootstrap.css" type="text/css" />
  
  <link rel="stylesheet" href="css/app.css" />
  <script src="js/modernizr.js"></script>
  <script src="js/jquery.min.js"></script>
  <script src="js/foundation.min.js"></script>
  <script src="js/jquery.responsiveTabs.js"></script>
  <script src="js/jquery.bxslider.js"></script>
  <script src="js/breakpoints.js"></script>
  <script src="js/skrollr.js"></script>
  <script src="js/imagesloaded.js"></script>
  <script src="js/app.js"></script>
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-backstretch/2.0.4/jquery.backstretch.min.js"></script>
  <script>
  	$(document).ready(function () {

    $(".hero-home").backstretch([
      "images/bg_home_hero_4.jpg",
      "images/bg_home_hero_5.jpg",
      "images/bg_home_hero_6.jpg"
      ], {
        fade: 750,
        duration: 4000,
        centeredY: false

    });
    });
</script>
	<script type="text/javascript" src="js.js"></script>
	<link rel="stylesheet" href="themeforest/css/app.css" type="text/css" />
	<!--[if lt IE 9]>
		<script src="themeforest/js/ie/html5shiv.js"></script>
		<script src="themeforest/js/ie/respond.min.js"></script>
		<script src="themeforest/js/ie/excanvas.js"></script>
	<![endif]-->
	<link href="css/main_styles_boot.css" rel="stylesheet">
	
	

<link href="css/searchpages.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">

	<!-- MEGA MENU (CSS IS @IMPORT IN STYLESHEET) -->
<link href="css/megamenu.css" rel="stylesheet">
<script type="text/javascript" src="js/megamenu.js"></script>
<script type="text/javascript" src="js/megamenu_plugins.js"></script>
<script type="text/javascript" src="js/custom/megamenu_popup.js"></script>
<script type="text/javascript" src="js/custom/company_narrow_result.js"></script>
<!-- MEGA MENU -->
</head>

<body id="path_index">
<div id="skrollr-body">  
	<?
	forest_header(1);
	?>
	<div style='width:100%; height:50px; line-height:50px; padding-left:20px; font-size:16px;'>
		<div class="information_popup_container" style='width:150px; float:left;'>
			<div class="information" style='cursor:pointer'>
				<!-- The thing or things you want to hover over go here such as images, tables, 
					 paragraphs, objects other divisions etc. --> 
				<div>Browse Products <i class="fa fa-caret-down"></i></div>
			</div>
			<div class="popup_information" style='margin-left:-5px;'>
				<!-- The thing or things you want to popup go here such as images, tables, 
				paragraphs, objects other divisions etc. --> 
			 
				<div class="megamenu_container_vertical megamenu_light_bar megamenu_light" id='categ_menu' style='z-index:100;'><!-- Begin Menu Container -->
				<ul class="megamenu megamenu_vertical"><!-- Begin Mega Menu -->
					<li class="megamenu_button"><a href="#_"><?=strtoupper($lang["shop_by_industry"])?></a></li>
					<?
					// Categories
					$i = 0;
					$sql = "SELECT PC.id, ".get_lang_column("category")." as categ
							FROM product_categories PC 
							WHERE EXISTS (select 1 from products where categ_id=PC.id) AND PC.id<>1
							ORDER BY 2";
					$result = mysql_query($sql);
					while($row = mysql_fetch_array($result)){
						$i++;
						$t_id = $row["id"];
						$t_cat = $row["categ"];
						?>
						<li>
							<a class='megamenu_drop' href='search.php?category=<?=$t_id?>'><?=$t_cat?></a>
							
							<?if (1==2){?>
							<div class="dropvertical_container"><!-- Vertical Drop Down Container -->
								<div class="dropdown_fullwidth dropdown_first"><!-- Begin Item Container -->
									<div class="col_12"><h3><a href='search.php?category=<?=$t_id?>'><?=$t_cat?></a></h3></div>
									<?
									$sql2 = "SELECT id, subcategory FROM product_categories_sub WHERE categ_id='$t_id' ORDER BY subcategory";
									$result2 = mysql_query($sql2);
									while($row2 = mysql_fetch_array($result2)){
										$t_subid = $row2["id"];
										$t_subcat = $row2["subcategory"];
										?>
										<div class="col_4">
											<ul class="list_unstyled">
												<li><a href="search.php?subcateg=<?=$t_subid?>"><b><u><?=$t_subcat?></u></b></a></li>	
											</ul>
										</div>
										<?
									}
									?>
								</div> <!-- End Item Container -->
							</div> <!-- End Vertical Drop Down Container -->
							<?}?>
						</li>
						<?
					}
					?>
				</ul>
				</div><!-- End Menu Container -->
			</div>
		</div>
		
		<div style='float:left; margin-left:200px;'>
			<a href='#'>Featured Items</a>
		</div>
		<div style='float:left; margin-left:50px;'>
			<a href='#'>Most Popular</a>
		</div>
		<div style='float:left; margin-left:50px;'>
			<a href='#'>Top Selling</a>
		</div>
		<div style='float:left; margin-left:50px;'>
			<a href='#'>New Products</a>
		</div>
	</div>
	
	<!--mobile header spacing fix for slideshow -->
  <div style="height:50px;" class="show-for-small-only"></div>
  	<!-- header spacing fix -->

  <div class="hero-home" style='margin-top:50px;'>
    <div class="hero-home-overlay"></div>
    <div class="row" style='margin-left:0px'>
      <div class="col-lg-12" style=''>
        <div class="hero-home-feature medium-6 large-6 columns">
          <h1 style='font-size:30px'>Enabling emerging product brands to enter new markets.</h1>
          <h1 style='font-size:18px'>Easy global trading, without the global hassles.</h1>
          <p><a href="#what-we-provide">See what Globemart can do for you! <img src='images/icon_arrow.png' border=0 width=33></a>
          </p>
        </div>
      </div>
    </div>
	
	<!--Carousel-->
    <div class="shading">
	<div style="position: absolute; background: none repeat scroll 0% 0% rgb(255, 255, 255); bottom: 0px; width: 100%; qheight: 75px;"></div>
      <div class="row">
        <div class="col-lg-12">
          <div class="featured-sellers col-lg-12 medium-12" style='text-align:right'>
			<a href='pricing'>
            <div class="join-cta-homepage">
				<?=$lang["JoinNow"]?> <span><?=$lang["start_orange_circle"]?></span>
            </div></a>
          </div>
        </div>
      </div>
    </div>
  </div>
	
<div class='home_bottom_part bottom_content' id='cont_marketplace' style='max-width:1160px; margin:0px auto;'>
	<div  class='product_header'>Featured Products</div>
	<br clear='all' />
	
	<ul class="list-group row marketplace-product-list" style='max-width:1160px;'>
	<?
	// Top Selling Products
	$i = 0;
	$query= "SELECT P.id as prod_id, P.product, H.photo, P.comp_id, P.hotdeal_img, P.fob_currency, 
					P.fob_min, P.date_posted, P.is_newarrival, P.product_url
			FROM products P 
			JOIN product_photo H ON H.prod_id=P.id and H.is_main=1 AND H.photo_video='p' 
			WHERE P.admin_featured=1 AND P.purpose=1 AND P.status=1 AND P.comp_id NOT IN (1, 2)
			LIMIT 12";
			//echo $query;
	$result = mysql_query($query);
	while($row = mysql_fetch_array($result)){
		$i++;
		$prod_id = $row["prod_id"];
		$product = $row["product"];
		$photo = $row["photo"];
		$comp_id = $row["comp_id"];
		$hotdeal_img = $row["hotdeal_img"];
		$fob_currency = $row["fob_currency"];
		$fob_min = $row["fob_min"];
		$date_posted = $row["date_posted"];
		$is_new = $row["is_newarrival"];
		$product_url = $row["product_url"];
		$cast_price = cast_price($fob_min, $fob_currency);
		
		$path_to_pic = "Media/Stores/$comp_id/$photo";
		$fit_img = fit_img($path_to_pic, 350,200);
		?>
		<li class="list-group-item col-md-2 col-sm-3 col-xs-6">
			<?
			//if ($is_new==1)
				//echo ribbon("n");
			?>
			<a href='<?=product_url($prod_id, $product_url)?>' style='text-decoration:none;'>
			<div class="marketplace-product-wrapper">
				<div class="responsive-container">
					<div class="dummy"></div>

					<div class="img-container">
						<div class="centerer"></div>
						<img class="marketplace-product-photo" src='<?=$path_to_pic?>' border=0 style='<?=$fit_img?>' />    
					</div>
				</div>
				
				<div class="marketplace-product-info" style='margin-top:5px'>
					<span class="marketplace-product-info-title"><?=$product?></span>
					<span class="marketplace-product-info-price"><?=$cast_price?>&nbsp;</span>
				</div>
			</div></a>
		</li>
		<?
	}
	?>
	</ul>
</div>
  
  
  
  <!--3 circles
  <section id="what-we-provide" class="home-module">
    <div class="row">
      <div class="col-lg-12">
        <h2>A Global Platform</h2>
        <ul>
          <li class="large-4 medium-4 columns">
            <a href='tradeware'><div class="icon tradeware"></div></a>
            <div class="content">
              <h3>Share Your<br>Product & Brand</h3>
              <div style="font-size:32px; color:#da7e24; margin-top:10px;">
			  <a href='tradeware'><img width="50" src="images/icon_arrow_blue.png"></a></div>
            </div>
          </li>
          <li class="large-4 medium-4 columns">
            <a href='tradefeed'><div class="icon tradefeed"></div></a>
            <div class="content">
			   <h3>With Micro-Sellers Around the World</h3>
              <div style="font-size:32px; color:#da7e24; margin-top:10px;">
			  <a href='tradefeed'><img width="50" src="images/icon_arrow_blue.png"></a></div>

            </div>
          </li>
          <li class="large-4 medium-4 columns">
            <a href='marketplace'><div class="icon marketplace"></div></a>
            <div class="content">
			  <h3>To Reach New Global Markets</h3>
              <div style="font-size:32px; color:#da7e24; margin-top:10px;">
			  <a href='marketplace'><img width="50" src="images/icon_arrow_blue.png"></a></div>

            </div>
          </li>
        </ul>
  </section>
  -->
  
  <!--Trending Industries (6 industries, 4 products in each)-->
  <section class="trending-industries home-module">
    <div class="row">
      <div class="col-lg-12">
        <h2><?=$lang["trending_industries"]?></h2>
        <div class="row">
			<?
			$sql = "SELECT * FROM product_categories WHERE is_trending=1 ORDER BY 2 LIMIT 6";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){
				$t_id = $row["id"];
				$t_categ = get_lang_field($row, "category");
				?>
				<div class="large-4 medium-4 columns">
					<ul class="trending-products-container">
					  <li>
						<h3><?=$t_categ?></h3>
						<ul class="trending-products small-block-grid-2 medium-block-grid-2 large-block-grid-2" style='margin-top:0px; padding-left:2px'>
							<?
							$sql_spec = "";
							if ($t_id==6)	$sql_spec = " AND P.id IN (10,11,16,183)";
							elseif ($t_id==14)	$sql_spec = " AND P.id IN (125,124,68,122)";
							
							$sql2 = "SELECT P.id, P.product, H.photo, P.comp_id, P.product_url
									FROM products P
									JOIN product_photo H ON H.prod_id=P.id AND H.is_main=1
									WHERE P.categ_id='$t_id' AND P.status=1 AND P.purpose=1 $sql_spec
									ORDER BY P.id DESC
									LIMIT 4";
							$result2 = mysql_query($sql2);
							while($row2 = mysql_fetch_array($result2)){
								$prod_id = $row2["id"];
								$comp_id = $row2["comp_id"];
								$product = $row2["product"];
								$photo = $row2["photo"];
								$product_url = $row2["product_url"];
								$small_pic_src = "Media/Stores/$comp_id/$photo";
								$fit_img = fit_img($small_pic_src, 120,120);
								echo "<li style='text-align:center; width:48%; height:130px; background-color:#FFF;'>
										<a href='".product_url($prod_id, $product_url)."'>
										<img src='$small_pic_src' style='$fit_img' border=0 title='$product'></a></li>";
							}
							?>
						</ul>
					  </li>
					</ul>
				</div>
				<?
			}
			?>
        </div>
      </div>
    </div>
  </section>
  
  <!--A marketplace for everyone. [sellers] [buyers]-->
  <section class="marketplace-for-everyone home-module">
    <div class="row">
      <div class="col-lg-12">
        <h2><?=$lang["marketplace4everyone"]?></h2>
        <div class="large-9 large-centered columns">
          <div class="large-5 medium-6 columns">
            <h3><?=$lang["Sellers"]?></h3>
            <a href='sellers'><img class="photo" src="images/img_seller.jpg" width="222" height="222" border=0></a>
            <p><?=$lang["seller_index_text"]?></p>
			<p class="learn-more"><?=$lang["learn_more"]?>
               <a href='sellers'><img src='images/icon_arrow.png' border=0 width=33 align='absmiddle'></a>
            </p>
          </div>
          <div class="marketplace-for-everyone-spacer hide-for-medium-only large-2 columns">
            <div></div>
          </div>
          <div class="large-5 medium-6 columns">
            <h3><?=$lang["Buyers"]?></h3>
            <a href='buyers'><img class="photo" src="images/img_buyer.jpg" width="222" height="222" border=0></a>
            <p><?=$lang["buyer_index_text"]?></p>
            <p class="learn-more"><?=$lang["learn_more"]?>
              <a href='buyers'><img src='images/icon_arrow.png' border=0 width=33 align='absmiddle'></a>
            </p>
          </div>
        </div>
      </div>
  </section>
  
  <!--Benefits (6 icons)--->
  <section id="benefits" class="home-module">
    <div class="row">
      <div class="col-lg-12">
        <h2><?=$lang["benefits"]?></h2>
        <ul class="benefits-list small-block-grid-2 medium-block-grid-3 large-block-grid-3">
          <li>
            <div class="icon"><img src="images/icon_benefits_1.png">
            </div>
            <p><?=$lang["benefits_quick"]?></p>
          </li>
          <li>
            <div class="icon"><img src="images/icon_benefits_2.png">
            </div>
            <p><?=$lang["benefits_improvef"]?></p>
          </li>
          <li>
            <div class="icon"><img src="images/icon_benefits_3.png">
            </div>
            <p><?=$lang["benefits_improvem"]?></p>
          </li>
          <li>
            <div class="icon"><img src="images/icon_benefits_4.png">
            </div>
            <p><?=$lang["benefits_expand"]?></p>
          </li>
          <li>
            <div class="icon"><img width="140" src="images/icon_benefits_5.png">
            </div>
            <p><?=$lang["benefits_shorten"]?></p>
          </li>
          <li>
            <div class="icon"><img src="images/icon_benefits_6.png">
            </div>
            <p><?=$lang["benefits_connect"]?></p>
          </li>
        </ul>
      </div>
    </div>
  </section>
  
  <!--Trade Anywhere (diff. screens)-->
  <section id="trade-anywhere" class="home-module">
    <div class="row">
      <div class="col-lg-12 large-centered columns">
        <h2><?=$lang["Tradeanywhere"]?></h2>
        <img width="800" src="images/img_tradeanywhere_devices.jpg">
      </div>
    </div>
    </div>
  </section>
  <?
  join_now_section(1);
  public_footer();
  ?>
  <script>
    $(document).foundation();

    var doc = document.documentElement;
    doc.setAttribute('data-useragent', navigator.userAgent);
  </script>
</div>
</body>

</html>

<!-- Bootstrap -->
<script src="themeforest/js/bootstrap.js"></script>
<script src="themeforest/js/app.js"></script> 