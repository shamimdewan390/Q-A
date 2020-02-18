@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h3>Edit Questions</h3>
                        <div class="ml-auto">
                            <a class="btn btn-outline-secondary" href="{{route('questions.index')}}">
                                Back To All Questions
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{route('questions.update', $question->id)}}" method="post">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="question-title">Question Title</label>
                        <input value="{{old('title',$question->title)}}" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" type="text" name="title" id="question-title">
                            @if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                        </div>
                        <div class="form-group">
                            <label for="question-body">Explain Your Questions</label>
                        <textarea class="form-control{{ $errors->has('body') ? ' is-invalid' : '' }}" name= "body" id="question-body" rows="10">{{old('body',$question->body)}}</textarea>
                            @if ($errors->has('body'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                @endif
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-outline-info btn-lg">Update Questions</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
