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
    private $admin_slug;
    private $admin_page_url;
    private $auth_uri;
    private $token_uri;

    public function __construct($plugin_slug, $version, $option_name) {
        $this->plugin_slug = $plugin_slug;
        $this->version = $version;
        $this->option_name = $option_name;
        $this->settings = get_option($this->option_name);
        $this->settings_group = $this->option_name.'_group';
        $this->admin_slug = 'options-general.php';
        $this->admin_page_url = get_admin_url() . $this->admin_slug . '?page=' . $this->plugin_slug;
        $this->auth_uri = 'https://api.instagram.com/oauth/authorize/';
        $this->token_uri = 'https://api.instagram.com/oauth/access_token';history.replaceState(null, null, origin + pathname + pageQuery);
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
        wp_register_script($this->plugin_slug, plugin_dir_url(__FILE__).'js/hipster-feed-admin.js', ['jquery'], $this->version, true);

        wp_localize_script($this->plugin_slug, 'hipsterSettings', [
            'nonce' => wp_create_nonce($this->plugin_slug)
        ]);

        wp_enqueue_script($this->plugin_slug);
    }

    public function register_settings() {
        register_setting($this->settings_group, $this->option_name);
    }

    public function add_menus() {
        $plugin_name = Info::get_plugin_title();
        add_submenu_page(
            $this->admin_slug,
            $plugin_name,
            $plugin_name,
            'manage_options',
            $this->plugin_slug,
            [$this, 'render']
        );
    }

    public function logout() {

        check_ajax_referer($this->plugin_slug, 'security');

        $settings = $this->settings;

        if (!empty($settings['access_token'])) {

            // Unset items
            unset($settings['access_token']);
            unset($settings['user_id']);
            unset($settings['username']);
            unset($settings['full_name']);
            unset($settings['profile_picture']);

            // Save settings to database
            update_option($this->option_name, $settings);
        }

        die('success');
    }

    /**
     * Render the view using MVC pattern.
     */
    public function render() {

        // Generate the settings fields
        $field_args = [
            [
                'label' => 'API Client ID',
                'slug'  => 'client',
                'type'  => 'text'
            ],
            [
                'label' => 'API Client Secret',
                'slug'  => 'secret',
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

        // Authentication
        if (!empty($_GET['code'])) {

            $settings['code'] = $_GET['code'];

            // Curl request
            $instaQuery = [
                'client_id' => $settings['client'],
                'client_secret' => $settings['secret'],
                'grant_type' => 'authorization_code',
                'redirect_uri' => $this->admin_page_url,
                'code' => $_GET['code']
            ];

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $this->token_uri);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $instaQuery);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_NOBODY, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $jsonData = json_decode(curl_exec($ch));

            curl_close($ch);

            // Items to save to database
            $settings['access_token'] = $jsonData->access_token;
            $settings['user_id'] = $jsonData->user->id;
            $settings['username'] = $jsonData->user->username;
            $settings['full_name'] = $jsonData->user->full_name;
            $settings['profile_picture'] = $jsonData->user->profile_picture;

            // Save items to database
            update_option($this->option_name, $settings);
        }

        // Controller
        $authQuery = [
            'client_id' => $settings['client'],
            'redirect_uri' => $this->admin_page_url,
            'response_type' => 'code'

        ];
        $auth_uri = $this->auth_uri . '?' . http_build_query($authQuery);

        $fields = $this->custom_settings_fields($field_args, $settings);
        $settings_group = $this->settings_group;
        $heading = Info::get_plugin_title();
        $submit_text = esc_attr__('Save Settings', 'hipster-feed');

        if (!empty($settings['access_token'])) {
            $authentication = '<div id="hipster-feed-profile">';
            $authentication .= '<h3>' . $settings['full_name'] . '</h3>';
            $authentication .= '<img src="' . $settings['profile_picture'] . '" alt="' . esc_attr__('profile picture', 'hipster-feed') . '">';
            $authentication .= '<p><a id="hipster-feed-logout" href="#" class="button button-primary">Log Out</a></p>';
            $authentication .= '</div>';
            $authentication .= '<p><a id="hipster-feed-authenticate" href="' . $auth_uri . '" class="is-hidden button button-primary">Authenticate</a></p>';
        } else {
            $authentication = '<a id="hipster-feed-authenticate" href="' . $auth_uri . '" class="button button-primary">Authenticate</a>';
        }

        // View
        require_once plugin_dir_path(dirname(__FILE__)).'admin/partials/view.php';
    }
}
