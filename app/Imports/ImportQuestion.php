<?php

namespace App\Imports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportQuestion implements ToModel, WithHeadingRow
{

    public function model(array $ImportRows)
    {
        $question = new Question;
        $question->name = $ImportRows['name'];
        $question->option1 = $ImportRows['option1'];
        $question->option2 = $ImportRows['option2'];
        $question->option3 = $ImportRows['option3'];
        $question->option4 = $ImportRows['option4'];
        $question->option5 = $ImportRows['option5'];
        $question->option6 = $ImportRows['option6'];
        $question->answer_no = $ImportRows['answer_no'];
        $question->subject_id = $ImportRows['subject_id'];
        $question->question_type_id = $ImportRows['question_type_id'];
        $question->status = $ImportRows['status'];
        $question->save();
    }
}