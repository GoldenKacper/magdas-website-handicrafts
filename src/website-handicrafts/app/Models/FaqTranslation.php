<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FaqTranslation extends Model
{
    /** @use HasFactory<\Database\Factories\FaqTranslationFactory> */
    use HasFactory;

    protected $table = "faq_translations";
    protected $primaryKey = "id";
    protected $guarded = ["id"];

    protected $fillable = [
        'faq_id',
        'question',
        'answer',
        'order',
        'visible',
        'locale',
    ];

    protected $casts = [
        'visible' => 'bool',
    ];

    public function faq(): BelongsTo
    {
        return $this->belongsTo(Faq::class);
    }
}
