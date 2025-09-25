<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;
use App\HasI18nScopes;

class ProductImage extends Model
{
    /** @use HasFactory<\Database\Factories\ProductImageFactory> */
    use HasFactory, HasI18nScopes;

    protected $table = "product_images";
    protected $primaryKey = "id";
    protected $guarded = ["id"];

    protected $fillable = [
        'product_id',
        'image',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(ProductImageTranslation::class);
    }

    // "Current" translation according to app locale
    public function translation(): HasOne
    {
        return $this->hasOne(ProductImageTranslation::class)
            ->where('locale', app()->getLocale());
    }

    // Fallback: if no translation for current, try 'pl' or first available
    public function translationWithFallback(): HasOne
    {
        $locale = app()->getLocale();

        return $this->hasOne(ProductImageTranslation::class)
            ->where(function ($q) use ($locale) {
                $q->where('locale', $locale)
                    ->orWhere('locale', 'pl');
            })
            ->orderByRaw("CASE WHEN locale = ? THEN 0 WHEN locale = 'pl' THEN 1 ELSE 2 END", [$locale]);
    }

    // Convenient accessory: $category->name will be retrieved from translations
    // Laravel has a convention: get{StudlyCase}Attribute() → accessor to the {snake_case} field
    protected $appends = [
        'image_alt',
        'order',
        'visible',
        'image_url',
    ];

    public function getImageAltAttribute(): ?string
    {
        $t = $this->relationLoaded('translationWithFallback')
            ? $this->getRelation('translationWithFallback')
            : $this->translationWithFallback()->first();

        return $t?->image_alt;
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
    public function getImageUrlAttribute(): ?string
    {
        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk('public');

        return $this->image ? $disk->url($this->image) : null;
    }

    // Scope for eager-loading to avoid N+1
    // you have scopeWithLocalized() → you can write Category::withLocalized() due to the convention in Laravel
    public function scopeWithLocalized($query)
    {
        return $query->with(['translationWithFallback']);
    }

    // A set of all scopes needed for frontend
    public function scopeForFrontend($query)
    {
        return $query
            ->withLocalized()
            ->whereVisibleI18n('visible', 'pl')
            ->orderByI18n('order', 'asc', 'pl');
    }
}
