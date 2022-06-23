<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Models\Attachment;

class Beneficiare extends Model
{
    use HasFactory;

    protected $with = ['attach'];
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function attach()
    {
        return $this->belongsTo(Attachment::class, 'carteId','id');
    }
}
