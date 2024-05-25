<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'image', 'quantity', 'is_featured', 'brand'];

    protected $casts = [
        'image' => 'array',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($product) {
            // Log to debug
            \Log::debug('Deleting event triggered for product ID: ' . $product->id);

            // Check if the images field is null or already an array
            if ($product->image !== null && is_array($product->image)) {
                $images = $product->image;
            } else {
                // Decode the images JSON
                $images = json_decode($product->image, true);
            }

            if ($images && is_array($images)) {
                foreach ($images as $image) {
                    // Replace escaped slashes with regular slashes in the file path
                    $filePath = str_replace('\/', '/', $image);

                    // Get the full path to the file
                    $fullPath = storage_path('app/public/' . $filePath);

                    // Check if the file exists before attempting deletion
                    if (file_exists($fullPath)) {
                        if (is_dir($fullPath)) {
                            \Log::warning('Cannot delete directory: ' . $fullPath);
                        } else {
                            // Delete the associated file from storage
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
                \Log::warning('Invalid or empty images array for product ID: ' . $product->id);
            }
        });

        static::updating(function ($product) {
            // Log to debug
            \Log::debug('Updating event triggered for product ID: ' . $product->id);

            // Get the original image paths before update
            $originalImages = $product->getOriginal('image');

            // Check if the image field is being updated
            if ($product->isDirty('image')) {
                // Log the change
                \Log::debug('Image field updated for product ID: ' . $product->id . '. Old images: ' . json_encode($originalImages));

                // Decode the original images JSON if it's a string
                if (is_string($originalImages)) {
                    $originalImages = json_decode($originalImages, true);
                }

                // Get the new images array
                $newImages = $product->image;
                if (is_string($newImages)) {
                    $newImages = json_decode($newImages, true);
                }

                // Find the images that are no longer in the new images array
                $imagesToDelete = array_diff($originalImages, $newImages);

                if ($imagesToDelete && is_array($imagesToDelete)) {
                    foreach ($imagesToDelete as $image) {
                        // Replace escaped slashes with regular slashes in the file path
                        $filePath = str_replace('\/', '/', $image);

                        // Get the full path to the file
                        $fullPath = storage_path('app/public/' . $filePath);

                        // Check if the file exists before attempting deletion
                        if (file_exists($fullPath)) {
                            if (is_dir($fullPath)) {
                                \Log::warning('Cannot delete directory: ' . $fullPath);
                            } else {
                                // Delete the associated file from storage
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
                    \Log::warning('No images to delete for product ID: ' . $product->id);
                }
            }
        });
    }
}
