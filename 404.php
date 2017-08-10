<?php
/**
 * Страница 404 ошибки (404.php)
 * @package WordPress
 * @subpackage your-clean-template-3
 */
get_header(); // Подключаем header.php ?>
<section>
    <div class=" page404" >
        <div class="wrap-search">
            <div class="content-search">
                <div class="logo">
                    <h1><a href="#"><img src="<?php echo get_template_directory_uri() ?>/img/logo1.png"/></a></h1>
                    <span><img src="<?php echo get_template_directory_uri() ?>/img/signal.png"/>Oops! The Page you requested was not found!</span>
                </div>

                <div class="buttom" style="background:url(<?php echo get_template_directory_uri() ?>/img/bg2.png) no-repeat 100% 0%;">
                    <div class="seach_bar">
                        <p>you can go to <span><a href="<?php echo get_home_url(); ?>">home</a></span> page or search here</p>

                        <div class="search_box">
                            <form action="<?php echo home_url( '/' ); ?>">
                                <input type="text" value="Search" name="s"><input style="background: url(<?php echo get_template_directory_uri() ?>/img/search.png) no-repeat 0px 1px;" type="submit" value="" >
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

</section>

<?php get_footer(); // подключаем footer.php ?>