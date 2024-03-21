<?php
/*
 * Display a widget with customizable content
 */
if (!class_exists('WooCommerce')) return;

class Ryxon_Widget extends WC_Widget {

    function __construct() {

        $this->widget_cssclass    = 'ryxon_widget 1.1';
        $this->widget_description = __('Displays customizable content.', 'best-shop');
        $this->widget_id          = 'ryxon_widget_id';
        $this->widget_name        = __('Ryxon Widget', 'best-shop');

        parent::__construct();
    }


    function widget($args, $instance) {
//        echo $args['before_widget'];

        // Widget content
        if (!empty($instance['content'])) {
            $content = wp_kses_post($instance['content']);
        }else{
            $content = '';
        }

        ?>

        <div class="textwidget" style="width:100%;">
            <h1>Ryxondev widget</h1>
            <p>Custom content goes here:</p>
            <p><?php echo $content; ?></p>
        </div>
        <?php

//        echo $args['after_widget'];
    }

    function form($instance) {
        $content = !empty($instance['content']) ? $instance['content'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('content'); ?>"><?php _e('Content:', 'best-shop'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>" rows="5"><?php echo esc_textarea($content); ?></textarea>
        </p>
        <?php
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['content'] = !empty($new_instance['content']) ? $new_instance['content'] : '';
        return $instance;
    }
}

function ryxon_widget_register() {
    register_widget('Ryxon_Widget');
}
add_action('widgets_init', 'ryxon_widget_register');
?>
