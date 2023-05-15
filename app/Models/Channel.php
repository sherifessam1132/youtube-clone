<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Channel extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'name',
        'slug',
        'description',
        'image_filename',
    ];
    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}
