
<?php

/**

 * Astra Child Theme functions and definitions




/**

 * Define Constants

 */

define( 'CHILD_THEME_ASTRA_CHILD_VERSION', '1.0.0' );



/**

 * Enqueue styles

 */

function child_enqueue_styles() {



	wp_enqueue_style( 'astra-child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );



}



add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );

function add_custom_theme_style(){
	wp_enqueue_style( 'plantet_style_cst', get_stylesheet_directory_uri() . '/css/jogi_custom_style.css', 'all' );
	//wp_enqueue_style( 'plantet_style_cst', get_stylesheet_directory_uri() . '/planet_file/plantet_style.css', 'all' );

	wp_enqueue_script( 'jquery_min', get_stylesheet_directory_uri() . '/js/jquery.min.js', 'true' );
	wp_enqueue_script( 'jogi_csutom_script', get_stylesheet_directory_uri() . '/js/jogi_csutom_script.js', 'true' );
	wp_enqueue_script( 'isotpoe-pkgd', 'https://npmcdn.com/isotope-layout@2/dist/isotope.pkgd.js', 'true' );
	//wp_enqueue_script( 'plantet_script_cst', get_stylesheet_directory_uri() . '/planet_file/plantet_script.js', 'true' );
	
}
add_action( 'wp_enqueue_scripts', 'add_custom_theme_style');


function add_jogi_lord_planet(){
	$out = "";
    $out .= '<div id="universe" class="scale-stretched">
      <div id="galaxy">
        <div id="solar-system" class="earth">
          <div id="mercury" class="orbit">
            <div class="pos">
              <div class="planet">
                <dl class="infos">
                  <dt>Mercury</dt>
                  <dd><span></span></dd>
                </dl>
              </div>
            </div>
          </div>
          <div id="venus" class="orbit">
            <div class="pos">
              <div class="planet">
                <dl class="infos">
                  <dt>Venus</dt>
                  <dd><span></span></dd>
                </dl>
              </div>
            </div>
          </div>
          <div id="earth" class="orbit">
            <div class="pos">
             <!--  <div class="orbit">
               <div class="pos">
                  <div class="moon"></div>
                </div>
              </div> -->
              <div class="planet">
                <dl class="infos">
                  <dt>Moon</dt>
                  <dd><span></span></dd>
                </dl>
              </div>
            </div>
          </div>
          <div id="mars" class="orbit">
            <div class="pos">
              <div class="planet">
                <dl class="infos">
                  <dt>Mars</dt>
                  <dd><span></span></dd>
                </dl>
              </div>
            </div>
          </div>
          <div id="jupiter" class="orbit">
            <div class="pos">
              <div class="planet">
                <dl class="infos">
                  <dt>Jupiter</dt>
                  <dd><span></span></dd>
                </dl>
              </div>
            </div>
          </div>
          <div id="saturn" class="orbit">
            <div class="pos">
              <div class="planet">
                <div class="ring"></div>
                <dl class="infos">
                  <dt>Saturn</dt>
                  <dd><span></span></dd>
                </dl>
              </div>
            </div>
          </div>
          <div id="rahu" class="orbit">
            <div class="pos">
              <div class="planet">
			    <div class="ring"></div>
                <dl class="infos">
                  <dt>Rahu</dt>
                  <dd><span></span></dd>
                </dl>
              </div>
            </div>
          </div>
          <div id="ketu" class="orbit">
            <div class="pos">
              <div class="planet">
			    <div class="ring"></div>
                <dl class="infos">
                  <dt>Ketu</dt>
                  <dd><span></span></dd>
                </dl>
              </div>
            </div>
          </div>
          <div id="sun">
            <dl class="infos">
              <dt>Sun</dt>
              <dd><span></span></dd>
            </dl>
          </div>
        </div>
      </div>

  </div>';
 return $out;
}
add_shortcode('jogi_lord_planet_srt','add_jogi_lord_planet');


function jogi_home_banner(){
	$out = "";
	$out .= '<div class="wrapper">
		<!--Slider Start-->
			<div class="ast_slider_wrapper">
			   <div class="ast_banner_text">
			      <div class="ast_bannertext_wrapper">
					<div id="testimonials">
			        <ul>
						<li><h2>No better boat than astrology to cross the sea of life</h2></li>
						<li><h2>We can not change our destiny but can face it with precautions</h2></li>
						<li><h2>Nothing happens without a reason</h2></li>
			        </ul>
			    </div>
					    <ul class="ast_toppadder40 ast_bottompadder50">
			            <li>horoscopes</li>
			            <li>gemstones</li>
			            <li>Match-making</li>
			         </ul>
			         <a href="#scroll" class="ast_btn">Get now</a>
			      </div>
				  <div class="zodiac_sign_img_block">
					<img src="/wp-content/uploads/2022/01/astro_horoscope-1.png" class="rotate_img">
				  </div>
			   </div>
		</div>';
	return $out;

}
add_shortcode('jogi_home_banner_srt','jogi_home_banner');

/* Please remove this js file if you don't need the planet */
function add_footer_js(){
	
	?>
    <script type="text/javascript">
    if (typeof jQuery == 'undefined') { 
      document.write(unescape("%3Cscript src='js/jquery.min.js' type='text/javascript'%3E%3C/script%3E"));
    }
	
    </script>
	<?php
}
add_action('wp_footer','add_footer_js');
