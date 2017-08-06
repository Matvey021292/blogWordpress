<?php

/**
 *
 * Required: set ‘ot_theme_mode’ filter to true.
 */
add_filter('ot_theme_mode', '__return_true');
/**
 */
add_filter('ot_show_new_layout', '__return_false');

/**
 *
 * Required: include OptionTree.
 */
require(trailingslashit(get_template_directory()) . 'option-tree/ot-loader.php');
require(trailingslashit(get_template_directory()) . 'template/meta-boxes.php');
require(trailingslashit(get_template_directory()) . 'template/theme-options.php');
/**
 * Функции шаблона (function.php)
 * @package WordPress
 * @subpackage your-clean-template-3
 */
function content($limit)
{
    $content = explode(' ', get_the_content(), $limit);
    if (count($content) >= $limit) {
        array_pop($content);
        $content = implode(" ", $content) . '...';
    } else {
        $content = implode(" ", $content);
    }
    $content = preg_replace('/\[.+\]/', '', $content);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    return $content;
}

add_theme_support('title-tag'); // теперь тайтл управляется самим вп

register_nav_menus(array( // Регистрируем 2 меню
    'top' => 'Верхнее', // Верхнее
));

add_theme_support('post-thumbnails'); // включаем поддержку миниатюр
set_post_thumbnail_size(250, 150); // задаем размер миниатюрам 250x150
add_image_size('big-thumb', 80, 100, true); // добавляем еще один размер картинкам 400x400 с обрезкой

register_sidebars($number = 2,array( // регистрируем левую колонку, этот кусок можно повторять для добавления новых областей для виджитов
    'name' => 'Сайдбар %d', // Название в админке
    'id' => "sidebar", // идентификатор для вызова в шаблонах
    'description' => 'Обычная колонка в сайдбаре', // Описалово в админке
    'before_widget' => '', // разметка до вывода каждого виджета
    'after_widget' => "</div>\n", // разметка после вывода каждого виджета
    'before_title' => '', //  разметка до вывода заголовка виджета
    'after_title' => "</span>\n", //  разметка после вывода заголовка виджета
));



if (!class_exists('clean_comments_constructor')) { // если класс уже есть в дочерней теме - нам не надо его определять
    class clean_comments_constructor extends Walker_Comment
    { // класс, который собирает всю структуру комментов
        public function start_lvl(&$output, $depth = 0, $args = array())
        { // что выводим перед дочерними комментариями
            $output .= '<ul class="children">' . "\n";
        }

        public function end_lvl(&$output, $depth = 0, $args = array())
        { // что выводим после дочерних комментариев
            $output .= "</ul><!-- .children -->\n";
        }

        protected function comment($comment, $depth, $args)
        { // разметка каждого комментария, без закрывающего </li>!
            $classes = implode(' ', get_comment_class()) . ($comment->comment_author_email == get_the_author_meta('email') ? ' author-comment' : ''); // берем стандартные классы комментария и если коммент пренадлежит автору поста добавляем класс author-comment
            echo '<li id="comment-' . get_comment_ID() . '" class="' . $classes . ' media">' . "\n"; // родительский тэг комментария с классами выше и уникальным якорным id
            echo '<div class="media-left">' . get_avatar($comment, 64, '', get_comment_author(), array('class' => 'media-object')) . "</div>\n"; // покажем аватар с размером 64х64
            echo '<div class="media-body">';
            echo '<span class="meta media-heading">Автор: ' . get_comment_author() . "\n"; // имя автора коммента
            //echo ' '.get_comment_author_email(); // email автора коммента, плохой тон выводить почту
            echo ' ' . get_comment_author_url(); // url автора коммента
            echo ' Добавлено ' . get_comment_date('F j, Y в H:i') . "\n"; // дата и время комментирования
            if ('0' == $comment->comment_approved) echo '<br><em class="comment-awaiting-moderation">Ваш комментарий будет опубликован после проверки модератором.</em>' . "\n"; // если комментарий должен пройти проверку
            echo "</span>";
            comment_text() . "\n"; // текст коммента
            $reply_link_args = array( // опции ссылки "ответить"
                'depth' => $depth, // текущая вложенность
                'reply_text' => 'Ответить', // текст
                'login_text' => 'Вы должны быть залогинены' // текст если юзер должен залогинеться
            );
            echo get_comment_reply_link(array_merge($args, $reply_link_args)); // выводим ссылку ответить
            echo '</div>' . "\n"; // закрываем див
        }

        public function end_el(&$output, $comment, $depth = 0, $args = array())
        { // конец каждого коммента
            $output .= "</li><!-- #comment-## -->\n";
        }
    }
}

