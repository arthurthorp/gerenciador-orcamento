<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinhaOrcamento extends Model
{
    use HasFactory;

    protected $primaryKey = "id";
    protected $table = "linha_orcamentos";
}
