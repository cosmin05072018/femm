<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone', 'email', 'role_id', 'department_id'];

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
}
