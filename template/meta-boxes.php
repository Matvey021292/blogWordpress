<?php
/**
 * Initialize the custom Meta Boxes.
 */
add_action('admin_init', 'custom_meta_boxes');

/**
 * Meta Boxes demo code.
 *
 * You can find all the available option types in demo-theme-options.php.
 *
 * @return    void
 * @since     2.0
 */

function custom_meta_boxes()
{

    $main_page = array(
        'id' => 'main_page_box',
        'title' => 'Настройки главной страницы',
        'desc' => '',
        'pages' => array('page'),
        'context' => 'normal',
        'priority' => 'high',
        'fields' => array(
            array(
                'label' => 'Слайдер',
                'id' => 'main-slider-tab',
                'type' => 'tab'
            ),

            array(
                'label' => 'Показивать слайдер',
                'id' => 'demo_slider_show',
                'type' => 'on-off',
                'desc' => 'Вкл\Выкл слайдер га главной',
                'std' => 'off'
            ),

            array(
                'id' => 'main_slider_list',
                'label' => 'Slider',
                'desc' => '',
                'std' => '',
                'type' => 'list-item',
                'condition' => 'demo_slider_show:is(on)',
                'settings' => array(
                    array(
                        'id' => 'main_slider_list_header',
                        'label' => 'Заголовок',
                        'desc' => '',
                        'std' => '',
                        'type' => 'text',
                    ),
                    array(
                        'id' => 'main_slider_list_upload',
                        'label' => 'Загрузите слайд',
                        'desc' => '',
                        'std' => '',
                        'type' => 'upload',
                    ),
                )
            ),array(
                'label' => 'Галерея',
                'id' => 'gallery',
                'type' => 'tab'
            ),array(
                'label' => 'Показивать галерею',
                'id' => 'gallery_show',
                'type' => 'on-off',
                'desc' => 'Вкл\Выкл слайдер га главной',
                'std' => 'off'
            ),array(
                'id' => 'main_gallery_list',
                'label' => 'Галерея',
                'desc' => '',
                'std' => '',
                'type' => 'list-item',
                'condition' => 'gallery_show:is(on)',
                'settings' => array(
                    array(
                        'id' => 'main_gallery_list_text',
                        'label' => 'Подпись',
                        'desc' => '',
                        'std' => '',
                        'type' => 'text',
                    ),
                    array(
                        'id' => 'main_gallery_list_upload',
                        'label' => 'Загрузите изображение',
                        'desc' => '',
                        'std' => '',
                        'type' => 'upload',
                    ),
                )
            )
        ),
    );

    $my_meta_box = array(
        'id' => 'demo_meta_box',
        'title' => __('Demo Meta Box', 'theme-text-domain'),
        'desc' => '',
        'pages' => array('post'),
        'context' => 'normal',
        'priority' => 'high',
        'fields' => array(
            array(
                'label' => __('Conditions', 'theme-text-domain'),
                'id' => 'demo_conditions',
                'type' => 'tab'
            ),
            array(
                'label' => __('Show Gallery', 'theme-text-domain'),
                'id' => 'demo_show_gallery',
                'type' => 'on-off',
                'desc' => sprintf(__('Shows the Gallery when set to %s.', 'theme-text-domain'), '<code>on</code>'),
                'std' => 'off'
            ),
            array(
                'label' => '',
                'id' => 'demo_textblock',
                'type' => 'textblock',
                'desc' => __('Congratulations, you created a gallery!', 'theme-text-domain'),
                'operator' => 'and',
                'condition' => 'demo_show_gallery:is(on),demo_gallery:not()'
            ),
            array(
                'label' => __('Gallery', 'theme-text-domain'),
                'id' => 'demo_gallery',
                'type' => 'gallery',
                'desc' => sprintf(__('This is a Gallery option type. It displays when %s.', 'theme-text-domain'), '<code>demo_show_gallery:is(on)</code>'),
                'condition' => 'demo_show_gallery:is(on)'
            ),
            array(
                'label' => __('More Options', 'theme-text-domain'),
                'id' => 'demo_more_options',
                'type' => 'tab'
            ),
            array(
                'label' => __('Text', 'theme-text-domain'),
                'id' => 'demo_text',
                'type' => 'text',
                'desc' => __('This is a demo Text field.', 'theme-text-domain')
            ),
            array(
                'label' => __('Textarea', 'theme-text-domain'),
                'id' => 'demo_textarea',
                'type' => 'textarea',
                'desc' => __('This is a demo Textarea field.', 'theme-text-domain')
            )
        )
    );

    /**
     * Register our meta boxes using the
     * ot_register_meta_box() function.
     */
    if (function_exists('ot_register_meta_box'))
        ot_register_meta_box($my_meta_box);
    ot_register_meta_box($main_page);

}
// $post_id = isset($_GET['post'] ) ? $_GET['post'] : (isset($_POST['post_ID']) ? $_POST['post_ID']: 0 );
// $template_file = get_post_meta( $post_id, 'wp_page_template', TRUE );
// if ($template_file == 'page-custom.php') {
//    ot_register_meta_box( $main_page );
// }




