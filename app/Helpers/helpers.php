<?php

use App\User;
use App\Gallery;
use Picqer\Barcode\Types\TypeCode128;
use Picqer\Barcode\Renderers\SvgRenderer;
use Picqer\Barcode\BarcodeGeneratorSVG;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Illuminate\Support\Facades\DB;


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

if ( ! function_exists('getPhoto') ) {
    /**
     * Retrieves existing photo for provided @path argument
     * @var $path - relative file path
     */
    function getPhoto(string $path) : string
    {
        try {
            if (\Storage::exists($path)) {
                return \Storage::url($path);
            }
            return asset($path);
        } catch (\Throwable $th) {
            return '';
        }
    }
}

if ( ! function_exists('generateBarcodeSVG') ) {
    function generateBarcodeSVG( string $barcode, string $type, float $widthFactor = 2, float $height = 30, string $color = "black" ) : string
    {
        $renderer = (new BarcodeGeneratorSVG())->getBarcode($barcode, $type, $widthFactor, $height, $color);
        $renderer = str_replace('<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">', '', $renderer);
        $renderer = str_replace('<?xml version="1.0" standalone="no" ?>', '', $renderer);
        $renderer = preg_replace('~^(?:\r?\n)+~', '', $renderer); // Remove all leading EOLs

        return $renderer;
    }
}

if ( ! function_exists('generateBarcodeHTML') ) {
    function generateBarcodeHTML( string $barcode, string $type, float $widthFactor = 2, float $height = 30, string $color = "black" ) : string
    {
        return (new BarcodeGeneratorHTML())
            ->getBarcode($barcode, $type, $widthFactor, $height, $color);
    }
}

if ( ! function_exists('uploadPhotos') ) {
    function updatePhotos($table, $photoFiles = [], $pathname = '')
    {
        $currentPhotos = $table->photos;
        DB::transaction(function () use ($table, $photoFiles, $currentPhotos, $pathname) {
            if (empty($photoFiles)) {
                foreach ($currentPhotos as $photo) {
                    $photo->delete();
                }
                return; // Exit early since there's nothing to add
            }

            foreach ($photoFiles as $file) {
                $photo = $currentPhotos->shift() ?? new Gallery();
                $filename      = str_replace(' ', '', $file->hashName());
                $imagePath     = $file->storeAs($pathname, $filename);
                $absolutePath  = storage_path('app/public/' . $imagePath);
                $photo->photo = $filename;

                switch ($pathname) {
                    case 'orders':
                        $photo->custom_order_id = $table->id;
                        break;
                    case 'models':
                        $photo->model_id = $table->id;
                        break;
                    case 'products':
                        $photo->product_id = $table->id;
                        break;
                    case 'products_others':
                        $photo->product_other_id = $table->id;
                        break;
                    case 'stones':
                        $photo->stone_id = $table->id;
                        break;
                    case 'sliders':
                        $photo->slider_id = $table->id;
                        break;
                    case 'blogs':
                        $photo->blog_id = $table->id;
                        break;
                    default:
                        break;
                }

                $photo->table = $pathname;
                $photo->save();
            }

            foreach ($currentPhotos as $photo) {
                $photo->delete();
            }
        });

        return $currentPhotos;
    }
}

if (!function_exists('getCurrency')) {
    function getCurrencyRate(string $code): string
    {
        $cacheKey = 'currency_rate_' . $code;
        $currencyCode = strtoupper($code);
        $currencyRate = 1.0;
        $cachedRate = Cache::get($cacheKey);
        if (Cache::has($cacheKey)) {
            $currencyRate = $cachedRate;
            return $currencyRate;
        }
        $currencyRate = Currency::where('name', $currencyCode)->value('currency');
        if (!$currencyRate) {
            throw new InvalidArgumentException("Currency code '{$currencyCode}' is not supported.");
        }
        Cache::put($cacheKey, $currencyRate, now()->addHours(24));
        return $currencyRate;
    }
}
?>
