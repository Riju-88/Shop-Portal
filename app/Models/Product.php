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
}


}
