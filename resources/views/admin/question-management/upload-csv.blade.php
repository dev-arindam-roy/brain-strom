@extends('admin.layout.layout')

@section('page-title')
Question Management
@endsection

@section('page-content')
<div id="UploadQuestions" v-cloak>
    @include('admin.layout.loading')
    <div class="row mb-2">
        <div class="col-sm-6">
          <h5 class="section-header"><span>Question Management</span> | Upload Bulk Questions</h5>
        </div>
        <div class="col-6">
          <div class="btn-group float-right" role="group" aria-label="Basic example">
            <a href="{{ route('admin.account.question.add') }}" class="btn btn-outline-primary">
                Create New Question <i class="nav-icon fas fa-plus-square"></i>
            </a>
            <a href="{{ route('admin.account.question.upload_csv') }}" class="btn btn-outline-primary">
                Upload CSV <i class="nav-icon fas fa-file-alt"></i>
            </a>
          </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="UploadQuestionForm" @submit.prevent="onSubmit" action="{{ route('admin.account.question.upload_csv_action') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-6">
                                <label class='form-control-label'>Upload Questions CSV:</label><br/>
                                <input type="file" name="question_csv" accept=".csv" @change="selectCSVforUpload">
                            </div>
                            <div class="form-group col-sm-12 col-md-2">
                                <button type="submit" class="btn btn-outline-primary ml-auto mt-4">Upload</button>
                            </div>
                            <div class="form-group col-sm-12 col-md-4">
                                <a href="{{ asset('public/assets/BrainStorm_SampleQuestion.csv') }}" download>Download Sample CSV File</a>
                                <p style="font-size:12px;"><span><i>Please download and use same format for bulk question upload, otherwise system unable to proccess, thanks.</i></span></p>
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
let app = new Vue({
    el: '#UploadQuestions',
    data() {
      return {
        isLoading: false,
        selectedCSV: null,
      }
    },
    mounted() {
        
    },
    validations: {
        
    },
    methods: {
        selectCSVforUpload(event) {
            this.selectedCSV = event.target.files[0];
        },
        onSubmit() {
            console.log(this.selectedCSV);
            //console.log(this.selectedCSV.name.substr(this.selectedCSV.name.lastIndexOf('.') + 1));
            if (this.selectedCSV != null && this.selectedCSV != '') {
                if (this.selectedCSV.name != undefined) {
                    const fileExtension = this.selectedCSV.name.substr(this.selectedCSV.name.lastIndexOf('.') + 1); 
                    if (fileExtension == 'csv') {
                        this.isLoading = true;
                        document.getElementById('UploadQuestionForm').submit();
                    } else {
                        this.$toastr.e('Please select only csv file', 'Validation Error!');
                    }
                } else {
                    this.$toastr.e('Please select csv file', 'Validation Error!');
                }
                
            } else {
                this.$toastr.e('Please select csv file', 'Validation Error!');
            }
            
        }
    },
});
</script>
@endpush
