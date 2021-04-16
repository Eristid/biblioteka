<ul class="list-group">
    @foreach ($publishers as $publisher)
    <li class="list-group-item list-line">
        <div>
        {{$publisher->title}}
        </div> 
        <div class="list-line__buttons">
        <a href="{{route('publisher.edit',[$publisher])}}" class="btn btn-info">EDIT</a>
        <form data-delete class="pub-delete" data-url="{{route('publisher.js.destroy', [$publisher])}}">
        @csrf
        <button type="submit" class="btn btn-danger">DELETE</button>
        </form>
        </div>
    </li>
    @endforeach
</ul>