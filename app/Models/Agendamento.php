<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    use HasFactory;
    protected $fillable = ['usuario_id','servico_id','data_agendamento','quantidade','total','valor_plataforma','consumido','codigo'];
    protected $table = 'agendamentos';
}
