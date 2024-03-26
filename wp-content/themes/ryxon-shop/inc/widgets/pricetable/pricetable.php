<?php
if (!class_exists('WooCommerce')) return;

class Price_Table_Widget extends WC_Widget {

    function __construct() {
        $this->widget_cssclass    = 'ryxon_widget';
        $this->widget_description = __('Displays customizable content.', 'best-shop');
        $this->widget_id          = 'ryxon_widget_id';
        $this->widget_name        = __('Ryxon Widget 1.1', 'best-shop');
        parent::__construct();
    }

    function widget($args, $instance) {

        $properties = !empty($instance['properties']) ? $instance['properties'] : [];
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $description = !empty($instance['description']) ? $instance['description'] : '';
        ?>

        <div class='textwidget' style='width:100%;'>
            <h1>Ryxondev widget 1.1</h1>
            <p>Title: <?= $title ?></p>
            <p>Description: <?= $description ?></p>
            <?php if (!empty($properties)) :

                var_dump($properties);
                ?>
                <h3>Properties:</h3>
                <ul style="list-style: none; padding: 0;">
                    <?php foreach ($properties as $property) : ?>
                        <li style="padding-left: 20px; position: relative; display: flex; align-items: center;">
                            <i style="position: absolute; left: 0;" class="fa fa-<?= $property['icon'] ?>"></i>
                            <?= $property['name'] ?>
                        </li>
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
        <link rel="stylesheet" id="font-awesome-official-css" href="https://use.fontawesome.com/releases/v6.5.1/css/all.css" media="all">

        <input type="hidden" class="hidden-input-field">

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

                <?php
                $randomClassId = 'fieldwrapper-'.rand(0, 1000);
                $field = $this->get_field_name('properties');
                ?>

                <div class="elementor-repeater-fields-wrapper <?php echo $randomClassId; ?>">
                    <?php if (!empty($properties)) : ?>
                        <?php foreach ($properties as $index => $property) :

                            $name = esc_attr($property['name']);
                            $icon = esc_attr($property['icon']);
                            ?>
                            <script>
                                jQuery(document).ready(function($) {
                                    addProp('<?php echo $field; ?>', '<?php echo $index; ?>', '<?php echo $name; ?>', '<?php echo $icon; ?>');
                                });
                            </script>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <script>
                            jQuery(document).ready(function($) {
                                addProp('<?php echo $field; ?>', '0', '', '');
                            });
                        </script>
                    <?php endif; ?>
                </div>
                
                <br/>
                <button class="elementor-button elementor-repeater-add"><?php _e('Add Property', 'best-shop'); ?></button>

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
                        });

                        // trigger change event to let elementor know that the field has changed, the preview will then be updated
                        $('.hidden-input-field').trigger('change');
                    }
                });
            });

            function addProp(field, index, name, icon) {
                // alert('addProp');
                var propRow = $(`<div class="elementor-repeater-field" style="padding: 10px 5px; border: 2px solid white; margin: 5px 0; position: relative;">
                        <span class="elementor-repeater-delete" style="position: absolute; top: 8px; left: 8px;"><i style="font-size: 18px;" class="fa fa-close"></i></span>
                        <span class="sorthandle" style="position: absolute; top: 8px; right: 8px;"><i style="font-size: 18px;" class="fa fa-bars"></i></span>
                        <br/>
                        <span style="width: 28%; display: inline-block;">Name:</span><input style="width: 70%;" type="text" attr-id="`+index+`" class="widefat name" name="`+field+`[`+index+`][name]" value="`+name+`" placeholder="Property Name">
                        <span style="width: 28%; display: inline-block;">Icon:</span><input  style="width: 70%;" type="text" class="icon indexfield" name="`+field+`[`+index+`][icon]" value="`+icon+`">
                    </div>`);

                //var wrapper = field.closest('.elementor-control').find('.elementor-repeater-fields-wrapper');
                var wrapper = $('.<?= $randomClassId; ?>');
                wrapper.append(propRow);
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

                    alert('next index is ' + nextIndex);

                    addProp('<?php echo $this->get_field_name('properties'); ?>', nextIndex, '', '');

                    // var $repeaterWrapper = $(this).closest('.elementor-control').find('.elementor-repeater-fields-wrapper');
                    // var $template = $repeaterWrapper.find('.elementor-repeater-field').first().clone();
                    // $template.find('input').val('');
                    // $repeaterWrapper.append($template);
                    // $repeaterWrapper.find('.elementor-repeater-remove-btn').show();
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
        return $old_instance;
    }
}

function enqueue_jquery_ui() {
    wp_enqueue_script('jquery-ui-sortable');
}
add_action('admin_enqueue_scripts', 'enqueue_jquery_ui');

add_action('widgets_init', function() {
    register_widget('Price_Table_Widget');
});

//register the plugin's style.css in both backend and frontend
add_action('wp_enqueue_scripts', function() {
    $thisDir = str_replace(ABSPATH, '/', dirname(__FILE__));
    wp_enqueue_style('ryxon_widget_style', $thisDir.'/style.css', array(), time(), 'all');
});
add_action('admin_enqueue_scripts', function() {
    $thisDir = str_replace(ABSPATH, '/', dirname(__FILE__));
    wp_enqueue_style('ryxon_widget_style', $thisDir.'/style.css', array(), time(), 'all');
    wp_enqueue_style('font-awesome', 'https://use.fontawesome.com/releases/v6.5.1/css/all.css', array(), '6.5.1', 'all');
});