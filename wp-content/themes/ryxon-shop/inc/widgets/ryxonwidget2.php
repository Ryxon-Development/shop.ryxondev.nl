<?php
if (!class_exists('WooCommerce')) return;

class Ryxon_Widget extends WC_Widget {

    function __construct() {
        $this->widget_cssclass    = 'ryxon_widget';
        $this->widget_description = __('Displays customizable content.', 'best-shop');
        $this->widget_id          = 'ryxon_widget_id';
        $this->widget_name        = __('Ryxon Widget 1.1', 'best-shop');
        parent::__construct();
    }

    function widget($args, $instance) {
        $content = !empty($instance['content']) ? wp_kses_post($instance['content']) : '';
        $properties = !empty($instance['properties']) ? $instance['properties'] : [];
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $description = !empty($instance['description']) ? $instance['description'] : '';
        ?>

        <div class='textwidget' style='width:100%;'>
            <h1>Ryxondev widget</h1>
            <p>Title: <?= $title ?></p>
            <p>Description: <?= $description ?></p>
            <?php if (!empty($properties)) : ?>
                <h3>Properties:</h3>
                <ul>
                    <?php foreach ($properties as $property) : ?>
                        <li><?= $property['name'] ?> <img src="<?= $property['icon'] ?>" alt="<?= $property['name'] ?>"></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <?php
    }

    function form($instance) {
        $content = !empty($instance['content']) ? $instance['content'] : '';
        $properties = !empty($instance['properties']) ? $instance['properties'] : [];
        ?>

        <div class="elementor-control">
            <details>
                <summary>Header</summary>
                <p>
                    <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'best-shop'); ?></label>
                    <input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>">
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('Description:', 'best-shop'); ?></label>
                    <input class="widefat" type="text" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>" value="<?php echo esc_attr($description); ?>">
                </p>
            </details>

            <details>
                <summary>Properties</summary>
                <div class="elementor-repeater-fields-wrapper">
                    <?php if (!empty($properties)) : ?>
                        <?php foreach ($properties as $index => $property) : ?>
                            <div class="elementor-repeater-field">
                                <input type="text" class="widefat" name="<?php echo $this->get_field_name('properties'); ?>[<?php echo $index; ?>][name]" value="<?php echo esc_attr($property['name']); ?>" placeholder="Property Name">
                                <input type="hidden" class="image-url-input" name="<?php echo $this->get_field_name('properties'); ?>[<?php echo $index; ?>][icon]" value="<?php echo esc_attr($property['icon']); ?>">
                                <button class="image-upload-button">Upload Image</button>
                                <img class="image-preview" src="<?php echo esc_attr($property['icon']); ?>" style="max-width: 100px;">
                                <button class="elementor-repeater-remove-btn">Remove</button>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="elementor-repeater-field">
                            <input type="text" class="widefat" name="<?php echo $this->get_field_name('properties'); ?>[0][name]" placeholder="Property Name">
                            <input type="hidden" class="image-url-input" name="<?php echo $this->get_field_name('properties'); ?>[0][icon]" placeholder="Icon URL">
                            <button class="image-upload-button">Upload Image</button>
                            <img class="image-preview" src="" style="max-width: 100px;">
                            <button class="elementor-repeater-remove-btn" style="display: none;">Remove</button>
                        </div>
                    <?php endif; ?>
                </div>
                <button class="ryxon-add-property-button button"><?php _e('Add Property', 'best-shop'); ?></button>

            </details>
        </div>

        <script>
            jQuery(document).ready(function($) {
                $(document).on('click', '.image-upload-button', function(e) {
                    e.preventDefault();
                    var button = $(this); // Reference to the clicked button
                    var image = wp.media({
                        title: 'Upload Image',
                        multiple: false
                    }).open()
                        .on('select', function(e) {
                            var uploaded_image = image.state().get('selection').first();
                            var image_url = uploaded_image.toJSON().url;
                            button.siblings('.image-preview').attr('src', image_url); // Use button to reference the clicked button's siblings
                            button.siblings('.image-url-input').val(image_url); // Use button to reference the clicked button's siblings

                            // Enable the update button
                            button.closest('.elementor-control').find('.elementor-control-save').removeAttr('disabled');
                        });
                });
            });

            jQuery(document).ready(function($) {
                $(document).on('click', '.ryxon-add-property-button', function(e) {
                    e.preventDefault(); // Prevent default form submission behavior
                    // Your code to add a property goes here
                });

                $(document).on('click', '.elementor-repeater-remove-btn', function(e) {
                    e.preventDefault(); // Prevent default form submission behavior
                    // Your code to remove a property goes here
                });
            });
        </script>

        <?php
    }

    function update($new_instance, $old_instance) {
        $old_instance['content'] = !empty($new_instance['content']) ? $new_instance['content'] : '';
        $old_instance['properties'] = !empty($new_instance['properties']) ? $new_instance['properties'] : [];
        $old_instance['title'] = sanitize_text_field($new_instance['title']);
        $old_instance['description'] = sanitize_text_field($new_instance['description']);
        return $old_instance;
    }
}

add_action('widgets_init', function() {
    register_widget('Ryxon_Widget');
});