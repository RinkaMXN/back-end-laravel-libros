<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Autor;
use App\Models\Genero;

class BooksController extends Controller
{
    //
    public function index(){
      try{
        $books = Book::all();
        $data = array(
          'code' => 200,
          'status' => 'success',
          'books' => $books
        ); 
      }catch(\Illuminate\Database\QueryException $e) {
        // Respuesta de error
        $data = array(
            'status' => 'error',
            'code'   => 200,
            'message' => 'No se pudo conseguir los libros desde la consulta'
        ); 
      }
      return response()->json($data, $data['code']);
    }

    public function getAutoresAll(){
      try{
        $autores = Autor::all();
        $data = array(
          'code' => 200,
          'status' => 'success',
          'autores' => $autores
        ); 
      }catch(\Illuminate\Database\QueryException $e) {
        // Respuesta de error
        $data = array(
            'status' => 'error',
            'code'   => 200,
            'message' => 'No se pudieron conseguir a los autores desde la consulta'
        ); 
      }
      return response()->json($data, $data['code']);
    }

    public function getGenerosAll(){
      try{
        $generos = Genero::all();
        $data = array(
          'code' => 200,
          'status' => 'success',
          'generos' => $generos
        ); 
      }catch(\Illuminate\Database\QueryException $e) {
        // Respuesta de error
        $data = array(
            'code'   => 200,
            'status' => 'error',
            'message' => 'No se pudieron conseguir a los géneros desde la consulta'
        ); 
      }
      return response()->json($data, $data['code']);
    }

    public function createbook(Request $request){
      try{
        $book = new Book();
        $book->titulo_libro = $request->titulo_libro;
        $book->id_autor = $request->id_autor;
        $book->id_genero = $request->id_genero;
        $book->fecha_publicacion_libro = $request->fecha_publicacion_libro;
        $book->descripcion_libro = $request->descripcion_libro;
        $book->imagen_libro = $request->imagen_libro;
        $book->save();

        // Respuesta de success
        $data = array(
          'status' => 'success',
          'code'   => 200,
          'message' => 'El libro se guardó con éxito'
        ); 

      }catch(\Illuminate\Database\QueryException $e) {
        // Respuesta de error
        $data = array(
            'status' => 'error',
            'code'   => 200,
            'message' => 'No se pudo guardar el libro'
        ); 
      }
      return response()->json($data, $data['code']);
    }
}
