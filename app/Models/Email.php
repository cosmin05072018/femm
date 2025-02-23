<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'message_id',
        'from',
        'to',
        'subject',
        'body',
        'is_seen',
        'attachments',
        'type'
    ];

    protected $casts = [
        'attachments' => 'array', // Convertim JSON-ul în array automat
    ];

    /**
     * Relație: un email aparține unui utilizator
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Returnează lista atașamentelor
     */
    public function getAttachmentsList()
    {
        return $this->attachments ? json_decode($this->attachments, true) : [];
    }
}
