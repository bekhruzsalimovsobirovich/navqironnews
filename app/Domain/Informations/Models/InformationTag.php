<?php

namespace App\Domain\Informations\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformationTag extends Model
{
    protected $fillable = ['information_id','name'];
}