if (!function_exists('pagination')) { // если ф-я уже есть в дочерней теме - нам не надо её определять
    function pagination()
    { // функция вывода пагинации
        global $wp_query; // текущая выборка должна быть глобальной
        $big = 999999999; // число для замены
        $links = paginate_links(array( // вывод пагинации с опциями ниже
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))), // что заменяем в формате ниже
            'format' => '?paged=%#%', // формат, %#% будет заменено
            'current' => max(1, get_query_var('paged')), // текущая страница, 1, если $_GET['page'] не определено
            'type' => 'array', // нам надо получить массив
            'prev_text' => 'Prev', // текст назад
            'next_text' => 'Next', // текст вперед
            'total' => $wp_query->max_num_pages, // общие кол-во страниц в пагинации
            'show_all' => false, // не показывать ссылки на все страницы, иначе end_size и mid_size будут проигнорированны
            'end_size' => 15, //  сколько страниц показать в начале и конце списка (12 ... 4 ... 89)
            'mid_size' => 15, // сколько страниц показать вокруг текущей страницы (... 123 5 678 ...).
            'add_args' => false, // массив GET параметров для добавления в ссылку страницы
            'add_fragment' => '',    // строка для добавления в конец ссылки на страницу
            'before_page_number' => '', // строка перед цифрой
            'after_page_number' => '' // строка после цифры
        ));
        if (is_array($links)) { // если пагинация есть

            echo '<ul class="cd-pagination no-space animated-buttons custom-icons">';
            foreach ($links as $link) {
                if (strpos($link, 'current') !== false) echo "<li class='current'>$link</li>"; // если это активная страница
                else echo "<li>$link</li>";
            }
            echo '</ul>';

        }
    }
}

