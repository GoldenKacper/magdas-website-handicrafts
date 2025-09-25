<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Availability extends Model
{
    /** @use HasFactory<\Database\Factories\AvailabilityFactory> */
    use HasFactory;

    protected $table = "availabilities";
    protected $primaryKey = "id";
    protected $guarded = ["id"];

    protected $fillable = [
        'code',
        'label',
        'is_active',
        'locale',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
