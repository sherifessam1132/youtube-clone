<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded=[];
    public function getRouteKeyName()
    {
        return 'uid';
    }
    public function scopeLatestFirst($query)
    {
        return $query->orderBy('created_at','desc');
    }
    public function votesAllowed()
    {
        return (bool) $this->allow_votes;
    }
    public function commentsAllowed()
    {
        return (bool) $this->allow_comments;
    }
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
}
