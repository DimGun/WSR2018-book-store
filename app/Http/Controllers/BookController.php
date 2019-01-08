<?php

namespace App\Http\Controllers;

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

    return response()->json([
      'status' => true,
      'list' => $books
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $book = new Book;
    $book->title = $request->title;
    $book->anons = $request->anons;
    $book->image = $request->image;
    $book->save();
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
      $statusCode = 200;
      $payload = [
        'status' => true,
        'book' => $book
      ];
    } else {
      $statusCode = 404;
      $payload = [
        'status' => false,
        'message' => 'Book not found'
      ];
    }
    return response()->json($payload, $statusCode);
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
    $payload = null;
    $statusCode = 0;

    if($book) {
      $book->title = $request->title;
      $book->anons = $request->anons;
      $book->image = $request->image;
      $book->save();

      $statusCode = 201;
      $payload = [
        'status' => true,
      ];
    } else {
      $statusCode = 404;
      $payload = [
        'status' => false,
        'message' => 'Book not found'
      ];
    }
    return response()->json($payload, $statusCode);
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
    $payload = null;
    $statusCode = 0;

    if($book) {
      $book->delete();
      $statusCode = 201;
      $payload = [
        'status' => true,
      ];
    } else {
      $statusCode = 404;
      $payload = [
        'status' => false,
        'message' => 'Book not found'
      ];
    }
    return response()->json($payload, $statusCode);
  }
}
