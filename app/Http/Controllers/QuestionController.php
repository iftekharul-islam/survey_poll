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
    return view('content.pages.pages-home');
  }

  public function questionCreate()
  {
    $topics = Topic::with('country')->get();
    $topics = $topics->map(function ($topic) {
      return [
        'value' => $topic->id,
        'label' => $topic->country->name . " - " . $topic->name,
      ];
    });

    return view('content.questions.pages-question-create', compact('topics'));
  }

  public function questionStore(Request $request)
  {
    try {
      DB::beginTransaction();
      foreach ($request->questions as $index => $question) {
        $newQuestion = Question::create(
          [
            'topic_id' => $request->topic_id,
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
