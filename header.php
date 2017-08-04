<?php
/**
 * Шаблон шапки (header.php)
 * @package WordPress
 * @subpackage your-clean-template-3
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); // вывод атрибутов языка ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); // кодировка ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<?php /* RSS и всякое */ ?>
	<link rel="alternate" type="application/rdf+xml" title="RDF mapping" href="<?php bloginfo('rdf_url'); ?>">
	<link rel="alternate" type="application/rss+xml" title="RSS" href="<?php bloginfo('rss_url'); ?>">
	<link rel="alternate" type="application/rss+xml" title="Comments RSS" href="<?php bloginfo('comments_rss2_url'); ?>">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php /* Все скрипты и стили теперь подключаются в functions.php */ ?>

	<!--[if lt IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<?php wp_head(); // необходимо для работы плагинов и функционала ?>
</head>
<body <?php body_class(); // все классы для body ?>>
	<header style="background-image:url('<?php echo ot_get_option( 'logo_upload'); ?>')">
    <section class="form">
    <div class="mockup-content">
                    <div class="morph-button morph-button-modal morph-button-modal-2 morph-button-fixed ">
                     <?php  if(ot_get_option('header_feedback_on_off') != 'off') { ?>
                        <button class="pulse-button" type="button"><a href="#header_feedback_form" class="pulse-buttonfeedback-form"><i class="fa-3x fa fa-phone " aria-hidden="true"></i></i></a></button>
                        <?php } ?>
                        <div class="morph-content">
                            <div>
                                <div class="content-style-form content-style-form-1">
                        <span class="icon icon-close"><i class="fa fa-times" aria-hidden="true"></i></span>
                                    <h2><a href="#header_feedback_form" class="feedback-form"><?php echo ot_get_option('header_feedback_title'); ?></a></h2>
                                     <?php if(ot_get_option('header_feedback_form')) { ?>
                                     <label for=""><p><?php echo do_shortcode(ot_get_option('header_feedback_form')); ?></p></label>
                                       <?php } ?>

</div>
                            </div>
                        </div>
                    </div><!-- morph-button -->
                    
                </div><!-- /form-mockup -->
<!-- form itself -->

        
    </section>

<nav id="sticky" class="" style="height: 0">
 <?php     /**
        * Displays a navigation menu
        * @param array $args Arguments
        */
        $args = array(
            'theme_location' => 'top',
            'menu' => '',
            'container' => 'nav',
            'container_class' => '',
            'container_id' => 'sticky',
            'menu_class' => '',
            'menu_id' => '',
            'echo' => true,
            'fallback_cb' => 'wp_page_menu',
            'before' => '',
            'after' => '',
            'link_before' => '',
            'link_after' => '',
            'items_wrap' => '<ul id = "%1$s" class = "%2$s">%3$s</ul>',
            'depth' => 0,
            'walker' => ''
        );
    
        wp_nav_menu( $args ); ?> 
 
    <div class="button">
        <a class="btn-open" href="#"></a>
    </div>
</nav>
<div class="overlay">

    <div class="wrap">
  <?php    /**
        * Displays a navigation menu
        * @param array $args Arguments
        */
        $args = array(
            'theme_location' => 'top',
            'menu' => '',
            'container' => 'ul',
            'container_class' => 'wrap',
            'container_id' => '',
            'menu_class' => 'wrap-nav',
            'menu_id' => '',
            'echo' => true,
            'fallback_cb' => 'wp_page_menu',
            'before' => '',
            'after' => '',
            'link_before' => '',
            'link_after' => '',
            'items_wrap' => '<ul id = "%1$s" class = "%2$s">%3$s</ul>',
            'depth' => 0,
            'walker' => ''
        );
    
        wp_nav_menu( $args ); ?>
        
        <div class="social">
            <a href="http://mario-loncarek.from.hr/">
                <div class="social-icon">
                    <i class="fa fa-facebook"></i>
                </div>
            </a>
            <a href="#">
                <div class="social-icon">
                    <i class="fa fa-twitter"></i>
                </div>
            </a>
            <a href="#">
                <div class="social-icon">
                    <i class="fa fa-codepen"></i>
                </div>
            </a>
        </div>
    </div>
</div>
           
</div>
	</header>
	<section>
              <div class="textKiev">
    <h1>
  <span
     class="txt-rotate"
     data-period="2000"
     data-rotate='[ "Иной путь к сердцу Киева",
      "נתיב שונה בלב קייב",
       "Another way to the heart of Kiev",
        "Иной путь к сердцу Киева",
         "Иной путь к сердцу Киева" ]'></span>
</h1>
</div>
<div class="social-container">
    <div class="links">
        <a href="#" data-type="twitter" data-url="http://sonnyt.com/prettySocial" data-description="Custom share buttons for Pinterest, Twitter, Facebook and Google Plus." data-via="sonnyt" class="prettySocial fa fa-twitter"></a>
        <a href="#" data-type="facebook" data-url="http://sonnyt.com/prettySocial" data-title="prettySocial - custom social share buttons." data-description="Custom share buttons for Pinterest, Twitter, Facebook and Google Plus." data-media="http://sonnyt.com/assets/imgs/prettySocial.png" class="prettySocial fa fa-facebook"></a>
        <a href="#" data-type="googleplus" data-url="http://sonnyt.com/prettySocial" data-description="Custom share buttons for Pinterest, Twitter, Facebook and Google Plus." class="prettySocial fa fa-google-plus"></a>
        <a href="#" data-type="pinterest" data-url="http://sonnyt.com/prettySocial" data-description="Custom share buttons for Pinterest, Twitter, Facebook and Google Plus." data-media="http://sonnyt.com/assets/imgs/prettySocial.png" class="prettySocial fa fa-pinterest"></a>
        <a href="#" data-type="linkedin" data-url="http://sonnyt.com/prettySocial" data-title="prettySocial - custom social share buttons." data-description="Custom share buttons for Pinterest, Twitter, Facebook and Google Plus." data-via="sonnyt" data-media="http://sonnyt.com/assets/imgs/prettySocial.png" class="prettySocial fa fa-linkedin"></a>
    </div>
</div>

        </section>