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

  public function edit($id)
  {
    $question = Question::with('options', 'images')->find($id);
    return view('content.questions.edit', compact('question'));
  }

  public function update(Request $request, $id)
  {
    $question = Question::find($id);
    $questionOption = QuestionOption::where('question_id', $question->id)->delete();

    $question->question = $request->question;
    $question->marks = $request->marks;

    foreach ($request->options as $key => $option) {
      $questionOption = QuestionOption::create(
        [
          'question_id' => $question->id,
          'option' => $option,
        ]
      );
      if ($request->selected == $option) {
        $question->right_id = $questionOption->id;
      }
    }

    if ($request->hasFile('images')) {
      foreach ($request->file('images') as $image) {
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->storeAs('images', $imageName);
        QuestionImage::create(
          [
            'question_id' => $question->id,
            'image' => $imageName,
          ]
        );
      }
    }
    $question->save();
    return redirect()->route('question');
  }

  public function delete($id)
  {
    $question = Question::find($id);
    $question->delete();
    return redirect()->route('question');
  }
}
