@extends('layout.layout')

@section('content')
<div class="row">
    <div class="col-12 p-5">
        <form method="POST">
            @csrf
            <div class="form-group row">
                <label for="inputUrl" class="col-sm-2 col-form-label  @error('url') text-danger @enderror">Input your Url</label>
                <div class="col-sm-7">
                    <input type="url" name="url" class="form-control @error('url') is-invalid @enderror" id="url" placeholder="Url">
                </div>
                <div class="col-sm-3">
                    @if($errors->any())
                        <small id="urlHelp" class="text-danger">
                            {{ $errors }}
                        </small>
                    @endif
                </div>
            </div>
            <button>Submit</button>
        </form>
    </div>
    <div class="col-12 p-5">
        @if(\Illuminate\Support\Facades\Session::has('destroy'))
            <h3 class="badge-warning">Url removed</h3>
        @endif
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Url Shortener</th>
                <th scope="col">Url</th>
                <th scope="col">click count</th>
                <th scope="col">delete Url</th>
            </tr>
            </thead>
            <tbody>
            @foreach($urlShorteners as $url)
                <tr @if(\Illuminate\Support\Facades\Session::has('generate_url')
                           && $url->id == \Illuminate\Support\Facades\Session::get('generate_url'))
                    class="badge-success"
                @endif>
                    <th scope="row">{{ $url->id }}</th>
                    <td><a href="{{ url($url->code) }}">{{ url($url->code) }}</a></td>
                    <td><a href="{{ $url->code }}">{{ $url->url }}</a></td>
                    <td>{{$url->click_count}}</td>
                    <td><form method="POST" action="{{route('url-shortener.destroy', $url->id)}}">
                            @method('DELETE')
                            @csrf
{{--                            <input type="hidden" name="id" value="{{$url->id}}">--}}
                            <button type="submit">X</button>
                        </form></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $urlShorteners->render() }}
    </div>
</div>
@endsection
