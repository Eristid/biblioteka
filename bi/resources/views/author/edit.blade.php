@extends('layouts.app')

@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">
               <div class="card-header">Edit Author</div>
               <div class="card-body">
                 <form method="POST" action="{{route('author.update', $author)}}" enctype="multipart/form-data">
                  <div class="form-group">
                     <label>Name: </label>
                     <input type="text" class="form-control" name="author_name" value="{{old('author_name', $author->name)}}">
                     <small class="form-text text-muted">Please enter authors name</small>
                  </div>
                  <div class="form-group">
                     <label>Surname: </label>
                     <input type="text" class="form-control" name="author_surname" value="{{old('author_surname',$author->surname)}}">
                     <small class="form-text text-muted">Please enter authors surname</small>
                  </div>
                  <div class="form-group">
                     <label>Portret: </label>
                     <span style="padding:8px;margin:8px;display:inline-block;">
                     <img src="{{$author->portret}}">
                     </span>
                     <input type="file" class="form-control" name="author_portret">
                     <small class="form-text text-muted">Please upload portret</small>
                  </div>
                     @csrf
                     <button type="submit" class="btn btn-primary">EDIT</button>
                  </form>
               </div>
           </div>
       </div>
   </div>
</div>
@endsection
