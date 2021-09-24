<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\ImportQuestion;
use App\Exports\ExportQuestion;
use App\Models\Language;
use App\Models\Question;
use App\Models\QuestionType;
use App\Models\Subject;
use Excel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\HeadingRowImport;
use Session;

class QuestionManagementController extends Controller
{

    public function index(Request $request)
    {
        $DataBag = array();
        $DataBag['activeSideBarMenu'] = "QuestionManagement";
        $DataBag['subjectsData'] = Subject::where('status', 1)->orderBy('name', 'asc')->get();
        $DataBag['questionTypeData'] = QuestionType::orderBy('id', 'asc')->get();
        $DataBag['languageData'] = Language::orderBy('id', 'asc')->get();
        $DataBag['allQuestions'] = $this->questionSearch($request, 1);
        return view('admin.question-management.index', $DataBag);
    }

    public function addQuestion(Request $request)
    {
        $DataBag = array();
        $DataBag['activeSideBarMenu'] = "QuestionManagement";
        $DataBag['subjectsData'] = Subject::where('status', 1)->orderBy('name', 'asc')->get();
        $DataBag['questionTypeData'] = QuestionType::orderBy('id', 'asc')->get();
        $DataBag['languageData'] = Language::orderBy('id', 'asc')->get();
        return view('admin.question-management.create', $DataBag);
    }

    public function saveQuestion(Request $request)
    {
        $question = new Question;
        $question->name = $request->name;
        $question->option1 = $request->option1;
        $question->option2 = $request->option2;
        $question->option3 = $request->option3;
        $question->option4 = $request->option4;
        $question->option5 = $request->option5;
        $question->option6 = $request->option6;
        $question->answer_no = $request->answer_no;
        $question->subject_id = $request->subject_id;
        $question->question_type_id = $request->question_type_id;
        $question->language_id = $request->language_id;
        $question->standard_level = $request->standard_level;
        $question->status = $request->status;
        if ($question->save()) {
            session()->flash('msg', 'Question has been created successfully.');
            session()->flash('msg_class', 'alert alert-success');
            session()->flash('msg_title', 'Success!');

            return response()->json([
                'status' => 'success',
            ]);
        }

        session()->flash('msg', 'Something went wrong!');
        session()->flash('msg_class', 'alert alert-danger');
        session()->flash('msg_title', 'Error!');

        return response()->json([
            'status' => 'failed',
        ]);
    }

    public function uploadQuestions()
    {
        $DataBag = array();
        $DataBag['activeSideBarMenu'] = "QuestionManagement";
        return view('admin.question-management.upload-csv', $DataBag);
    }

    public function uploadQuestionsAction(Request $request)
    {
        $csvHeaderCol = [
            'name',
            'option1',
            'option2',
            'option3',
            'option4',
            'option5',
            'option6',
            'answer_no',
            'subject_id',
            'question_type_id',
            'status',
        ];

        $errorMsg = '';
        if ($request->hasFile('question_csv')) {
            $uploadFile = $request->file('question_csv');
            $extension = $uploadFile->getClientOriginalExtension();
            $size = $uploadFile->getSize();

            if (strtolower($extension) != 'csv') {
                $errorMsg = "Uploaded file extension incorrect. It should be csv format.";
            }

            if ($size > 2000000) {
                $errorMsg = "Uploaded file size is greater than 2mb. It should be less than 2mb.";
            }

            $headings = (new HeadingRowImport)->toArray(request()->file('question_csv'));
            $headings = $headings[0];
            foreach ($headings as $col) {
                foreach ($col as $v) {
                    if (!in_array($v, $csvHeaderCol)) {
                        $errorMsg = 'CSV heading format incorrect. Please download sample format and verify.';
                    }
                }
            }

            if ($errorMsg != '') {
                session()->flash('msg', $errorMsg);
                session()->flash('msg_class', 'alert alert-danger');
                session()->flash('msg_title', 'Error!');
                return back();
            }

            Excel::import(new ImportQuestion, request()->file('question_csv'), null, \Maatwebsite\Excel\Excel::CSV);
            session()->flash('msg', 'Bulk Questions in CSV format has been uploaded successfully.');
            session()->flash('msg_class', 'alert alert-success');
            session()->flash('msg_title', 'Success!');
            return redirect()->back();
        }

        return back();
    }

    public function editQuestion(Request $request, $id)
    {
        $DataBag = array();
        $DataBag['activeSideBarMenu'] = "QuestionManagement";
        $DataBag['questionData'] = Question::findOrFail($id);
        $DataBag['subjectsData'] = Subject::where('status', 1)->orderBy('name', 'asc')->get();
        $DataBag['questionTypeData'] = QuestionType::orderBy('id', 'asc')->get();
        $DataBag['languageData'] = Language::orderBy('id', 'asc')->get();
        return view('admin.question-management.create', $DataBag);
    }

    public function deleteQuestion(Request $request, $id)
    {
        Question::findOrFail($id)->delete();
        session()->flash('msg', 'Question has been deleted successfully.');
        session()->flash('msg_class', 'alert alert-success');
        session()->flash('msg_title', 'Success!');
        return redirect()->back();
    }

    public function exportQuestions(Request $request)
    {
        $downloadFileName = 'BrainStorm_' . date('d-m-Y H:i:s') . '.xls';
        $getData = $this->questionSearch($request)->toArray();
        $export = new ExportQuestion($getData);
        return Excel::download($export, $downloadFileName);
    }

    public function questionSearch(Request $request, $pagination = 0)
    {
        $data = Question::select(
                'questions.*',
                'language.name as language',
                'language.code as language_code',
                'question_type.name as question_type',
                'subjects.name as subject_name'
            )
            ->join('language', 'questions.language_id', '=', 'language.id')
            ->join('question_type', 'questions.question_type_id', '=', 'question_type.id')
            ->join('subjects', 'questions.subject_id', '=', 'subjects.id')
            ->where('questions.language_id', '!=', 0)
            ->where('questions.subject_id', '!=', 0)
            ->where('questions.question_type_id', '!=', 0)
            ->orderBy('id', 'desc');

        if ($request->has('name') && $request->get('name') != '') {
            $data = $data->where('questions.name', 'LIKE', '%' . trim($request->get('name')) . '%');
        }
        if ($request->has('standard_level') && $request->get('standard_level') != '') {
            $data = $data->where('questions.standard_level', trim($request->get('standard_level')));
        }
        if ($request->has('subject_id') && $request->get('subject_id') != '') {
            $data = $data->where('questions.subject_id', trim($request->get('subject_id')));
        }
        if ($request->has('question_type_id') && $request->get('question_type_id') != '') {
            $data = $data->where('questions.question_type_id', trim($request->get('question_type_id')));
        }
        if ($request->has('language_id') && $request->get('language_id') != '') {
            $data = $data->where('questions.language_id', trim($request->get('language_id')));
        }
        if ($pagination == 1) {
            $data = $data->paginate(25);
        } else {
            $data = $data->get();
        }

        return $data;
    }

}
