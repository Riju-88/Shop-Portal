<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'parent_id', 'image'];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // public function products()
    // {
    //     return $this->belongsToMany(Product::class);
    // }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product');
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($category) {
            // Log to debug
            \Log::debug('Deleting event triggered for category ID: ' . $category->id);

            // Check if the image field is not null
            if ($category->image !== null) {
                // Replace escaped slashes with regular slashes in the file path
                $filePath = str_replace('\/', '/', $category->image);

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
            } else {
                \Log::warning('No image found for category ID: ' . $category->id);
            }
        });

        static::updating(function ($category) {
            // Log to debug
            \Log::debug('Updating event triggered for category ID: ' . $category->id);

            // Get the original image path before update
            $originalImage = $category->getOriginal('image');

            // Check if the image field is being updated
            if ($category->isDirty('image')) {
                // Log the change
                \Log::debug('Image field updated for category ID: ' . $category->id . '. Old image: ' . $originalImage);

                // Check if the original image field is not null
                if ($originalImage !== null) {
                    // Replace escaped slashes with regular slashes in the file path
                    $filePath = str_replace('\/', '/', $originalImage);

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
                } else {
                    \Log::warning('No old image found for category ID: ' . $category->id);
                }
            }
        });
    }
}
