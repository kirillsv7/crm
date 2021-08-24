<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

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
        '1' => 'Created',
        '2' => 'Working',
        '3' => 'Paused',
        '4' => 'Pending validation',
        '5' => 'Finished',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    public function scopeFilterByStatus($query)
    {
        if (request()->has('status_id')) {
            request()->validate([
                'status_id' => [
                    'numeric',
                    Rule::in(collect(self::$statuses)->keys()->prepend(0)),
                ],
            ]);
            if (request('status_id') != 0) {
                return $query->where('status_id', request()->input('status_id'));
            }
        }

        return $query;
    }

    public function scopeFilterAssignedToUser($query)
    {
        if (request()->has('assigned_to_user')) {
            request()->validate(['assigned_to_user' => 'boolean']);
            if (request('assigned_to_user') == true) {
                return $query->whereHas('project', function ($q) {
                    $q->where('user_id', auth()->id());
                });
            }
        }

        return $query;
    }

    public function getStatusAttribute()
    {
        return self::$statuses[$this->status_id];
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
