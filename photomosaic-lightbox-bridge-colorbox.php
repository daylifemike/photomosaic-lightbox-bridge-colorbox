<?php
/*
    Plugin Name: PhotoMosaic : Lightbox Bridge : Colorbox
    Plugin URI: https://github.com/daylifemike/photomosaic-lightbox-bridge-colorbox
    Description: Use jQuery Colorbox as your PhotoMosaic lightbox.  Requires the <strong>jQuery Colorbox</strong> plugin (which can be installed using the "Lightbox Plugin Details" link to the left).
    Author: Michael Kafka
    Author URI: http://www.codecanyon.net/user/makfak?ref=makfak
    Version: 0.1
    GitHub Plugin URI: daylifemike/photomosaic-lightbox-bridge-colorbox
*/

if ( ! defined( 'WPINC' ) ) { die; }

class PhotoMosaic_Lightbox_Bridge_Colorbox {

    protected $plugin_name = 'photomosaic-lightbox-bridge-colorbox';
    protected $plugin_slug = 'colorbox';
    protected $plugin_bridge = 'jquery-colorbox';
    protected $version = '0.1';

    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );

        add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'action_links' ) );
    }

    public function enqueue_scripts () {
        global $photomosaic;

        if ( !class_exists('PhotoMosaic') ) {
            $this->oops();
        } else {
            wp_enqueue_script(
                $this->plugin_name,
                plugins_url('/'. $this->plugin_name .'.js', __FILE__ ),
                array( $photomosaic->get_plugin_name() . '-localize' ),
                $this->version,
                true
            );
        }
    }

    public function action_links ( $links ) {
        $bridge_link = '<a
            href="' . admin_url( 'plugin-install.php?tab=plugin-information&plugin=' . $this->plugin_bridge . '&TB_iframe=true&width=772&height=957' ) . '"
            class="thickbox"
        >Lightbox Plugin Details</a>';

        array_push( $links, $bridge_link );

        return $links;
    }

    public function plugins_loaded () {
        global $photomosaic;

        if ( !class_exists('PhotoMosaic') || !is_object( $photomosaic ) ) {
            $this->oops();
        } else {
            $photomosaic->register_lightbox( $this->plugin_slug );
        }
    }

    public function oops () {
        // PhotoMosaic isn't installed or activated
    }
}

$photomosaic_lightbox_bridge_colorbox = new PhotoMosaic_Lightbox_Bridge_Colorbox;

?>