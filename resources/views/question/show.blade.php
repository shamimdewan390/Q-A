@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <div class="d-flex align-items-center">
                            <h3>{{$question->title}}</h3>
                            <div class="ml-auto">
                                <a class="btn btn-outline-secondary" href="{{route('questions.index')}}">
                                    Back To All Questions
                                </a>
                            </div>
                        </div>
                    </div>
                        <hr>
                    <div class="media">
                        <div class="d-flex flex-column votes-control">

                            <a class="vote-up
                            {{Auth::guest() ? 'off' :''}}"
                            onclick="event.preventDefault(); document.getElementById('vote-up-question-{{$question->id}}').submit();">
                                <i class="fas fa-caret-up fa-3x"></i>
                            </a>
                            <span class="votes-count">
                                {{$question->votes_count}}
                            </span>

                            {{ session(['purl' => \Request::path()]) }}
                            <form id="vote-up-question-{{$question->id}}" style="display:none;" action="/questions/{{$question->id}}/vote" method="post">
                                @csrf
                                <input type="hidden" name="vote" value="1">
                            </form>
                            <a class="vote-down
                            {{Auth::guest() ? 'off' : ''}}"
                            onclick="event.preventDefault(); document.getElementById('vote-down-question-{{$question->id}}').submit();">
                                <i class="fas fa-caret-down fa-3x"></i>
                            </a>
                            <form id="vote-down-question-{{$question->id}}" style="display:none;" action="/questions/{{$question->id}}/vote" method="post">
                                @csrf
                                <input type="hidden" name="vote" value="-1">
                            </form>

                        <a title="Mark As Favourite" class="favourite mt-3
                        {{Auth::guest() ? 'off' : ($question->is_favorited) ? 'favourited': ''}}"
                            onclick="event.preventDefault(); document.getElementById('faborite-question-{{$question->id}}').submit();">
                                <i class="fas fa-star fa-2x"></i>
                                <span class="favourited">
                                   {{$question->favorites_count}}
                                </span>
                                <form id="faborite-question-{{$question->id}}" style="display:none;" action="/questions/{{$question->id}}/favorites" method="post">
                                    @csrf
                                    @if ($question->is_favorited)
                                        @method('DELETE')
                                    @endif
                                </form>
                            </a>
                        </div>
                        <div class="media-body">
                            {{-- {{ strip_tags($question->body_html) }} --}}
                            {{-- {!! strip_tags($question->body_html) !!} --}}
                            <code>
                                {!!$question->body_html !!}
                            </code>
                            <div class="float-right">
                                <span class="text-muted">
                                    Questioned {{$question->created_at->diffForHumans()}}
                                </span>
                                <div class="media">
                                    <a href="{{$question->user->url}}">
                                    <img class="pr-2" src="{{$question->user->avater}}" alt="">
                                    </a>
                                    <div class="media-body">
                                        <a href="{{$question->user->url}}">
                                            {{$question->user->name}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!------- Ansewers row  --->
    <div class="row mt-5">
         <div class="col-md-12">
             <div class="card">
                 <div class="card-body">
                    <div class="card-title">
                        <h2>Your Answer</h2>

                        @include('layouts._message')
                        {{ session(['purl' => \Request::path()]) }}
                        <form action="{{route('questions.answers.store',$question->id)}}" method="post">
                        @csrf
                            <div class="form-group">
                                <textarea class="form-control {{ $errors->has('body') ? ' is-invalid' : '' }}" name="body" rows="7"></textarea>

                                @if ($errors->has('body'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('body') }}</strong>
                                </span>
                            @endif
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-outline-secondary">Submit</button>
                            </div>
                        </form>

                        <hr>
                        <h3>
                            {{$question->answers_count }}
                            {{str_plural('Answer')}}
                        </h3>
                    </div>
                    @foreach ($question->answers as $answer)
                        <div class="media">
                            <div class="d-flex flex-column votes-control">


                                <a class="vote-up
                                    {{Auth::guest() ? 'off' :''}}"
                                    onclick="event.preventDefault(); document.getElementById('vote-up-answer-{{$answer->id}}').submit();">
                                        <i class="fas fa-caret-up fa-3x"></i>
                                    </a>
                                    <span class="votes-count">
                                        {{$answer->votes_count}}
                                    </span>
                                    {{ session(['purl' => \Request::path()]) }}
                                    <form id="vote-up-answer-{{$answer->id}}" style="display:none;" action="/answers/{{$answer->id}}/vote" method="post">
                                        @csrf
                                        <input type="hidden" name="vote" value="1">
                                    </form>
                                    <a class="vote-down
                                    {{Auth::guest() ? 'off' : ''}}"
                                    onclick="event.preventDefault(); document.getElementById('vote-down-answer-{{$answer->id}}').submit();">
                                        <i class="fas fa-caret-down fa-3x"></i>
                                    </a>
                                    <form id="vote-down-answer-{{$answer->id}}" style="display:none;" action="/answers/{{$answer->id}}/vote" method="post">
                                        @csrf
                                        <input type="hidden" name="vote" value="-1">
                                    </form>



                                @can('accept', $answer)
                                <a title="Choos As Best Answer" class="favourite mt-3 {{$answer->status}}"

                                onclick="event.preventDefault(); document.getElementById('answer-accept-{{$answer->id}}').submit();">
                                    <i class="fas fa-check fa-2x"></i>
                                </a>
                                <form id="answer-accept-{{$answer->id}}" style="display:none;" action="{{route('accept.answer', $answer->id)}}" method="post">
                                        @csrf
                                    </form>
                                    @else
                                        @if ($answer->is_best)
                                        <a title="Questioner Select The Best Answer" class="favourite mt-3 {{$answer->status}}">
                                                <i class="fas fa-check fa-2x"></i>
                                            </a>
                                        @endif
                                    @endcan
                            </div>
                            <div class="media-body">
                                {!!$answer->body_html!!}
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="ml-auto">

                                            @can('update', $answer)

                                            <a class="btn btn-outline-primary btn-sm" href="{{route('questions.answers.edit',[$question->id,$answer->id])}}">Edit</a>
                                            @endcan
                                            @can('delete', $answer)

                                            <form onclick="return confirm('Are You Sure?')" class="form-delete" action="{{route('questions.answers.destroy',[$question->id,$answer->id])}}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-outline-danger btn-sm">
                                                    Delete
                                                </button>
                                            </form>
                                            @endcan
                                        </div>
                                    </div>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <div class="float-right">
                                            <span class="text-muted">
                                                Answered {{$answer->created_at->diffForHumans()}}
                                            </span>
                                            <div class="media">
                                                <a href="{{$answer->user->url}}">
                                                <img class="pr-2" src="{{$answer->user->avater}}" alt="">
                                                </a>
                                                <div class="media-body">
                                                    <a href="{{$answer->user->url}}">
                                                        {{$answer->user->name}}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <hr>
                    @endforeach
                 </div>
             </div>
         </div>
    </div>
</div>
@endsection
