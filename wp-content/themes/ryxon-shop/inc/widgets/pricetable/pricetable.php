<?php
if (!class_exists('WooCommerce')) return;

class Price_Table_Widget extends WC_Widget {

    function __construct() {
        $this->widget_cssclass    = 'ryxon_widget';
        $this->widget_description = __('Displays price information!', 'best-shop');
        $this->widget_id          = 'ryxon_widget_id';
        $this->widget_name        = __('Price Table Pro', 'best-shop');
        parent::__construct();
    }

    function widget($args, $instance) {

        $properties = !empty($instance['properties']) ? $instance['properties'] : [];
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $description = !empty($instance['description']) ? $instance['description'] : '';
        $button_txt = !empty($instance['button_txt']) ? $instance['button_txt'] : '';
        $button_url = !empty($instance['button_url']) ? $instance['button_url'] : '';
        $color = !empty($instance['color']) ? $instance['color'] : '';
        ?>

        <div class='textwidget' style='width:100%;'>
            <div class="heading" style="background: <?= $color; ?>">
                <h2><?= $title ?></h2>
                <p><?= $description ?></p>
            </div>

            <div class="elementor-price-table__price price">
                <span class="elementor-price-table__currency">€</span>
                <span class="elementor-price-table__integer-part"> <?= $instance['price']?> </span>
                <span class="elementor-price-table__period elementor-typo-excluded"><?= $instance['price_txt'] ?></span>
            </div>

            <div class="props">
            <?php if (!empty($properties)) : ?>
                <ul style="list-style: none; padding: 0;">
                    <?php foreach ($properties as $property) : ?>
                        <li>
                            <i style="color: <?=$property['color']?>" class="fa fa-<?= $property['icon'] ?>"></i>
                            <?= $property['name'] ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            </div>

            <div class="button">
                <a class="elementor-price-table__button elementor-button elementor-size-md" href="<?= $button_url ?>"> <?= $button_txt ?> </a>
            </div>

        </div>

        <?php

    }

    function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $description = !empty($instance['description']) ? $instance['description'] : '';
        $button_txt = !empty($instance['button_txt']) ? $instance['button_txt'] : '';
        $button_url = !empty($instance['button_url']) ? $instance['button_url'] : '';
        $content = !empty($instance['content']) ? $instance['content'] : '';
        $properties = !empty($instance['properties']) ? $instance['properties'] : [];
        $price = !empty($instance['price']) ? $instance['price'] : '';
        $price_txt = !empty($instance['price_txt']) ? $instance['price_txt'] : '';
        $color = !empty($instance['color']) ? $instance['color'] : '';
        ?>
        <link rel="stylesheet" id="font-awesome-official-css" href="https://use.fontawesome.com/releases/v6.5.1/css/all.css" media="all">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/mdbassit/Coloris@latest/dist/coloris.min.css"/>
        <script src="https://cdn.jsdelivr.net/gh/mdbassit/Coloris@latest/dist/coloris.min.js"></script>

        <input type="hidden" class="hidden-input-field">
        <div class="colorscript"></div>
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

                <p>
                    <label for="color">Choose a color:</label>
                    <input data-jscolor="{}" type="text" class="color-picker" id="<?php echo $this->get_field_id('description'); ?>"   name="<?php echo $this->get_field_name('color'); ?>"  value="<?php echo esc_attr($color); ?>">
                </p>

            </details>
<!--            price!-->
            <details>
                <summary>Price</summary>
                <p>
                    <label for="<?php echo $this->get_field_id('price'); ?>"><?php _e('Price:', 'best-shop'); ?></label>
                    <input class="widefat" type="text" id="<?php echo $this->get_field_id('price'); ?>" name="<?php echo $this->get_field_name('price'); ?>" value="<?php echo esc_attr($price); ?>">
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('price_txt'); ?>"><?php _e('Price text:', 'best-shop'); ?></label>
                    <input class="widefat" type="text" id="<?php echo $this->get_field_id('price_txt'); ?>" name="<?php echo $this->get_field_name('price_txt'); ?>" value="<?php echo esc_attr($price_txt); ?>">
                </p>
            </details>

