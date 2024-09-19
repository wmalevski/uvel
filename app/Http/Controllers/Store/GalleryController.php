<?php

namespace App\Http\Controllers\Store;

use App\PublicGallery;
use Illuminate\Http\Request;

class GalleryController extends BaseController
{
    public function index(PublicGallery $gallery)
    {
        $assets = $gallery::select('media_type', 'media_path', 'title', 'thumbnail_path')->orderBy('id', 'DESC')->paginate(\App\Setting::where('key','per_page')->first()->value ?? 30);

        return view('store.pages.gallery.index')
            ->with([
                'assets'      => $assets,
                'assetsArray' => $assets->toArray(),
                'pagination'  => $assets->hasMorePages(),
            ]);
    }
}
