<?php

namespace Flyn\Xenforo;

use FlynXenforo\Shortcodes\Xenforo;

class API
{
    protected $cache_timeout = 120; // 2 minutes
    protected $cache = [];
    protected $baseUrl = '';
    protected $apiKey = '';

    public function __construct($baseUrl, $apiKey)
    {
        $this->baseUrl = $baseUrl;
        $this->apiKey = $apiKey;
    }

    /**
     * Returns the response from the API
     *
     * @param string $path
     * @param array $options
     * @param bool $force_recache
     * @return array
     */
    public function get($path, array $options = [], $force_recache = false)
    {
        $cache_key = md5($path . implode('|', $options));
        $db_cache_key = 'fxf-api-' . $cache_key;

        // Check to see if we have a DB cache
        if (!isset($this->cache[$cache_key])) {
            $db_cache = get_transient($db_cache_key);

            if ($db_cache) {
                $this->cache[$cache_key] = $db_cache;
            }
        }

        if ($force_recache || !isset($this->cache[$cache_key])) {
            $db_cache_key = 'fxf-api-' . $cache_key;
            $dbcache = get_transient($db_cache_key);

            $response = wp_remote_get($this->baseUrl . $path, [
                'headers' => [
                    'XF-API-Key' => $this->apiKey
                ],
            ]);

            if (is_wp_error($response)) {
                return [
                    'errors' => [
                        'code' => 'api_retrieval_error',
                        'message' => $response->get_error_message(),
                    ],
                ];
            }

            $response = wp_remote_retrieve_body($response);
            $json = json_decode($response, true);

            if ($json === null) {
                return [
                    'errors' => [
                        'code' => 'api_decode_error',
                        'message' => $response,
                    ],
                ];
            }

            $this->cache[$cache_key] = $json;
            set_transient($db_cache_key, $json, $this->cache_timeout);
        }

        return $this->cache[$cache_key];
    }
}
