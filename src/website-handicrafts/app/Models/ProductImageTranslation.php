<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImageTranslation extends Model
{
    /** @use HasFactory<\Database\Factories\ProductImageTranslationFactory> */
    use HasFactory;

    protected $table = "product_image_translations";
    protected $primaryKey = "id";
    protected $guarded = ["id"];

    protected $fillable = [
        'product_image_id',
        'image_alt',
        'order',
        'visible',
        'locale',
    ];

    protected $casts = [
        'visible' => 'bool',
    ];

    public function productImage(): BelongsTo
    {
        return $this->belongsTo(ProductImage::class);
    }
}
