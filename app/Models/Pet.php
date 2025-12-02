<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Pet Model
 * 
 * @property int $id Pet ID
 * @property int $user_id User ID
 * @property string $title Pet title
 * @property string $description Description
 * @property string $species Pet species
 * @property int $age Pet age (months)
 * @property string $photo Pet photo path
 * @property bool $is_visible Is visible
 */
class Pet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'species',
        'age',
        'photo',
        'is_visible',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'age' => 'integer',
        'is_visible' => 'boolean',
    ];

    /**
     * Validation rules
     * 
     * @param int|null $petId Pet ID (used to exclude itself when updating)
     * @return array<string, mixed>
     */
    public static function validationRules(?int $petId = null): array
    {
        return [
            'title' => 'required|string|max:100',
            'description' => 'required|string|min:10',
            'species' => 'required|string|max:50',
            'age' => 'required|integer|min:0|max:300',
            'photo' => $petId ? 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120' : 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'is_visible' => 'nullable|boolean',
        ];
    }

    /**
     * Validation messages
     * 
     * @return array<string, string>
     */
    public static function validationMessages(): array
    {
        return [
            'title.required' => 'Pet title is required',
            'title.max' => 'Pet title cannot exceed 100 characters',
            'description.required' => 'Description is required',
            'description.min' => 'Description must be at least 10 characters',
            'species.required' => 'Pet species is required',
            'species.max' => 'Pet species cannot exceed 50 characters',
            'age.required' => 'Pet age is required',
            'age.integer' => 'Pet age must be an integer',
            'age.min' => 'Pet age cannot be negative',
            'age.max' => 'Pet age cannot exceed 300 months',
            'photo.required' => 'Pet photo is required',
            'photo.image' => 'Uploaded file must be an image',
            'photo.mimes' => 'Image format only supports jpeg, png, jpg, gif',
            'photo.max' => 'Image size cannot exceed 5MB',
        ];
    }

    /**
     * Get the user that owns the pet
     * 
     * @return BelongsTo<User, Pet>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 获取宠物照片的完整URL
     * 
     * @return string
     */
    public function getPhotoUrlAttribute(): string
    {
        return asset('storage/' . $this->photo);
    }

    /**
     * Set default visibility
     * 
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        // Set default visibility to true when creating a pet
        static::creating(function ($pet) {
            if (!isset($pet->is_visible)) {
                $pet->is_visible = true;
            }
        });
    }
}