add_action('wp_footer', 'add_scripts'); // приклеем ф-ю на добавление скриптов в футер
if (!function_exists('add_scripts')) { // если ф-я уже есть в дочерней теме - нам не надо её определять
    function add_scripts()
    { // добавление скриптов
        if (is_admin()) return false; // если мы в админке - ничего не делаем
        wp_deregister_script('jquery'); // выключаем стандартный jquery
        wp_enqueue_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js', '', '', true); // добавляем свой
        wp_enqueue_script('slider', get_template_directory_uri() . '/js/js/components/jquery.hslider.js', '', '', true); //lloader
        wp_enqueue_script('sliderpost', get_template_directory_uri() . '/js/js/components/slider.js', '', '', true); //lloader
        wp_enqueue_script('loadMain', get_template_directory_uri() . '/js/js/components/navmain.js', '', '', true); //lloader
        wp_enqueue_script('http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js', '', '', true); // добавляем свой
        wp_enqueue_script('paralax', get_template_directory_uri() . '/js/js/components/parallax.min.js', '', '', true); //lloader
        wp_enqueue_script('Imgloaded', get_template_directory_uri() . '/js/js/components/imagesloaded.pkgd.min.js', '', '', true); //lloader
        // wp_enqueue_script('https://maps.googleapis.com/maps/api/js?key=AIzaSyDYDsaHdwINMUwooo_yfVbJhABBiuvQ4cw','','',true); // добавляем свой
        // wp_enqueue_script('Main', get_template_directory_uri().'/js/js/components/main.js','','',true); //lloader
        wp_enqueue_script('Modernizm', get_template_directory_uri() . '/js/js/components/modernizr.js', '', '', true); //lloader
        wp_enqueue_script('jquery3', '//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js', '', '', true); // добавляем свой
        wp_enqueue_script('Social', get_template_directory_uri() . '/js/js/jquery.prettySocial.min.js', '', '', true); //lloader
        wp_enqueue_script('SocialIcon', get_template_directory_uri() . '/js/js/components/socialicon.js', '', '', true); //lloader
        wp_enqueue_script('textEfext', get_template_directory_uri() . '/js/js/components/textEfext.js', '', '', true); //lloader
        wp_enqueue_script('pocupmod', get_template_directory_uri() . '/js/js/modal/modernizr.custom.js', '', '', true); //Popup
        wp_enqueue_script('pocupcus', get_template_directory_uri() . '/js/js/modal/classie.js', '', '', true); //Popup
        wp_enqueue_script('pocup', get_template_directory_uri() . '/js/js/modal/uiMorphingButton_fixed.js', '', '', true); //Popup
        wp_enqueue_script('gallerymodernizr', get_template_directory_uri() . '/js/js/gallery/modernizr.custom.js', '', '', true); //gallery
        wp_enqueue_script('galleryimagesloaded', get_template_directory_uri() . '/js/js/gallery/imagesloaded.pkgd.min.js', '', '', true); //gallery
        wp_enqueue_script('gallerymasonry', get_template_directory_uri() . '/js/js/gallery/masonry.pkgd.min.js', '', '', true); //gallery
        wp_enqueue_script('galleryclassie', get_template_directory_uri() . '/js/js/gallery/classie.js', '', '', true); //gallery
        wp_enqueue_script('gallery', get_template_directory_uri() . '/js/js/gallery/cbpGridGallery.js', '', '', true); //gallery
        wp_enqueue_script('searchcustom', get_template_directory_uri() . '/js/js/search/modernizr.customSearch.js', '', '', true); //gallery
        wp_enqueue_script('search', get_template_directory_uri() . '/js/js/search/classieSearch.js', '', '', true); //gallery
        wp_enqueue_script('custom', get_template_directory_uri() . '/js/js/custom.js', '', '', true); //lloader

    }
}

add_action('wp_print_styles', 'add_styles'); // приклеем ф-ю на добавление стилей в хедер
if (!function_exists('add_styles')) { // если ф-я уже есть в дочерней теме - нам не надо её определять
    function add_styles()
    { // добавление стилей
        if (is_admin()) return false; // если мы в админке - ничего не делаем
        wp_enqueue_style('font_awesome', get_template_directory_uri() . '/css/font-awesome.min.css'); // бутстрап
        wp_enqueue_style('style', get_template_directory_uri() . '/style.css'); // основные стили шаблона
        wp_enqueue_style('styles', get_template_directory_uri() . '/styles.css'); // основные стили шаблона

    }
}
function font_awesome()
{
    if (!is_admin()) {
        wp_register_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css');
        wp_enqueue_style('font-awesome');
    }
}


function load_fonts()
{
    wp_register_style('et-googleFonts',
        'https://fonts.googleapis.com/css?family=Oswald:200,300,400,500,600,700&subset=cyrillic,latin-ext,vietnamese');
    wp_enqueue_style('et-googleFonts');
    wp_register_style('et-googleFontsItalic',
        'https://fonts.googleapis.com/css?family=Marck+Script&subset=cyrillic,latin-ext');
    wp_enqueue_style('et-googleFontsItalic');
    wp_register_style('et-googleFontsUbuntu',
        'https://fonts.googleapis.com/css?family=Ubuntu:300,300i,400,400i,500,500i,700,700i&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext');
    wp_enqueue_style('et-googleFontsUbuntu');
    wp_register_style('et-googleFontsJuru',
        'https://fonts.googleapis.com/css?family=Jura:300,400,500,600,700&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese');
    wp_enqueue_style('et-googleFontsJuru');
    wp_register_style('et-googleFontsRobo',
        'https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese');
    wp_enqueue_style('et-googleFontsRobo');

}

