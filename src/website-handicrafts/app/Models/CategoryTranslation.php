<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CategoryTranslation extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryTranslationFactory> */
    use HasFactory;

    protected $table = "category_translations";
    protected $primaryKey = "id";
    protected $guarded = ["id"];

    protected $fillable = [
        'category_id',
        'name',
        'image_alt',
        'label_meta',
        'order',
        'visible',
        'locale',
    ];

    protected $casts = [
        'visible' => 'bool',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
