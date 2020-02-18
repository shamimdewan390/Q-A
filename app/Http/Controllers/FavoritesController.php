<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use Illuminate\Support\Facades\Auth;

class FavoritesController extends Controller
{

    public function store(Question $question){
        $question->favorites()->attach(Auth()->id());
        return back();
    }
    public function destroy(Question $question){
        $question->favorites()->detach(Auth()->id());
        return back();
    }
}
