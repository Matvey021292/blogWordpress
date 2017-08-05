<?php
/**
 * Шаблон формы поиска (searchform.php)
 * @package WordPress
 * @subpackage your-clean-template-3
 */
?>
<div class="content search ">
    <div class="breadcrumbs">
        <?php kama_breadcrumbs() ?>
    </div>
<div id="sb-search" class="sb-search">

    <form action="<?php echo home_url( '/' ); ?>">
        <input class="sb-search-input " placeholder="поиск..." type="text" value="<?php echo get_search_query() ?>" name="s" id="search">
        <input class="sb-search-submit " type="submit" value="">
        <span class="sb-icon-search">
            <i class="fa fa-search" aria-hidden="true"></i>
        </span>
    </form>
</div>
</div>