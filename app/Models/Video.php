<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use HasFactory,SoftDeletes;
    protected $guraded=[];
    public function getRouteKeyName()
    {
        return 'uid';
    }
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
}