add_action('wp_print_styles', 'load_fonts');
if (!function_exists('content_class_by_sidebar')) { // если ф-я уже есть в дочерней теме - нам не надо её определять
    function content_class_by_sidebar()
    { // функция для вывода класса в зависимости от существования виджетов в сайдбаре
        if (is_active_sidebar('sidebar')) { // если есть
            echo ''; // пишем класс на 80% ширины
        } else { // если нет
            echo ''; // контент на всю ширину
        }
    }
}
remove_filter('the_content', 'wp_make_content_images_responsive');
remove_filter('the_content', 'wpautop'); // Отключаем автоформатирование в полном посте
remove_filter('the_excerpt', 'wpautop'); // Отключаем автоформатирование в кратком(анонсе) посте
remove_filter('comment_text', 'wpautop'); // Отключаем автоформатирование в комментариях

function sidebar_news_func($atts)
{
    wp_reset_query();
    $art_posts = array(
        'orderby' => 'date',
        'order' => 'ASC',
        'posts_per_page' => 5,
        'post_type' => 'post',
    );
    $query = new WP_Query($art_posts);
    $output = "<h5 class='titleaside'>{$atts['title']}</h5>";
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $output .= '<div class="blog-content-news  ">';
            $output .= '<h3 ><a  href="' . get_the_permalink() . '">' . get_the_title() . '</a></h3>
                <div class="flex-container">
                    <div class="">
                        <figure class=>' . get_the_post_thumbnail() . '</figure>
                    </div>
                   
                </div>
                
                <a class="more " href="' . get_the_permalink() . '">Читать...</a>
            </div>';
        }
    }
    wp_reset_postdata();
    ?>

    <?php
    return $output;
}

add_shortcode('sidebar_news', 'sidebar_news_func');



//breadcrumbs


/**
 * Хлебные крошки для WordPress (breadcrumbs)
 *
 * @param  string [$sep  = '']      Разделитель. По умолчанию '  '
 * @param  array  [$l10n = array()] Для локализации. См. переменную $default_l10n.
 * @param  array  [$args = array()] Опции. См. переменную $def_args
 * @return string Выводит на экран HTML код
 *
 * version 3.3.1
 */
function kama_breadcrumbs( $sep = ' ', $l10n = array(), $args = array() ){
    $kb = new Kama_Breadcrumbs;
    echo $kb->get_crumbs( $sep, $l10n, $args );
}

class Kama_Breadcrumbs {

    public $arg;

    // Локализация
    static $l10n = array(
        'home'       => '<i class="fa fa-home" aria-hidden="true"></i>Главная',
        'paged'      => 'Страница %d',
        '_404'       => 'Ошибка 404',
        'search'     => '',
        'author'     => 'Архив автора: <b>%s</b>',
        'year'       => 'Архив за <b>%d</b> год',
        'month'      => 'Архив за: <b>%s</b>',
        'day'        => '',
        'attachment' => 'Медиа: %s',
        'tag'        => 'Записи по метке: <b>%s</b>',
        'tax_tag'    => '%1$s из "%2$s" по тегу: <b>%3$s</b>',
        // tax_tag выведет: 'тип_записи из "название_таксы" по тегу: имя_термина'.
        // Если нужны отдельные холдеры, например только имя термина, пишем так: 'записи по тегу: %3$s'
    );

