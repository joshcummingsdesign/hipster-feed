<?php

namespace HipsterFeed;

/**
 * The code used in the admin.
 */
class Admin
{
    private $plugin_slug;
    private $version;
    private $option_name;
    private $settings;
    private $settings_group;

    public function __construct($plugin_slug, $version, $option_name) {
        $this->plugin_slug = $plugin_slug;
        $this->version = $version;
        $this->option_name = $option_name;
        $this->settings = get_option($this->option_name);
        $this->settings_group = $this->option_name.'_group';
    }

    /**
     * Generate settings fields by passing an array of data (see the render method).
     *
     * @param array $field_args The array that helps build the settings fields
     * @param array $settings   The settings array from the options table
     *
     * @return string The settings fields' HTML to be output in the view
     */
    private function custom_settings_fields($field_args, $settings) {
        $output = '';

        foreach ($field_args as $field) {
            $slug = $field['slug'];
            $setting = $this->option_name.'['.$slug.']';
            $label = esc_attr__($field['label'], 'hipster-feed');
            $output .= '<h3><label for="'.$setting.'">'.$label.'</label></h3>';

            if ($field['type'] === 'text') {
                $output .= '<p><input type="text" id="'.$setting.'" name="'.$setting.'" value="'.$settings[$slug].'"></p>';
            } elseif ($field['type'] === 'textarea') {
                $output .= '<p><textarea id="'.$setting.'" name="'.$setting.'" rows="10">'.$settings[$slug].'</textarea></p>';
            } elseif ($field['type'] === 'toggle') {
                $output .= '<p><input type="checkbox" id="'.$setting.'" name="'.$setting.'" value="1" ' . checked($settings[$slug], 1, false) . '></p>';
            }
        }

        return $output;
    }

    public function assets() {
        wp_enqueue_style($this->plugin_slug, plugin_dir_url(__FILE__).'css/hipster-feed-admin.css', [], $this->version);
        wp_enqueue_script($this->plugin_slug, plugin_dir_url(__FILE__).'js/hipster-feed-admin.js', ['jquery'], $this->version, true);
    }

    public function register_settings() {
        register_setting($this->settings_group, $this->option_name);
    }

    public function add_menus() {
        $plugin_name = Info::get_plugin_title();
        add_submenu_page(
            'options-general.php',
            $plugin_name,
            $plugin_name,
            'manage_options',
            $this->plugin_slug,
            [$this, 'render']
        );
    }

    /**
     * Render the view using MVC pattern.
     */
    public function render() {

        // Generate the settings fields
        $field_args = [
            [
                'label' => 'Instagram username',
                'slug'  => 'user',
                'type'  => 'text'
            ],
            [
                'label' => 'Items per slide',
                'slug'  => 'items',
                'type'  => 'text'
            ],
            [
                'label' => 'Slider loop',
                'slug'  => 'loop',
                'type'  => 'toggle'
            ],
            [
                'label' => 'Show navigation',
                'slug'  => 'nav',
                'type'  => 'toggle'
            ],
            [
                'label' => 'Show dots',
                'slug'  => 'dots',
                'type'  => 'toggle'
            ]
        ];

        // Model
        $settings = $this->settings;

        // Controller
        $fields = $this->custom_settings_fields($field_args, $settings);
        $settings_group = $this->settings_group;
        $heading = Info::get_plugin_title();
        $submit_text = esc_attr__('Submit', 'hipster-feed');

        // View
        require_once plugin_dir_path(dirname(__FILE__)).'admin/partials/view.php';
    }
}
