<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductTranslation extends Model
{
    /** @use HasFactory<\Database\Factories\ProductTranslationFactory> */
    use HasFactory;

    protected $table = "product_translations";
    protected $primaryKey = "id";
    protected $guarded = ["id"];

    protected $fillable = [
        'product_id',
        'availability_id',
        'short_name',
        'name',
        'description',
        'price',
        'currency',
        'order',
        'visible',
        'locale',
    ];

    protected $casts = [
        'visible' => 'bool',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function availability(): BelongsTo
    {
        return $this->belongsTo(Availability::class, 'availability_id', 'id');
    }
}
