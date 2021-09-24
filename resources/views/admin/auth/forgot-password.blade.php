@php
$alertType = '';
if(isset($alertDetails) && !empty($alertDetails)) {
  $alertType = $alertDetails['type'];
}
$email = old('email');
@endphp

@extends('auth.layout.layout')

@section('page-title')
Forgot password
@endsection

@section('page-content')
<div class="card-body login-card-body" id="forgot-password-page" v-cloak>
    <p class="text-md font-weight-bold text-primary text-center">{{ __('label.forgot_password.title') }}</p>
    <p class="text-center text-sm text-secondary">{{ __('label.forgot_password.description') }}</p>
    <hr class="m-2">
    <div class="px-4">
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
      <form id="form" @submit.prevent="onSubmit" action="{{ route('forgot-password-action') }}" method="POST">
        @csrf
        <label class='form-control-label'>{{ __('label.operator.email.address') }}</label>
        <div class="input-group">
          <input type="email" v-model.trim="email" name="email" class="form-control" placeholder="{{ __('label.operator.email.address') }}">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="text-danger" v-if="!$v.email.required && $v.email.$error">{{ __('validation.operator.email.required') }}</div>
        <div class="text-danger" v-if="!$v.email.maxLength && $v.email.$error">{{ __('validation.operator.email.maxlength') }}</div>
        <div class="text-danger" v-if="!$v.email.emailValidate && $v.email.$error">{{ __('validation.operator.email.emailformat') }}</div>
        <div class="row justify-content-center mt-3">
          <div class="col-6 text-center">
            <button type="submit" class="btn btn-outline-primary">{{ __('label.btn.reset') }}</button>
          </div>
        </div>
      </form>
    </div>
    <div class="row">
    <div class="col-12 text-center mt-4">
        <a href="{{ url('auth/login') }}"><p class="text-primary mb-0">{{ __('label.auth.btn.back_to_login') }}</p></a>
    </div>
    </div>

    <!-- Need For Alter -->
    <input type="hidden" v-model.trim="alertType">
    <!-- End Need For Alter -->

</div>
@endsection

@push('page_scripts')
<script src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript">
// intialize vuelidate
Vue.use(window.vuelidate.default);
const emailValidate = (value, vm) => {
  if (value == '') return true
    return /^[a-zA-Z0-9!@#\?$%\^\&*\[\]{}+=._-]{8,32}$/.test(value)
}

let app = new Vue({
    el: '#forgot-password-page',
    data() {
      return {
        email: '{!! $email !!}',
        showAlert: {!! !empty($showAlert) ? 'true' : 'false' !!},
        alertType: '{!! $alertType !!}',
      }
    },
    mounted() {
      if (this.showAlert) {
        if (this.alertType == 'success') {
          this.$toastr.s('{!! !empty($alertDetails["message"]) ? __("success.".$alertDetails["message"]) : '' !!}');
        }
        if (this.alertType == 'error') {
          this.$toastr.e('{!! !empty($alertDetails["message"]) ? __("error.".$alertDetails["message"]) : '' !!}');
        }
        this.showAlert = false
      }
    },
    methods: {
      onSubmit() {
        // this.$isSubmitted = true
        this.$v.$touch();
        console.log(this.$v);
        if (!this.$v.$error) {
            document.getElementById('form').submit();
        }
      }
    },
    validations: {
      email: {
        required,
        emailValidate,
        maxLength: maxLength(191),
      }
    }
});
</script>
@endpush
