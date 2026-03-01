<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Custody extends Model
{
    protected $fillable = ['name'];

    public function custodyDepartments()
    {
        return $this->hasMany(CustodyDepartment::class);
    }
}
