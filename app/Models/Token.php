<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    protected $table = 'tokens';

    protected $fillable = [
        'name_app',
        'api_url',
        'app_key',
        'app_secret',
        'callback_url',
        'access_token',
        'refresh_token',
        'expires_in',
        'refresh_expires_in',
        'status',
        'active_at',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden   = ['deleted_at'];
    
    public function hasExpired(){
        if($this->expires_in < Carbon::now()->startOfDay()){
            return true;
        }

        return false;
    }
}
