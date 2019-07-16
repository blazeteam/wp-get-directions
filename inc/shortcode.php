<?php

if (!defined('ABSPATH'))

    exit;



// Get Directions

add_shortcode('wp_get_directions', 'blz_get_directions_sc');

function blz_get_directions_sc($atts) {

    $opt   = get_option('blz_get_directions_options');

    $lat   = (!empty($opt['lat'])) ? esc_attr($opt['lat']) : '';

    $lon   = (!empty($opt['lon'])) ? esc_attr($opt['lon']) : '';

    $label = (!empty($opt['label'])) ? '<label for="your-location">' . esc_attr($opt['label']) . '</label>' : '';

    if (empty($lat) || empty($lon)) {

        $output = '<strong>' . __('Please enter the Latitude and Longitude of your location in the <a href="' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=blz_get_directions">settings page</a> to enable the Get Directions feature.', 'wp-get-directions') . '</strong>';

    } else {

        $output = '<form action="http://maps.google.com/maps" method="get" target="_blank" id="blz-get-directions">

      ' . $label . '

      <input type="text" name="saddr" id="your-location" placehoder="' . __('Your location', 'wp-get-directions') . '" />

      <input type="hidden" name="daddr" value="' . $lat . ',' . $lon . '" />

      <input type="submit" value="' . __('Submit', 'wp-get-directions') . '" />

      <a class="use-my-location" style="margin-left:10px" href="http://maps.google.com/maps?saddr=My%20Location&daddr=' . $lat . '%2C+' . $lon . '" target="_blank" title="' . __('Use my location', 'wp-get-directions') . '"><i class="fa fa-location-arrow"></i> ' . __('Use my location', 'wp-get-directions') . '</a>

    </form>';

    }

    return $output;

}

