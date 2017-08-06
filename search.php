<?php
/**
 * Шаблон поиска (search.php)
 * @package WordPress
 * @subpackage your-clean-template-3
 */
get_header(); // подключаем header.php ?> 
<section>
    <?php get_template_part('searchform');//хлебные крошки ?>

    <div class="content postSection postContent">
        <div class="blog-content center  ">
            <div class=" blog-content-news one_bloc effect6">

        <h3><?php printf('Поиск по строке: %s', get_search_query()); // заголовок поиска ?></h3>

			<div class="<?php content_class_by_sidebar(); // функция подставит класс в зависимости от того есть ли сайдбар, лежит в functions.php ?>">
				<?php if (have_posts()) : while (have_posts()) : the_post(); // если посты есть - запускаем цикл wp ?>
					<?php get_template_part('loop'); // для отображения каждой записи берем шаблон loop.php ?>
				<?php endwhile; // конец цикла
				else: echo '<p>Нет записей.</p> '; endif; // если записей нет, напишим "простите" ?>
				<?php pagination(); // пагинация, функция нах-ся в function.php ?>
			</div>

		</div>
	</div>
        <?php get_sidebar(); // подключаем sidebar.php ?>

    </div>
</section>
<?php get_footer(); // подключаем footer.php ?>