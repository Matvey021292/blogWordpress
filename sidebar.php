<?php
/**
 * Шаблон сайдбара (sidebar.php)
 * @package WordPress
 * @subpackage your-clean-template-3
 */
?>
<button id="responsleftTitle" class="leftTitle toggle-nav button button--wapasha button--text-thick button--text-upper button--size-s"><?php echo ot_get_option( 'text_sidebar_left'); ?></button>
<button id="responsrightTitle" class=" toggle-nav button button--wapasha button--text-thick button--text-upper button--size-s"><?php echo ot_get_option( 'text_sidebar_right'); ?></button>
<div id="asideLeft" class="blog-content aside  effect6">
    <i class="fa fa-times closeaside" aria-hidden="true"></i>
<?php if (is_active_sidebar( 'Sidebar' )) { // если в сайдбаре есть что выводить ?>
    <h5 class="sidebat_title "><?php echo ot_get_option( 'text_sidebar_left'); ?></h5>
    <?php echo do_shortcode("[pt_view id=a0b6b7d8ve]"); ?>
	<?php dynamic_sidebar('Sidebar'); // выводим сайдбар, имя определено в functions.php ?>


<?php } ?>

<div id="asideRight" class=" blog-content aside_context effect6">
    <i class="fa fa-times closeaside closeasideRight" aria-hidden="true"></i>
<?php if (is_active_sidebar( 'Sidebar-2' )) { // если в сайдбаре есть что выводить ?>
    <h5 class="sidebat_title "><?php echo ot_get_option( 'text_sidebar_right'); ?></h5>

    <?php dynamic_sidebar('Sidebar-2'); // выводим сайдбар, имя определено в functions.php ?>

    </div>

<?php } ?>
</div>
