<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        '0' => 'Created',
        '1' => 'Working',
        '2' => 'Paused',
        '3' => 'Pending validation',
        '4' => 'Finished',
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

    public function getDeadlineInvertedAttribute()
    {
        return Carbon::createFromFormat('Y-m-d', $this->deadline)->format('d/m/Y');
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
