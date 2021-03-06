<?php
/**
 * Страница с кастомным шаблоном (page-custom.php)
 * @package WordPress
 * @subpackage your-clean-template-3
 * Template Name: Главная страница
 */
get_header(); // подключаем header.php ?>

    <section>
        <div class="sale">
            <div class="wrapper" id="box">
                <div class=" box effect7">
                    <img src="<?php echo ot_get_option('logo_upload_sale'); ?>">
                    <div class="ribbon-wrapper-green">
                        <div class="ribbon-green">Sale</div>
                    </div>
                </div>
            </div>
            ​
        </div>
        <?php
        $sliders_main = get_post_meta($post->ID, 'main_slider_list', true);
        ?>
        <div class="hsldr-container">
            <ul>
                <?php
                foreach ($sliders_main as $slider) { ?>
                    <li>
                        <img src="<?php echo $slider[main_slider_list_upload] ?>"/>
                        <div class="caption"><?php echo $slider[main_slider_list_header] ?></div>
                    </li>
                <?php };
                ?>
            </ul>
        </div>
        <h2 id="title"><?php the_title(); // заголовок поста ?></h2>

            <?php get_template_part('searchform');//хлебные крошки ?>

        <div class="content postContent">
            <!-- Центальный блок -->
            <div class="blog-content center">
                <?php
                $art_cat = array(
                    'orderby' => 'name',
                    'order' => '123',
                    'hide_empty' => 1,
                    'exclude' => '17',
                    'include' => '',
                    'taxonomy' => 'category',
                    // полный список параметров смотрите в описании функции http://wp-kama.ru/function/get_terms
                );
                $categories = get_categories($art_cat);

                ?>

                <?php the_content(); // контент ?>
                <div class="<?php content_class_by_sidebar(); // функция подставит класс в зависимости от того есть ли сайдбар, лежит в functions.php ?>">

                </div>
                <?php

                if ($categories) {
                    foreach ($categories as $cat) {
                        $category =$cat->taxonomy;
                        $category.='/';
                        $category.=strtolower($cat->slug);
                        ?>

                        <div class="blog-content-news one_bloc  effect6">
                            <h3><a href="<?php echo ($category); ?>" class="effect-shine"><?php echo $cat->name; ?></a></h3>
                            <div class="blog-content">


                                <div class="blog-content-news">
                                    <div class="flex-container">
                                        <div class="grid">
                                            <figure class="effect-roxy">
                                                <?php $art_posts = array(
                                                    'orderby' => 'name',
                                                    'order' => 'ABC',
                                                    'orderby'=>'date',
                                                    'posts_per_page' => 1,
                                                    'post_type' => 'post',
                                                    'exclude' => '',
                                                    'post_status' => 'publish',
                                                    'cat' => $cat->cat_ID,

                                                    // полный список параметров смотрите в описании функции http://wp-kama.ru/function/get_terms
                                                );
                                                $query = new WP_Query($art_posts);

                                                global $more;

                                                ?>

                                                <?php if ($query->have_posts()) while ($query->have_posts()) :
                                                $query->the_post(); // старт цикла ?>

                                                <?php the_post_thumbnail('full') ?>
                                            </figure>
                                        </div>

                                        <ul class="social-logo-icon">
                                            <li><a href="https://www.facebook.com/"><i class="fa fa-facebook-square" aria-hidden="true"></i></i></a>
                                            </li>
                                            <li><a href=""><i class="fa fa-foursquare" aria-hidden="true"></i></a></li>
                                            <li><a href=""><i class="fa fa-map-marker" aria-hidden="true"></i></a></li>
                                            <li><a href=""><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                                        </ul>
                                    </div>
                                    <article
                                            id="post-<?php the_ID(); ?>" <?php post_class(); ?>> <?php // контэйнер с классами и id ?>
                                        <h4><a class="effect-shine"
                                               href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                    </article>
                                    <a href="<?php the_permalink();?>"><?php the_truncated_post( 200 );?></a>

                                    <?php $art_posts_news = array(
                                            'orderby' => 'name',
                                            'order' => 'DESC',
                                            'posts_per_page' => 3,
                                            'orderby'=>'date',
                                            'post_type' => 'post',
                                            'post_status' => 'publish',
                                            'exclude'=> '',
                                            'cat' => $cat->cat_ID,

                                            // полный список параметров смотрите в описании функции http://wp-kama.ru/function/get_terms
                                        );

                                        $query_new = new WP_Query($art_posts_news);

                                        ?>

                                </div>
                                <div class="blog-content">
                                    <?php if ($query_new->have_posts()) while ($query_new->have_posts()) : $query_new->the_post(); // старт цикла ?>
                                        <div class="blog-content-news effect6">
                                            <p>Опубликовано: <?php the_time(get_option('date_format')); ?></p> <?php // дата и время создания ?>

                                            <div class="flex-container">
                                                <a href="<?php the_permalink(); ?>" class="img"
                                                   id="img_news">    <?php the_post_thumbnail('full') ?></a>
                                            </div>
                                            <p style="padding-right: 4px;"><?php comments_number(); ?></p>
                                        </div>
                                    <?php endwhile;
                                    wp_reset_postdata(); // конец цикла ?>
                                </div>

                            </div>
                            <?php endwhile;
                            wp_reset_postdata(); // конец цикла
                            ?>
                        </div>

                        <?php
                    }
                } ?>
            </div>
            <?php get_sidebar(); // подключаем sidebar.php ?>
        </div>

        <section>
            <?php include'gallery.php'?>
        </section>
    </section>
    <section>
        <div class="column_about">
            <?php $the_quer = new WP_Query('p=381'); ?>
            <?php while  ($the_quer->have_posts() ) : $the_quer->the_post(); ?>

            <div class="grid">
                <figure class="effect-layla">
                    <?php the_post_thumbnail('full') ?>
                    <figcaption>
                    <h2><?php the_title(); ?></h2>
                    <p><?php the_content(); ?></p>
                    </figcaption>
                </figure>
            </div>
            <?php endwhile; ?>
            <?php wp_reset_postdata();?>






        </div>

    </section>

<?php get_footer(); // подключаем footer.php ?>

