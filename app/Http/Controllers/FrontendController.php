<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;
use App\Models\Question;
use App\Models\QuestionType;
use App\Models\Subject;
use Session;
use Auth;

class FrontendController extends Controller
{
    public function index(Request $request)
    {
        $DataBag = array();
        return view('frontend.index', $DataBag);
    }

    public function quickTest(Request $request)
    {
        $DataBag = array();

        $allQuestionIds = Question::with(['subjectInfo', 'questionTypeInfo'])
            ->orderByRaw('RAND()')
            ->pluck('id')
            ->take(10)
            ->toArray();

        if (empty($allQuestionIds)) {
            return redirect()->route('f.index');
        } 
        $DataBag['allQuestionIds'] = json_encode($allQuestionIds);
        return view('frontend.quick-test', $DataBag);
    }
}
