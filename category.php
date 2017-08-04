<?php
/**
 * Шаблон рубрики (category.php)
 * @package WordPress
 * @subpackage your-clean-template-3
 */
get_header(); // подключаем header.php ?> 
<section>
    <h2 id="title"><?php single_cat_title(); // название категории ?></h2>
    <div class="content postSection">
        <!-- Центальный блок -->
        <div class="blog-content " id="headfside">

				<?php if (have_posts()) : while (have_posts()) : the_post(); // если посты есть - запускаем цикл wp ?>
					<?php get_template_part('loop'); // для отображения каждой записи берем шаблон loop.php ?>
				<?php endwhile; // конец цикла
				else: echo '<p>Нет записей.</p>'; endif; // если записей нет, напишим "простите" ?>	 
				<?php pagination(); // пагинация, функция нах-ся в function.php ?>
			</div>
        <?php get_sidebar(); // подключаем sidebar.php ?>

        </div>
    </div>
</section>
<?php get_footer(); // подключаем footer.php ?>