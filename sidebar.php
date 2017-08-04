<?php
/**
 * Шаблон сайдбара (sidebar.php)
 * @package WordPress
 * @subpackage your-clean-template-3
 */
?>
<button id="responsleftTitle" class="leftTitle toggle-nav button button--wapasha button--text-thick button--text-upper button--size-s">Новое</button>
<div id="asideLeft" class="blog-content aside  effect6">
<?php if (is_active_sidebar( 'Sidebar' )) { // если в сайдбаре есть что выводить ?>


	<?php dynamic_sidebar('Sidebar'); // выводим сайдбар, имя определено в functions.php ?>


<?php } ?>

  <button id="responsrightTitle" class=" toggle-nav button button--wapasha button--text-thick button--text-upper button--size-s">популярное</button>
<div id="show" class=" blog-content aside_context effect6">
<?php if (is_active_sidebar( 'Sidebar-2' )) { // если в сайдбаре есть что выводить ?>


    <?php dynamic_sidebar('Sidebar-2'); // выводим сайдбар, имя определено в functions.php ?>

    </div>

<?php } ?>
</div>
