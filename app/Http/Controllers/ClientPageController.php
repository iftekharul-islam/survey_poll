<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\Question;
use App\Models\Topic;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isNull;

class ClientPageController extends Controller
{
  public function index()
  {
    $pageConfigs = ['myLayout' => 'blank'];

    $countries = Country::where('id', '!=', 1)->get();
    $topics = Country::all();
    return view('content.client.index', ['pageConfigs' => $pageConfigs, 'countries' => $countries, 'topics' => $topics]);
  }

  public function topicList(Request $request)
  {
    $country_id = $request->country_id;
    $topics = Topic::whereHas('questions', function ($query) use ($country_id) {
      $query->where('country_id', $country_id);
    })->get();
    return response()->json($topics);
  }

  public function quesRange(Request $request)
  {
    $country_id = $request->country_id;
    $topic_id = $request->topic_id;
    $questions = Question::where('country_id', $country_id)->where('group_id', $topic_id)->count();
    return response()->json($questions);
  }

  public function examInfo(Request $request)
  {

    $groups = config('survey.groups');

    $groupQuestions = collect();

    $fixedCountry = Country::find(1); // Germany default for take shuffle
    $questions = Question::where('country_id', $fixedCountry->id)
      ->where('is_associated', 1)
      ->take(30)
      ->get();
    ;
    $remainingQuestions = 30  - count($questions);


    if($remainingQuestions) {
      $groupQuestions = $groupQuestions->concat($questions);
      $questions = Question::where('country_id', $fixedCountry->id)
        ->where('is_associated', 0)
        ->inRandomOrder()
        ->take($remainingQuestions)
        ->get();
    }

    $groupQuestions = $groupQuestions->concat($questions);
    foreach($groups as $key => $group) {
      $questions = Question::where('group_id', $group['id'])
        ->where('country_id', $request->country_id)
        ->where('is_associated', 1)
        ->take($group['no_of_questions'])
        ->get();

      $questionCollected = count($questions);
      $remainingQuestions = $group['no_of_questions'] - $questionCollected;
      if($remainingQuestions) {
        $groupQuestions = $groupQuestions->concat($questions);
        $questions = Question::where('group_id', $group['id'])
          ->where('country_id', $request->country_id)
          ->where('is_associated', 0)
          ->inRandomOrder()
          ->take($remainingQuestions)
          ->get();
      }


      $groupQuestions = $groupQuestions->concat($questions);
    }

    if(!count($groupQuestions)) {
      return redirect()->route('home')->with('error', 'Not enough questions for the selected country');
    }

    $exam = Exam::create([
      'country_id' => $request->country_id,
      'name' => $request->name,
      'email' => $request->email,
    ]);

    $points = 0;
    foreach ($groupQuestions as $question) {
      ExamQuestion::create([
        'exam_id' => $exam->id,
        'question_id' => $question->id,
        'right_id' => $question->right_id,
      ]);

      $points += $question->points;
    }

    $exam->total_score = $points;
    $exam->save();

    return redirect()->route('client.exam', ['exam_id' => $exam->id]);
  }

  public function exam($exam_id)
  {
    $pageConfigs = ['myLayout' => 'blank'];
    $exam = Exam::with('questions.question.options', 'questions.question.images')->find($exam_id);

    if ($exam->final_score !== null) {
      return redirect()->route('client.result', ['exam_id' => $exam->id]);
    }


    return view('content.client.exam', ['pageConfigs' => $pageConfigs, 'exam' => $exam]);
  }

  public function examSubmit(Request $request)
  {
    $final_score = 0;
    $exam = null;
    foreach ($request->questionlist as $question) {
      $examQuestion = ExamQuestion::find($question['id']);
      if (isset($question['selected'])) {
        $examQuestion->answer_id = $question['selected'];
        $examQuestion->save();
        if ($examQuestion->right_id == $question['selected']) {
          $final_score += $examQuestion->question->points;
        }
      }
      if (is_null($exam)) {
        $exam = Exam::find($examQuestion->exam_id);
      }
    }
    $exam->final_score = $final_score;
    $exam->save();

    return redirect()->route('client.result', ['exam_id' => $exam->id]);
  }

  public function result($exam_id)
  {
    $pageConfigs = ['myLayout' => 'blank'];

    $exam = Exam::with('questions.question.options', 'questions.question.images')->find($exam_id);

    return view('content.client.result', ['pageConfigs' => $pageConfigs, 'exam' => $exam]);
  }

  /**
   * @return \Illuminate\Contracts\Foundation\Application
   * |\Illuminate\Contracts\View\Factory
   * |\Illuminate\Contracts\View\View
   * |\Illuminate\Foundation\Application
   */
  public function suggestionPaper(Request $request)
  {

    $pageConfigs = ['myLayout' => 'blank'];

    $countries = Country::all();

    $questions = [];
    if($request->country_id){
      $questions = Question::where('country_id', $request->country_id)->with('options')->paginate('10');
    }


    return view('content.client.suggestion', compact('countries', 'questions', 'pageConfigs'));
  }
}
