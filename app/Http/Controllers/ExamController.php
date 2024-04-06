<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
  public function index()
  {
    $exams = Exam::paginate('10');
    return view('content.exam.list', compact('exams'));
  }

  public function show(string $id)
  {
    $exam = Exam::with('questions.question.options', 'questions.question.images')->find($id);
    return view('content.exam.show', compact('exam'));
  }
}
