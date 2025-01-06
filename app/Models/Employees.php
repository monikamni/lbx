<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model {

    /** @use HasFactory<\Database\Factories\EmployeesFactory> */
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'employees';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'emp_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['emp_id', 'prefix', 'first_name', 'middle_initial',
        'last_name', 'gender', 'email', 'dob', 'tob', 'age', 'doj',
        'age_in_company', 'phone_no', 'place', 'country', 'city', 'zip',
        'region', 'username', 'created_at', 'updated_at'];
}
