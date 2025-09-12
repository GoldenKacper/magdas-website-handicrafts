<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\HasI18nScopes;

class Faq extends Model
{
    /** @use HasFactory<\Database\Factories\FaqFactory> */
    use HasFactory, HasI18nScopes;

    protected $table = "faqs";
    protected $primaryKey = "id";
    protected $guarded = ["id"];

    protected $fillable = [
        'icon'
    ];

    public function translations(): HasMany
    {
        return $this->hasMany(FaqTranslation::class);
    }

    // "Current" translation according to app locale
    public function translation(): HasOne
    {
        return $this->hasOne(FaqTranslation::class)
            ->where('locale', app()->getLocale());
    }

    // Fallback: if no translation for current, try 'pl' or first available
    public function translationWithFallback(): HasOne
    {
        $locale = app()->getLocale();

        return $this->hasOne(FaqTranslation::class)
            ->where(function ($q) use ($locale) {
                $q->where('locale', $locale)
                    ->orWhere('locale', 'pl');
            })
            ->orderByRaw("CASE WHEN locale = ? THEN 0 WHEN locale = 'pl' THEN 1 ELSE 2 END", [$locale]);
    }

    protected $appends = [
        'question',
        'answer',
        'order',
        'visible',
    ];

    public function getQuestionAttribute(): ?string
    {
        $t = $this->relationLoaded('translationWithFallback')
            ? $this->getRelation('translationWithFallback')
            : $this->translationWithFallback()->first();

        return $t->question;
    }

    public function getAnswerAttribute(): ?string
    {
        $t = $this->relationLoaded('translationWithFallback')
            ? $this->getRelation('translationWithFallback')
            : $this->translationWithFallback()->first();

        return $t->answer;
    }

    public function getOrderAttribute(): ?int
    {
        $t = $this->relationLoaded('translationWithFallback')
            ? $this->getRelation('translationWithFallback')
            : $this->translationWithFallback()->first();

        return $t->order;
    }

    public function getVisibleAttribute(): ?bool
    {
        $t = $this->relationLoaded('translationWithFallback')
            ? $this->getRelation('translationWithFallback')
            : $this->translationWithFallback()->first();

        return $t->visible;
    }

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
