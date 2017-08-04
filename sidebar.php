<?php
/**
 * Шаблон сайдбара (sidebar.php)
 * @package WordPress
 * @subpackage your-clean-template-3
 */
?>
<button id="responsleftTitle" class="leftTitle toggle-nav button button--wapasha button--text-thick button--text-upper button--size-s">Новое</button>
<div id="show_block" class="blog-content aside  effect6">
<?php if (is_active_sidebar( 'sidebar' )) { // если в сайдбаре есть что выводить ?>


	<?php dynamic_sidebar('sidebar'); // выводим сайдбар, имя определено в functions.php ?>


<?php } ?>
</div>`	