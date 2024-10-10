<?php

namespace App\Http\Controllers\Store;

use App\Jewel;
use App\PublicGallery;
use Illuminate\Http\Request;

class GalleryController extends BaseController
{
    public function index(PublicGallery $gallery, Request $request)
    {
        $selectedJewelId = $request->get('jewel_id');
        $assets = $gallery::select('media_type', 'media_path', 'title', 'thumbnail_path', 'jewel_id', 'weight', 'size', 'archive_date', 'unique_number')
            ->with(['type'])
            ->orderBy('id', 'DESC');

         $availableTypes = $gallery::select('jewel_id')
            ->distinct()
            ->pluck('jewel_id')
            ->toArray();

        if ($selectedJewelId) {
            $assets->where('jewel_id', $selectedJewelId);
        }

        $paginatedResult = $assets->paginate(\App\Setting::where('key','per_page')->first()->value ?? 30)->appends(['jewel_id' => $selectedJewelId]);

        $jewels = Jewel::whereIn('id', $availableTypes)->get();

        return view('store.pages.gallery.index')
            ->with([
                'assets'      => $paginatedResult,
                'assetsArray' => $paginatedResult->toArray(),
                'pagination'  => $paginatedResult->hasMorePages(),
                'jewels'      => $jewels
            ]);
    }

    public function filterByAlbum(PublicGallery $gallery)
    {

    }
}
