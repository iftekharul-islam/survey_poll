<?php

namespace App\Http\Controllers\pages;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionImage;
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
    foreach ($request->questions as $index => $question) {
      $newQuestion = Question::create(
        [
          'group_id' => $request->group_id,
          'question' => $question['question'],
          'points' => $question['points'],
        ]
      );

      if ($request->hasFile("questions.$index.images")) {
        foreach ($request->file("questions.$index.images") as $image) {
          $imageName = time() . '_' . $image->getClientOriginalName();
          $image->storeAs('images', $imageName);
          QuestionImage::create(
            [
              'question_id' => $newQuestion->id,
              'image' => $imageName,
            ]
          );
        }
      }

      foreach ($question['options'] as $key => $option) {
        $option = QuestionOption::create(
          [
            'question_id' => $newQuestion->id,
            'option' => $option,
          ]
        );
        if ($option->option == $question['selected']) {
          $newQuestion->right_id = $option->id;
          $newQuestion->save();
        }
      }
    }

    return redirect()->route('create-question');
  }
}
