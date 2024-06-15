<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        // can set rules for admin users here
        return str_ends_with($this->email, '@example.net') && $this->hasVerifiedEmail();
    }

    /**
     * Get the URL to the user's profile photo.
     *
     * @return string
     */
    public function getProfilePhotoUrlAttribute()
    {
        $defaultUrl = 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($this->email))) . '?d=identicon';

        if ($this->profile_photo_path) {
            // Check if the profile photo path is an external URL
            if (filter_var($this->profile_photo_path, FILTER_VALIDATE_URL)) {
                return $this->profile_photo_path;
            }

            // Otherwise, return the local storage path
            return Storage::url($this->profile_photo_path);
        }

        return $defaultUrl;
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            \Log::debug('Deleting event triggered for user ID: ' . $user->id);

            if ($user->profile_photo_path) {
                $filePath = str_replace('\/', '/', $user->profile_photo_path);
                $fullPath = storage_path('app/public/profile-photos/' . $filePath);

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
            } else {
                \Log::warning('No profile photo path set for user ID: ' . $user->id);
            }
        });

        static::updating(function ($user) {
            \Log::debug('Updating event triggered for user ID: ' . $user->id);

            $originalPhotoPath = $user->getOriginal('profile_photo_path');

            if ($user->isDirty('profile_photo_path')) {
                \Log::debug('Profile photo updated for user ID: ' . $user->id . '. Old photo path: ' . $originalPhotoPath);

                if ($originalPhotoPath) {
                    $filePath = str_replace('\/', '/', $originalPhotoPath);
                    $fullPath = storage_path('app/public/profile-photos/' . $filePath);

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
            }
        });
    }
}
