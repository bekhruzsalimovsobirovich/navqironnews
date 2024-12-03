<?php

namespace App\Domain\Categories\Models;

use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model implements TranslatableContract
{
    use Translatable;

    /**
     * @var string[]
     */
    public $translatedAttributes  = ['name'];

    /**
     * @var string[]
     */
    protected $fillable = ['parent_id'];

    /**
     * @return HasOne
     */
    public function parent(): HasOne
    {
        return $this->hasOne(Category::class, 'parent_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
}
