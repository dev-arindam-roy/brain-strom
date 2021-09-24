@php
$questionLevel = array('0' => 'Easy', '1' => 'Medium', '2' => 'Standrad', '3' => 'Hard');
$correctAnswer = array(
    '1' => 'Option #1', 
    '2' => 'Option #2', 
    '3' => 'Option #3', 
    '4' => 'Option #4',
    '5' => 'Option #5',
    '6' => 'Option #6'
);
$questionStatus = array('0' => 'Inactive', '1' => 'Active', '2' => 'In-progress'); 
@endphp


@extends('admin.layout.layout')

@section('page-title')
Question Management
@endsection

@section('page-content')
<div class="row mb-2" id="addEditQuestion" v-cloak>
@include('admin.layout.loading')
  <div class="col-sm-6">
    <h5 class="section-header"><span>Question Management</span> | Create New Question</h5>
  </div>
  <div class="row">
    <div class="col-12 col-lg-12">
      <div class="card">
        <div class="card-body">
          @if ($errors->any())
            <div class="col-12 alert alert-danger alert-dismissible fade show" role="alert">
              @foreach ($errors->all() as $error)
                <li>{{ __('validation.'.$error) }}</li>
              @endforeach
              <button type="button" class="close text-light" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          @endif
          <form id="QuestionForm" @submit.prevent="onSubmit" action="{{ route('admin.account.question.create') }}" method="POST" enctype="multipart/form-data">
          @csrf
            <div id="actionForm">
                <div class="row">
                    <div class="form-group col-sm-12 col-md-4">
                        <label class='form-control-label'>Subject:</label>
                        <select name="subject_id" class="form-control" v-model="subject_id">
                            <option value="">-Select-</option>
                            <option v-for="(item, index) in subjectArr" :value="item.id">@{{item.name}}</option>
                        </select>
                        <div class="text-danger" v-if="!$v.subject_id.required && $v.subject_id.$error">Please select subject.</div>
                    </div>
                    <div class="form-group col-sm-12 col-md-4">
                        <label class='form-control-label'>Question Type:</label>
                        <select name="question_type_id" class="form-control" v-model="question_type_id">
                            <option v-for="(item, index) in questionTypeArr" :value="item.id">@{{item.name}}</option>
                        </select>
                        <div class="text-danger" v-if="!$v.question_type_id.required && $v.question_type_id.$error">Please select question type.</div>
                    </div>
                    <div class="form-group col-sm-12 col-md-2">
                        <label class='form-control-label'>Language:</label>
                        <select name="language_id" class="form-control" v-model="language_id">
                            <option v-for="(item, index) in languageArr" :value="item.id">@{{item.name}}</option>
                        </select>
                        <div class="text-danger" v-if="!$v.language_id.required && $v.language_id.$error">Please select language.</div>
                    </div>
                    <div class="form-group col-sm-12 col-md-2">
                        <label class='form-control-label'>Status:</label>
                        <select name="status" class="form-control" v-model="status">
                            <option v-for="(item, index) in statusArr" :value="index">@{{item}}</option>
                        </select>
                        <div class="text-danger" v-if="!$v.status.required && $v.status.$error">Please select status.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12 col-md-12">
                        <label class='form-control-label'>Question:</label>
                        <textarea name="name" v-model="name" class="form-control" placeholder="Type Question..." style="height:120px;"></textarea>
                        <div class="text-danger" v-if="!$v.name.required && $v.name.$error">Please add a question.</div>
                        <div class="text-danger" v-if="!$v.name.minLength && $v.name.$error">Question should have atleast 6 characters.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12 col-md-6">
                        <label class='form-control-label'>Option #1:</label>
                        <textarea name="option1" v-model="option1" class="form-control" placeholder="Option Number 1"></textarea>
                        <div class="text-danger" v-if="!$v.option1.required && $v.option1.$error">Please enter option number 1.</div>
                    </div>
                    <div class="form-group col-sm-12 col-md-6">
                        <label class='form-control-label'>Option #2:</label>
                        <textarea name="option2" v-model="option2" class="form-control" placeholder="Option Number 2"></textarea>
                        <div class="text-danger" v-if="!$v.option2.required && $v.option2.$error">Please enter option number 2.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12 col-md-6">
                        <label class='form-control-label'>Option #3:</label>
                        <textarea name="option3" v-model="option3" class="form-control" placeholder="Option Number 3"></textarea>
                        <div class="text-danger" v-if="!$v.option3.required && $v.option3.$error">Please enter option number 3.</div>
                    </div>
                    <div class="form-group col-sm-12 col-md-6">
                        <label class='form-control-label'>Option #4:</label>
                        <textarea name="option4" v-model="option4" class="form-control" placeholder="Option Number 4"></textarea>
                        <div class="text-danger" v-if="!$v.option4.required && $v.option4.$error">Please enter option number 4.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12 col-md-6">
                        <label class='form-control-label'>Option #5:</label>
                        <textarea name="option5" v-model="option5" class="form-control" placeholder="Option Number 5"></textarea>
                    </div>
                    <div class="form-group col-sm-12 col-md-6">
                        <label class='form-control-label'>Option #6:</label>
                        <textarea name="option6" v-model="option6" class="form-control" placeholder="Option Number 6"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12 col-md-6">
                    </div>
                    <div class="form-group col-sm-12 col-md-3">
                        <label class='form-control-label'>Correct Answer:</label>
                        <select name="answer_no" class="form-control" v-model="answer_no">
                            <option value="">-Select-</option>
                            <option v-for="(item, index) in correctAnswer" :value="index">@{{item}}</option>
                        </select>
                        <div class="text-danger" v-if="!$v.answer_no.required && $v.answer_no.$error">Please select correct option number.</div>
                    </div>
                    <div class="form-group col-sm-12 col-md-3">
                        <label class='form-control-label'>Standard Level:</label>
                        <select name="standard_level" class="form-control" v-model="standard_level">
                            <option v-for="(item, index) in standardLevel" :value="index">@{{item}}</option>
                        </select>
                        <div class="text-danger" v-if="!$v.standard_level.required && $v.standard_level.$error">Please select question standrad.</div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-12 col-md-6">
                        <button type="submit" class="btn btn-outline-primary ml-auto">Create Question</button>
                        <a href="#" class="btn btn-outline-secondary ml-2">Cancel</a>
                    </div>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('page_scripts')
