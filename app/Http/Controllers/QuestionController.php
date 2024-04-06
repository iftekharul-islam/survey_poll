<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Country;
use App\Models\Question;
use App\Models\QuestionImage;
use App\Models\QuestionOption;
use App\Models\Topic;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
  public function index()
  {
    $questions = Question::with('topic', 'country');
    $questions = $questions->paginate('10');
    return view('content.questions.list', compact('questions'));
  }

  public function questionCreate()
  {
    $countries = Country::all();
    $topics = Topic::all();

    return view('content.questions.pages-question-create', compact('countries', 'topics'));
  }

  public function questionStore(Request $request)
  {
    try {
      DB::beginTransaction();
      foreach ($request->questions as $index => $question) {
        $newQuestion = Question::create(
          [
            'topic_id' => $request->topic_id,
            'country_id' => $request->country_id,
            'question' => $question['question'],
            'marks' => $question['mark'],
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

      DB::commit();

      return redirect()->route('create-question');
    } catch (\Throwable $th) {
      //throw $th;
    }
  }
}
