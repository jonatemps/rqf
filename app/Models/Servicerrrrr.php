<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Service extends Model
{
    use HasFactory,AsSource, Filterable, Attachable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $with = ['secteur'];
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function secteur()
    {
        return $this->belongsTo(Secteur::class,'seceur_id');
    }

}
