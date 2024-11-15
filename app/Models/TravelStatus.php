<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TravelStatus extends Model
{

    protected $fillable = ['status_name'];

    public function travelRequests()
    {
        return $this->hasMany(TravelRequest::class);
    }
}
