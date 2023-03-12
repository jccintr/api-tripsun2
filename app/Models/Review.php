<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
   protected $fillable = ['usuario_id','servico_id','rate','message','data'];
    protected $table = 'reviews';
}