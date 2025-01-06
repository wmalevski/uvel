<?php

namespace App\Http\Controllers\Store;

use App\CustomOrder;
use App\Gallery;
use App\InfoMails;
use App\InfoPhones;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Response;
use File;
use Storage;
use Mail;
use Auth;
use App\CMS;
use App\Setting;

class CustomOrderController extends BaseController{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $attachment    = $request->get('blob');
        $url           = null;
        $mediaType     = $request->get('media') ?? 'image';
        $archive_date  = $request->get('archiveDate');
        $weight        = $request->get('weight');
        $type          = $request->get('jewelType');
        $size          = $request->get('size');
        $unique_number = $request->get('uniqueNumber');

        if ($attachment) {
            switch ($mediaType) {
                case 'video':
                    $url = '';
                    break;
                case 'image':
                    $url = Storage::url('/gallery' . '/' . $attachment);
                    break;
                default:
                    break;
            }
        }

        return \View::make('store.pages.orders.index')->with([
            'attachment'    => $url,
            'mediaType'     => $mediaType,
            'archive_date'  => $archive_date,
            'size'          => $size,
            'weight'        => $weight,
            'type'          => $type,
            'unique_number' => $unique_number
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $validator = Validator::make( $request->all(), [
            'name'                    => 'required|string',
            'email'                   => 'required|string|email|max:255',
            'content'                 => 'required|string',
            'phone'                   => 'required',
            'city'                    => 'required',
            'g-recaptcha-response'    => 'required|recaptcha',
            'images.*'                => 'file|max:2000|mimes:jpeg,png,jpg,gif',
        ], [
            'images.mimes'    => 'Каченият файл трябва да бъде в един от тези формати [jpeg,png,jpg,gif].',
            'images.max'      => 'Каченият файл не трябва да надвишава 2mb.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
        }

        $customOrder = CustomOrder::create($request->all());

        $path = storage_path('orders/');

        File::makeDirectory($path, 0775, true, true);
        if ( !Storage::disk('public')->exists('orders') ) {
            Storage::disk('public')->makeDirectory('orders', 0775, true);
        }
 
        // Clean up the temp folder if it exists. Related to uploading thumb files from youtube videos

        if (Storage::exists('temp')) {
            Storage::deleteDirectory('temp');
        }

        $file_data = $request->file('images');
        try {
            Mail::send('order',
                array(
                    'ID'            => $customOrder->id,
                    'name'          => $request->name,
                    'email'         => $request->email,
                    'city'          => $request->city,
                    'phone'         => $request->phone,
                    'content'       => $request->content,
                    'size'          => $request->size ?? null,
                    'unique_number' => $request->unique_number ?? null,
                    'weight'        => $request->weight ?? null,
                    'type'          => $request->type ?? null,
                    'archive_date'  => $request->archive_date ?? null
                ),
                function($message) use ($file_data, $customOrder) {
                    $message
                        ->to(config('mail.from.address'))
                        ->subject('Uvel Поръчка');

                    if($file_data){
                        foreach($file_data as $img) {
                            $file_name              = 'orderimage_' . uniqid().time() . '.' . $img->getClientOriginalExtension();
                            $imagePath              = $img->storeAs('orders', $file_name);
                            $absolutePath           = storage_path('app/public/' . $imagePath);
                            $url                    = Storage::url($imagePath);
                            $photo                  = new Gallery();
                            $photo->photo           = $file_name;
                            $photo->custom_order_id = $customOrder->id;
                            $photo->table           = 'orders';
                            $photo->save();
                            $message->attach($url);
                        }
                    }
                }
            );
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        return redirect()->route('custom_order')->with('success', 'Поръчката Ви беше изпратена успешно');
    }

}