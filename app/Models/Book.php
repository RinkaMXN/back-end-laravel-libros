<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $table = 'libros';
    protected $primaryKey = 'id_libro';
    protected $fillable = ['id_libro','titulo_libro','id_autor','id_genero','fecha_publicacion_libro','descripcion_libro','imagen_libro'];
}
