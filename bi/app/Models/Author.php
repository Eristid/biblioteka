<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Author extends Model
{
    use HasFactory;



    public function authorBooksList()
    {
        return $this->hasMany('App\Models\Book', 'author_id', 'id');
    }


    public static function new()
    {
        return new self;
    }


    public function refreshAndSave(Request $request)
    {
        
        $file = $request->file('author_portret');   
        $name = $file->getClientOriginalName(); 

        $name = rand(1000000000, 9999999999). '.'. $file->getClientOriginalExtension(); //random vardas

        $file->move(public_path('img'), $name); 

        $this->portret = 'http://bi.com/img/'.$name; 

       
        
        $this->name = $request->author_name;
        $this->surname = $request->author_surname;
        $this->save();
        return $this;
    }





}
