<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PublicGallery extends Model
{
    use HasFactory;
    protected $table = 'public_galleries';
    protected $fillable = [
        'title',
        'description',
        'media_type',
        'media_path',
        'thumbnail_path',
        'embed_code',
        'alt_text'
    ];

    public function delete() {
        try {
            if ($this->media_type === 'image' && file_exists($this->media_path)) {
                unlink($this->media_path);
                unlink($this->thumbnail_path);
            }
        } catch (\Exception $e) {
            throw $e->getMessage();
        }

        parent::delete();
    }
}