    // Параметры по умолчанию
    static $args = array(
        'on_front_page'   => true,  // выводить крошки на главной странице
        'show_post_title' => true,  // показывать ли название записи в конце (последний элемент). Для записей, страниц, вложений
        'show_term_title' => true,  // показывать ли название элемента таксономии в конце (последний элемент). Для меток, рубрик и других такс
        'title_patt'      => '<span class="current"> <a href="#">%s</a></span>', // шаблон для последнего заголовка. Если включено: show_post_title или show_term_title
        'last_sep'        => true,  // показывать последний разделитель, когда заголовок в конце не отображается
        'markup'          => 'schema.org', // 'markup' - микроразметка. Может быть: 'rdf.data-vocabulary.org', 'schema.org', '' - без микроразметки
        // или можно указать свой массив разметки:
        // array( 'wrappatt'=>'<div class="kama_breadcrumbs">%s</div>', 'linkpatt'=>'<a href="%s">%s</a>', 'sep_after'=>'', )
        'priority_tax'    => array('category'), // приоритетные таксономии, нужно когда запись в нескольких таксах
        'priority_terms'  => array(), // 'priority_terms' - приоритетные элементы таксономий, когда запись находится в нескольких элементах одной таксы одновременно.
        // Например: array( 'category'=>array(45,'term_name'), 'tax_name'=>array(1,2,'name') )
        // 'category' - такса для которой указываются приор. элементы: 45 - ID термина и 'term_name' - ярлык.
        // порядок 45 и 'term_name' имеет значение: чем раньше тем важнее. Все указанные термины важнее неуказанных...
        'nofollow' => false, // добавлять rel=nofollow к ссылкам?

        // служебные
        'sep'             => '',
        'linkpatt'        => '',
        'pg_end'          => '',
    );

