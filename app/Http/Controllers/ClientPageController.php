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

    $countries = Country::all();
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
    $questions = Question::where('country_id', $country_id)->where('topic_id', $topic_id)->count();
    return response()->json($questions);
  }

  public function examInfo(Request $request)
  {
    $exam = Exam::create([
      'country_id' => $request->country_id,
      'topic_id' => $request->topic_id,
      'name' => $request->name,
      'email' => $request->email,
      'range' => $request->question_count,
    ]);


    for ($i = 0; $i < $request->question_count; $i++) {
      $question = Question::where('country_id', $request
        ->country_id)->where('topic_id', $request->topic_id)->whereNotIn('id', function ($query) use ($exam) {
        $query->select('question_id')->from('exam_questions')->where('exam_id', $exam->id);
      })->inRandomOrder()->first();

      ExamQuestion::create([
        'exam_id' => $exam->id,
        'question_id' => $question->id,
        'right_id' => $question->right_id,
      ]);
    }

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
          $final_score += $examQuestion->question->marks;
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
}
