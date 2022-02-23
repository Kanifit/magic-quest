<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('book.bookApp');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        //
    }

    /**
     * Получить книги пользователя. (миниатюры с id)
     *
     * @return \Illuminate\Http\Response $book json
     */
    public function userBooks()
    {
        $books = auth()->user()->openHistory;
//        $books = Book::all();

        $result = [];

        foreach($books as $book)
        {
            $result[] = [
                'id' => $book->id,
                'image' => $book->cover_file,
            ];
        }

        return response(json_encode($result), 200);
    }


    /**
     * Получить информацию о конкретной книге. (через id)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response $book json
     */
    public function getBookInfo(Request $request)
    {
        if (!$request->ajax())
        {
            return abort(404);
        }

        $book = Book::findOrFail($request->book_id);
//        $test = 1;

        $result = [
            'image' => $book->cover_file,
            'title' => $book->book_title,
            'authors' => $book->authorsForBooksinfo,
            'description' => $book->annotation,
            'accentColor' => $book->accent_color,
            'link' => route('book.reader', $book->id),
//            'testLink' => route('book.test', ['testId' => $test->id, 'bookId' => $book->id]),
        ];

        return response(json_encode($result), 200);
    }

    public function reader(Book $book)
    {
        $u_id = auth()->user()->id;
        $b_id = $book->id;

        DB::table('book_open_history')->where('book_id', $b_id)->where('user_id', $u_id)->update(['opened_at' => date('Y-m-d H:i:s')]);;

        return view('book.reader', ['book' => $book]);
    }

    public function getAvailableBooks()
    {
        return response()->json( Book::whereDoesntHave('test')->get()->toArray() ? : []);
    }
}