            <details>
                <summary>Properties</summary>

                <?php
                $randomClassId = 'fieldwrapper-'.rand(0, 1000);
                $field = $this->get_field_name('properties');
                ?>

                <div class="elementor-repeater-fields-wrapper <?php echo $randomClassId; ?>">
                    <?php if (!empty($properties)) : ?>
                        <?php foreach ($properties as $index => $property) :

                            $name = esc_attr($property['name']);
                            $icon = esc_attr($property['icon']);
                            $color = esc_attr($property['color']);
                            ?>
                            <script>
                                jQuery(document).ready(function($) {
                                    addProp('<?php echo $field; ?>', '<?php echo $index; ?>', '<?php echo $name; ?>', '<?php echo $icon; ?>', '<?php echo $color; ?>' );
                                });
                            </script>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <script>
                            jQuery(document).ready(function($) {
                                addProp('<?php echo $field; ?>', '0', '', '', '');
                            });
                        </script>
                    <?php endif; ?>
                </div>
                
                <br/>
                <button class="elementor-button elementor-repeater-add"><?php _e('Add Property', 'best-shop'); ?></button>
            </details>

            <details>
                <summary>Button</summary>
                <p>
                    <label for="<?php echo $this->get_field_id('button_txt'); ?>"><?php _e('Text:', 'best-shop'); ?></label>
                    <input class="widefat" type="text" id="<?php echo $this->get_field_id('button_txt'); ?>" name="<?php echo $this->get_field_name('button_txt'); ?>" value="<?php echo esc_attr($button_txt); ?>">
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('button_url'); ?>"><?php _e('Url:', 'best-shop'); ?></label>
                    <input class="widefat" type="text" id="<?php echo $this->get_field_id('button_url'); ?>" name="<?php echo $this->get_field_name('button_url'); ?>" value="<?php echo esc_attr($button_url); ?>">
                </p>
            </details>
        </div>

        <script>
            jQuery(document).ready(function($) {

                $('.<?php echo $randomClassId; ?>').sortable({
                    items: ".elementor-repeater-field",
                    handle: ".sorthandle",
                    axis: "y",
                    containment: "parent",
                    opacity: 0.7,
                    cursor: "move",
                    update: function(event, ui) {

                        // when sorting changes, updates all the indexes
                        var wrapper = $('.<?php echo $randomClassId; ?>');
                        wrapper.find('.elementor-repeater-field').each(function(index) {
                            $(this).find('.name').attr('name', '<?php echo $field; ?>[' + index + '][name]');
                            $(this).find('.icon').attr('name', '<?php echo $field; ?>[' + index + '][icon]');
                            $(this).find('.color').attr('name', '<?php echo $field; ?>[' + index + '][color]');
                        });

                        // trigger change event to let elementor know that the field has changed, the preview will then be updated
                        $('.hidden-input-field').trigger('change');
                    }
                });
            });

