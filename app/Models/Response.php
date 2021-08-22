<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Response extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['content', 'task_id', 'user_id'];
    protected $with = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
