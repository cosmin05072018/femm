<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Hotel;
use App\Models\Department;
use App\Models\Role;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users'; // Opțional, doar dacă ai redenumit tabela

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'county',
        'company_name',
        'hotel_name',
        'company_cui',
        'manager_name',
        'employee_name',
        'phone',
        'function',
        'company_address',
        'email',
        'password',
        'email_femm',
        'password_mail_femm',
        'status',
        'role_id',
        'department_id',
        'hotel_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'status' => 'integer'
    ];

    /**
     * Get the department assigned to the user.
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

}