    function get_crumbs( $sep, $l10n, $args ){
        global $post, $wp_query, $wp_post_types;

        self::$args['sep'] = $sep;

        // Фильтрует дефолты и сливает
        $loc = (object) array_merge( apply_filters('kama_breadcrumbs_default_loc', self::$l10n ), $l10n );
        $arg = (object) array_merge( apply_filters('kama_breadcrumbs_default_args', self::$args ), $args );



        // упростим
        $sep = & $arg->sep;
        $this->arg = & $arg;

        // микроразметка ---
        if(1){
            $mark = & $arg->markup;

            // Разметка по умолчанию
            if( ! $mark ) $mark = array(
                'wrappatt'  => '<div id="breadcrumbs-two" class="kama_breadcrumbs ">%s</div>',
                'linkpatt'  => '<a href="%s ">%s</a>',
                'sep_after' => '',
            );
            // rdf
            elseif( $mark === 'rdf.data-vocabulary.org' ) $mark = array(
                'wrappatt'   => '<div id="breadcrumbs-two" class="kama_breadcrumbs " prefix="v: http://rdf.data-vocabulary.org/#">%s</div>',
                'linkpatt'   => '<span typeof="v:Breadcrumb "><a href="%s" rel="v:url" property="v:title">%s</a>',
                'sep_after'  => '</span>', // закрываем span после разделителя!
            );
            // schema.org
            elseif( $mark === 'schema.org' ) $mark = array(
                'wrappatt'   => '<div id="breadcrumbs-two" class="kama_breadcrumbs " itemscope itemtype="http://schema.org/BreadcrumbList">%s</div>',
                'linkpatt'   => '<span itemprop="itemListElement " itemscope itemtype="http://schema.org/ListItem"><a href="%s" itemprop="item"><span itemprop="name">%s</span></a></span>',
                'sep_after'  => '',
            );

            elseif( ! is_array($mark) )
                die( __CLASS__ .': "markup" parameter must be array...');

            $wrappatt  = $mark['wrappatt'];
            $arg->linkpatt  = $arg->nofollow ? str_replace('<a ','<a rel="nofollow"', $mark['linkpatt']) : $mark['linkpatt'];
            $arg->sep      .= $mark['sep_after']."\n";
        }

        $linkpatt = $arg->linkpatt; // упростим

        $q_obj = get_queried_object();

        // может это архив пустой таксы?
        $ptype = null;
        if( empty($post) ){
            if( isset($q_obj->taxonomy) )
                $ptype = & $wp_post_types[ get_taxonomy($q_obj->taxonomy)->object_type[0] ];
        }
        else $ptype = & $wp_post_types[ $post->post_type ];

        // paged
        $arg->pg_end = '';
        if( ($paged_num = get_query_var('paged')) || ($paged_num = get_query_var('page')) )
            $arg->pg_end = $sep . sprintf( $loc->paged, (int) $paged_num );

        $pg_end = $arg->pg_end; // упростим

        // ну, с богом...
        $out = '';

        if( is_front_page() ){
            return $arg->on_front_page ? sprintf( $wrappatt, ( $paged_num ? sprintf($linkpatt, get_home_url(), $loc->home) . $pg_end : $loc->home ) ) : '';
        }
        // страница записей, когда для главной установлена отдельная страница.
        elseif( is_home() ) {
            $out = $paged_num ? ( sprintf( $linkpatt, get_permalink($q_obj), esc_html($q_obj->post_title) ) . $pg_end ) : esc_html($q_obj->post_title);
        }
        elseif( is_404() ){
            $out = $loc->_404;
        }
        elseif( is_search() ){
            $out = sprintf( $loc->search, esc_html( $GLOBALS['s'] ) );
        }
        elseif( is_author() ){
            $tit = sprintf( $loc->author, esc_html($q_obj->display_name) );
            $out = ( $paged_num ? sprintf( $linkpatt, get_author_posts_url( $q_obj->ID, $q_obj->user_nicename ) . $pg_end, $tit ) : $tit );
        }
        elseif( is_year() || is_month() || is_day() ){
            $y_url  = get_year_link( $year = get_the_time('Y') );

            if( is_year() ){
                $tit = sprintf( $loc->year, $year );
                $out = ( $paged_num ? sprintf($linkpatt, $y_url, $tit) . $pg_end : $tit );
            }
            // month day
            else {
                $y_link = sprintf( $linkpatt, $y_url, $year);
                $m_url  = get_month_link( $year, get_the_time('m') );

                if( is_month() ){
                    $tit = sprintf( $loc->month, get_the_time('F') );
                    $out = $y_link . $sep . ( $paged_num ? sprintf( $linkpatt, $m_url, $tit ) . $pg_end : $tit );
                }
                elseif( is_day() ){
                    $m_link = sprintf( $linkpatt, $m_url, get_the_time('F'));
                    $out = $y_link . $sep . $m_link . $sep . get_the_time('l');
                }
            }
        }
        // Древовидные записи
        elseif( is_singular() && $ptype->hierarchical ){
            $out = $this->_add_title( $this->_page_crumbs($post), $post );
        }
        // Таксы, плоские записи и вложения
        else {
            $term = $q_obj; // таксономии

            // определяем термин для записей (включая вложения attachments)
            if( is_singular() ){
                // изменим $post, чтобы определить термин родителя вложения
                if( is_attachment() && $post->post_parent ){
                    $save_post = $post; // сохраним
                    $post = get_post($post->post_parent);
                }

                // учитывает если вложения прикрепляются к таксам древовидным - все бывает :)
                $taxonomies = get_object_taxonomies( $post->post_type );
                // оставим только древовидные и публичные, мало ли...
                $taxonomies = array_intersect( $taxonomies, get_taxonomies( array('hierarchical' => true, 'public' => true) ) );

                if( $taxonomies ){
                    // сортируем по приоритету
                    if( ! empty($arg->priority_tax) ){
                        usort( $taxonomies, function($a,$b)use($arg){
                            $a_index = array_search($a, $arg->priority_tax);
                            if( $a_index === false ) $a_index = 9999999;

                            $b_index = array_search($b, $arg->priority_tax);
                            if( $b_index === false ) $b_index = 9999999;

                            return ( $b_index === $a_index ) ? 0 : ( $b_index < $a_index ? 1 : -1 ); // меньше индекс - выше
                        } );
                    }

                    // пробуем получить термины, в порядке приоритета такс
                    foreach( $taxonomies as $taxname ){
                        if( $terms = get_the_terms( $post->ID, $taxname ) ){
                            // проверим приоритетные термины для таксы
                            $prior_terms = & $arg->priority_terms[ $taxname ];
                            if( $prior_terms && count($terms) > 2 ){
                                foreach( (array) $prior_terms as $term_id ){
                                    $filter_field = is_numeric($term_id) ? 'term_id' : 'slug';
                                    $_terms = wp_list_filter( $terms, array($filter_field=>$term_id) );

                                    if( $_terms ){
                                        $term = array_shift( $_terms );
                                        break;
                                    }
                                }
                            }
                            else
                                $term = array_shift( $terms );

                            break;
                        }
                    }
                }

                if( isset($save_post) ) $post = $save_post; // вернем обратно (для вложений)
            }

            // вывод

            // все виды записей с терминами или термины
            if( $term && isset($term->term_id) ){
                $term = apply_filters('kama_breadcrumbs_term', $term );

                // attachment
                if( is_attachment() ){
                    if( ! $post->post_parent )
                        $out = sprintf( $loc->attachment, esc_html($post->post_title) );
                    else {
                        if( ! $out = apply_filters('attachment_tax_crumbs', '', $term, $this ) ){
                            $_crumbs    = $this->_tax_crumbs( $term, 'self' );
                            $parent_tit = sprintf( $linkpatt, get_permalink($post->post_parent), get_the_title($post->post_parent) );
                            $_out = implode( $sep, array($_crumbs, $parent_tit) );
                            $out = $this->_add_title( $_out, $post );
                        }
                    }
                }
                // single
                elseif( is_single() ){
                    if( ! $out = apply_filters('post_tax_crumbs', '', $term, $this ) ){
                        $_crumbs = $this->_tax_crumbs( $term, 'self' );
                        $out = $this->_add_title( $_crumbs, $post );
                    }
                }
                // не древовидная такса (метки)
                elseif( ! is_taxonomy_hierarchical($term->taxonomy) ){
                    // метка
                    if( is_tag() )
                        $out = $this->_add_title('', $term, sprintf( $loc->tag, esc_html($term->name) ) );
                    // такса
                    elseif( is_tax() ){
                        $post_label = $ptype->labels->name;
                        $tax_label = $GLOBALS['wp_taxonomies'][ $term->taxonomy ]->labels->name;
                        $out = $this->_add_title('', $term, sprintf( $loc->tax_tag, $post_label, $tax_label, esc_html($term->name) ) );
                    }
                }
                // древовидная такса (рибрики)
                else {
                    if( ! $out = apply_filters('term_tax_crumbs', '', $term, $this ) ){
                        $_crumbs = $this->_tax_crumbs( $term, 'parent' );
                        $out = $this->_add_title( $_crumbs, $term, esc_html($term->name) );
                    }
                }
            }
            // влоежния от записи без терминов
            elseif( is_attachment() ){
                $parent = get_post($post->post_parent);
                $parent_link = sprintf( $linkpatt, get_permalink($parent), esc_html($parent->post_title) );
                $_out = $parent_link;

                // вложение от записи древовидного типа записи
                if( is_post_type_hierarchical($parent->post_type) ){
                    $parent_crumbs = $this->_page_crumbs($parent);
                    $_out = implode( $sep, array( $parent_crumbs, $parent_link ) );
                }

                $out = $this->_add_title( $_out, $post );
            }
            // записи без терминов
            elseif( is_singular() ){
                $out = $this->_add_title( '', $post );
            }
        }

        // замена ссылки на архивную страницу для типа записи
        $home_after = apply_filters('kama_breadcrumbs_home_after', '', $linkpatt, $sep, $ptype );

        if( '' === $home_after ){
            // Ссылка на архивную страницу типа записи для: отдельных страниц этого типа; архивов этого типа; таксономий связанных с этим типом.
            if( $ptype && $ptype->has_archive && ! in_array( $ptype->name, array('post','page','attachment') )
                && ( is_post_type_archive() || is_singular() || (is_tax() && in_array($term->taxonomy, $ptype->taxonomies)) )
            ){
                $pt_title = $ptype->labels->name;

                // первая страница архива типа записи
                if( is_post_type_archive() && ! $paged_num )
                    $home_after = $pt_title;
                // singular, paged post_type_archive, tax
                else{
                    $home_after = sprintf( $linkpatt, get_post_type_archive_link($ptype->name), $pt_title );

                    $home_after .= ( ($paged_num && ! is_tax()) ? $pg_end : $sep ); // пагинация
                }
            }
        }

        $before_out = sprintf( $linkpatt, home_url(), $loc->home ) . ( $home_after ? $sep.$home_after : ($out ? $sep : '') );

        $out = apply_filters('kama_breadcrumbs_pre_out', $out, $sep, $loc, $arg );

        $out = sprintf( $wrappatt, $before_out . $out );

        return apply_filters('kama_breadcrumbs', $out, $sep, $loc, $arg );
    }

