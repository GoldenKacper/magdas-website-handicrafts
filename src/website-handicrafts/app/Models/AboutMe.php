<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

class AboutMe extends Model
{
    /** @use HasFactory<\Database\Factories\AboutMeFactory> */
    use HasFactory;

    protected $table = "about_mes";
    protected $primaryKey = "id";
    protected $guarded = ["id"];

    protected $fillable = [
        'about_author_image',
    ];

    public function translations(): HasMany
    {
        return $this->hasMany(AboutMeTranslation::class);
    }

    // "Current" translation according to app locale
    public function translation(): HasMany
    {
        return $this->hasMany(AboutMeTranslation::class)
            ->where('locale', app()->getLocale());
    }

    // Fallback: if no translation for current, try 'pl' or first available
    public function translationWithFallback(): HasMany
    {
        $locale = app()->getLocale() ?? 'pl';

        return $this->hasMany(AboutMeTranslation::class)
            ->where(function ($q) use ($locale) {
                $q->where('locale', $locale);
            })
            ->where('visible', '1')
            ->orderBy('order', 'asc')
            ->orderByRaw("CASE WHEN locale = ? THEN 0 WHEN locale = 'pl' THEN 1 ELSE 2 END", [$locale]);
    }

    // Convenient accessory: $category->name will be retrieved from translations
    // Laravel has a convention: get{StudlyCase}Attribute() → accessor to the {snake_case} field
    protected $appends = [
        'about_author_image_alt',
        'content',
        'main_page',
        'order',
        'visible',
        'about_author_image_url'
    ];

    public function getAboutAuthorImageAltAttribute(): ?string
    {
        $t = $this->relationLoaded('translationWithFallback')
            ? $this->getRelation('translationWithFallback')->first()
            : $this->translationWithFallback()->first();

        return $t?->about_author_image_alt;
    }

    public function getContentAttribute(): ?string
    {
        $t = $this->relationLoaded('translationWithFallback')
            ? $this->getRelation('translationWithFallback')->first()
            : $this->translationWithFallback()->first();

        return $t?->content;
    }

    public function getMainPageAttribute(): ?bool
    {
        $t = $this->relationLoaded('translationWithFallback')
            ? $this->getRelation('translationWithFallback')->first()
            : $this->translationWithFallback()->first();

        return $t?->main_page;
    }

    public function getOrderAttribute(): ?int
    {
        $t = $this->relationLoaded('translationWithFallback')
            ? $this->getRelation('translationWithFallback')
            : $this->translationWithFallback()->first();

        return $t?->order;
    }

    public function getVisibleAttribute(): ?bool
    {
        $t = $this->relationLoaded('translationWithFallback')
            ? $this->getRelation('translationWithFallback')
            : $this->translationWithFallback()->first();

        return $t?->visible;
    }

    /**
     * @return string|null
     */
    public function getAboutAuthorImageUrlAttribute(): ?string
    {
        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk('public');

        return $this->about_author_image ? $disk->url($this->about_author_image) : null;
    }

    // Scope for eager-loading to avoid N+1
    // you have scopeWithLocalized() → you can write Category::withLocalized() due to the convention in Laravel
    public function scopeWithLocalized($query)
    {
        return $query->with(['translationWithFallback']);
    }
}
