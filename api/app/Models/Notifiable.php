<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifiable extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'allow_notify_to_email',
        'allow_notify_to_phone',
    ];
}
