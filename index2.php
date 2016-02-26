<?
include_once("mysql.php");
include_once("func_build.php");
include_once("functions.php");
include_once("lang/lang.".get_LG().".php");

//$serlzd_cookie_params = get_cookie_params();
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
      <div class="large-12 columns" style=''>
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
        <div class="large-12 columns">
          <div class="featured-sellers large-12 medium-12" style='text-align:right'>
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
	
<ul class="list-group row marketplace-product-list" style="max-width:1160px;">
			<li class="list-group-item col-md-2 col-sm-3 col-xs-6">
						<a href="https://globemart.com/product/24841819-Stinger-3" style="text-decoration:none;">
			<div class="marketplace-product-wrapper">
				<div class="responsive-container">
					<div class="dummy"></div>

					<div class="img-container">
						<div class="centerer"></div>
						<img class="marketplace-product-photo" src="https://globemart.com/Media/Stores/7/1702754137_mens-stinger-3.jpg" border="0" style="width:273.770491803px">    
					</div>
				</div>
				
				<div class="marketplace-product-info" style="margin-top:5px">
					<span class="marketplace-product-info-title">Stinger 3</span>
					<span class="marketplace-product-info-price">&nbsp;</span>
				</div>
			</div></a>
		</li>
				<li class="list-group-item col-md-2 col-sm-3 col-xs-6">
						<a href="https://globemart.com/product/24841888-18-457-mm-Pocket-Canvas-Tool-Bag" style="text-decoration:none;">
			<div class="marketplace-product-wrapper">
				<div class="responsive-container">
					<div class="dummy"></div>

					<div class="img-container">
						<div class="centerer"></div>
						<img class="marketplace-product-photo" src="https://globemart.com/Media/Stores/14/1276290655_tool-bag.jpg" border="0" style="width:200px">    
					</div>
				</div>
				
				<div class="marketplace-product-info" style="margin-top:5px">
					<span class="marketplace-product-info-title">18'' (457 mm) Pocket Canvas Tool Bag</span>
					<span class="marketplace-product-info-price">&nbsp;</span>
				</div>
			</div></a>
		</li>
				<li class="list-group-item col-md-2 col-sm-3 col-xs-6">
						<a href="https://globemart.com/product/24842034-24-pack-of-5L-Bottles" style="text-decoration:none;">
			<div class="marketplace-product-wrapper">
				<div class="responsive-container">
					<div class="dummy"></div>

					<div class="img-container">
						<div class="centerer"></div>
						<img class="marketplace-product-photo" src="https://globemart.com/Media/Stores/57/391773821_half-liter-bottle-shop-online.jpg" border="0" style="width:98.0392156863px">    
					</div>
				</div>
				
				<div class="marketplace-product-info" style="margin-top:5px">
					<span class="marketplace-product-info-title">24-pack of .5L Bottles</span>
					<span class="marketplace-product-info-price">&nbsp;</span>
				</div>
			</div></a>
		</li>
				<li class="list-group-item col-md-2 col-sm-3 col-xs-6">
						<a href="https://globemart.com/product/24842188-Black-Bear-Energy-Drink" style="text-decoration:none;">
			<div class="marketplace-product-wrapper">
				<div class="responsive-container">
					<div class="dummy"></div>

					<div class="img-container">
						<div class="centerer"></div>
						<img class="marketplace-product-photo" src="https://globemart.com/Media/Stores/74/262899933-productdrink.png" border="0" style="width:234.309623431px">    
					</div>
				</div>
				
				<div class="marketplace-product-info" style="margin-top:5px">
					<span class="marketplace-product-info-title">Black Bear Energy Drink</span>
					<span class="marketplace-product-info-price">&nbsp;</span>
				</div>
			</div></a>
		</li>
				<li class="list-group-item col-md-2 col-sm-3 col-xs-6">
						<a href="https://globemart.com/product/24842288-Blackberry-Just-Fruit-Spread" style="text-decoration:none;">
			<div class="marketplace-product-wrapper">
				<div class="responsive-container">
					<div class="dummy"></div>

					<div class="img-container">
						<div class="centerer"></div>
						<img class="marketplace-product-photo" src="https://globemart.com/Media/Stores/54/1127207179-product_17_full.jpg" border="0" style="width:127.032967033px">    
					</div>
				</div>
				
				<div class="marketplace-product-info" style="margin-top:5px">
					<span class="marketplace-product-info-title">Blackberry Just Fruit Spread</span>
					<span class="marketplace-product-info-price">&nbsp;</span>
				</div>
			</div></a>
		</li>
				<li class="list-group-item col-md-2 col-sm-3 col-xs-6">
						<a href="https://globemart.com/product/24842305-FENDER-LIMITED-EDITION-AMERICAN-STANDARD-STRATOCASTER-ELECTRIC-GUITAR-OILED-ASH" style="text-decoration:none;">
			<div class="marketplace-product-wrapper">
				<div class="responsive-container">
					<div class="dummy"></div>

					<div class="img-container">
						<div class="centerer"></div>
						<img class="marketplace-product-photo" src="https://globemart.com/Media/Stores/111/1339424754-fender.jpg" border="0" style="width:82.8125px">    
					</div>
				</div>
				
				<div class="marketplace-product-info" style="margin-top:5px">
					<span class="marketplace-product-info-title">FENDER LIMITED EDITION AMERICAN STANDARD STRATOCASTER ELECTRIC GUITAR - OILED ASH</span>
					<span class="marketplace-product-info-price">&nbsp;</span>
				</div>
			</div></a>
		</li>
				<li class="list-group-item col-md-2 col-sm-3 col-xs-6">
						<a href="https://globemart.com/product/24842452-Kingii" style="text-decoration:none;">
			<div class="marketplace-product-wrapper">
				<div class="responsive-container">
					<div class="dummy"></div>

					<div class="img-container">
						<div class="centerer"></div>
						<img class="marketplace-product-photo" src="https://globemart.com/Media/Stores/135/1098740485_kingiimainitem.jpg" border="0" style="width:244.541484716px">    
					</div>
				</div>
				
				<div class="marketplace-product-info" style="margin-top:5px">
					<span class="marketplace-product-info-title">Kingii</span>
					<span class="marketplace-product-info-price">&nbsp;</span>
				</div>
			</div></a>
		</li>
				<li class="list-group-item col-md-2 col-sm-3 col-xs-6">
						<a href="https://globemart.com/product/24842515-ALL-BANISH-PRODUCTS" style="text-decoration:none;">
			<div class="marketplace-product-wrapper">
				<div class="responsive-container">
					<div class="dummy"></div>

					<div class="img-container">
						<div class="centerer"></div>
						<img class="marketplace-product-photo" src="https://globemart.com/Media/Stores/147/364955025_all-banish-products_rev2_1024x1024.jpg" border="0" style="width:200px">    
					</div>
				</div>
				
				<div class="marketplace-product-info" style="margin-top:5px">
					<span class="marketplace-product-info-title">ALL BANISH PRODUCTS</span>
					<span class="marketplace-product-info-price">$295.00&nbsp;</span>
				</div>
			</div></a>
		</li>
				<li class="list-group-item col-md-2 col-sm-3 col-xs-6">
						<a href="https://globemart.com/product/24842546-Ipad-cover-D-pad1" style="text-decoration:none;">
			<div class="marketplace-product-wrapper">
				<div class="responsive-container">
					<div class="dummy"></div>

					<div class="img-container">
						<div class="centerer"></div>
						<img class="marketplace-product-photo" src="https://globemart.com/Media/Stores/152/1311547703.jpg" border="0" style="width:133.333333333px">    
					</div>
				</div>
				
				<div class="marketplace-product-info" style="margin-top:5px">
					<span class="marketplace-product-info-title">Ipad cover (D pad)1</span>
					<span class="marketplace-product-info-price">$100.00&nbsp;</span>
				</div>
			</div></a>
		</li>
				<li class="list-group-item col-md-2 col-sm-3 col-xs-6">
						<a href="https://globemart.com/product/24842569-CAMP-SHERMAN" style="text-decoration:none;">
			<div class="marketplace-product-wrapper">
				<div class="responsive-container">
					<div class="dummy"></div>

					<div class="img-container">
						<div class="centerer"></div>
						<img class="marketplace-product-photo" src="https://globemart.com/Media/Stores/159/644878593.jpg" border="0" style="width:200px">    
					</div>
				</div>
				
				<div class="marketplace-product-info" style="margin-top:5px">
					<span class="marketplace-product-info-title">CAMP SHERMAN</span>
					<span class="marketplace-product-info-price">$139.99&nbsp;</span>
				</div>
			</div></a>
		</li>
				<li class="list-group-item col-md-2 col-sm-3 col-xs-6">
						<a href="https://globemart.com/product/24842575-Boba-4G-Baby-Carrier" style="text-decoration:none;">
			<div class="marketplace-product-wrapper">
				<div class="responsive-container">
					<div class="dummy"></div>

					<div class="img-container">
						<div class="centerer"></div>
						<img class="marketplace-product-photo" src="https://globemart.com/Media/Stores/161/1584998017.jpg" border="0" style="width:160px">    
					</div>
				</div>
				
				<div class="marketplace-product-info" style="margin-top:5px">
					<span class="marketplace-product-info-title">Boba 4G Baby Carrier</span>
					<span class="marketplace-product-info-price">$125.00&nbsp;</span>
				</div>
			</div></a>
		</li>
				<li class="list-group-item col-md-2 col-sm-3 col-xs-6">
						<a href="https://globemart.com/product/24842595-The-Ultimate-Hamper" style="text-decoration:none;">
			<div class="marketplace-product-wrapper">
				<div class="responsive-container">
					<div class="dummy"></div>

					<div class="img-container">
						<div class="centerer"></div>
						<img class="marketplace-product-photo" src="https://globemart.com/Media/Stores/164/495095988.jpg" border="0" style="width:200px">    
					</div>
				</div>
				
				<div class="marketplace-product-info" style="margin-top:5px">
					<span class="marketplace-product-info-title">The Ultimate Hamper</span>
					<span class="marketplace-product-info-price"><i class="fa fa-gbp"></i>18.00 GBP&nbsp;</span>
				</div>
			</div></a>
		</li>
			</ul>
