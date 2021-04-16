<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Author extends Model
{
    use HasFactory;

    // public static function create(Request $request)
    // {
    //     $author = new self;
    //     $author->name = $request->author_name;
    //     $author->surname = $request->author_surname;
    //     $author->save();
    // }


    public function authorBooksList()
    {
        return $this->hasMany('App\Models\Book', 'author_id', 'id');
    }


    // public function edit(Request $request)
    // {
    //     $this->name = $request->author_name;
    //     $this->surname = $request->author_surname;
    //     $this->save();
    // }


    public static function new()
    {
        return new self;
    }


    public function refreshAndSave(Request $request)
    {
        
        $file = $request->file('author_portret');   // is siuntimo pasiima failo aprasa

        $name = $file->getClientOriginalName(); // originalus vardas

        $name = rand(1000000000, 9999999999). '.'. $file->getClientOriginalExtension(); //random vardas

        $file->move(public_path('img'), $name); // perkeliam is tmp i ten kur reikia

        $this->portret = 'http://bi.com/img/'.$name; // i db + url kelias iki paveiksliuko

       
        
        $this->name = $request->author_name;
        $this->surname = $request->author_surname;
        $this->save();
        return $this;
    }





}
