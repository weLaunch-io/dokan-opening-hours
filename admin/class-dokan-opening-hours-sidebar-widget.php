<?php

class Dokan_Opening_Hours_Widget extends WP_Widget
{

    private $weekdays;

	/**
	 * Register Dokan Opening Hours Widget
	 * @author Daniel Barenkamp
	 * @version 1.0.0
	 * @since   1.0.0
	 * @link    http://woocommerce.db-dzine.de
	 */
    public function __construct()
    {
        $this->weekdays = array(
            1 => __('Monday', 'dokan-opening-hours'),
            2 => __('Tuesday', 'dokan-opening-hours'),
            3 => __('Wednesday', 'dokan-opening-hours'),
            4 => __('Thursday', 'dokan-opening-hours'),
            5 => __('Friday', 'dokan-opening-hours'),
            6 => __('Saturday', 'dokan-opening-hours'),
            0 => __('Sunday', 'dokan-opening-hours'),
        );

        $widget_ops = array( 'classname' => 'dokan-opening-hours', 'description' => __( 'Dokan Opening Hours', 'dokan-opening-hours' ) );
        parent::__construct( 'dokan-opening-hours', __( 'Dokan: Opening Hours', 'dokan-opening-hours' ), $widget_ops );
    }

    /**
     * Outputs the HTML for this widget.
     *
     * @param array  An array of standard parameters for widgets in this theme
     * @param array  An array of settings for this widget instance
     *
     * @return void Echoes it's output
     */
    function widget( $args, $instance ) {

        if ( ! dokan_is_store_page() ) {
            return;
        }

        extract( $args, EXTR_SKIP );

        $title        = apply_filters( 'widget_title', $instance['title'] );
        $store_info   = dokan_get_store_info( get_query_var( 'author' ) );
        $opening_hours = isset( $store_info['opening_hours'] ) ? $store_info['opening_hours'] : '';

        if ( empty( $opening_hours ) ) {
            return;
        }

        echo $before_widget;

        if ( ! empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        do_action('dokan-store-widget-before-opening-hours' , get_query_var( 'author' ));
        ?>

        <div class="dokan-store-widget-opening-hours-container">

            <div class="dokan-store-widget-opening-hours-current-open-container">

                <div class="dokan-store-widget-opening-hours-current-open">
                    <div class="dokan-store-widget-opening-hours-current-open-circle"></div>
                    <div class="dokan-store-widget-opening-hours-current-open-title"><?php echo __('currently open', 'dokan-opening-hours') ?></div>
                    <div class="clear"></div>
                </div>

                <div class="dokan-store-widget-opening-hours-current-closed">
                    <div class="dokan-store-widget-opening-hours-current-closed-circle"></div>
                    <div class="dokan-store-widget-opening-hours-current-closed-title"><?php echo __('currently closed', 'dokan-opening-hours') ?></div>
                    <div class="clear"></div>
                </div>

            </div>
        <?php 

        foreach ($opening_hours as $day => $times) {

            echo '<div class="dokan-store-widget-opening-hours-item-container">';

                echo '<div class="dokan-store-widget-opening-hours-item-title">';
                    echo($this->weekdays[$day]) . ':';
                echo '</div>';

                echo '<div class="dokan-store-widget-opening-hours-item-time">';
                    if(empty($times[0])) {
                        echo '<div class="dokan-store-widget-opening-hours-item-time-closed">' . __(" Closed", 'dokan-opening-hours') . '</div>';
                    } else {
                        echo $times[0] . ' – ' . $times[1] . __(" o'Clock", 'dokan-opening-hours');
                    }
                echo '</div>';

                echo '<div class="clear"></div>';

            echo '</div>';
        }

        echo '</div>';

        echo '<script>var store_opening_hours = ' . json_encode($opening_hours) . '</script>';

        do_action('dokan-store-widget-after-opening-hours', get_query_var( 'author' ));

        echo $after_widget;
    }

     /**
     * Deals with the settings when they are saved by the admin. Here is
     * where any validation should be dealt with.
     *
     * @param array  An array of new settings as submitted by the admin
     * @param array  An array of the previous settings
     *
     * @return array The validated and (if necessary) amended settings
     */
    function update( $new_instance, $old_instance ) {

        // update logic goes here
        $updated_instance = $new_instance;
        return $updated_instance;
    }

    /**
     * Displays the form for this widget on the Widgets page of the WP Admin area.
     *
     * @param array  An array of the current settings for this widget
     *
     * @return void Echoes it's output
     */
    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array(
            'title' => __( 'Store Opening Hours', 'dokan-opening-hours' ),
        ) );

        $title = $instance['title'];
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'dokan-opening-hours' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <?php
    }
}