</div>
  
  
  
  <!--3 circles
  <section id="what-we-provide" class="home-module">
    <div class="row">
      <div class="large-12 columns">
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
      <div class="large-12 columns">
        <h2>Trending Industries.</h2>
        <div class="row">
							<div class="large-4 medium-4 columns">
					<ul class="trending-products-container">
					  <li>
						<h3>Child &amp; Infant</h3>
						<ul class="trending-products small-block-grid-2 medium-block-grid-2 large-block-grid-2" style="margin-top:0px; padding-left:2px">
							<li style="text-align:center; width:48%; height:130px; background-color:#FFF;">
										<a href="https://globemart.com/product/24841905-Training-Pants">
										<img src="https://globemart.com/Media/Stores/13/1132493232_training-pnts.jpg" style="width:120px" border="0" title="Training Pants"></a></li><li style="text-align:center; width:48%; height:130px; background-color:#FFF;">
										<a href="https://globemart.com/product/24841904-Honest-Baby-Stroller">
										<img src="https://globemart.com/Media/Stores/13/387971394_stroller.jpg" style="width:79.8545454545px" border="0" title="Honest Baby Stroller"></a></li><li style="text-align:center; width:48%; height:130px; background-color:#FFF;">
										<a href="https://globemart.com/product/24841902-Prenatal-Multivitamin">
										<img src="https://globemart.com/Media/Stores/13/1754350203_prenatal.jpg" style="width:120px" border="0" title="Prenatal Multivitamin"></a></li><li style="text-align:center; width:48%; height:130px; background-color:#FFF;">
										<a href="https://globemart.com/product/24841848-Original-Baby-Carrier">
										<img src="https://globemart.com/Media/Stores/9/1798508674_original.jpg" style="width:120px" border="0" title="Original Baby Carrier"></a></li>						</ul>
					  </li>
					</ul>
				</div>
								<div class="large-4 medium-4 columns">
					<ul class="trending-products-container">
					  <li>
						<h3>Food &amp; Beverage</h3>
						<ul class="trending-products small-block-grid-2 medium-block-grid-2 large-block-grid-2" style="margin-top:0px; padding-left:2px">
							<li style="text-align:center; width:48%; height:130px; background-color:#FFF;">
										<a href="https://globemart.com/product/24841963-Ginger-Ale">
										<img src="https://globemart.com/Media/Stores/23/164068813_ginger-ale.jpeg" style="width:120px" border="0" title="Ginger Ale"></a></li><li style="text-align:center; width:48%; height:130px; background-color:#FFF;">
										<a href="https://globemart.com/product/24841796-Sweet-Corn-Crunch-Dried-Snack">
										<img src="https://globemart.com/Media/Stores/4/1932505382_sweetcorn.jpg" style="width:120px" border="0" title="Sweet Corn Crunch Dried Snack"></a></li><li style="text-align:center; width:48%; height:130px; background-color:#FFF;">
										<a href="https://globemart.com/product/24841791-Almonds">
										<img src="https://globemart.com/Media/Stores/3/1137751718_almonds.jpg" style="width:120px" border="0" title="Almonds"></a></li><li style="text-align:center; width:48%; height:130px; background-color:#FFF;">
										<a href="https://globemart.com/product/24841790-Dried-Plums">
										<img src="https://globemart.com/Media/Stores/3/25222535_plums.jpg" style="width:120px" border="0" title="Dried Plums"></a></li>						</ul>
					  </li>
					</ul>
				</div>
								<div class="large-4 medium-4 columns">
					<ul class="trending-products-container">
					  <li>
						<h3>Gifts &amp; Crafts</h3>
						<ul class="trending-products small-block-grid-2 medium-block-grid-2 large-block-grid-2" style="margin-top:0px; padding-left:2px">
							<li style="text-align:center; width:48%; height:130px; background-color:#FFF;">
										<a href="https://globemart.com/product/24842873-6KU-Bruh-Slap">
										<img src="https://globemart.com/Media/Stores/196/1444151198_bruh.jpg" style="width:90.0804289544px" border="0" title="6KU Bruh Slap"></a></li><li style="text-align:center; width:48%; height:130px; background-color:#FFF;">
										<a href="https://globemart.com/product/24842839-Wooden-Toys-Gift-Box-8211-sarah-bendrix">
										<img src="https://globemart.com/Media/Stores/188/1888384592.jpg" style="width:120px" border="0" title="Wooden Toys Gift Box                         – sarah &amp; bendrix"></a></li><li style="text-align:center; width:48%; height:130px; background-color:#FFF;">
										<a href="https://globemart.com/product/24842838-Wooden-Stacking-Truck-8211-sarah-bendrix">
										<img src="https://globemart.com/Media/Stores/188/1272792248.jpg" style="width:120px" border="0" title="Wooden Stacking Truck                         – sarah &amp; bendrix"></a></li><li style="text-align:center; width:48%; height:130px; background-color:#FFF;">
										<a href="https://globemart.com/product/24842837-Wooden-Stacking-Bear-8211-sarah-bendrix">
										<img src="https://globemart.com/Media/Stores/188/2029072614.jpg" style="width:120px" border="0" title="Wooden Stacking Bear                         – sarah &amp; bendrix"></a></li>						</ul>
					  </li>
					</ul>
				</div>
								<div class="large-4 medium-4 columns">
					<ul class="trending-products-container">
					  <li>
						<h3>Hardware &amp; Tools</h3>
						<ul class="trending-products small-block-grid-2 medium-block-grid-2 large-block-grid-2" style="margin-top:0px; padding-left:2px">
							<li style="text-align:center; width:48%; height:130px; background-color:#FFF;">
										<a href="https://globemart.com/product/24841896-Hard-Body-Oval-Bucket">
										<img src="https://globemart.com/Media/Stores/14/1290456143_bucket2.jpg" style="width:100px" border="0" title="Hard Body Oval Bucket"></a></li><li style="text-align:center; width:48%; height:130px; background-color:#FFF;">
										<a href="https://globemart.com/product/24841895-Leather-Bottom-Bucket">
										<img src="https://globemart.com/Media/Stores/14/936492448_bucket1.jpg" style="width:120px" border="0" title="Leather-Bottom Bucket"></a></li><li style="text-align:center; width:48%; height:130px; background-color:#FFF;">
										<a href="https://globemart.com/product/24841894-Extra-Deep-All-Purpose-Tool-Box">
										<img src="https://globemart.com/Media/Stores/14/114730926_tool-storage2.jpg" style="width:100px" border="0" title="Extra-Deep All-Purpose Tool Box"></a></li><li style="text-align:center; width:48%; height:130px; background-color:#FFF;">
										<a href="https://globemart.com/product/24841893-Extra-Large-16-Compartment-Storage-Box">
										<img src="https://globemart.com/Media/Stores/14/1092091444_tool-storage1.jpg" style="width:100px" border="0" title="Extra-Large 16-Compartment Storage Box"></a></li>						</ul>
					  </li>
					</ul>
				</div>
								<div class="large-4 medium-4 columns">
					<ul class="trending-products-container">
					  <li>
						<h3>Household Goods</h3>
						<ul class="trending-products small-block-grid-2 medium-block-grid-2 large-block-grid-2" style="margin-top:0px; padding-left:2px">
							<li style="text-align:center; width:48%; height:130px; background-color:#FFF;">
										<a href="https://globemart.com/product/24843088-Large-Precision-Angle-Broom-with-Dustpan">
										<img src="https://globemart.com/Media/Stores/192/188290908.png" style="width:116.062176166px" border="0" title="Large Precision Angle Broom with Dustpan"></a></li><li style="text-align:center; width:48%; height:130px; background-color:#FFF;">
										<a href="https://globemart.com/product/24843087-Large-Precision-Angle-Broom">
										<img src="https://globemart.com/Media/Stores/192/1516236011.png" style="width:100.900900901px" border="0" title="Large Precision Angle Broom"></a></li><li style="text-align:center; width:48%; height:130px; background-color:#FFF;">
										<a href="https://globemart.com/product/24843086-Household-Dust-Pan">
										<img src="https://globemart.com/Media/Stores/192/1457459977.png" style="width:120px" border="0" title="Household Dust Pan"></a></li><li style="text-align:center; width:48%; height:130px; background-color:#FFF;">
										<a href="https://globemart.com/product/24843085-Heavy-Duty-Scrub-Brush">
										<img src="https://globemart.com/Media/Stores/192/760448109.png" style="width:94.5147679325px" border="0" title="Heavy Duty Scrub Brush"></a></li>						</ul>
					  </li>
					</ul>
				</div>
								<div class="large-4 medium-4 columns">
					<ul class="trending-products-container">
					  <li>
						<h3>Jewelry</h3>
						<ul class="trending-products small-block-grid-2 medium-block-grid-2 large-block-grid-2" style="margin-top:0px; padding-left:2px">
							<li style="text-align:center; width:48%; height:130px; background-color:#FFF;">
										<a href="https://globemart.com/product/24842059-Initial-B-Charm-Bangle">
										<img src="https://globemart.com/Media/Stores/70/1873714621_a13eb14bg-2.jpg" style="width:120px" border="0" title="Initial B Charm Bangle"></a></li><li style="text-align:center; width:48%; height:130px; background-color:#FFF;">
										<a href="https://globemart.com/product/24842049-Hendrix-Ring">
										<img src="https://globemart.com/Media/Stores/67/1345751141-hendrix_ring_gold.jpg" style="width:120px" border="0" title="Hendrix Ring"></a></li><li style="text-align:center; width:48%; height:130px; background-color:#FFF;">
										<a href="https://globemart.com/product/24841930-Gold-Tulsi-Mala-Seeds-of-Change">
										<img src="https://globemart.com/Media/Stores/17/1063690299_ng555-l29.jpg" style="width:120px" border="0" title="Gold Tulsi Mala - Seeds of Change"></a></li><li style="text-align:center; width:48%; height:130px; background-color:#FFF;">
										<a href="https://globemart.com/product/24841929-Blue-Floral-Scarf">
										<img src="https://globemart.com/Media/Stores/17/1745063243_s70-blue.jpg" style="width:120px" border="0" title="Blue Floral Scarf"></a></li>						</ul>
					  </li>
					</ul>
				</div>
				        </div>
      </div>
    </div>
  </section>
  
  <!--A marketplace for everyone. [sellers] [buyers]-->
  <section class="marketplace-for-everyone home-module">
    <div class="row">
      <div class="large-12 columns">
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
      <div class="large-12 columns">
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
      <div class="large-12 large-centered columns">
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