    function _page_crumbs( $post ){
        $parent = $post->post_parent;

        $crumbs = array();
        while( $parent ){
            $page = get_post( $parent );
            $crumbs[] = sprintf( $this->arg->linkpatt, get_permalink($page), esc_html($page->post_title) );
            $parent = $page->post_parent;
        }

        return implode( $this->arg->sep, array_reverse($crumbs) );
    }

    function _tax_crumbs( $term, $start_from = 'self' ){
        $termlinks = array();
        $term_id = ($start_from === 'parent') ? $term->parent : $term->term_id;
        while( $term_id ){
            $term       = get_term( $term_id, $term->taxonomy );
            $termlinks[] = sprintf( $this->arg->linkpatt, get_term_link($term), esc_html($term->name) );
            $term_id    = $term->parent;
        }

        if( $termlinks )
            return implode( $this->arg->sep, array_reverse($termlinks) ) /*. $this->arg->sep*/;
        return '';
    }

    // добалвяет заголовок к переданному тексту, с учетом всех опций. Добавляет разделитель в начало, если надо.
    function _add_title( $add_to, $obj, $term_title = '' ){
        $arg = & $this->arg; // упростим...
        $title = $term_title ? $term_title : esc_html($obj->post_title); // $term_title чиститься отдельно, теги моугт быть...
        $show_title = $term_title ? $arg->show_term_title : $arg->show_post_title;

        // пагинация
        if( $arg->pg_end ){
            $link = $term_title ? get_term_link($obj) : get_permalink($obj);
            $add_to .= ($add_to ? $arg->sep : '') . sprintf( $arg->linkpatt, $link, $title ) . $arg->pg_end;
        }
        // дополняем - ставим sep
        elseif( $add_to ){
            if( $show_title )
                $add_to .= $arg->sep . sprintf( $arg->title_patt, $title );
            elseif( $arg->last_sep )
                $add_to .= $arg->sep;
        }
        // sep будет потом...
        elseif( $show_title )
            $add_to = sprintf( $arg->title_patt, $title );

        return $add_to;
    }

}

//Коментарии
function dp_recent_comments() {
    $comment_len = 100;
    $comments = get_comments('number=10');
    if ($comments) {
        foreach ($comments as $comment) {
            //ob_start();
            ?>
            <li>

                <div style="float: left;"><?php echo get_avatar($comment,$size='40' ); ?></div>

                <a href="<?php echo get_permalink( $comment->comment_post_ID ) . '#comment-' . $comment->comment_ID; ?>"><?php echo $comment->comment_author; ?>:</a>

                <p>                <?php echo strip_tags(substr(apply_filters('get_comment_text', $comment->comment_content), 0, $comment_len)); ?>...
                </p>

            </li>
            <?php
            //ob_end_flush();
        }
    } else {
        echo "<li>No comments</li>";
    }

}
//Коментарии

function your_widget_display($args) {
   echo  dp_recent_comments();
}

wp_register_sidebar_widget(
    'your_widget_1',        // ID виджета
    'Виджет коментариев',           // Заголовок виджета
    'your_widget_display',  // Функция обратного вызова
    array(                  // Настройки
        'description' => 'Виджет коментариев',
    )
);