            function addProp(field, index, name, icon, color) {
                // alert('addProp');
                var propRow = $(`<div class="elementor-repeater-field" style="padding: 10px 5px; border: 2px solid white; margin: 5px 0; position: relative;">
                        <span class="elementor-repeater-delete" style="position: absolute; top: 8px; left: 8px;"><i style="font-size: 18px;" class="fa fa-close"></i></span>
                        <span class="sorthandle" style="position: absolute; top: 8px; right: 8px;"><i style="font-size: 18px;" class="fa fa-bars"></i></span>
                        <br/>
                        <span style="width: 28%; display: inline-block;">Name:</span><input style="width: 70%;" type="text" attr-id="`+index+`" class="widefat name" name="`+field+`[`+index+`][name]" value="`+name+`" placeholder="Property Name">
                        <span style="width: 28%; display: inline-block;">Icon:</span><input  style="width: 70%;" type="text" class="icon indexfield" name="`+field+`[`+index+`][icon]" value="`+icon+`">
                        <span style="width: 28%; display: inline-block;">Color:</span><input data-jscolor="{}" style="width: 70%;" type="text" class="color indexfield" name="`+field+`[`+index+`][color]" value="`+color+`">
                    </div>`);

                //var wrapper = field.closest('.elementor-control').find('.elementor-repeater-fields-wrapper');
                var wrapper = $('.<?= $randomClassId; ?>');
                wrapper.append(propRow);
                $('.colorscript').html(`<script src="/wp-includes/js/jscolor.js"/>`);
            }

            function determineNextIndex() {

                var wrapper = $('.<?= $randomClassId; ?>');

                //get the highest attr-id from all .widefat inputs
                var nextIndex = 0;
                wrapper.find('.widefat').each(function() {
                    var index = parseInt($(this).attr('attr-id'));
                    if (index > nextIndex) {
                        nextIndex = index;
                    }
                });

                return nextIndex;
            }

            jQuery(document).ready(function($) {

                $(document).off('click', '.elementor-repeater-delete');
                $(document).on('click', '.elementor-repeater-delete', function(e) {
                    e.preventDefault();
                    var $repeaterField = $(this).closest('.elementor-repeater-field');
                    $repeaterField.remove();
                    $('.hidden-input-field').trigger('change');
                });

                $(document).off('click', '.elementor-repeater-add');
                $(document).on('click', '.elementor-repeater-add', function(e) {
                    e.preventDefault();
                    var nextIndex = determineNextIndex() + 1;
                    addProp('<?php echo $this->get_field_name('properties'); ?>', nextIndex, '', '');
                });

                $(document).off('click', '.elementor-repeater-remove-btn');
                $(document).on('click', '.elementor-repeater-remove-btn', function(e) {
                    e.preventDefault();
                    var $repeaterWrapper = $(this).closest('.elementor-control').find('.elementor-repeater-fields-wrapper');
                    $(this).closest('.elementor-repeater-field').remove();
                    if ($repeaterWrapper.find('.elementor-repeater-field').length === 1) {
                        $repeaterWrapper.find('.elementor-repeater-remove-btn').hide();
                    }
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
        $old_instance['button_txt'] = sanitize_text_field($new_instance['button_txt']);
        $old_instance['button_url'] = sanitize_text_field($new_instance['button_url']);
        $old_instance['price'] = sanitize_text_field($new_instance['price']);
        $old_instance['price_txt'] = sanitize_text_field($new_instance['price_txt']);
        $old_instance['color'] = sanitize_text_field($new_instance['color']);
        return $old_instance;
    }
}



add_action('widgets_init', function() {
    register_widget('Price_Table_Widget');
});

function enqueue_jquery_ui() {
    wp_enqueue_script('jquery-ui-sortable');
}
add_action('admin_enqueue_scripts', 'enqueue_jquery_ui');

//register the plugin's style.css in both backend and frontend
add_action('wp_enqueue_scripts', function() {
    $thisDir = str_replace(ABSPATH, '/', dirname(__FILE__));
    wp_enqueue_style('ryxon_widget_style', $thisDir.'/style.css', array(), time(), 'all');
});
add_action('admin_enqueue_scripts', function() {
    $thisDir = str_replace(ABSPATH, '/', dirname(__FILE__));
    wp_enqueue_style('ryxon_widget_style', $thisDir.'/style.css', array(), time(), 'all');
    wp_enqueue_style('font-awesome', '/wp-includes/css/font-awesome.css', array(), '6.5.1', 'all');
    wp_enqueue_script('jscolor', '/wp-includes/js/jscolor.js', array(), '1.0', 'all');
});