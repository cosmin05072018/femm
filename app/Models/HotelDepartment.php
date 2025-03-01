<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelDepartment extends Model
{
    use HasFactory;

    protected $table = 'hotel_department'; // Numele tabelei în baza de date

    protected $fillable = ['hotel_id', 'department_id']; // Coloanele care pot fi populate

    public $timestamps = false; // Dezactivează timestamps dacă tabela nu are `created_at` și `updated_at`

    // Relație cu modelul Hotel
    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }

    // Relație cu modelul Department
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
