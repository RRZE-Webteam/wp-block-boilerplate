<?php

namespace RRZE\WpBlockBoilerplate;

defined('ABSPATH') || exit;

use RRZE\WpBlockBoilerplate\ThemeSniffer;

class Patterns
{
    public function __construct()
    {
        $this->register_hooks();
    }

    /**
     * Register all hooks.
     */
    private function register_hooks()
    {
        add_action('init', [$this, 'wp_block_boilerplate_pattern_categories']);
        add_action('init', [$this, 'register_fau_custom_wp_block_patterns']);
        add_action('init', [$this, 'register_dev_patterns']);
    }

    /**
     * Register pattern categories.
     */
    public function wp_block_boilerplate_pattern_categories()
    {
        // register_block_pattern_category('page', [
        //     'label'       => _x('Pages', 'Block pattern category'),
        //     'description' => __('A collection of full page layouts.'),
        // ]);

        if (!$this->is_development_environment() || !ThemeSniffer::getThemeGroup('fauthemes')) {
            return;
        }

        register_block_pattern_category('dev-wp-block-boilerplate', [
            'label'       => _x('DEV: wp-block-boilerplate', 'Block pattern category'),
            'description' => __('A collection of DEV layouts for automated testing.'),
        ]);
    }

    /**
     * Register development patterns.
     */
    public function register_dev_patterns()
    {
        if (!$this->is_development_environment() || !ThemeSniffer::getThemeGroup('fauthemes')) {
            return;
        }

        $patterns = [
            [
                'file_name'   => 'dev-example',
                'pattern_name' => 'wp-block-boilerplate/dev-example',
                'title'       => __('DEV: Example', 'wp-block-boilerplate'),
                'description' => _x('A testing template.', 'DEV Template', 'wp-block-boilerplate'),
                'categories'  => ['dev-wp-block-boilerplate'],
                'postTypes'   => ['page'],
                'inserter'    => true,
                'keywords'    => [],
                'blockTypes'  => [],
                'isPhp'       => true
            ]
        ];

        foreach ($patterns as $pattern) {
            $this->register_pattern(
                $pattern['file_name'],
                $pattern['pattern_name'],
                $pattern['title'],
                $pattern['description'],
                $pattern['categories'],
                $pattern['postTypes'],
                $pattern['inserter'],
                $pattern['keywords'],
                $pattern['blockTypes'],
                $pattern['isPhp'] ?? false,
                'dev-patterns'
            );
        }
    }

    /**
     * Register custom WP block patterns for FAU themes.
     */
    public function register_fau_custom_wp_block_patterns()
    {
        if (!ThemeSniffer::getThemeGroup('fauthemes')) {
            return;
        }

        $patterns = [
            [
                'file_name'   => 'example',
                'pattern_name' => 'wp-block-boilerplate/example',
                'title'       => __('Example Pattern Blockeditor', 'wp-block-boilerplate'),
                'description' => _x('Description for Example Pattern', 'Block pattern description', 'wp-block-boilerplate'),
                'categories'  => ['text'],
                'postTypes'   => ['page'],
                'inserter'    => true,
                'keywords'    => [],
                'blockTypes'  => [],
                'isPhp'       => false
            ]
        ];

        foreach ($patterns as $pattern) {
            $this->register_pattern(
                $pattern['file_name'],
                $pattern['pattern_name'],
                $pattern['title'],
                $pattern['description'],
                $pattern['categories'],
                $pattern['postTypes'] ?? ['page', 'single'],
                $pattern['inserter'] ?? true,
                $pattern['keywords'] ?? [],
                $pattern['blockTypes'] ?? [],
                $pattern['isPhp'] ?? false,
                'patterns'
            );
        }
    }

    /**
     * Register a block pattern.
     */
    private function register_pattern($file_name, $pattern_name, $title, $description, $categories, $postTypes = ['page', 'single'], $inserter = true, $keywords = [], $blockTypes = [], $isPhp = false, $directory = 'patterns')
    {

        if ($isPhp) {
            $extension = '.php';
        } else {
            $extension = '.html';
        }

        $pattern_path = plugin_dir_path(__FILE__) . $directory . '/' . $file_name . $extension;

        if (!file_exists($pattern_path)) {
            return;
        }

        $pattern_content = file_get_contents($pattern_path);

        $pattern_content = $this->replace_random_numbers($pattern_content);

        if (function_exists('register_block_pattern')) {
            register_block_pattern($pattern_name, [
                'title'       => $title,
                'description' => $description,
                'content'     => $pattern_content,
                'categories'  => $categories,
                'postTypes'   => $postTypes,
                'inserter'    => $inserter,
                'keywords'    => $keywords,
                'blockTypes'  => $blockTypes,
            ]);
        }
    }

    /**
     * Replace {random_number} placeholders with unique random numbers.
     */
    private function replace_random_numbers($content)
    {
        $random_numbers = [];
        $content = preg_replace_callback('/{random_number}/', function () use (&$random_numbers) {
            static $counter = 0;
            $pair_index = intval($counter / 2);

            if (!isset($random_numbers[$pair_index])) {
                $random_numbers[$pair_index] = rand(100, 1000);
            }

            $counter++;
            return $random_numbers[$pair_index];
        }, $content);

        return $content;
    }

    /**
     * Check if the current environment is development.
     */
    private function is_development_environment()
    {
        return wp_get_environment_type() === 'local';
    }
}
