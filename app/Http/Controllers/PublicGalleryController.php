<?php

namespace App\Http\Controllers;

use App\Jewel;
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
    const IMAGE_QUALITY = 20;

    public function index(PublicGallery $gallery)
    {
        $user     = Auth::user();
        $userRole = $user->role;
        $gallery  = $gallery->orderBy('id', 'DESC')->paginate(\App\Setting::where('key','per_page')->first()->value ?? 30);
        $locale   = app()->getLocale();
        $jewels   = Jewel::select('id', 'name')->get();

        return view('admin.gallery.index')->with(compact('userRole', 'gallery', 'locale', 'jewels'));
    }

    public function uploadVideo(Request $request, PublicGallery $gallery)
    {
        $validator = Validator::make($request->all(), [
            'media_type'          => 'required|in:video',
            'video_archive_date'  => 'required',
            'youtube_link'        => [
                'required',
                'string',
            ],
            'video_size'          => 'required|numeric',
            'video_weight'        => 'required|numeric',
            'video_unique_number' => 'required|numeric',
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
        $embed           = $embedMeta['sanitized_embed_code'] ?? NULL;
        $embedAttributes = $embedMeta['attributes'];
        $thumbnail       = $embedAttributes['thumbnail'];
        $embedSource     = $embedAttributes['src'];
        $uniqueNum       = $request->input('video_unique_number');
        $archiveDate     = Carbon::createFromFormat('d m y', $request->input('video_archive_date'));
        $archiveDate->setTime(now()->hour, now()->minute, now()->second);

        $formattedDate   = $archiveDate->format('Y-m-d H:i:s');
        $weight          = $request->input('video_weight');
        $type            = $request->input('video_type');
        $size            = $request->input('video_size');

        $gallery->create([
            'media_type'     => $request->input('media_type'),
            'embed_code'     => $embed,
            'thumbnail_path' => $thumbnail,
            'media_path'     => $embedSource,
            'title'          => $request->input('title') ?? NULL,
            'jewel_id'       => $type,
            'unique_number'  => $uniqueNum,
            'archive_date'   => $archiveDate,
            'weight'         => $weight,
            'jewel_id'       => $type,
            'size'           => $size
        ]);

        return redirect()->back()->with('success', 'Video uploaded successfully!');
    }

    public function uploadImage(Request $request, PublicGallery $gallery)
    {
        $validator = Validator::make($request->all(), [
            'images'        => 'required|array|max:5',
            'size'          => 'required|numeric',
            'archive_date'  => 'required',
            'weight'        => 'required|numeric',
            'unique_number' => 'required|numeric',
            'images.*'      => 'image|max:3045|mimes:jpeg,png,jpg,gif',
            'media_type'    => 'required|in:image', // Ensures media_type is 'image',
        ], [
            'images.required' => 'Пропуснахте да качите снимка.',
            'images.image'    => 'Каченият файл трябва да бъде снимка.',
            'images.mimes'    => 'Каченият файл трябва да бъде в един от тези формати [jpeg,png,jpg].',
            'images.max'      => 'Каченият файл не трябва да надвишава 2MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $images      = $request->file('images');
        $uniqueNum   = $request->input('unique_number');
        $archiveDate = Carbon::createFromFormat('d m y', $request->input('archive_date'));
        $archiveDate->setTime(now()->hour, now()->minute, now()->second);

        $formattedDate = $archiveDate->format('Y-m-d H:i:s');
        $weight        = $request->input('weight');
        $type          = $request->input('type');
        $size          = $request->input('size');

        if ( $request->hasFile('images') ) {
            foreach ($images as $image) {
                $filename      = str_replace(' ', '', $image->getClientOriginalName());
                $imagePath     = $image->storeAs('gallery', $filename);
                $absolutePath  = storage_path('app/public/' . $imagePath);
                $thumbnailUrl  = Storage::url('gallery/thumb_' . $filename);
                $thumbnailPath = storage_path('app/public/gallery/thumb_' . $filename);
                $this->thumbFactory($absolutePath, $thumbnailPath);

                $gallery->create([
                    'title'          => $request->input('title') ?? NULL,
                    'media_type'     => $request->input('media_type'),
                    'media_path'     => $absolutePath,
                    'description'    => $request->input('description') ?? NULL,
                    'thumbnail_path' => $thumbnailPath,
                    'unique_number'  => $uniqueNum,
                    'archive_date'   => $formattedDate,
                    'weight'         => $weight,
                    'jewel_id'       => $type,
                    'size'           => $size
                ]);
            }
        }

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

    /**
     * Creates an image that is suitable for thumbnail
     * @param $path - Absolute path to original image
     * @param $tpath - Generated thumb image storage
     */
    private function thumbFactory(string $path, string $tpath)
    {
        if (!file_exists($path)) {
            \Log::error(
                PHP_EOL . '    File: ' . __FILE__ . PHP_EOL .
                '    Line: ' . __LINE__ . PHP_EOL .
                '    File does not exist at path: ' . $path
            );
            return redirect()->back()->withErrors('File does not exist.');
        }

        try {
            $imageManager = new ImageManager(
                new InterventionDriver()
            );

            $blob = $imageManager
                ->read($path);

            $blobWidth = $blob->width();
            $blobHeight = $blob->height();

            if ( $blobWidth > 1280 ) {
                $blob->resize(1280, 720);
            }

            $blob->encode(new AutoEncoder(quality: self::IMAGE_QUALITY))
                ->save($tpath);
        } catch (\Exception $e) {
            \Log::error(
                PHP_EOL . '    File: ' . __FILE__ . PHP_EOL .
                '    Line: ' . __LINE__ . PHP_EOL .
                '    Error while processing image: ' . $e->getMessage()
            );
        }
    }
}
