<?php
/**
 * Шаблон отдельной записи (single.php)
 * @package WordPress
 * @subpackage your-clean-template-3
 */
get_header(); // подключаем header.php ?>
<?php get_template_part('breadcrumbs');?>
<section>
    <?php get_template_part('searchform');//хлебные крошки ?>
    <div class="content postSection postContent">
        <!-- Центальный блок -->
        <div class="blog-content center" id="headfside">
			<div class="blog-content-news one_bloc  effect6 <?php content_class_by_sidebar(); // функция подставит класс в зависимости от того есть ли сайдбар, лежит в functions.php ?>">
				<?php if ( have_posts() ) while ( have_posts() ) : the_post(); // старт цикла ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>> <?php // контэйнер с классами и id ?>
						<h3><?php the_title(); // заголовок поста ?></h3>
						<div class="meta">
							<p id="breadcrumbs-two" class="category_post "><a>Категории:</a> <?php the_category(' ') ?></p> <?php // ссылки на категории в которых опубликован пост, через зпт ?>
							<?php the_tags('<p>Тэги: ', ',', '</p>'); // ссылки на тэги поста ?>
						</div>
                        <div class="flex-container">
                            <div class="grid">
                        <?php if ( has_post_thumbnail() ) { ?>
                            <figure class="effect-zoe">
                                <?php the_post_thumbnail('full'); ?>
                            </figure>
                            <?php if(function_exists('the_ratings')) { the_ratings(); } ?>
                            <p>Опубликовано: <?php the_time(get_option('date_format')." в ".get_option('time_format')); ?></p> <?php // дата и время создания ?>
                        <?php } ?>
                            </div>
                        </div>
						<p><?php the_content(); // контент ?></p>
					</article>
				<?php endwhile; // конец цикла ?>
                <div class="buttom_row">

				<?php previous_post_link('%link', '<i class="fa fa-arrow-left" aria-hidden="true"></i> Предыдущий пост: %title', TRUE); // ссылка на предыдущий пост ?>
				<?php next_post_link('%link', 'Следующий пост: %title <i class="fa fa-arrow-right" aria-hidden="true"></i>', TRUE); // ссылка на следующий пост ?>
                </div>
				<?php if (comments_open() || get_comments_number()) comments_template('', true); // если комментирование открыто - мы покажем список комментариев и форму, если закрыто, но кол-во комментов > 0 - покажем только список комментариев ?>
			</div>


		</div>
        <?php get_sidebar(); // подключаем sidebar.php ?>
	</div>
    <?php echo do_shortcode("[pt_view id=bd4705dt5y]"); ?>
</section>
<?php get_footer(); // подключаем footer.php ?>
