<?php

namespace RRZE\WpBlockBoilerplate;
defined('ABSPATH') || exit;

/**
 * The Blocks class initializes the blocks and sets up localization.
 */
class Blocks
{
    public function __construct()
    {
        add_action('init', [$this, 'rrze_wp_block_boilerplate_block_init']);
    }

    /**
     * Initializes the block registration and sets up localization.
     */
    public function rrze_wp_block_boilerplate_block_init()
    {
            $this->rrze_register_blocks_and_translations();
            // Additional logic for blocks with custom render callbacks below this line.
    }

    /**
     * Registers blocks and localizations.
     */
    private function rrze_register_blocks_and_translations()
    {
        // Array with the names of the blocks to be registered.
        $blocks = [
            'exampleblock'
        ];

        foreach ($blocks as $block) {
            register_block_type(plugin_dir_path(__DIR__) . 'build/' . $block);

            load_plugin_textdomain('wp-block-boilerplate', false, dirname(plugin_basename(__DIR__)) . 'languages');

            $script_handle = generate_block_asset_handle('wp-block-boilerplate/' . $block, 'editorScript');
            wp_set_script_translations($script_handle, 'wp-block-boilerplate', plugin_dir_path(__DIR__) . 'languages');
        }

        // Enqueue previously registered global styles and scripts here.
        // wp_enqueue_style('fontawesome');
        // wp_enqueue_style('rrze-elements-blocks');
    }
}
