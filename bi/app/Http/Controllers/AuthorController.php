<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Validator;

class AuthorController extends Controller
{
    
    
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        // $authors = $request->sort ? Author::orderBy('surname')->get() : Author::all();
        
        if ('name' == $request->sort) {
            $authors = Author::orderBy('name')->get();
        }
        elseif ('surname' == $request->sort) {
            $authors = Author::orderBy('surname')->get();
        }
        else {
            $authors = Author::all();
        }
        
        
        // $authors = Author::all();

        // $authors = Author::orderBy('surname')->get();



        return view('author.index', ['authors' => $authors]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('author.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make(
            $request->all(),

            [
                'author_name' => ['required', 'min:3', 'max:64'],
                'author_surname' => ['required', 'min:3', 'max:64'],
            ],

            [
                'author_surname.required' => 'idek pavarde!',
                'author_surname.min' => 'per trumpas pavarde'
            ]
    
            );
    
    
        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator);
        }
    




        Author::new()->refreshAndSave($request);

        return redirect()->
        route('author.index')->
        with('success_message', 'The Author was created. Nice job!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function edit(Author $author)
    {
        return view('author.edit', ['author' => $author]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Author $author)
    {
        
        
        $validator = Validator::make(
            $request->all(),

            [
                'author_name' => ['required', 'min:3', 'max:64'],
                'author_surname' => ['required', 'min:3', 'max:64'],
            ],

            [
                'author_surname.required' => 'idek pavarde!',
                'author_surname.min' => 'per trumpas pavarde'
            ]
    
            );
    
    
        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator);
        }
        
        
        // $author->edit($request);
        $author->refreshAndSave($request);
        return redirect()->route('author.index')->with('success_message', 'The Author was renamed. Nice job!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        if ($author->authorBooksList->count() !== 0) {
            return redirect()->back()->with('info_message', 'The Author is immortal. You cant kill him. Nice try!');
        }

        $addedLink = 'http://bi.com/img/'; // pridetas linkas

        $imgName = str_replace($addedLink, '', $author->portret); // prideta linka istrinam 

        if (file_exists(public_path('img').'/'.$imgName) && is_file(public_path('img').'/'.$imgName)) {
            unlink(public_path('img').'/'.$imgName); // istrinam
        }
        
        $author->delete();
        return redirect()->route('author.index')->with('info_message', 'The Author was killed. Nice job!');
    }
}
