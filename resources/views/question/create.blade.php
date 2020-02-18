@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h3>All Questions</h3>
                        <div class="ml-auto">
                            <a class="btn btn-outline-secondary" href="{{route('questions.index')}}">
                                Back To All Questions
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{route('questions.store')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="question-title">Question Title</label>
                        <input value="{{old('title')}}" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" type="text" name="title" id="question-title">
                            @if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                        </div>
                        <div class="form-group">
                            <label for="question-body">Explain Your Questions</label>
                        <textarea class="form-control{{ $errors->has('body') ? ' is-invalid' : '' }} my-editor" name= "body" id="question-body" rows="10">{{old('body')}}</textarea>
                            @if ($errors->has('body'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                @endif
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-outline-info btn-lg">Ask This Questions</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('footer_js')
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

<script>
    var editor_config = {
      path_absolute : "/",
      selector: "textarea.my-editor",
      plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern"
      ],
      toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
      relative_urls: false,
      file_browser_callback : function(field_name, url, type, win) {
        var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
        var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

        var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
        if (type == 'image') {
          cmsURL = cmsURL + "&type=Images";
        } else {
          cmsURL = cmsURL + "&type=Files";
        }

        tinyMCE.activeEditor.windowManager.open({
          file : cmsURL,
          title : 'Filemanager',
          width : x * 0.8,
          height : y * 0.8,
          resizable : "yes",
          close_previous : "no"
        });
      }
    };

    tinymce.init(editor_config);
  </script>
@endsection
