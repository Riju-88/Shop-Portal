<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'image', 'active'];

    protected $casts = [
        'image' => 'array',
    ];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($promo) {
            \Log::debug('Deleting event triggered for promo ID: ' . $promo->id);

            $images = $promo->image;

            if (is_string($images)) {
                $images = json_decode($images, true);
            }

            if ($images && is_array($images)) {
                foreach ($images as $image) {
                    $filePath = str_replace('\/', '/', $image);
                    $fullPath = storage_path('app/public/' . $filePath);

                    if (file_exists($fullPath)) {
                        if (is_dir($fullPath)) {
                            \Log::warning('Cannot delete directory: ' . $fullPath);
                        } else {
                            \Log::debug('Attempting to delete file: ' . $fullPath);
                            $deleted = unlink($fullPath);

                            if ($deleted) {
                                \Log::info('File deleted successfully: ' . $fullPath);
                            } else {
                                \Log::error('Failed to delete file: ' . $fullPath);
                            }
                        }
                    } else {
                        \Log::warning('File does not exist: ' . $fullPath);
                    }
                }
            } else {
                \Log::warning('Invalid or empty images array for promo ID: ' . $promo->id);
            }
        });

        static::updating(function ($promo) {
            \Log::debug('Updating event triggered for promo ID: ' . $promo->id);

            $originalImages = $promo->getOriginal('image');

            if ($promo->isDirty('image')) {
                \Log::debug('Image field updated for promo ID: ' . $promo->id . '. Old images: ' . json_encode($originalImages));

                if (is_string($originalImages)) {
                    $originalImages = json_decode($originalImages, true);
                }

                $newImages = $promo->image;
                if (is_string($newImages)) {
                    $newImages = json_decode($newImages, true);
                }

                $imagesToDelete = array_diff($originalImages, $newImages);

                if ($imagesToDelete && is_array($imagesToDelete)) {
                    foreach ($imagesToDelete as $image) {
                        $filePath = str_replace('\/', '/', $image);
                        $fullPath = storage_path('app/public/' . $filePath);

                        if (file_exists($fullPath)) {
                            if (is_dir($fullPath)) {
                                \Log::warning('Cannot delete directory: ' . $fullPath);
                            } else {
                                \Log::debug('Attempting to delete old file: ' . $fullPath);
                                $deleted = unlink($fullPath);

                                if ($deleted) {
                                    \Log::info('Old file deleted successfully: ' . $fullPath);
                                } else {
                                    \Log::error('Failed to delete old file: ' . $fullPath);
                                }
                            }
                        } else {
                            \Log::warning('Old file does not exist: ' . $fullPath);
                        }
                    }
                } else {
                    \Log::warning('No images to delete for promo ID: ' . $promo->id);
                }
            }
        });
    }
}
