<?php

/**

Required: set ‘ot_theme_mode’ filter to true.
*/
add_filter( 'ot_theme_mode', '__return_true' );
/**

 */
add_filter( 'ot_show_new_layout', '__return_false' );

/**

Required: include OptionTree.
*/
require( trailingslashit( get_template_directory() ) . 'option-tree/ot-loader.php' );
require( trailingslashit(get_template_directory() ) . 'template/meta-boxes.php');
require( trailingslashit(get_template_directory() ) . 'template/theme-options.php');
/**

 * Функции шаблона (function.php)
 * @package WordPress
 * @subpackage your-clean-template-3
 */
function content($limit) {
  $content = explode(' ', get_the_content(), $limit);
  if (count($content)>=$limit) {
    array_pop($content);
    $content = implode(" ",$content).'...';
  } else {
    $content = implode(" ",$content);
  }           
  $content = preg_replace('/\[.+\]/','', $content);
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

register_sidebar(array( // регистрируем левую колонку, этот кусок можно повторять для добавления новых областей для виджитов
	'name' => 'Сайдбар', // Название в админке
	'id' => "sidebar", // идентификатор для вызова в шаблонах
	'description' => 'Обычная колонка в сайдбаре', // Описалово в админке
	'before_widget' => '<div id="%1$s" class="widget %2$s">', // разметка до вывода каждого виджета
	'after_widget' => "</div>\n", // разметка после вывода каждого виджета
	'before_title' => '<span class="widgettitle">', //  разметка до вывода заголовка виджета
	'after_title' => "</span>\n", //  разметка после вывода заголовка виджета
));

if (!class_exists('clean_comments_constructor')) { // если класс уже есть в дочерней теме - нам не надо его определять
	class clean_comments_constructor extends Walker_Comment { // класс, который собирает всю структуру комментов
		public function start_lvl( &$output, $depth = 0, $args = array()) { // что выводим перед дочерними комментариями
			$output .= '<ul class="children">' . "\n";
		}
		public function end_lvl( &$output, $depth = 0, $args = array()) { // что выводим после дочерних комментариев
			$output .= "</ul><!-- .children -->\n";
		}
	    protected function comment( $comment, $depth, $args ) { // разметка каждого комментария, без закрывающего </li>!
	    	$classes = implode(' ', get_comment_class()).($comment->comment_author_email == get_the_author_meta('email') ? ' author-comment' : ''); // берем стандартные классы комментария и если коммент пренадлежит автору поста добавляем класс author-comment
	        echo '<li id="comment-'.get_comment_ID().'" class="'.$classes.' media">'."\n"; // родительский тэг комментария с классами выше и уникальным якорным id
	    	echo '<div class="media-left">'.get_avatar($comment, 64, '', get_comment_author(), array('class' => 'media-object'))."</div>\n"; // покажем аватар с размером 64х64
	    	echo '<div class="media-body">';
	    	echo '<span class="meta media-heading">Автор: '.get_comment_author()."\n"; // имя автора коммента
	    	//echo ' '.get_comment_author_email(); // email автора коммента, плохой тон выводить почту
	    	echo ' '.get_comment_author_url(); // url автора коммента
	    	echo ' Добавлено '.get_comment_date('F j, Y в H:i')."\n"; // дата и время комментирования
	    	if ( '0' == $comment->comment_approved ) echo '<br><em class="comment-awaiting-moderation">Ваш комментарий будет опубликован после проверки модератором.</em>'."\n"; // если комментарий должен пройти проверку
	    	echo "</span>";
	        comment_text()."\n"; // текст коммента
	        $reply_link_args = array( // опции ссылки "ответить"
	        	'depth' => $depth, // текущая вложенность
	        	'reply_text' => 'Ответить', // текст
				'login_text' => 'Вы должны быть залогинены' // текст если юзер должен залогинеться
	        );
	        echo get_comment_reply_link(array_merge($args, $reply_link_args)); // выводим ссылку ответить
	        echo '</div>'."\n"; // закрываем див
	    }
	    public function end_el( &$output, $comment, $depth = 0, $args = array() ) { // конец каждого коммента
			$output .= "</li><!-- #comment-## -->\n";
		}
	}
}

if (!function_exists('pagination')) { // если ф-я уже есть в дочерней теме - нам не надо её определять
	function pagination() { // функция вывода пагинации
		global $wp_query; // текущая выборка должна быть глобальной
		$big = 999999999; // число для замены
		$links = paginate_links(array( // вывод пагинации с опциями ниже
			'base' => str_replace($big,'%#%',esc_url(get_pagenum_link($big))), // что заменяем в формате ниже
			'format' => '?paged=%#%', // формат, %#% будет заменено
			'current' => max(1, get_query_var('paged')), // текущая страница, 1, если $_GET['page'] не определено
			'type' => 'array', // нам надо получить массив
			'prev_text'    => 'Назад', // текст назад
	    	'next_text'    => 'Вперед', // текст вперед
			'total' => $wp_query->max_num_pages, // общие кол-во страниц в пагинации
			'show_all'     => false, // не показывать ссылки на все страницы, иначе end_size и mid_size будут проигнорированны
			'end_size'     => 15, //  сколько страниц показать в начале и конце списка (12 ... 4 ... 89)
			'mid_size'     => 15, // сколько страниц показать вокруг текущей страницы (... 123 5 678 ...).
			'add_args'     => false, // массив GET параметров для добавления в ссылку страницы
			'add_fragment' => '',	// строка для добавления в конец ссылки на страницу
			'before_page_number' => '', // строка перед цифрой
			'after_page_number' => '' // строка после цифры
		));
	 	if( is_array( $links ) ) { // если пагинация есть
		    echo '<ul class="pagination">';
		    foreach ( $links as $link ) {
		    	if ( strpos( $link, 'current' ) !== false ) echo "<li class='active'>$link</li>"; // если это активная страница
		        else echo "<li>$link</li>"; 
		    }
		   	echo '</ul>';
		 }
	}
}

add_action('wp_footer', 'add_scripts'); // приклеем ф-ю на добавление скриптов в футер
if (!function_exists('add_scripts')) { // если ф-я уже есть в дочерней теме - нам не надо её определять
	function add_scripts() { // добавление скриптов
	    if(is_admin()) return false; // если мы в админке - ничего не делаем
	    	    wp_deregister_script('jquery'); // выключаем стандартный jquery
	    wp_enqueue_script('jquery','//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js','','',true); // добавляем свой
	    	    wp_enqueue_script('slider', get_template_directory_uri().'/js/js/components/jquery.hslider.js','','',true); //lloader
	    wp_enqueue_script('sliderpost', get_template_directory_uri().'/js/js/components/slider.js','','',true); //lloader
	    wp_enqueue_script('loadMain', get_template_directory_uri().'/js/js/components/navmain.js','','',true); //lloader
	    wp_enqueue_script('http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js','','',true); // добавляем свой
	    wp_enqueue_script('paralax', get_template_directory_uri().'/js/js/components/parallax.min.js','','',true); //lloader
	    wp_enqueue_script('Imgloaded', get_template_directory_uri().'/js/js/components/imagesloaded.pkgd.min.js','','',true); //lloader
	     // wp_enqueue_script('https://maps.googleapis.com/maps/api/js?key=AIzaSyDYDsaHdwINMUwooo_yfVbJhABBiuvQ4cw','','',true); // добавляем свой
	    // wp_enqueue_script('Main', get_template_directory_uri().'/js/js/components/main.js','','',true); //lloader
	    wp_enqueue_script('Modernizm', get_template_directory_uri().'/js/js/components/modernizr.js','','',true); //lloader
	    wp_enqueue_script('jquery3','//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js','','',true); // добавляем свой
	    wp_enqueue_script('Social', get_template_directory_uri().'/js/js/jquery.prettySocial.min.js','','',true); //lloader
	    wp_enqueue_script('SocialIcon', get_template_directory_uri().'/js/js/components/socialicon.js','','',true); //lloader
	    wp_enqueue_script('textEfext', get_template_directory_uri().'/js/js/components/textEfext.js','','',true); //lloader
	    wp_enqueue_script('pocupmod', get_template_directory_uri().'/js/js/modal/modernizr.custom.js','','',true); //Popup
	    wp_enqueue_script('pocupcus', get_template_directory_uri().'/js/js/modal/classie.js','','',true); //Popup
	    wp_enqueue_script('pocup', get_template_directory_uri().'/js/js/modal/uiMorphingButton_fixed.js','','',true); //Popup
	    wp_enqueue_script('jquery1','//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js','','',true); // добавляем свой
	    wp_enqueue_script('custom', get_template_directory_uri().'/js/js/custom.js','','',true); //lloader

	}
}

add_action('wp_print_styles', 'add_styles'); // приклеем ф-ю на добавление стилей в хедер
if (!function_exists('add_styles')) { // если ф-я уже есть в дочерней теме - нам не надо её определять
function add_styles() { // добавление стилей
	    if(is_admin()) return false; // если мы в админке - ничего не делаем
	    wp_enqueue_style( 'font_awesome', get_template_directory_uri().'/css/font-awesome.min.css' ); // бутстрап
		wp_enqueue_style( 'style', get_template_directory_uri().'/style.css' ); // основные стили шаблона
		wp_enqueue_style( 'styles', get_template_directory_uri().'/styles.css' ); // основные стили шаблона

	}
}
function font_awesome() {
  if (!is_admin()) {
    wp_register_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css');
    wp_enqueue_style('font-awesome');
  }
}


function load_fonts() 
{             
wp_register_style('et-googleFonts', 
'https://fonts.googleapis.com/css?family=Oswald:200,300,400,500,600,700&subset=cyrillic,latin-ext,vietnamese');            
 wp_enqueue_style( 'et-googleFonts');
 wp_register_style('et-googleFontsItalic', 
'https://fonts.googleapis.com/css?family=Marck+Script&subset=cyrillic,latin-ext');            
 wp_enqueue_style( 'et-googleFontsItalic'); 
 wp_register_style('et-googleFontsUbuntu', 
'https://fonts.googleapis.com/css?family=Ubuntu:300,300i,400,400i,500,500i,700,700i&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext');            
 wp_enqueue_style( 'et-googleFontsUbuntu'); 
  wp_register_style('et-googleFontsJuru', 
'https://fonts.googleapis.com/css?family=Jura:300,400,500,600,700&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese');            
 wp_enqueue_style( 'et-googleFontsJuru'); 
  wp_register_style('et-googleFontsRobo', 
'https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese');            
 wp_enqueue_style( 'et-googleFontsRobo'); 
               
}     
add_action('wp_print_styles', 'load_fonts');
if (!function_exists('content_class_by_sidebar')) { // если ф-я уже есть в дочерней теме - нам не надо её определять
	function content_class_by_sidebar() { // функция для вывода класса в зависимости от существования виджетов в сайдбаре
		if (is_active_sidebar( 'sidebar' )) { // если есть
			echo 'col-sm-9'; // пишем класс на 80% ширины
		} else { // если нет
			echo 'col-sm-12'; // контент на всю ширину
		}
	}
}
remove_filter( 'the_content', 'wp_make_content_images_responsive' );
remove_filter( 'the_content', 'wpautop' ); // Отключаем автоформатирование в полном посте
remove_filter( 'the_excerpt', 'wpautop' ); // Отключаем автоформатирование в кратком(анонсе) посте
remove_filter('comment_text', 'wpautop'); // Отключаем автоформатирование в комментариях


?>
