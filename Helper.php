<?php

// Import additionnal class into the global namespace
use \LaswitchTech\Core\Abstracts\Helper;

class GravatarHelper extends Helper {

    // Properties
    private $Path;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Import Global Variables
        global $CONFIG;

        // Set Properties
        $this->Path = $CONFIG->root() . DIRECTORY_SEPARATOR . 'data';
    }

    /**
     * Retrieve the Gravatar URL
     */
    public function url(string $email, int $size = 128): string
    {
        // Retrieve the Gravatar
        $gravatar = md5(strtolower(trim($email)));

        // Return the Gravatar
        return 'https://www.gravatar.com/avatar/' . $gravatar . '?s=' . $size . '&d=mp'; // Default: mp, identicon, monsterid, wavatar, retro, robohash, blank
    }

    /**
     * Retrieve the Gravatar Content
     */
    public function content(string $email, int $size = 128): string
    {
        // Retrieve the file content
        $content = file_get_contents($this->url($email, $size));

        // Return the file content
        return $content;
    }

    /**
     * Retrieve the Gravatar MIME Type
     */
    public function mimeType(string $email, int $size = 128): ?string
    {
        // Get headers from the Gravatar URL
        $headers = get_headers($this->url($email, $size), true);

        // Check if headers exist and contain Content-Type
        if ($headers && isset($headers['Content-Type'])) {
            return is_array($headers['Content-Type']) ? end($headers['Content-Type']) : $headers['Content-Type'];
        }

        // If unable to determine, return null
        return null;
    }
}
