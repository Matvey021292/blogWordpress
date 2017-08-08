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

	</footer>
	</footer>
<?php wp_footer(); // необходимо для работы плагинов и функционала  ?>
</body>
</html>