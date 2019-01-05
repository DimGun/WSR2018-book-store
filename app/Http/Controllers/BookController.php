<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
  // Array to store books info
  protected $books = array();

  public function __construct()
  {
    $this->books[] = ['title' => 'Mystical island', 'anons' => 'A group of surrendes find themself on an island'];
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return response()->json([
      'status' => true,
      'list' => $this->books
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
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $book = $this->books[$id] ?? null;
    $payload = null;
    if($book) {
      $payload = [
        'status' => true,
        'book' => $book
      ];
    } else {
      $payload = [
        'status' => false,
        'message' => 'Book not found'
      ];
    }
    return response()->json($payload);
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
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }
}
