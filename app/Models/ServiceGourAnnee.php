<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Metrics\Chartable;
use Orchid\Screen\AsSource;

class ServiceGourAnnee extends Model
{
    use HasFactory,AsSource,Chartable;

    protected $table = 'vue_service_gourmand_annee';
}
