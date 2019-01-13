<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Book;

class BookController extends Controller
{
  public function __construct()
  {
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $books = Book::all();
    return $this->makeResponse(200, ['list' => $books]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $data = $request->all();
    $errors = $this->validateBook($data);

    if (sizeof($errors) == 0) { //If no errors
      $book = new Book;
      $this->updateBook($book, $data);
      return $this->makeResponse(200, ['book_id'=>$book->id]);
    } else {
      return $this->makeResponse(401, ['message' => $errors]);
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $book = Book::find($id);
    $payload = null;
    $statusCode = 0;

    if($book) {
      return $this->makeResponse(200, ['book' => $book]);
    } else {
      return $this->makeResponse(404, ['message' => 'Book not found']);
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $book = Book::find($id);

    if(!$book) {
      return $this->makeResponse(404, ['message' => 'Book not found']);
    } else {
      $data = $request->all();
      $errors = $this->validateBook($data);

      if (sizeof($errors) == 0) { //If no errors
        $this->updateBook($book, $data);
        //TODO: add handlers for errors from updateBook
        return $this->makeResponse(201, ['book'=>$book]);
      } else {
        return $this->makeResponse(400, ['message' => $errors]);
      }
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $book = Book::find($id);

    if($book) {
      $book->delete();
      return $this->makeResponse(200, null);
    } else {
      return $this->makeResponse(404, ['message' => 'Book not found']);
    }
  }

  /**
   * Constructs a uniform response
   * @param int $code -- an HTTP code,
   * @param Array payload -- any additional data that should be passed
   * @return \Illuminate\Http\Response
   */
  protected function makeResponse($code, $payload)
  {
    $status = ($code >= 200 && $code < 300);
    $payload = $payload ?? [];
    $payload['status'] = $status;
    return response()->json($payload, $code);
  }

  /**
   * Validates book data
   * @param  Array $data -- book data
   * @return Array -- list of errors
   */
  protected function validateBook($data)
  {
    //TODO: adjust validator rules to conform to the both new and exiting book update
    $validator = Validator::make($data, [
      'title' => 'unique:books,title',
      'anons' => 'nullable',
      'image' => 'required'
    ]);

    return $validator->errors();
  }

  /**
   * Updates specified book model
   * @param  Array $data -- book data
   * @return Array -- list of errors
   */
  protected function updateBook($book, $data)
  {
      $book->title = $data['title'];
      $book->anons = $data['anons'];
      $book->image = $data['image'];
      $book->save();

      return [];
  }
}
