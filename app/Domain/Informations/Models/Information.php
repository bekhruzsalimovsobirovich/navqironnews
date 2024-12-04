<?php

namespace App\Domain\Informations\Models;

use App\Domain\Files\Models\File;
use App\Models\Traits\Filterable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Information extends Model implements TranslatableContract
{
    use Filterable,Translatable;

    public $translatedAttributes  = ['title','text'];

    protected $fillable = [
        'category_id',
        'date',
    ];

    /**
     * @return MorphMany
     */
    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
