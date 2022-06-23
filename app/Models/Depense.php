<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Screen\AsSource;

class Depense extends Model
{
    use HasFactory,AsSource, Filterable, Attachable,Chartable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $with = ['categories','categorie1','categorie2'];
    protected $with = ['budget'];
    public $an ;
/**
 * The attributes that aren't mass assignable.
 *
 * @var array
 */
    protected $guarded = [];

    public function categorie1(){
        return $this->belongsTo(Depense::class,'id_cat_1');
    }

    public function categorie2(){
        return $this->belongsTo(Depense::class,'id_cat_2');
    }

    public function categories()
    {
        return $this->hasMany(Depense::class,'id_cat_1');
    }

    public function budget(){
        return $this->belongsTo(Budget::class,'id','id_depense');
    }

    public function getFullAttribute(): string
    {
        return '| ' . $this->attributes['numero'] . ' | -'.$this->attributes['libelle'];
    }

    public function annee()
    {
        return  substr($this->created_at,0,4) ;
    }
}
