<?php
/**
 * Шаблон рубрики (category.php)
 * @package WordPress
 * @subpackage your-clean-template-3
 */
get_header(); // подключаем header.php ?>
<?php get_template_part('breadcrumbs');?>

<section>
    <h2 id="title"><?php single_cat_title(); // название категории ?></h2>
    <?php get_template_part('searchform');//хлебные крошки ?>
    <div class="content postSection postContent">
        <!-- Центальный блок -->
        <div class="blog-content center" id="headfside">

				<?php if (have_posts()) : while (have_posts()) : the_post(); // если посты есть - запускаем цикл wp ?>
					<?php get_template_part('loop'); // для отображения каждой записи берем шаблон loop.php ?>
				<?php endwhile; // конец цикла
				else: echo '<p>Нет записей.</p>'; endif; // если записей нет, напишим "простите" ?>	 
				<?php pagination(); // пагинация, функция нах-ся в function.php ?>
			</div>
        <?php get_sidebar(); // подключаем sidebar.php ?>

        </div>
</section>
<?php get_footer(); // подключаем footer.php ?>