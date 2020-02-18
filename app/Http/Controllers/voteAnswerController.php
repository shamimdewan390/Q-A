<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Answer;

class voteAnswerController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function vote(Answer $answer){
        $vote = (int) request()->vote;
        auth()->user()->voteAnswer($answer, $vote);
        return back();
    }
}
