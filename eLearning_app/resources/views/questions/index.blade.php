@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
            @if(Auth::user()->is_admin)
            <div class="m-2">
                <a href="/lesson/{{ $lesson->id }}/questions/create" class="btn btn-primary">Add Question</a>
                <a href="/lesson" class="btn btn-warning">Back</a>
            </div>
            @else
            <div class="m-2">
                <a href="/lesson" class="btn btn-warning">Back</a>
            </div>
            @endif
            @foreach($lesson->questions as $index => $question)
                <div class="card">
                    <div class="card-body">
                        <div class="text-left">
                            <h1>Question #{{$index + 1}}</h1>
                            <p>{{$question->question}}</p>
                            <div class="text-right">
                                <p>
                                    @if(Auth::user()->is_admin)
                                    <a href="/lesson/{{$question->id}}/question/edit" class="btn btn-success">Edit</a>
                                    <a href="/lesson/{{$question->id}}/question/delete" class="btn btn-danger">Delete</a>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            @endforeach
            </div>
        </div>
    </div>

@endsection