<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['company', 'vat', 'address'];

    public function getCreatedAtAttribute($created_at)
    {
        return Carbon::parse($created_at)->format('d/m/Y H:i:s');
    }

    public function getUpdatedAtAttribute($updated_at)
    {
        return Carbon::parse($updated_at)->format('d/m/Y H:i:s');
    }

    public function getDeleteAtAttribute($deleted_at)
    {
        return Carbon::parse($deleted_at)->format('d/m/Y H:i:s');
    }
}
