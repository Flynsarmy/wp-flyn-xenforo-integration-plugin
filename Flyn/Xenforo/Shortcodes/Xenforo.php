<?php

namespace Flyn\Xenforo\Shortcodes;

use Flyn\Xenforo\Xenforo as XF;
use Flyn\Xenforo\Helpers;

class Xenforo
{
    /**
     * Renders the Xenforo shortcode
     *
     * @param array $atts
     * @return string
     */
    public function shortcode(array $atts)
    {
        if (in_array('categories', $atts)) {
            return $this->categories();
        } elseif (isset($atts['category'])) {
            return $this->category($atts);
        }

        return '';
    }

    /**
     * Renders a category table
     *
     * @param integer $id
     * @return string
     */
    public function categories()
    {
        $api = XF::instance()->api;
        $nodes = $api->get('nodes/flattened')['nodes_flat'];

        $output = '';
        // Find the category we specified in the shortcode
        foreach ($nodes as $node) {
            if ($node['node']['node_type_id'] == 'Category') {
                $output .= $this->category([
                    'category' => $node['node']['node_id']
                ]);
                continue;
            }
        }

        return $output;
    }

    /**
     * Renders a category table
     *
     * @param integer $id
     * @return string
     */
    public function category(array $atts)
    {
        $id = intval($atts['category']);
        $api = XF::instance()->api;
        $nodes = $api->get('nodes/flattened')['nodes_flat'];

        // Find the given node and its children
        $childNodes = [];
        $the_node = null;
        foreach ($nodes as $node) {
            // Find the category we specified in the shortcode
            if ($node['node']['node_id'] == $id && $node['node']['node_type_id'] == 'Category') {
                $the_node = $node;
                continue;
            }

            // Retrieve a list of its children
            if ($node['node']['parent_node_id'] == $id && !empty($node['node']['display_in_list'])) {
                $childNodes[] = $node;
            }
        }

        if (!$the_node) {
            return 'Category not found.';
        }

        // Support override of the category's title
        if (isset($atts['block-header'])) {
            $the_node['node']['title'] = $atts['block-header'];
        }

        //return '<pre>' . print_r($the_node, true) . print_r($childNodes, true) . '</pre>' .

        return Helpers::requireWith(
            __DIR__ . '/../../../views/shortcodes/xenforo/category.php',
            [
                'baseUrl' => XF::instance()->baseUrl,
                'the_node' => $the_node,
                'childNodes' => $childNodes,
            ]
        );
    }
}