<script src="https://cdn.jsdelivr.net/npm/vue-loading-overlay@3"></script>
<link href="https://cdn.jsdelivr.net/npm/vue-loading-overlay@3/dist/vue-loading.css" rel="stylesheet">
<script type="text/javascript">
// loading
Vue.use(VueLoading);
Vue.component('loading', VueLoading);
var _standardLevelArr = <?php echo json_encode($questionLevel); ?>;
var _correctAnswerArr = <?php echo json_encode($correctAnswer); ?>;
var _subjectArr = <?php echo json_encode($subjectsData); ?>;
var _questionTypeArr = <?php echo json_encode($questionTypeData); ?>;
var _languageArr = <?php echo json_encode($languageData); ?>;
var _statusArr = <?php echo json_encode($questionStatus); ?>;
let app = new Vue({
    el: '#addEditQuestion',
    data() {
      return {
        isLoading: false,
        standardLevel: _standardLevelArr,
        correctAnswer: _correctAnswerArr,
        subjectArr: _subjectArr,
        questionTypeArr: _questionTypeArr,
        languageArr: _languageArr,
        statusArr: _statusArr,
        standard_level: 0,
        answer_no: "",
        status: 1,
        subject_id: "",
        question_type_id: 1,
        language_id: 1,
        name: "",
        option1: "",
        option2: "",
        option3: "",
        option4: "",
        option5: "",
        option6: "",
      }
    },
    mounted() {
        
    },
    validations: {
        subject_id: {
            required,
        },
        name: {
            required,
            minLength: minLength(6),
        },
        question_type_id: {
            required,
        },
        language_id: {
            required,
        },
        status: {
            required,
        },
        option1: {
            required,
        },
        option2: {
            required,
        },
        option3: {
            required,
        },
        option4: {
            required,
        },
        answer_no: {
            required
        },
        standard_level: {
            required
        },
    },
    methods: {
        async onSubmit() {
            this.$v.$touch();
            if (this.$v.$error) {
                this.$toastr.e('Please check all fields and enter correct value', 'Validation Error!');
            }
            if (!this.$v.$error) {
                this.isLoading = true;
                var _currentInstance = this;
                var url = document.getElementById('QuestionForm').action;
                const submitData = await axios({
                    method: 'post',
                    url: url,
                    data: {
                        'subject_id' : _currentInstance.subject_id,
                        'question_type_id' : _currentInstance.question_type_id,
                        'language_id' : _currentInstance.language_id,
                        'status' : _currentInstance.status,
                        'name' : _currentInstance.name,
                        'option1' : _currentInstance.option1,
                        'option2' : _currentInstance.option2,
                        'option3' : _currentInstance.option3,
                        'option4' : _currentInstance.option4,
                        'option5' : _currentInstance.option5,
                        'option6' : _currentInstance.option6,
                        'answer_no' : _currentInstance.answer_no,
                        'standard_level' : _currentInstance.standard_level,
                    },
                    headers: {'Content-Type': 'application/json'}
                })
                .then(function (response) {
                    setTimeout(() => {
                        window.location.href = '{{ route("admin.account.question.index") }}'
                    }, 1000);
                })
                .catch(function (response) {
                    console.log(response);
                });
            }
        }
    },
});
</script>
@endpush
