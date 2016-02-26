<?
//include_once("mysql.php");
//include_once("func_build.php");
//include_once("functions.php");
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
  
  <!--<link rel="stylesheet" type="text/css" media="all" href="fonts/gothammedium.css">-->
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
</head>

<body id="path_index">
<div id="skrollr-body">  
	<?
	forest_header(1);
	?>
	<!--mobile header spacing fix for slideshow -->
  <div style="height:50px;" class="show-for-small-only"></div>
  	<!-- header spacing fix -->

  <div class="hero-home">
    <div class="hero-home-overlay"></div>
    <div class="row" style='margin-left:0px'>
      <div class="large-12 columns">
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
	<div style="position: absolute; background: none repeat scroll 0% 0% rgb(255, 255, 255); bottom: 0px; width: 100%; height: 75px;"></div>
      <div class="row">
        <div class="large-12 columns">
          <div class="featured-sellers large-12 medium-12">
            <div class="slider1">
				<?
				// start with ergobaby
				$sql = "SELECT id, name, comp_url, header_image 
						FROM companies 
						WHERE header_image<>'' AND supplier=1 AND EXISTS (select 1 from products where comp_id=companies.id)
						ORDER BY order_homepage DESC, id DESC LIMIT 15";
				$result = mysql_query($sql);
				while($row = mysql_fetch_array($result)){
					$comp_id = $row["id"];
					$comp_name = $row["name"];
					$comp_url = $row["comp_url"];
					$header_image = $row["header_image"];
					$comp_pic_src = "Media/Stores/$comp_id/profile/$header_image";
					$fit_img = fit_img($comp_pic_src, 100, 38);
					if ($header_image!="" and file_exists($comp_pic_src)){
						?>
						<div class="slide">
						<a href='<?=$URL.$comp_url?>'><img src="<?=$comp_pic_src?>" style='<?=$fit_img?>' border=0 title='<?=$comp_name?>'></a>
						</div>
						<?
					}
				}
				?>
            </div>
			<a href='pricing'>
            <div class="join-cta-homepage">
				<?=$lang["JoinNow"]?> <span><?=$lang["start_orange_circle"]?></span>
            </div></a>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!--3 circles-->
  <section id="what-we-provide" class="home-module">
    <div class="row">
      <div class="large-12 columns">
        <h2><?=$lang["what_we_provide"]?></h2>
        <ul>
          <li class="large-4 medium-4 columns">
            <a href='tradeware'><div class="icon tradeware"></div></a>
            <div class="content">
              <h3><?=$lang["circ_tradeware"]?></h3>
              <p><?=$lang["circ_tradeware_text"]?></p>
              <div style="font-size:32px; color:#da7e24; margin-top:10px;">
			  <a href='tradeware'><img width="50" src="images/icon_arrow_blue.png"></a></div>
            </div>
          </li>
          <li class="large-4 medium-4 columns">
            <a href='tradefeed'><div class="icon tradefeed"></div></a>
            <div class="content">
              <h3><?=$lang["circ_tradefeed"]?></h3>
              <p><?=$lang["circ_tradefeed_text"]?></p>
              <div style="font-size:32px; color:#da7e24; margin-top:10px;">
			  <a href='tradefeed'><img width="50" src="images/icon_arrow_blue.png"></a></div>

            </div>
          </li>
          <li class="large-4 medium-4 columns">
            <a href='marketplace'><div class="icon marketplace"></div></a>
            <div class="content">
              <h3><?=$lang["circ_marketplace"]?></h3>
              <p><?=$lang["circ_marketplace_text"]?></p>
              <div style="font-size:32px; color:#da7e24; margin-top:10px;">
			  <a href='marketplace'><img width="50" src="images/icon_arrow_blue.png"></a></div>

            </div>
          </li>
        </ul>
  </section>
  
  <!--Trending Industries (6 industries, 4 products in each)-->
  <section class="trending-industries home-module">
    <div class="row">
      <div class="large-12 columns">
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
  
  <!--Testimonial-->
  <section id="testimonial" class="home-module">
    <div class="row">
      <div class="large-12 columns large-centered">
        <div class="large-7 columns">
          <div class="quote-container">
            <p class="quote">"<?=$lang["testimon_haseverything"]?>"</p>
            <p class="quote-author"><?=$lang["testimon_michaelsantos"]?> <span><?=$lang["testimon_nationalprodcomp"]?></span>
            </p>
          </div>
        </div>
        <div class="large-5 medium-12 columns">
          <img src="images/img_testimonial_man.jpg">
        </div>
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