<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Country;
use App\Models\Question;
use App\Models\QuestionImage;
use App\Models\QuestionOption;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class QuestionController extends Controller
{
  public function index()
  {
    $questions = Question::with( 'country')->paginate('10');
    return view('content.questions.list', compact('questions'));
  }

  public function questionCreate()
  {
    $countries = Country::all();
    $groups = config('survey.groups');

    return view('content.questions.pages-question-create', compact('countries', 'groups'));
  }

  public function questionStore(Request $request)
  {
    try {
      DB::beginTransaction();
      foreach ($request->questions as $index => $question) {
        $newQuestion = Question::create(
          [
            'group_id' => $request->group_id,
            'country_id' => $request->country_id,
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

      DB::commit();
      return redirect()->route('question')->with('success', 'Question added successfully');

    } catch (\Throwable $th) {
      //throw $th;
      dd($th->getMessage());
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
    if(isset($request->is_associated)){
      $question->is_associated = 1;
    } else {
      $question->is_associated = 0;
    }
    $question->points = $request->points;

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
//    if($request->has('is_associated')){
//      return Redirect::to('group-questions/'. $question->group_id . '/' . $question->country_id);
//    }
    return redirect()->route('question');
  }

  public function delete($id)
  {
    $question = Question::find($id);
    $question->delete();
    return redirect()->route('question');
  }

  public function fixGroupQuestion()
  {
    $groups = Question::with('country')->select('group_id', 'country_id', DB::raw('COUNT(*) as question_count'))
      ->groupBy('group_id', 'country_id')
      ->get();

    return view('content.groups.list', compact('groups'));
  }

  public function addQuestionsOnGroup()
  {
    $questions = Question::where('group_id', request('group_id'))->where('country_id', request('country_id'))->paginate('10');
    return view('content.groups.question-list', compact('questions'));
  }
}
