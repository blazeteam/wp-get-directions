<?php
if (!defined('ABSPATH'))
    exit;

class BlzGetDirections {
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct() {
        add_action('admin_menu', array(
            $this,
            'add_plugin_page'
        ));
        add_action('admin_init', array(
            $this,
            'page_init'
        ));
    }

    /**
     * Add options page
     */
    public function add_plugin_page() {
        // This page will be under "Settings"
        add_options_page(__('Get Directions', 'wp-get-directions'), // page lon
            __('Get Directions', 'wp-get-directions'), // menu lon
            'manage_options', // capability
            'blz_get_directions', // menu slug
            array(
            $this,
            'create_admin_page'
        ) // function
            );
    }

    /**
     * Options page callback
     */
    public function create_admin_page() {
        // Set class property
        $this->options = get_option('blz_get_directions_options');
?>
       <div class="wrap">
            <h1><?php
        _e('Get Directions Settings', 'wp-get-directions');
?></h1>
            <form method="post" action="options.php">
            <?php
        // This prints out all hidden setting fields
        settings_fields('blz_get_directions_fields');
        do_settings_sections('blz_get_directions');
        submit_button();
?>
           </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init() {
        register_setting('blz_get_directions_fields', // Option group
            'blz_get_directions_options', // Option name
            array(
            $this,
            'sanitize'
        ) // Sanitize
            );

        add_settings_section('setting_section_location', // ID
            __('Your Business Location', 'wp-get-directions'), // Title
            array(
            $this,
            'print_location_section_info'
        ), // Callback
            'blz_get_directions' // Page
            );

        add_settings_field('lat', // ID
            __('Latitude', 'wp-get-directions'), // Title
            array(
            $this,
            'lat_callback'
        ), // Callback
            'blz_get_directions', // Page
            'setting_section_location' // Section
            );

        add_settings_field('lon', __('Longitude', 'wp-get-directions'), array(
            $this,
            'lon_callback'
        ), 'blz_get_directions', 'setting_section_location');

        add_settings_section('blz_get_directions_settings_label', // ID
            __('Get Directions Label', 'wp-get-directions'), // Title
            array(
            $this,
            'print_label_section_info'
        ), // Callback
            'blz_get_directions' // Page
            );

        add_settings_field('label', // ID
            __('Input Label', 'wp-get-directions'), // Title
            array(
            $this,
            'label_callback'
        ), // Callback
            'blz_get_directions', // Page
            'blz_get_directions_settings_label' // Section
            );

        add_settings_section('blz_get_directions_settings_shortcode', // ID
            __('Shortcode', 'wp-get-directions'), // Title
            array(
            $this,
            'print_shortcode_section_info'
        ), // Callback
            'blz_get_directions' // Page
            );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize($input) {
        $new_input = array();
        if (isset($input['lat']))
            $new_input['lat'] = sanitize_text_field($input['lat']);

        if (isset($input['lon']))
            $new_input['lon'] = sanitize_text_field($input['lon']);

        if (isset($input['label']))
            $new_input['label'] = sanitize_text_field($input['label']);

        return $new_input;
    }

    /**
     * Print the Section text
     */
    public function print_location_section_info() {
        print __('Enter the latitude and longitude of your business below. This is where your customers will be directed to.<br>You can find the coordinates of your chosen location <a href="https://www.latlong.net/convert-address-to-lat-long.html" target="_blank">here</a>.', 'wp-get-directions');
    }

    public function print_label_section_info() {
        print __('Option to have text above the Get Directions input.', 'wp-get-directions');
    }

    public function print_shortcode_section_info() {
        print __('Use the <code>[wp_get_directions]</code> shortcode in your page, post or widget.', 'wp-get-directions');
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function lat_callback() {
        printf('<input type="text" id="lat" name="blz_get_directions_options[lat]" value="%s" />', isset($this->options['lat']) ? esc_attr($this->options['lat']) : '');
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function lon_callback() {
        printf('<input type="text" id="lon" name="blz_get_directions_options[lon]" value="%s" />', isset($this->options['lon']) ? esc_attr($this->options['lon']) : '');
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function label_callback() {
        printf('<input type="text" id="label" name="blz_get_directions_options[label]" value="%s" />', isset($this->options['label']) ? esc_attr($this->options['label']) : '');
    }
}
