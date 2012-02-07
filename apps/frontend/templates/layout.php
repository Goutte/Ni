<?php // We supply a default layout with the apostrophePlugin which is great for ?>
<?php // both CMS and non-CMS pages because you can easily override every section ?>
<?php // via Symfony slots. We've put this require here to ensure that we don't ?>
<?php // accidentally let this copy get out of sync with the one in the plugin. ?>
<?php // YES, you may ABSOLUTELY replace this layout.php with your own. ?>
<?php //require sfConfig::get('sf_plugins_dir') . '/apostrophePlugin/modules/a/templates/layout.php' ?>
<!doctype html>
<?php use_helper('a') ?>
<?php $page = aTools::getCurrentNonAdminPage() ?>
<?php $realPage = aTools::getCurrentPage() ?>
<?php $root = aPageTable::retrieveBySlug('/') ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8">
  <base href="/" />

	<?php include_http_metas() ?>
	<?php include_metas() ?>

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="/favicon.ico">
	<link rel="apple-touch-icon" href="/apple-touch-icon.png">

	<?php include_title() ?>
  <?php a_include_stylesheets() ?>
	<?php a_include_javascripts() ?>

  <link href="css/style.css" rel="stylesheet" type="text/css" />
<!--  <script type="text/javascript" src="js/jquery-1.5.1.js"></script>-->
  <script type="text/javascript" src="js/imgbox.js"></script>
</head>

<?php $a_bodyclass = '' ?>
<?php $a_bodyclass .= (has_slot('a-body-class')) ? get_slot('a-body-class') : '' ?>
<?php $a_bodyclass .= (has_slot('body_class')) ? get_slot('body_class') : '' ?>
<?php $a_bodyclass .= ($page && $page->archived) ? ' a-page-unpublished' : '' ?>
<?php $a_bodyclass .= ($page && $page->view_is_secure) ? ' a-page-secure' : '' ?>
<?php $a_bodyclass .= ($page) ? ' a-page-id-'.$page->id.' a-page-depth-'.$page->level : '' ?>
<?php $a_bodyclass .= (sfConfig::get('app_a_js_debug', false)) ? ' js-debug':'' ?>
<?php $a_bodyclass .= ($realPage && !is_null($realPage['engine'])) ? ' a-engine':'' ?>
<?php $a_bodyclass .= ($sf_user->isAuthenticated()) ? ' logged-in':' logged-out' ?>

<body class="<?php echo $a_bodyclass ?>">

<div id="ni_wrap">

	<?php include_partial('a/doNotEdit') ?>

  <?php include_partial('a/globalTools') ?>

  <ul id="ni_menu" class="quicktrans">

    <li class="itm_side"></li>
    <li class="itm_cont"><a href="/"><span class="txt_menu_effect itm1">accueil</span><span class="txt_white">.</span></a></li>
    <li class="itm_cont"><a href="/le-groupe"><span class="txt_menu_effect itm2">le groupe</span><span class="txt_white">.</span></a></li>
    <li class="itm_cont"><a href="/concerts"><span class="txt_menu_effect itm3">concerts</span><span class="txt_white">.</span></a></li>
    <li class="itm_cont"><a href="/albums"><span class="txt_menu_effect itm4">albums</span><span class="txt_white">.</span></a></li>
    <li class="itm_cont"><a href="/contact"><span class="txt_menu_effect itm5">contact</span><span class="txt_white">.</span></a></li>
    <li class="itm_side"></li>

  </ul> <!-- FIN ni_menu -->

  <div id="top_wrapper">

      <div id="alice" class="eclatee">
      <div class="n1"></div><div class="n2"></div><div class="n3"></div><div class="n4"></div><div class="n5"></div>
          <div class="n6"></div><div class="n7"></div><div class="n8"></div><div class="n9"></div><div class="n10"></div>
          <div class="n11"></div><div class="n12"></div><div class="n13"></div>
      </div>

  	<div id="ni_logo"></div>

    <div id="img_box">

    	<div id="cache"></div>

      <div id="demoSliderContainer">

        <ul id="demoSlider" class="slide-images">
          <li class="slide-image">
            <img src="imgs/pics/ni_ben.jpg" />
            <span>Ben</span>
          </li>

          <li class="slide-image">
            <img src="imgs/pics/ni_scene.jpg" />
            <span>Scene</span>
          </li>
        </ul>

        <div class="options">
          <a href="javascript:;" class="prevSlide">prev</a>
          <span class="slide-pager">
            <a href="javascript:;">1</a>
            <a href="javascript:;">2</a>
            <a href="javascript:;">3</a>
            <a href="javascript:;">4</a>
          </span>
          <a href="javascript:;" class="nextSlide">next</a>
        </div>

      </div>

      <div id="options">
        <label for="transitionEffect">Transition effect :</label>
        <select id="transitionEffect">
          <option value="transition-opacity">opacity fade</option>
          <option value="transition-left">left slide</option>
        </select>
      </div>

    </div> <!-- FIN img_box -->

  </div> <!-- FIN top_wrapper -->


  <div id="content_wrap">

    <?php if (has_slot('a-page-header')): ?>
      <?php include_slot('a-page-header') ?>
    <?php endif; ?>

		<div id="main_box">
    	<div id="bx_top" class="<?php echo ($page && $page->getSlugTrimmed()) ? $page->getSlugTrimmed() : 'default' ?>"></div>
      <div id="bx_body">
        <?php echo $sf_data->getRaw('sf_content') ?>
      </div>

      <div id="bx_bottom"></div>
    </div>


    <div id="rgt_col">

    <div class="rgt_box_top" id="rgt_conc"></div>
    <div class="rgt_box_body">

    <?php if (has_slot('a-subnav')): ?>
			<?php include_slot('a-subnav') ?>
		<?php elseif ($page): ?>
			<?php //include_component('a', 'subnav', array('page' => $page)) # Subnavigation ?>
		<?php endif ?>

      <?php include_component('aEvent', 'subNavConcerts', array('page' => $page)) ?>
      
    </div>

    <!-- <div class="rgt_box_top" id="rgt_msc"></div>
    <div class="rgt_box_body"></div> -->

    <div class="rgt_box_top" id="rgt_scl"></div>
    <div class="rgt_box_body">
    	<img class="img_fb" src="imgs/soc_fb.png" width="202" height="97" alt="Rejoignez-nous sur Facebook !">
      <img class="img_mysp" src="imgs/soc_mysp.png" width="202" height="97" alt="Rejoignez-nous sur Myspace !">
      </div>

    </div>



    <div class="clearboth"></div>

    <div id="ni_btm">
      <p class="footer1 footer_txt">http://www.ni-music.com</p>
      <p class="footer2 footer_txt">Pour votre sécurité, n'essayez en aucun cas de mettre votre tête dans un sac plastique : les photos des artistes ont été réalisées sans trucage mais sous contrôle sécuritaire de la gendarmerie nationale. Les scies circulaires sont des objets létaux : usage déconseillé avant 8 ans.</p>
    </div>

	</div> <!-- FIN content_wrap -->


</div> <!-- FIN ni_wrap -->

<?php // Invokes apostrophe.smartCSS, your project level JS hook and a_include_js_calls ?>
<?php include_partial('a/globalJavascripts') ?>

</body>
</html>