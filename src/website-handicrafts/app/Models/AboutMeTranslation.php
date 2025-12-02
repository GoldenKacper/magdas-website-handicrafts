<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AboutMeTranslation extends Model
{
    /** @use HasFactory<\Database\Factories\AboutMeTranslationFactory> */
    use HasFactory;

    protected $table = "about_me_translations";
    protected $primaryKey = "id";
    protected $guarded = ["id"];

    protected $fillable = [
        'about_me_id',
        'about_author_image_alt',
        'content',
        'main_page',
        'order',
        'visible',
        'locale',
    ];

    protected $casts = [
        'visible' => 'bool',
        'main_page' => 'bool',
    ];

    public function aboutMe(): BelongsTo
    {
        return $this->belongsTo(AboutMe::class);
    }
}
