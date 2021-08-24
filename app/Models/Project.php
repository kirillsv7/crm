<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'deadline',
        'client_id',
        'user_id',
        'status_id',
    ];

    protected $with = ['client', 'user'];
    protected $withCount = ['tasks'];

    public static $statuses = [
        '1' => 'Created',
        '2' => 'Working',
        '3' => 'Paused',
        '4' => 'Pending validation',
        '5' => 'Finished',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
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
                return $query->where('user_id', auth()->id());
            }
        }

        return $query;
    }

    public function getDeadlineInvertedAttribute()
    {
        return Carbon::createFromFormat('Y-m-d', $this->deadline)->format('d/m/Y');
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
