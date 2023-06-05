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
    public function scopeLatestFirsts($query)
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
    public function scopeLatestFirst($query)
    {
        return $query->orderBy('created_at','desc');
    }
    public function isProcessed()
    {
        return $this->processed;
    }
    public function getThumbnail()
    {
        if(!$this->isProcessed()){
            return '';
        }
        return $this->video_filename;
    }
    public function isPrivate()
    { 
        return $this->visiblity === 'private' ;
    }
    public function ownedByUser(User $user)
    {
        return $user->id === $this->channel->user->id;
    }
    public function canBeAccessed(User $user= null)
    {
        if(!$user && $this->isPrivate()){
            return false ;
        }
        if($user && $this->isPrivate() && ($user->id !== $this->channel->user_id))
        {
            return false ;
        }
        return true;
    }
}
