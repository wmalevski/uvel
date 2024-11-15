<?php

namespace App\Http\Controllers\Store;

use App\Jewel;
use App\PublicGallery;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GalleryController extends BaseController
{
    public array $searchCriteria = [
        'BY_DATE' => 1,
        'BY_NUM'  => 2
    ];

    public function index(PublicGallery $gallery, Request $request)
    {
        $selectedJewelId = $request->get('jewel_id');
        $videosParam     = $request->get('videos');
        $videosCount     = $gallery->select('id')->where('media_type', 'video')->count();
        $searchTerm      = $request->input('search');
        $isSearching     = !is_null($searchTerm);
        $queryParams     = $request->query();
        $assets = $gallery->select('media_type', 'media_path', 'title', 'thumbnail_path', 'jewel_id', 'weight', 'size', 'archive_date', 'created_at', 'unique_number')
            ->with(['type'])
            ->orderBy('id', 'ASC');

        if ( $isSearching ) {
            $criteria = $request->input('criteria');

            switch ($criteria) {
                case $this->searchCriteria['BY_DATE'] == $criteria:
                    $validate_data = [
                        'search' => 'numeric|digits:6',
                    ];

                    $validator = Validator::make( $request->all(), $validate_data);
                    if ($validator->fails()) {
                        return redirect()->back()->withErrors(__('Въведената дата трябва да съдържа 6 цифрени символа'))->withInput($request->all());
                    }

                    $year          = substr($searchTerm, 0, 2);
                    $month         = substr($searchTerm, 2, 2);
                    $day           = substr($searchTerm, 4, 2);
                    $formattedDate = Carbon::createFromFormat('y-m-d', "$year-$month-$day")->format('Y-m-d');

                    $assets->where('archive_date', 'like', "%$formattedDate%");
                    break;
                case $this->searchCriteria['BY_NUM'] == $criteria:
                    $assets->where('unique_number', 'like', "%$searchTerm%");
                    break;
                default:
                    break;
            }
        }

        $availableTypes = $gallery->select('jewel_id')
            ->distinct()
            ->pluck('jewel_id')
            ->toArray();

        if ($selectedJewelId) {
            $assets->where('jewel_id', $selectedJewelId)
                ->where('media_type', 'image');
        }

        if ($videosParam) {
            $assets->where('media_type', 'video');
        }

        $paginatedAssets = $assets->paginate(\App\Setting::where('key','per_page')->first()->value ?? 30)->appends(['jewel_id' => $selectedJewelId])->appends($request->query());;
        $jewels          = Jewel::whereIn('id', $availableTypes)->get();

        return view('store.pages.gallery.index')
            ->with([
                'images'      => $paginatedAssets,
                'imagesArray' => $paginatedAssets->toArray(),
                'videosCount' => $videosCount,
                'jewels'      => $jewels,
                'searchTerm'  => $searchTerm
            ]);
    }
}
