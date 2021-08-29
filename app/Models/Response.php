<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Response extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['content', 'task_id', 'user_id'];
    protected $with = ['user', 'media'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
