<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Screen\AsSource;

class Demande extends Model
{
    use HasFactory,AsSource, Filterable, Attachable,Chartable;

    protected $with = ['user','attach','service','beneficiaire','depense'];
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function beneficiaire(){
        return $this->belongsTo(Beneficiare::class,'id','demande_id');
    }
    public function service(){
        return $this->belongsTo(service::class,'service_id');
    }

    public function depense(){
        return $this->belongsTo(Depense::class,'depense_id');
    }

    public function formatDate(){
        $date = $this->updated_at;
        return Carbon::parse($date)->diffForHumans();
    }

    public function autAb1(){
        if ($this->autorisationAb1 == 'Accorder') {
           return '<i class="text-success">●</i>';
        }if ($this->autorisationAb1 == 'En_attente') {
            return '<i class="text-warning">●</i>';
         }if ($this->autorisationAb1 == 'Rejeter') {
            return '<i class="text-danger">●</i>';
         }if ($this->autorisationAb1 == '') {
            return '<i class="text-secondary">●</i>';
         }
    }
    public function autRec(){
        if ($this->autorisationRec == 'Accorder') {
           return '<i class="text-success">●</i>';
        }if ($this->autorisationRec == 'En_attente') {
            return '<i class="text-warning">●</i>';
         }if ($this->autorisationRec == 'Rejeter') {
            return '<i class="text-danger">●</i>';
         }if ($this->autorisationRec =='') {
            return '<i class="text-secondary">●</i>';
         }
    }
    public function autAB2(){
        if ($this->autorisationAb2 == 'Accorder') {
           return '<i class="text-success">●</i>';
        }if ($this->autorisationAb2 == 'En_attente') {
            return '<i class="text-warning">●</i>';
         }if ($this->autorisationAb2 == 'Rejeter') {
            return '<i class="text-danger">●</i>';
         }if ($this->autorisationAb2 == '') {
            return '<i class="text-secondary">●</i>';
         }
    }
    public function autCaisse(){
        if ($this->autorisationCaisse == 'Suffisant') {
           return '<i class="text-success">●</i>';
        }if ($this->autorisationCaisse == 'Insuffisant') {
            return '<i class="text-warning">●</i>';
         }if ($this->autorisationCaisse == '') {
            return '<i class="text-secondary">●</i>';
         }
    }

    public function autorisation(){
        return $this->autAb1().$this->autRec().$this->autAB2().$this->autCaisse();

        // if  ($this->autorisationAb1 && $this->autorisationRec && $this->autorisationAb2 && $this->autorisationCaisse){
        //     return '<i class="text-success">●</i><i class="text-success">●</i><i class="text-success">●</i><i class="text-success">●</i>';
        // } else if ($this->autorisationAb1 && $this->autorisationRec && $this->autorisationAb2) {
        //     return '<i class="text-success">●</i><i class="text-success">●</i><i class="text-success">●</i><i class="text-danger">●</i>';
        // }else if ($this->autorisationAb1 && $this->autorisationRec) {
        //     return '<i class="text-success">●</i><i class="text-success">●</i><i class="text-danger">●</i><i class="text-danger">●</i>';
        // } else if ($this->autorisationAb1) {
        //     return '<i class="text-success">●</i><i class="text-danger">●</i><i class="text-danger">●</i><i class="text-danger">●</i>';
        // }if  (!$this->autorisationAb1 && !$this->autorisationRec && !$this->autorisationAb2 && !$this->autorisationCaisse){
        //     return '<i class="text-danger">●</i><i class="text-danger">●</i><i class="text-danger">●</i><i class="text-danger">●</i>';
        // }

    }
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */

    public function attach()
    {
        return $this->belongsTo(Attachment::class, 'file','id');
    }

    public function annee()
    {
        return  substr($this->created_at,0,4) ;
    }
}
