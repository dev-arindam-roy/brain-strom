@php
$questionLevel = array('0' => 'Easy', '1' => 'Medium', '2' => 'Standrad', '3' => 'Hard');
$searchQuestionName = '';
$searchStandardLevel = '';
$searchQuestionSubject = '';
$searchQuestionType = '';
$searchQuestionLanguage = '';
if(isset($_GET['name']) && $_GET['name'] != '') {
  $searchQuestionName = $_GET['name'];
}
if(isset($_GET['standard_level']) && $_GET['standard_level'] != '') {
  $searchStandardLevel = $_GET['standard_level'];
}
if(isset($_GET['subject_id']) && $_GET['subject_id'] != '') {
  $searchQuestionSubject = $_GET['subject_id'];
}
if(isset($_GET['question_type_id']) && $_GET['question_type_id'] != '') {
  $searchQuestionType = $_GET['question_type_id'];
}
if(isset($_GET['language_id']) && $_GET['language_id'] != '') {
  $searchQuestionLanguage = $_GET['language_id'];
}
@endphp

@extends('admin.layout.layout')

@section('page-title')
Question Management
@endsection

@section('page-content')
<div id="QuestionList" v-cloak>
    @include('admin.layout.loading')
    <div class="row mb-2">
        <div class="col-sm-6">
          <h5 class="section-header"><span>Question Management</span> | All Questions</h5>
        </div>
        <div class="col-6">
          <div class="btn-group float-right" role="group" aria-label="Basic example">
            <a href="{{ route('admin.account.question.add') }}" class="btn btn-outline-primary">
                Create <i class="nav-icon fas fa-plus-square"></i>
            </a>
            <a href="{{ route('admin.account.question.upload_csv') }}" class="btn btn-outline-primary">
                Upload CSV <i class="nav-icon fas fa-file-alt"></i>
            </a>
            <a href="javascript:void(0);" class="btn btn-outline-primary" id="ExportQuestionBtn" v-on:click="ExportQuestion">
                Download Excel <i class="nav-icon fas fa-download"></i>
            </a>
          </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card" style="background-color: rgb(249 249 249);">
                <div class="card-body">
                  <form name="questionFilter" id="questionFilter" action="" method="GET">
                    <div class="row mb-2">
                      <div class="col-sm-6">
                        <input type="text" name="name" v-model.trim="searchParams.name" class="form-control" placeholder="Search By Question Name...">
                      </div>
                      <div class="col-sm-3">
                        <select name="language_id" class="form-control" v-model="searchParams.language_id">
                            <option value="">Language</option>
                            <option v-for="(item, index) in languageArr" :value="item.id">@{{item.name}}</option>
                        </select>
                      </div>
                      <div class="col-sm-3" style="text-align: right;">
                        <button type="submit" class="btn btn-outline-primary ml-auto" :disabled="searchDisabled">Search</button>
                        <a href="{{ route('admin.account.question.index') }}" class="btn btn-outline-primary">Clear</a>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-3">
                        <select name="standard_level" class="form-control" v-model="searchParams.standard_level">
                            <option value="">Standard Level</option>
                            <option v-for="(item, index) in standardLevelArr" :value="item">@{{item}}</option>
                        </select>
                      </div>
                      <div class="col-sm-3">
                        <select name="subject_id" class="form-control" v-model="searchParams.subject_id">
                            <option value="">Subjects</option>
                            <option v-for="(item, index) in subjectArr" :value="item.id">@{{item.name}}</option>
                        </select>
                      </div>
                      <div class="col-sm-3">
                        <select name="question_type_id" class="form-control" v-model="searchParams.question_type_id">
                            <option value="">Question Type</option>
                            <option v-for="(item, index) in questionTypeArr" :value="item.id">@{{item.name}}</option>
                        </select>
                      </div>
                    </div>
                  </form>
                  <!-- ExportForm -->
                  <form name="questionFilterExport" id="questionFilterExport" action="{{ route('admin.account.question.export_questions') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="name" v-model.trim="searchParams.name">
                    <input type="hidden" name="subject_id" v-model.trim="searchParams.subject_id">
                    <input type="hidden" name="question_type_id" v-model.trim="searchParams.question_type_id">
                    <input type="hidden" name="standard_level" v-model.trim="searchParams.standard_level">
                    <input type="hidden" name="language_id" v-model.trim="searchParams.language_id">
                  </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-1">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                  @if(isset($allQuestions) && !empty($allQuestions))
                    @php $sl = 1; @endphp
                    @foreach($allQuestions as $question)
                      <div class="questionItem @if($sl > 1) mt-3 @endif" style="border-bottom: 1px dashed #ddd; padding-bottom: 12px;">
                        <div class="row">
                          <div class="col-md-2">
                            <input type="checkbox" value="{{ $question->id }}">
                            <span><i class="fas fa-hashtag"></i>{{ $sl }}</span>
                          </div>
                          <div class="col-md-10">
                            <div><p class="question">{{ $question->name }}</p></div>
                            <div class="row">
                              <div class="col-sm-4"><span class="mr-3"><i class="fas fa-bookmark"></i> {{ $question->subjectInfo->name }}</span></div>
                              <div class="col-sm-3"><span class="mr-3"><i class="fas fa-clipboard-check"></i> {{ $question->questionTypeInfo->name }}</span></div>
                              <div class="col-sm-2"><span class="mr-3"><i class="fas fa-brain"></i> {{ $questionLevel[$question->standard_level] }}</span></div>
                              <div class="col-sm-2"><span class="mr-3"><i class="fas fa-globe"></i> {{ $question->language_code }}</span></div>
                              <div class="col-sm-1">
                                <a href="javascript:void(0);" title="Delete Question" @click="onDeleteAction('{{ $question->id }}')"><i class="fas fa-trash-alt" style="color: #fc6600;"></i></a>
                                <a href="{{ route('admin.account.question.edit', array('id' => $question->id)) }}" title="Edit Question"><i class="fas fa-edit" style="color: #fc6600;"></i></a></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    @php $sl++; @endphp
                    @endforeach
                  <div class="row mt-4">
                    <div class="col-sm-4 py-2"></div>
                    <div class="col-sm-8 py-2 oxp">
                      {{ $allQuestions->links() }}
                    </div>
                  </div>
                  @endif
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
var _subjectArr = <?php echo json_encode($subjectsData); ?>;
var _questionTypeArr = <?php echo json_encode($questionTypeData); ?>;
var _languageArr = <?php echo json_encode($languageData); ?>;
let app = new Vue({
    el: '#QuestionList',
    data() {
      return {
        isLoading: false,
        standardLevelArr: _standardLevelArr,
        subjectArr: _subjectArr,
        questionTypeArr: _questionTypeArr,
        languageArr: _languageArr,
        searchParams: {
          name: '{{ $searchQuestionName }}',
          standard_level: '{{ $searchStandardLevel }}',
          subject_id: '{{ $searchQuestionSubject }}',
          question_type_id: '{{ $searchQuestionType }}',
          language_id: '{{ $searchQuestionLanguage }}'
        },
      }
    },
    watch: {
    },
    computed: {
      searchDisabled: function() {
        if (this.searchParams.name != '' || this.searchParams.standard_level != '' || this.searchParams.subject_id != '' || this.searchParams.question_type_id != '' || this.searchParams.language_id != '') {
          return false;
        } else {
          return true;
        }
      }
    },
    validations: {
        
    },
    methods: {
      onDeleteAction(questionId) {
        var _deleteURL = "{{ url('administrator/auth/account/question-management/delete') }}" + "/" + questionId;
        var _this = this;
        Swal.fire({
          title: 'Are you sure?',
          text: 'You want to delete this question',
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Yes',
          cancelButtonText: 'Cancel',
          customClass: {
            confirmButton: 'btn btn-outline-primary',
            cancelButton: 'btn btn-outline-secondary',
          }
        }).then((result) => {
          if (result.isConfirmed) {
            _this.isLoading = true;
            window.location.href = _deleteURL;
          }
        })
      },
      ExportQuestion() {
        var _currentInstance = this;
        _currentInstance.isLoading = true;
        $('#questionFilterExport').submit();
        setTimeout(() => {
          _currentInstance.isLoading = false;
        }, 3000);
      }
    },
});
</script>
@endpush
