<?php

use App\User;


if( ! function_exists('isDev') ){
    /**
     *
     * Check the current environment
     *
     * @return bool
     */
    function isDev()
    {
        $isDev = strtolower(config('app.env')) == 'development';
        $isLocal = strtolower(config('app.env')) == 'local';

        return ($isDev || $isLocal);
    }
}

if( ! function_exists('aggregateLink') ){
    function aggregateLink(string $url)
    {
        $videoId                      = getIdFromUrl($url);
        $attributesArray              = [];
        $attributesArray['thumbnail'] = getVideoThumbnail($videoId, 'hq');
        $attributesArray['src']       = $url;
        $embedCode = '<iframe width="560" height="315" src="https://www.youtube.com/embed/' . $videoId . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';

        return [
            'sanitized_embed_code' => $embedCode,
            'attributes' => $attributesArray,
        ];
    }
}

if ( ! function_exists('isAdmin') ) {
    function isAdmin(User $user = null) {
        return ($user ?? auth()->user())?->role === 'admin';
    }
}

if ( ! function_exists('getIdFromUrl') ) {
    /**
     * Retrieves ID from YouTube URL
     */
    function getIdFromUrl(string $videoUrl): ?string
    {
        $URL_REGEX =
            '%^             # Match any youtube URL
            (?:https?://)?  # Optional scheme. Either http or https
            (?:www\.)?      # Optional www subdomain
            (?:             # Group host alternatives
            youtu\.be/    # Either youtu.be,
            | youtube\.com  # or youtube.com
            (?:           # Group path alternatives
                /embed/     # Either /embed/
            | /v/         # or /v/
            | /watch\?v=  # or /watch\?v=
            )             # End path alternatives.
            )               # End host alternatives.
            ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
            $%x';

        $urlComponents = [];
        $parsedUrl = parse_url($videoUrl, PHP_URL_QUERY);

        if ($parsedUrl) {
            parse_str($parsedUrl, $urlComponents);
        }

        if (isset($urlComponents['v'])) {
            return $urlComponents['v'];
        }

        preg_match($URL_REGEX, $videoUrl, $matches);

        return $matches[1] ?? null;
    }
}

if ( ! function_exists('getVideoThumbnail') ) {
    /**
     * Retrieves path to youtube video thumbnail
     */
    function getVideoThumbnail(string $videoId, string $quality = null): string
    {
        $QUALITY_MAP = ['hq', 'mq', 'sd', 'maxres'];
        $URL_IMAGES = 'http://img.youtube.com/vi';

        if (! is_null($quality) && ! in_array($quality, $QUALITY_MAP)) {
            throw new InvalidArgumentException("Invalid quality mode '{$quality}' requested for video thumbnail.");
        }

        $urlBlocks = [
            rtrim($URL_IMAGES, '/'),
            $videoId,
            $quality . 'default.jpg',
        ];

        $urlBlocks = array_filter($urlBlocks, fn ($block) => ! empty($block));

        return implode('/', $urlBlocks);
    }
}

?>
