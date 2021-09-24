<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';
    protected $primaryKey = 'id';

    public function subjectInfo()
    {
        return $this->hasOne('App\Models\Subject', 'id', 'subject_id');
    }

    public function questionTypeInfo()
    {
        return $this->hasOne('App\Models\QuestionType', 'id', 'question_type_id');
    }
}
