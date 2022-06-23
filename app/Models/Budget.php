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

    public function depense(){
        return $this->belongsTo(Depense::class,'id_depense');
    }
    public function annee(){
        return $this->belongsTo(Annee::class,'id_annee');
    }
}
