<?php

class Dokan_Opening_Hours_Admin
{
    private $plugin_name;
    private $version;
    private $weekdays;

    /**
     * Construct Advanced Categories Admin Class
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.de
     * @param   string                         $plugin_name
     * @param   string                         $version    
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;

        $this->weekdays = array(
            1 => __('Monday', 'dokan-opening-hours'),
            2 => __('Tuesday', 'dokan-opening-hours'),
            3 => __('Wednesday', 'dokan-opening-hours'),
            4 => __('Thursday', 'dokan-opening-hours'),
            5 => __('Friday', 'dokan-opening-hours'),
            6 => __('Saturday', 'dokan-opening-hours'),
            0 => __('Sunday', 'dokan-opening-hours'),
        );
    }

    /**
     * Enqueue Admin Styles
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.de
     * @return  boolean
     */
    public function enqueue_styles()
    {
        wp_enqueue_style($this->plugin_name.'-custom', plugin_dir_url(__FILE__).'css/dokan-opening-hours-admin.css', array(), $this->version, 'all');
    }

    /**
     * Enqueue Admin Scripts
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.de
     * @return  boolean
     */
    public function enqueue_scripts()
    {
        // wp_enqueue_script($this->plugin_name.'-custom', plugin_dir_url(__FILE__).'js/dokan-opening-hours-admin.js', array('jquery'), $this->version, true);
    }

    /**
     * Init Admin facade
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.de
     * @return  [type]                         [description]
     */
    public function init()
    {
        // add_shortcode('dokan_opening_hours', array($this, 'display_opening_hours') );
    }

    public function register_widgets()
    {
        register_widget( 'Dokan_Opening_Hours_Widget' );
    }

    public function redirect_sellers_to_dashboard($redirect_to, $request, $user ) 
    {
        if (isset($user->roles) && is_array($user->roles)) {
            if (in_array('seller', $user->roles)) {
                $redirect_to = dokan_get_navigation_url('dashboard'); 
            }
        }
        return $redirect_to;
    }

    public function show_products_headline()
    {
        echo '<h3>' . __('Products', 'dokan-opening-hours') . '</h3>';
    }

    public function add_description_field($current_user, $profile_info )
    {
        $description = isset( $profile_info['description'] ) ? $profile_info['description'] : '';
        ?>
         <div class="gregcustom dokan-form-group">
                <label class="dokan-w3 dokan-control-label" for="setting_address">
                    <?php _e( 'Description', 'dokan-opening-hours' ); ?>
                </label>
                <div class="dokan-w5">
                    <input type="text" class="dokan-form-control input-md valid" name="description" id="reg_description" value="<?php echo $description; ?>" />
                </div>
            </div>
        <?php
    }

    public function save_description_field( $store_id )
    {
        $dokan_settings = dokan_get_store_info($store_id);
        if ( isset( $_POST['description'] ) ) {
            $dokan_settings['description'] = $_POST['description'];
        }

        update_user_meta( $store_id, 'dokan_profile_settings', $dokan_settings );
    }

        
    public function show_description_field($store_user_data, $store_info)
    {
        if ( isset( $store_info['description'] ) && !empty( $store_info['description'] ) ) { 
            // echo '<h3>' . __('Description', 'dokan-opening-hours') . '</h3>';
            echo '<div class="dokan-single-store-description">';

                echo wpautop($store_info['description'] );
            echo '</div>';
        }

    }

    public function add_opening_hours_fields($current_user, $profile_info )
    {

        echo '<h2>' . __('Opening Hours', 'dokan-opening-hours') . '</h2>';

        foreach ($this->weekdays as $key => $value) {

            $opening_hour_from = 'opening_hours[' . $key . '][0]';
            $opening_hour_until = 'opening_hours[' . $key . '][1]';

            $opening_hour_from_saved_data = isset( $profile_info['opening_hours'][$key][0] ) ? $profile_info['opening_hours'][$key][0] : '';
            $opening_hour_until_saved_data = isset( $profile_info['opening_hours'][$key][1] ) ? $profile_info['opening_hours'][$key][1] : '';
            ?>

            <div class="gregcustom dokan-form-group">
                <label class="dokan-w3 dokan-control-label" for="setting_address">
                    <?php echo $value ?>
                </label>
                <div class="dokan-w3">
                    <input type="time" class="dokan-form-control input-md valid" name="<?php echo $opening_hour_from ?>"  value="<?php echo $opening_hour_from_saved_data; ?>" />
                </div>
                <div class="dokan-w3">
                    <input type="time" class="dokan-form-control input-md valid" name="<?php echo $opening_hour_until ?>"  value="<?php echo $opening_hour_until_saved_data; ?>" />
                </div>
            </div>

        <?php
        }
    }

    public function save_opening_hours_fields( $store_id )
    {
        $dokan_settings = dokan_get_store_info($store_id);
        if ( isset( $_POST['opening_hours'] ) ) {
            $dokan_settings['opening_hours'] = $_POST['opening_hours'];
        }

        update_user_meta( $store_id, 'dokan_profile_settings', $dokan_settings );
    }

    public function show_opening_hours_fields($store_user)
    {
        return false;

        $store_info = dokan_get_store_info($store_user);

        if ( isset( $store_info['opening_hours'] ) && !empty( $store_info['opening_hours'] ) ) { 
            _e('Opening Hours', 'dokan-opening-hours');
            echo wpautop($store_info['opening_hours'] );
        }

    }

    public function show_opening_hours_on_listing($seller, $store_info) 
    {
        $opening_hours = "";
        if ( isset( $store_info['opening_hours'] ) && !empty( $store_info['opening_hours'] ) ) { 
            $opening_hours = json_encode($store_info['opening_hours']);
        }
        ?>

        <div class="dokan-store-opening-hours-current-open-container" data-opening-hours='<?php echo $opening_hours ?>'>

            <div class="dokan-store-opening-hours-current-open">
                <div class="dokan-store-opening-hours-current-open-circle"></div>
                <div class="dokan-store-opening-hours-current-open-title"><?php echo __('currently open', 'dokan-opening-hours') ?></div>
                <div class="clear"></div>
            </div>

            <div class="dokan-store-opening-hours-current-closed">
                <div class="dokan-store-opening-hours-current-closed-circle"></div>
                <div class="dokan-store-opening-hours-current-closed-title"><?php echo __('currently closed', 'dokan-opening-hours') ?></div>
                <div class="clear"></div>
            </div>

        </div>    
        <?php
    }

    public function display_opening_hours()
    {
        $store_info   = dokan_get_store_info( get_query_var( 'author' ) );
        $opening_hours = isset( $store_info['opening_hours'] ) ? $store_info['opening_hours'] : '';

        
    }
}