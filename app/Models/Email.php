<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email_id',
        'from',
        'to',
        'subject',
        'body',
        'date',
        'is_read'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
