<?php

namespace App\Http\Controllers\pages;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Topic;

class HomePage extends Controller
{
  public function index()
  {
    return view('content.pages.pages-home');
  }

  public function questionCreate()
  {
    $countries = Country::all();
    $topics = Topic::all();
    return view('content.questions.pages-question-create', compact('countries', 'topics'));
  }

  public function questionStore(Request $request)
  {
      //create a new question
      $question = Question::create(
          [
              'topic_id' => $request->topic_id,
              'question' => $request->question,
              'marks' => 1,
              'right_id' => 1,
          ]
      );

      //run a loop to create options
      foreach ($request->options as $key => $option) {
          QuestionOption::create(
              [
                  'question_id' => $question->id,
                  'option' => $option,
                  // 'is_correct' => $request->is_correct,
              ]
          );
      }

      // return redirect
      return redirect()->route('create-question');
  }
}
