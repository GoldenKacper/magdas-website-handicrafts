<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OpinionTranslation extends Model
{
    /** @use HasFactory<\Database\Factories\OpinionTranslationFactory> */
    use HasFactory;

    protected $table = "opinion_translations";
    protected $primaryKey = "id";
    protected $guarded = ["id"];

    protected $fillable = [
        'opinion_id',
        'first_name',
        'country_code',
        'content',
        'image_alt',
        'label_meta',
        'order',
        'rating',
        'visible',
        'locale'
    ];

    protected $casts = [
        'visible' => 'bool',
    ];

    public function opinion(): BelongsTo
    {
        return $this->belongsTo(Opinion::class);
    }
}
