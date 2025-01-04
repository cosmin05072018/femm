<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
    ];

    /**
     * Relația dintre hotel și utilizatori.
     * Un hotel poate avea mai mulți utilizatori (indiferent de rol).
     */
    public function users()
    {
        return $this->hasMany(User::class, 'hotel_id');
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'hotel_department');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class, 'hotel_id');
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($hotel) {
            $hotel->employees()->delete(); // Șterge angajații asociați
        });
    }
}
