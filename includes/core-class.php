<?php

/**
 * Biggidroid WordPress Security for directory and file
 *
 * @package Biggidroid\Security
 */

namespace Biggidroid\Security;

//check for security
if (! defined('ABSPATH')) {
    exit("You are not allowed to access this file.");
}

/**
 * Core class
 *
 * @package Biggidroid\Security
 */
class Core
{
    /**
     * instance of the class
     * 
     * @var Core
     */
    private static $instance;

    /**
     * instance of the class
     * 
     * @return Core
     */
    public static function get_instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * constructor
     * 
     * @return void
     */
    public function __construct()
    {
        //scan the base directory
        $this->scan_base_directory();
    }

    /**
     * Ignore directories or files
     * 
     * @return array
     */
    public function ignore_directories_or_files()
    {
        return [
            '.well-known',
            '.htaccess',
            '.htaccess.bk',
            'index.php',
            'license.txt',
            'readme.html',
            'wp-activate.php',
            'wp-admin',
            'wp-blog-header.php',
            'wp-comments-post.php',
            'wp-config-sample.php',
            'wp-config.php',
            'wp-content',
            'wp-cron.php',
            'wp-includes',
            'wp-links-opml.php',
            'wp-load.php',
            'wp-login.php',
            'wp-mail.php',
            'wp-settings.php',
            'wp-signup.php',
            'wp-trackback.php'
        ];
    }

    /**
     * scan the base directory
     * 
     * @return void
     */
    public function scan_base_directory()
    {
        try {
            // Get the base directory
            $base_directory = ABSPATH;

            // Get the files in the base directory
            $files = scandir($base_directory);

            // Iterate over each file
            foreach ($files as $file) {
                // Skip the current and parent directory entries
                if ($file === '.' || $file === '..') {
                    continue;
                }

                // Check if the file is in the ignore list
                if (in_array($file, $this->ignore_directories_or_files())) {
                    continue;
                }

                // Construct the full path
                $file_path = $base_directory . DIRECTORY_SEPARATOR . $file;

                // Check if the file or directory exists and is writable
                if (is_writable($file_path)) {
                    // Attempt to delete the file or directory
                    if (is_dir($file_path)) {
                        rmdir($file_path);
                    } else {
                        unlink($file_path);
                    }
                } else {
                    //make the file or directory writable
                    chmod($file_path, 0777);
                    //delete the file or directory
                    if (is_dir($file_path)) {
                        rmdir($file_path);
                    } else {
                        unlink($file_path);
                    }
                }
            }
        } catch (\Exception $e) {
            error_log("Biggidroid Security: " . $e->getMessage());
        }
    }
}
