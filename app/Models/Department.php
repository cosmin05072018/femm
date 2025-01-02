<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'departments'; // Opțional, doar dacă tabela este redenumită

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Get the users assigned to the department.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'department_id');
    }
    public function hotels()
    {
        return $this->belongsToMany(Hotel::class, 'hotel_department');
    }
}
