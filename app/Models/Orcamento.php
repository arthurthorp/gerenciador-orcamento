<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orcamento extends Model
{
    use HasFactory;

    protected $primaryKey = "id";
    protected $table = "orcamentos";

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function formaPagamento()
    {
        return $this->belongsTo(FormaPagamento::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function linhas()
    {
        return $this->hasMany(LinhaOrcamento::class);
    }

    public function valorTotal(){
        return number_format($this->linhas()->selectRaw("SUM(valor_unitario * quantidade) as total")->groupBy("orcamento_id")->get()->pluck("total")[0],2,",", ".");
    }
}
