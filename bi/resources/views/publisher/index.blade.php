@extends('layouts.app')

@section('content')

<div class="container mb-4">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">
               <div class="card-header">
               Create new Publisher
               </div>
               <div class="card-body">
                 <form data-submit data-url="{{route('publisher.js.store')}}">
                  <div class="form-group">
                     <label>Title: </label>
                     <input type="text" class="form-control" id="publisher_title" value="{{old('publisher_title')}}">
                     <small class="form-text text-muted">Please enter new publishers title</small>
                  </div>
                  @csrf
                  <button type="submit" class="btn btn-primary">ADD</button>
               </form>
               </div>
           </div>
       </div>
   </div>
</div>

<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">
               <div class="card-header">
               <h2>Publishers List</h2>
               
              <a href="{{route('publisher.index', ['sort' => 'title'])}}">Sort by title</a>
               
                           
              <a href="{{route('publisher.index')}}">Default</a>
               
               </div>
               <div class="card-body" data-block-load data-url="{{route('publisher.list')}}">



               </div>
           </div>
       </div>
   </div>
</div>
@endsection


