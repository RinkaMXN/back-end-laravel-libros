<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
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
            'message' => 'Hubo un error en la BD, no se pudieron conseguir los libros, intentelo más tarde'
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
            'message' => 'Hubo un error en la BD, no se pudieron conseguir a los autores, intentelo más tarde'
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
            'message' => 'Hubo un error en la BD, no se pudieron conseguir los generos, intentelo más tarde'
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

        // Obtiene el último ID
        $lastId = Book::max('id_libro');
        // Si no hay registros, comienza desde 1 
        $nextId = $lastId ? $lastId + 1 : 1; 
        // Obtener el ID recién creado
        $bookId = $nextId; 

        $file = $request->file('imagen_libro');
        $img = $file->getClientOriginalName();
        $img2 = $bookId . $img;
        \Storage::disk('local')->put($img2, \File::get($file));
        
        //$book->imagen_libro = $img2;
        $book->imagen_libro = asset('archivos/' . $img2);
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
            'message' => 'Hubo un error en la BD, no se pudo crear el libro, intentelo más tarde'
        ); 
      }
      return response()->json($data, $data['code']);
    }

    public function getBookById($id){
      try{

        $book = DB::table('libros as l')
        ->select(
            'l.id_libro',
            'l.titulo_libro',
            'l.id_autor',
            'l.descripcion_libro',
            'l.id_genero',
            'l.fecha_publicacion_libro',
            'l.imagen_libro',
            )
        ->where('id_libro', $id)
        ->first();

        // Preparar la respuesta, regresamos lo de los inputs y la tabla.
        $data = array(
          'status' => 'success',
          'code' => 200,
          'books' => $book,
        );

      }catch(\Illuminate\Database\QueryException $e) {
        // Respuesta de error
        $data = array(
            'status' => 'error',
            'code'   => 200,
            'message' => 'Hubo un error en la BD, no se pudo conseguir los datos del libro, intentelo más tarde'
        ); 
      }
      return response()->json($data, $data['code']);
    }

    public function updatebook(Request $request, $id){
      try{
        // Buscar el libro por ID
        $book = Book::find($id);
    
        if (!$book) {
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'Libro no encontrado'
            ], 404);
        }

        $book->titulo_libro = $request->titulo_libro;
        $book->id_genero = $request->id_genero;
        $book->id_autor = $request->id_autor;
        $book->fecha_publicacion_libro = $request->fecha_publicacion_libro;
        $book->descripcion_libro = $request->descripcion_libro;
        // Subir archivo de evidencia, si existe
        if ($request->hasFile('imagen_libro')) {
          // Opcional: eliminar evidencia asociada, si existe
          if ($book->imagen_libro && file_exists(public_path('archivos/' . $book->imagen_libro))) {
              unlink(public_path('archivos/' . $book->imagen_libro));
          }
          $file = $request->file('imagen_libro');
          $img = $file->getClientOriginalName();
          $img2 = $book->id_libro . $img;
          \Storage::disk('local')->put($img2, \File::get($file));
          $book->imagen_libro = asset('archivos/' . $img2);
        }
        $book->save();

        // Preparar la respuesta, regresamos lo de los inputs y la tabla.
        $data = array(
          'status' => 'success',
          'code' => 200,
          'message' => 'El libro se actualizó con éxito'
        );

      }catch(\Illuminate\Database\QueryException $e) {
        // Respuesta de error
        $data = array(
            'status' => 'error',
            'code'   => 200,
            'message' => 'Hubo un error en la BD, no se pudo actualizar el libro, intentelo más tarde'
        ); 
      }
      return response()->json($data, $data['code']);
    }
}
