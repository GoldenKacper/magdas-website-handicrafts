<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;
use App\HasI18nScopes;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, HasI18nScopes;

    protected $table = "products";
    protected $primaryKey = "id";
    protected $guarded = ["id"];

    protected $fillable = [
        'category_id',
        'default_price',
        'default_currency',
        'stock_quantity',
        'slug',
    ];

    // Eager-load: product translation, availability, category (with fallback), and ALL photos with their translations
    protected $with = [
        'translationWithFallback.availability',
        'category.translationWithFallback',
        'imagesForFrontend.translationWithFallback',
    ];

    public function imagesForFrontend(): HasMany
    {
        $locale = app()->getLocale() ?? 'pl';

        return $this->hasMany(ProductImage::class)
            ->withLocalized()
            ->whereVisibleI18n('visible', $locale)
            ->orderByI18n('order', 'asc', $locale);
    }

    public function images(): HasMany
    {
        // we create a column 'image' (relative path) in product_images
        return $this->hasMany(ProductImage::class);
    }

    public function category(): BelongsTo
    {
        // category_id is nullable — we don't use withDefault()
        // to avoid creating empty objects; we simply return null in the accessor
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function translations(): HasMany
    {
        return $this->hasMany(ProductTranslation::class);
    }

    // "Current" translation according to app locale
    public function translation(): HasOne
    {
        return $this->hasOne(ProductTranslation::class)
            ->where('locale', app()->getLocale());
    }

    // Fallback: if no translation for current, try 'pl' or first available
    public function translationWithFallback(): HasOne
    {
        $locale = app()->getLocale();

        return $this->hasOne(ProductTranslation::class)
            ->where(function ($q) use ($locale) {
                $q->where('locale', $locale)
                    ->orWhere('locale', 'pl');
            })
            ->orderByRaw("CASE WHEN locale = ? THEN 0 WHEN locale = 'pl' THEN 1 ELSE 2 END", [$locale]);
    }

    // Support method to ensure the relation is loaded only once
    protected function currentTranslation(): ?ProductTranslation
    {
        $this->loadMissing('translationWithFallback.availability');
        return $this->getRelation('translationWithFallback');
    }

    /**
     * Returns the "main" photo selected according to:
     * 1) visible (visible = true) → first,
     * 2) lowest `order` from translation,
     * 3) lowest id as tie-breaker.
     *
     * If there are no visible ones — we take the first one according to `order`.
     */
    protected function mainImage(): ?ProductImage
    {
        $this->loadMissing('images.translationWithFallback');

        $images = $this->images;

        if ($images->isEmpty()) {
            return null;
        }

        // order by priorities
        $sorted = $images->sortBy(function (ProductImage $img) {
            $t = $img->getRelation('translationWithFallback');
            return [
                ($t?->visible ? 0 : 1),
                $t?->order ?? 99,   // NOTE: if you use display_order, change this and below
                $img->id,
            ];
        })->values();

        return $sorted->first();
    }

    // Convenient accessory: $category->name will be retrieved from translations
    // Laravel has a convention: get{StudlyCase}Attribute() → accessor to the {snake_case} field
    protected $appends = [
        'short_name',
        'name',
        'description',
        'price',
        'currency',
        'order',
        'visible',

        'availability_code',
        'availability_label',

        'category_name',

        'product_image',
        'product_image_alt',
        'product_image_url',
    ];

    public function getShortNameAttribute(): ?string
    {
        return $this->currentTranslation()?->short_name;
    }

    public function getNameAttribute(): ?string
    {
        return $this->currentTranslation()?->name;
    }

    public function getDescriptionAttribute(): ?string
    {
        return $this->currentTranslation()?->description;
    }

    public function getPriceAttribute(): ?string
    {
        return $this->currentTranslation()?->price ?? $this->default_price;
    }

    public function getCurrencyAttribute(): ?string
    {
        return $this->currentTranslation()?->currency ?? $this->default_currency;
    }

    public function getOrderAttribute(): ?int
    {
        return $this->currentTranslation()?->order;
    }

    public function getVisibleAttribute(): ?bool
    {
        return $this->currentTranslation()?->visible;
    }

    // Appends with availability (for translations)
    public function getAvailabilityCodeAttribute(): ?string
    {
        return $this->currentTranslation()?->availability?->code;
    }

    public function getAvailabilityLabelAttribute(): ?string
    {
        return $this->currentTranslation()?->availability?->label;
    }

    // category name from translation with fallback
    public function getCategoryNameAttribute(): ?string
    {
        // load relation only if not loaded (to avoid N+1)
        $this->loadMissing('category.translationWithFallback');

        // if product has no category (NULL), return NULL
        return $this->category?->translationWithFallback?->name;
    }

    // Appends with "main" image
    public function getProductImageAttribute(): ?string
    {
        return $this->mainImage()?->image;
    }

    public function getProductImageAltAttribute(): ?string
    {
        return $this->mainImage()?->translationWithFallback?->image_alt;
    }

    public function getProductImageUrlAttribute(): ?string
    {
        $img = $this->mainImage();
        if (!$img?->image) {
            return null;
        }

        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk('public');

        return $disk->url($img->image);
    }

    //The most convenient way is to create a scope with a 'base' set and the option to add additional tracks.
    public function scopeWithLocalized($query, array $extra = [], bool $withAllCategoryTranslations = false)
    {
        $base = [
            'translationWithFallback.availability',
            'category.translationWithFallback',
            // 'images.translationWithFallback',
            'imagesForFrontend.translationWithFallback',
        ];

        if ($withAllCategoryTranslations) {
            $base[] = 'category.translations';
        }

        return $query->with(array_merge($base, $extra));
    }

    // A set of all scopes needed for frontend
    public function scopeForFrontend($query)
    {
        return $query
            ->withLocalized()
            ->whereVisibleI18n('visible', 'pl')
            ->orderByI18n('order', 'asc', 'pl');
    }

    // HOW TO USE:

    /*

    // only translations + availability (default)
    Product::withLocalized()->get();

    // + images with translations and category
    Product::withLocalized([
        'images.translationWithFallback',
        'category',
    ])->get();


    // default (fallback to PL if no current locale)
    $products = Product::withLocalized()->get();
    foreach ($products as $p) {
        echo $p->category_name; // name for category_translations with fallback
    }

    // all category translations loaded too (e.g. for a filter list)
    $products = Product::withLocalized(extra: [], withAllCategoryTranslations: true)->get();
    // now you have: $product->category->translations (collection)


    // retrieve products with translations, category, and ALL images (with fallback)
    $products = Product::withLocalized()->get();

    foreach ($products as $p) {
        // appends from the main image
        echo $p->product_image_url;
        echo $p->product_image_alt;
        // access to all photos:
        foreach ($p->images as $img) {
            echo $img->image_url;          // url of a given photo
            echo $img->image_alt;          // alt for a photo according to the current locale with fallback
        }
    }

    */
}
