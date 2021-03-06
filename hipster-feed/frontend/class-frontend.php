<?php

namespace HipsterFeed;

/**
 * The code used on the frontend.
 */
class Frontend
{
    private $plugin_slug;
    private $version;
    private $option_name;
    private $settings;

    public function __construct($plugin_slug, $version, $option_name) {
        $this->plugin_slug = $plugin_slug;
        $this->version     = $version;
        $this->option_name = $option_name;
        $this->settings    = get_option($this->option_name);
    }

    public function assets() {
        wp_enqueue_style($this->plugin_slug, plugin_dir_url(__FILE__).'css/hipster-feed-frontend.css', [], $this->version);
        wp_register_script($this->plugin_slug, plugin_dir_url(__FILE__).'js/hipster-feed-frontend.js', ['jquery'], $this->version, true);

        $settings = $this->settings;

        wp_localize_script($this->plugin_slug, 'settings', [
            'owlCarouselJS'  => 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js',
            'owlCarouselCSS' => 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.carousel.min.css',
            'items'          => $settings['items'],
            'loop'           => $settings['loop'],
            'nav'            => $settings['nav'],
            'dots'           => $settings['dots']
        ]);

        wp_enqueue_script($this->plugin_slug);
    }

    /**
     * Render the view using MVC pattern.
     */
    public function render() {

        // Model
        $settings = $this->settings;

        if (!empty($settings['access_token'])) {

            // Controller
            $url    = sprintf('https://api.instagram.com/v1/users/self/media/recent/?access_token=%s', $settings['access_token']);
            $json   = json_decode(file_get_contents($url));
            $instas = $json->data;

            // View
            $output = '';
            if (locate_template('partials/' . $this->plugin_slug . '.php')) {
                require locate_template('partials/' . $this->plugin_slug . '.php');
            } else {
                require plugin_dir_path(dirname(__FILE__)).'frontend/partials/view.php';
            }
            return $output;
        }
    }
}
