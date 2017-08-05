<?php
/**
 * Запись в цикле (loop.php)
 * @package WordPress
 * @subpackage your-clean-template-3
 */
?>
<div class="blog-content-news  effect6 id="post-<?php the_ID(); ?>" <?php post_class(); ?>> <?php // контэйнер с классами и id ?>
<h3 ><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3> <?php // заголовок поста и ссылка на его полное отображение (single.php) ?>
<span class="category_post">Категории: <?php the_category(',') ?></span> <?php // ссылки на категории в которых опубликован пост, через зпт ?>
<div class="flex-container">
    <div class="grid">
		<?php if ( has_post_thumbnail() ) { ?>
            <figure class="effect-zoe">
                  <?php the_post_thumbnail('full'); ?>
                <figcaption>
                    <h2 style="padding-right: 4px;"><i class="fa fa-calendar-o" aria-hidden="true"></i></h2>
                    <h2><span><?php  the_time(get_option('date_format')); ?> </span><?php the_time(get_option('time_format')); ?></h2>
                    <span><i class="fa fa-comment-o" aria-hidden="true"></i></span>
                    <span><h2 style="padding-right: 4px;"><?php comments_number(); ?></h2></span>
                    <a href="#">View more</a>
                </figcaption>
            </figure>
		<?php } ?>

    </div>
    <ul class="social-logo-icon">
        <li><a href=""><i class="fa fa-facebook-square" aria-hidden="true"></i></i></a></li>
        <li><a href=""><i class="fa fa-foursquare" aria-hidden="true"></i></a></li>
        <li><a href=""><i class="fa fa-map-marker" aria-hidden="true"></i></a></li>
        <li><a href=""><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
    </ul>
</div>
		<p>

			<?php the_content('Читать...'); // пост превью, до more ?>
		</p>

</div>