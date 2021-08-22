<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'project_id',
        'status_id',
    ];

    protected $with = ['project'];

    public static $statuses = [
        '0' => 'Created',
        '1' => 'Working',
        '2' => 'Paused',
        '3' => 'Pending validation',
        '4' => 'Finished',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    public function getCreatedAtAttribute($created_at)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $created_at)->format('d/m/Y H:i:s');
    }

    public function getUpdatedAtAttribute($updated_at)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $updated_at)->format('d/m/Y H:i:s');
    }

    public function getDeleteAtAttribute($deleted_at)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $deleted_at)->format('d/m/Y H:i:s');
    }
}
