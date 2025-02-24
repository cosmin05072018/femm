<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class Employee extends Model implements Authenticatable
{
    use HasFactory, AuthenticatableTrait;

    protected $fillable = ['name', 'phone', 'email', 'password', 'function', 'role_id', 'department_id', 'hotel_id'];

    /**
     * Get the role associated with the employee.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the department associated with the employee.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the hotel associated with the employee.
     */
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
