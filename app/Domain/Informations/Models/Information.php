<?php

namespace App\Domain\Informations\Models;

use App\Domain\Categories\Models\Category;
use App\Models\Traits\Filterable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Information extends Model implements TranslatableContract
{
    use Filterable,Translatable;

    protected $casts = [
        'files' => 'json'
    ];

    public $translatedAttributes  = ['title','text'];

    protected $fillable = [
        'category_id',
        'date',
        'files',
    ];

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return HasMany
     */
    public function tags(): HasMany
    {
        return $this->hasMany(InformationTag::class);
    }
}
