<?php
/**
 * Шаблон подвала (footer.php)
 * @package WordPress
 * @subpackage your-clean-template-3
 */
?>
	<footer>

		 <div id="topNubex" ><i style="color:#fff" class="fa fa-arrow-circle-o-up fa-4x" aria-hidden="true"></i>

</div>
<div id="footernav">
    <?php    /**
        * Displays a navigation menu
        * @param array $args Arguments
        */

        $args = array(
            'theme_location' => 'top',
            'menu' => '',
            'container' => 'ul',
            'container_class' => '',
            'container_id' => '',
            'menu_class' => 'mainBootoom',
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
    
    <div class="logoText">
        <ul class="gridText">
            <li class="ot-letter-left"><span data-letter="K">K</span></li>
            <li class="ot-letter-bottom"><span data-letter="I">I</span></li>
            <li class="ot-letter-right"><span data-letter="E">E</span></li>
            <li class="ot-letter-bottom"><span data-letter="V">V</span></li>
        </ul>
    </div>
    <div class="social-container">
        <div class="links">
            <a href="#" data-type="twitter" data-url="http://sonnyt.com/prettySocial" data-description="Custom share buttons for Pinterest, Twitter, Facebook and Google Plus." data-via="sonnyt" class="prettySocial fa fa-twitter-square"></a>
            <a href="#" data-type="facebook" data-url="http://sonnyt.com/prettySocial" data-title="prettySocial - custom social share buttons." data-description="Custom share buttons for Pinterest, Twitter, Facebook and Google Plus." data-media="http://sonnyt.com/assets/imgs/prettySocial.png" class="prettySocial fa fa-facebook-square"></a>
            <a href="#" data-type="googleplus" data-url="http://sonnyt.com/prettySocial" data-description="Custom share buttons for Pinterest, Twitter, Facebook and Google Plus." class="prettySocial fa fa-google-plus-square"></a>
            <a href="#" data-type="pinterest" data-url="http://sonnyt.com/prettySocial" data-description="Custom share buttons for Pinterest, Twitter, Facebook and Google Plus." data-media="http://sonnyt.com/assets/imgs/prettySocial.png" class="prettySocial fa fa-pinterest-square"></a>
        </div>
    </div>
	</footer>
	</footer>
<?php wp_footer(); // необходимо для работы плагинов и функционала  ?>
</body>
</html>