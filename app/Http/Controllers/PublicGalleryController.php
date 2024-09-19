<?php

namespace App\Http\Controllers;

use App\PublicGallery;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver as InterventionDriver;
use Intervention\Image\Encoders\AutoEncoder;
use Intervention\Image\ImageManager;

class PublicGalleryController extends Controller
{
    const IMAGE_QUALITY = 80;


    public function index(PublicGallery $gallery)
    {
        $user     = Auth::user();
        $userRole = $user->role;
        $gallery  = $gallery->orderBy('id', 'DESC')->paginate(\App\Setting::where('key','per_page')->first()->value ?? 30);
        $locale   = app()->getLocale();

        return view('admin.gallery.index')->with(compact('userRole', 'gallery', 'locale'));
    }

    public function uploadVideo(Request $request, PublicGallery $gallery)
    {
        $validator = Validator::make($request->all(), [
            'media_type' => 'required|in:video',
            'youtube_link' => [
                'required',
                'string',
            ],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Regular expression to validate YouTube URLs
        $youtubePattern = '/^(https?\:\/\/)?(www\.youtube\.com|youtu\.?be)\/.+$/';
        $youtubeLinkMatch = preg_match($youtubePattern, $request->input('youtube_link'), $matches);

        if (!count($matches)) {
            return redirect()->back()->withErrors('Въведеното видео от вас не е валиден youtube линк');
        }

        $embedMeta       = aggregateLink($request->input('youtube_link')); // Sanitize the embed code to prevent XSS
        $embed           = $embedMeta['sanitized_embed_code'] ?? null;
        $embedAttributes = $embedMeta['attributes'];
        $thumbnail       = $embedAttributes['thumbnail'];
        $embedSource     = $embedAttributes['src'];

        $gallery->create([
            'media_type'     => $request->input('media_type'),
            'embed_code'     => $embed,
            'thumbnail_path' => $thumbnail,
            'media_path'     => $embedSource,
            'title'          => $request->input('title') ?? NULL,
        ]);

        return redirect()->back()->with('success', 'Video uploaded successfully!');
    }

    public function uploadImage(Request $request, PublicGallery $gallery)
    {
        $validator = Validator::make($request->all(), [
            'images'     => 'required|image|max:2045|mimes:jpeg,png,jpg',
            'media_type' => 'required|in:image', // Ensures media_type is 'image',
        ], [
            'images.required' => 'Пропуснахте да качите снимка.',
            'images.image'    => 'Каченият файл трябва да бъде снимка.',
            'images.mimes'    => 'Каченият файл трябва да бъде в един от тези формати [jpeg,png,jpg].',
            'images.max'      => 'Каченият файл не трябва да надвишава 2MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $image               = $request->file('images');
        $filename            = 'PublicGalleryPhoto_' . now()->timestamp . '.' . $image->extension();
        $imagePath           = $image->storeAs('gallery', $filename);
        $absolutePath        = storage_path('app/public/' . $imagePath);
        $thumbnailUrl        = Storage::url('/gallery/thumb_' . $filename);
        $thumbnailPath       = storage_path('app/public/gallery/thumb_' . $filename);
        $interventionManager = new ImageManager(
            new InterventionDriver()
        );

        if (!file_exists($absolutePath)) {
            \Log::error(
                PHP_EOL . '    File: ' . __FILE__ . PHP_EOL .
                '    Line: ' . __LINE__ . PHP_EOL .
                '    File does not exist at path: ' . $absolutePath
            );
            return redirect()->back()->withErrors('File does not exist.');
        }

        try {
            $interventionManager
                ->read($absolutePath)
                ->resize(250,250)
                ->encode(new AutoEncoder(quality: self::IMAGE_QUALITY))
                ->save($thumbnailPath);
        } catch (\Exception $e) {
            \Log::error(
                PHP_EOL . '    File: ' . __FILE__ . PHP_EOL .
                '    Line: ' . __LINE__ . PHP_EOL .
                '    Error while processing image: ' . $e->getMessage()
            );
        }

        $gallery->create([
            'title'          => $request->input('title') ?? NULL,
            'media_type'     => $request->input('media_type'),
            'media_path'     => $absolutePath,
            'alt_text'       => $request->input('alt_text') ?? NULL,
            'thumbnail_path' => $thumbnailPath,
        ]);

        return redirect()->back()->with('success', 'Image uploaded successfully!');
    }

    /**
     * Delete the selected media item.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $media = PublicGallery::find($id);

        if (!$media) {
            return response()->json(['success' => 'Media not found', 'message' => 'Media not found.'], 404);
        }

        $media->delete();
        return response()->json(['success' => 'Изтрито успешно!', 'message' => 'Media deleted successfully.'], 200);
    }
}
