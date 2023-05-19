<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Screen\AsSource;

class Budget extends Model
{
    use HasFactory,AsSource, Filterable, Attachable,Chartable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    // protected $with = ['depense'];

    public function depense(){
        return $this->belongsTo(Depense::class,'id_depense');
    }
    public function annee(){
        return $this->belongsTo(Annee::class,'id_annee');
    }

    public function getFullAttribute(): string
    {
        return '| '.$this->id.' | -' .$this->depense->libelle ;
    }
}
