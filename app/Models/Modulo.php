<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    use HasFactory;
    protected $table = 'tbl_modulo';

    public $timestamps = false;

    public function operaciones()
    {
        return $this->hasMany(Permisos::class, 'idModulo');
    }
}
