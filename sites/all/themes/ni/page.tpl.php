<?php
  drupal_add_js('sites/all/themes/ni/js/ni.js');
  drupal_add_js('sites/all/themes/ni/js/jplayer.playlist.min.js');
  drupal_add_js('sites/all/themes/ni/js/jquery.jplayer.min.js');
  drupal_add_js('sites/all/themes/ni/js/jplayer.init.js');
?>

  <?php print render($page['header']); ?>

<div id="ni_wrap">

  <ul id="ni_menu" class="quicktrans">

    <li class="itm_side"></li>
    <li class="itm_cont i1"><a href="/"><span class="txt_menu_effect itm1">accueil</span><span class="txt_white">.</span></a></li>
    <li class="itm_cont i2"><a href="/le-groupe"><span class="txt_menu_effect itm2">le groupe</span><span class="txt_white">.</span></a></li>
    <li class="itm_cont i3"><a href="/concerts"><span class="txt_menu_effect itm3">concerts</span><span class="txt_white">.</span></a></li>
    <li class="itm_cont i4"><a href="/albums"><span class="txt_menu_effect itm4">albums</span><span class="txt_white">.</span></a></li>
    <li class="itm_cont i5"><a href="/contact"><span class="txt_menu_effect itm5">contact</span><span class="txt_white">.</span></a></li>
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
            <img src="sites/all/themes/ni/imgs/pics/ni_frben.jpg" />
          </li>

          <li class="slide-image">
            <img src="sites/all/themes/ni/imgs/pics/ni_antnic.jpg" />
          </li>

          <li class="slide-image">
            <img src="sites/all/themes/ni/imgs/pics/ni_fran.jpg" />
          </li>

          <li class="slide-image">
            <img src="sites/all/themes/ni/imgs/pics/ni_ben.jpg" />
          </li>

          <li class="slide-image">
            <img src="sites/all/themes/ni/imgs/pics/ni_nic.jpg" />
          </li>

          <li class="slide-image">
            <img src="sites/all/themes/ni/imgs/pics/ni_scene.jpg" />
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

		<div id="main_box">
    	<div id="bx_top" class="default"></div>
      <div id="bx_body">


        <div id="center"><div id="squeeze"><div class="right-corner"><div class="left-corner">
                  <a id="main-content"></a>
                  <?php if ($tabs): ?><div id="tabs-wrapper" class="clearfix"><?php endif; ?>
                  <?php print render($title_prefix); ?>
                  <?php print render($title_suffix); ?>
                  <?php if ($tabs): ?><?php print render($tabs); ?></div><?php endif; ?>
                  <?php print render($tabs2); ?>
                  <?php print $messages; ?>
                  <?php print render($page['help']); ?>
                  <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
                  <div class="clearfix">
                    <?php print render($page['content']); ?>
                  </div>
                  <?php print render($page['footer']); ?>
              </div></div></div></div> <!-- /.left-corner, /.right-corner, /#squeeze, /#center -->



      </div>

      <div id="bx_bottom"></div>
    </div>


    <div id="rgt_col">

    <div class="rgt_box_top" id="rgt_conc">
    </div>
    <div class="rgt_box_body">
      <?php print render($page['bloconcerts']); ?>
    </div>

    <div class="rgt_box_top" id="rgt_msc"></div>
    <div class="rgt_box_body">

      <div id="jquery_jplayer_1" class="jp-jplayer"></div>
        <div id="jp_container_1" class="jp-audio">
          <div class="jp-type-single">
            <div class="jp-gui jp-interface">
              <ul class="jp-controls">
                <li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
                <li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
                <li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
                <li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
                <li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
                <li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
              </ul>
              <div class="jp-progress">
                <div class="jp-seek-bar">
                  <div class="jp-play-bar"></div>
                </div>
              </div>
              <div class="jp-volume-bar">
                <div class="jp-volume-bar-value"></div>
              </div>
              <div class="jp-time-holder">
                <div class="jp-current-time"></div>
                <div class="jp-duration"></div>
                <ul class="jp-toggles">
                  <li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
                  <li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
                </ul>
              </div>
            </div>
            <div class="jp-title">
              <ul>
                <li>Bubble</li>
              </ul>
            </div>
            <div class="jp-no-solution">
              <span>Update Required</span>
              To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
            </div>
          </div>
        </div>

    </div>

    <div class="rgt_box_top" id="rgt_scl"></div>
    <div class="rgt_box_body">
    	<a href="#"><img class="img_fb" src="sites/all/themes/ni/imgs/soc_fb.png" width="202" height="97" alt="Rejoignez-nous sur Facebook !"></a>
      <a href="#"><img class="img_mysp" src="sites/all/themes/ni/imgs/soc_mysp.png" width="202" height="97" alt="Rejoignez-nous sur Myspace !"></a>
      </div>

    </div>

    <div class="clearboth"></div>

    <div id="ni_btm">
      <p class="footer1 footer_txt">http://www.ni-music.com</p>
      <p class="footer2 footer_txt">Pour votre sécurité, n'essayez en aucun cas de mettre votre tête dans un sac plastique : les photos des artistes ont été réalisées sans trucage mais sous contrôle sécuritaire de la gendarmerie nationale. Les scies circulaires sont des objets létaux : usage déconseillé avant 8 ans.</p>
    </div>

	</div> <!-- FIN content_wrap -->

</div> <!-- FIN ni_wrap -->