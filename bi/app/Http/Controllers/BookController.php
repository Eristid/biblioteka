<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Publisher;
use Illuminate\Http\Request;
use PDF;
use Auth;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        
      
        
        $authors = Author::all();


        //FILTRAVIMAS
        if ($request->author_id) {
            // $books = Book::where('author_id', $request->author_id)->get();
            $books = Book::where('author_id', $request->author_id)->paginate(3);
            $filterBy = $request->author_id;
            $books->appends(['author_id' => $request->author_id]);// tam kad but galima filtre paginuoti
        }
        else {
            // $books = Book::all();
            $books = Book::paginate(3);
        }


        //RUSIAVIMAS
        if ($request->sort && 'asc' == $request->sort) {
            $books = $books->sortBy('title');
            $sortBy = 'asc';
        }
        elseif ($request->sort && 'desc' == $request->sort) {
            $books = $books->sortByDesc('title');
            $sortBy = 'desc';
        }
        
        return view('book.index', [
            'books' => $books,
            'authors' => $authors,
            'filterBy' => $filterBy ?? 0,
            'sortBy' => $sortBy ?? ''
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        if (Auth::user()->role) {
            $authors = Author::all();
            $publishers = Publisher::all();
            return view('book.create', ['authors' => $authors, 'publishers' => $publishers]);
        }
        else {
            abort(403, 'You do not have permission to create new book.');
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->role) {
        $book = new Book;
        $book->title = $request->book_title;
        $book->isbn = $request->book_isbn;
        $book->pages = $request->book_pages;
        $book->about = $request->book_about;
        $book->author_id = $request->author_id;
        $book->publisher_id = $request->publisher_id;
        $book->save();
        return redirect()->route('book.index')->with('success_message', 'The Book was created.');
        }
        else {
            abort(403, 'You do not have permission to create new book.');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return view('book.show', ['book' => $book]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        $authors = Author::all();
        $publishers = Publisher::all();
        return view('book.edit', ['book' => $book, 'authors' => $authors, 'publishers' => $publishers]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $book->title = $request->book_title;
        $book->isbn = $request->book_isbn;
        $book->pages = $request->book_pages;
        $book->about = $request->book_about;
        $book->author_id = $request->author_id;
        $book->save();
        return redirect()->route('book.index')->with('success_message', 'Book was edited.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('book.index')->with('info_message', 'Book was deleted');
    }


    public function pdf(Book $book)
    {
        $pdf = PDF::loadView('book.pdf', ['book' => $book]); 
        return $pdf->download('book-id'.$book->id.'.pdf'); 
    }


}
