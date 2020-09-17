<?php

namespace Flyn\Xenforo;

use Flyn\Xenforo\Shortcodes\Xenforo as XenforoShortcode;

class Xenforo
{
    use \Flyn\Xenforo\Traits\Singleton;

    public $baseUrl = 'https://askandyaboutclothes.com/forum/';
    public $api;

    public function __construct()
    {
        $apiKey = defined('FLYNXENFORO_API_KEY') ? FLYNXENFORO_API_KEY : '';
        $this->api = new API($this->baseUrl . 'api/', $apiKey);

        add_shortcode('xenforo', [new XenforoShortcode(), 'shortcode']);

        add_action('wp_ajax_nopriv_flynxenforo-recache', [$this, 'recache']);
        add_action('wp_ajax_flynxenforo-recache', [$this, 'recache']);
    }

    public function recache()
    {
        header('Content-Type: application/json');
        exit(json_encode($this->api->get('nodes/flattened', [], true)));
    }
}
