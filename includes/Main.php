<?php

namespace RRZE\WpBlockBoilerplate;
use const RRZE\WpBlockBoilerplate\WPBLOCKBOILERPLATE_VERSION;

defined('ABSPATH') || exit;

/**
 * The Brain of the Plugin – Main Class
 */
class Main
{
    protected $pluginFile;

    public function __construct($pluginFile)
    {
        $this->pluginFile = $pluginFile;
        // add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);

        new Blocks();
        new Patterns();
    }

    /**
     * This method is used to register scripts and styles for the frontend.
     * The Block.json is used to enqueue the set scripts and styles if a block is in use.
     * @return void
     */
    public function registerScripts()
    {
        // USE THE SECTION FOR EMBEDDING FRONTEND SCRIPTS
        // Example Embed:
        // wp_register_script(
        //     'rrze-gsap',
        //     plugins_url('assets/js/gsap/gsap.min.js', plugin_basename($this->pluginFile)),
        //     [],
        //     WPBLOCKBOILERPLATE_VERSION
        // );
    }
}
