<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class posts extends Model
{
    use HasFactory, Notifiable, SoftDeletes;
    protected $fillable = [
        'title', 'Body', 'image','Pinned','user_id'
    ];
    protected $dates = ['deleted_at'];  
    public function tags()
    {
        return $this->hasMany(tags::class);
    }
}
