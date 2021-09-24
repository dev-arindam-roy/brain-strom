<?php

namespace App\Exports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Carbon\Carbon;

class ExportQuestion implements FromArray , WithHeadings , ShouldAutoSize , WithColumnWidths , WithStyles
{
    use Exportable;
    protected $questions;

    public function __construct(array $questions)
    {
        $serialNo = 1;
        $questionLevel = array('0' => 'Easy', '1' => 'Medium', '2' => 'Standrad', '3' => 'Hard');
        $this->questions = [];
        foreach ($questions as $v) {
            $arr = array();
            $arr['serial_no'] = $serialNo;
            $arr['question_name'] = $v['name'];
            $arr['option_1'] = $v['option1'];
            $arr['option_2'] = $v['option2'];
            $arr['option_3'] = $v['option3'];
            $arr['option_4'] = $v['option4'];
            $arr['option_5'] = $v['option5'];
            $arr['option_6'] = $v['option6'];
            $arr['subject'] = $v['subject_name'];
            $arr['type'] = $v['question_type'];
            $arr['level'] = $questionLevel[$v['standard_level']];
            $arr['language'] = $v['language'];

            if ($v['answer_no'] == 1) {
                $arr['answer'] = '(1) ' . $v['option1'];
            } elseif ($v['answer_no'] == 2) {
                $arr['answer'] = '(2) ' . $v['option2'];
            } elseif ($v['answer_no'] == 3) {
                $arr['answer'] = '(3) ' . $v['option3'];
            } elseif ($v['answer_no'] == 4) {
                $arr['answer'] = '(4) ' . $v['option4'];
            } elseif ($v['answer_no'] == 5) {
                $arr['answer'] = '(5) ' . $v['option5'];
            } elseif ($v['answer_no'] == 6) {
                $arr['answer'] = '(6) ' . $v['option6'];
            } else {
                $arr['answer'] = 'Unknown';
            }
            

            if ($v['status'] == 0) {
                $arr['status'] = 'Inactive';
            } elseif ($v['status'] == 2) {  
                $arr['status'] = 'In-progress';
            } else {
                $arr['status'] = 'Active';
            }
            
            $arr['created'] = Carbon::parse($v['created_at'])->format('d-m-Y');
            
            if ($v['updated_at'] != null) {
                $arr['updated'] = Carbon::parse($v['updated_at'])->format('d-m-Y');
            } else {
                $arr['updated'] = ''; 
            }
            
            array_push($this->questions, $arr);
            $serialNo++;
        }
    }

    public function array(): array
    {
        //dd($this->questions);
        return $this->questions;
    }

    //Doc Ref - https://docs.laravel-excel.com/3.1/exports/collection.html

    public function headings(): array
    {
        return [
            '#',
            'Question Name',
            'Option 1',
            'Option 2',
            'Option 3',
            'Option 4',
            'Option 5',
            'Option 6',
            'Subject',
            'Question Type',
            'Standard Level',
            'Language',
            'Correct Answer',
            'Status',
            'Created At',
            'Updated At'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'B' => 80,        
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true]],

            // Styling a specific cell by coordinate.
            //'B2' => ['font' => ['italic' => true]],

            // Styling an entire column.
            //'M'  => ['font' => ['bold' => true]],
        ];

        //another way
        //$sheet->getStyle('B2')->getFont()->setBold(true);
    }

}
