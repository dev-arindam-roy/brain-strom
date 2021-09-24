@php
$password = old('password');
$confirm_password = old('confirm_password');
@endphp

@extends('auth.layout.layout')

@section('page-title')
  @if(isset($referUrl) && $referUrl == 'RESET_PASSWORD')
    {{ __('label.reset_password.title') }}
  @else
    {{ __('label.set_password.title') }}
  @endif
@endsection

@section('page-content')
<div class="card-body login-card-body" id="reset-password-page" v-cloak>
    <p class="text-md font-weight-bold text-primary text-center">
      @if(isset($referUrl) && $referUrl == 'RESET_PASSWORD')
        {{ __('label.reset_password.title') }}
      @else
        {{ __('label.set_password.title') }}
      @endif
    </p>
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
      <form id="form" @submit.prevent="onSubmit" action="@if(isset($referUrl) && $referUrl == 'RESET_PASSWORD'){{ route('reset-password-action', array('token' => $token)) }}@else{{ route('operator.setPassword', array('token' => $token)) }}@endif" method="POST">
      @csrf
        <div class="form-group">
          <label class='form-control-label'>{{ __('label.email') }}</label>
          <input type="email" name="email" class="form-control" placeholder="{{ __('label.email') }}" value="@if(isset($operator) && !empty($operator)){{ $operator['email'] }}@endif" readonly="readonly" style="pointer-events: none;">
        </div>
        <div class="form-group">
          <label class='form-control-label'>{{ __('label.new_password') }}</label>
          <input type="password" v-model.trim="password" name="password" class="form-control" placeholder="{{ __('label.new_password') }}" value="{{ $password }}">
          <div class="text-danger" v-if="!$v.password.required && $v.password.$error">{{ __('validation.password.required') }}</div>
          <!-- <div class="text-danger" v-if="!$v.password.maxLength && $v.password.$error">maxlength</div>
          <div class="text-danger" v-if="!$v.password.minLength && $v.password.$error">minlength</div> -->
          <div class="text-danger" v-if="!$v.password.passwordValidate && $v.password.$error">{{ __('validation.password.validate') }}</div>
        </div>
        <div class="form-group">
          <label class='form-control-label'>{{ __('label.confirm_password') }}</label>
          <input type="password" v-model.trim="confirm_password" name="confirm_password" class="form-control" placeholder="{{ __('label.confirm_password') }}" value="{{ $confirm_password }}">
          <div class="text-danger" v-if="!$v.confirm_password.required && $v.confirm_password.$error">{{ __('validation.confirm_password.required') }}</div>
          <div class="text-danger" v-if="!$v.confirm_password.sameAs && $v.confirm_password.required">{{ __('validation.confirm_password.notmatch') }}</div>
        </div>
        <div class="row justify-content-center">
          <div class="col-6 text-center">
            <button type="submit" class="btn btn-outline-primary">
              @if(isset($referUrl) && $referUrl == 'RESET_PASSWORD')
                {{ __('label.reset_password.title') }}
              @else
                {{ __('label.set_password.title') }}
              @endif
            </button>
          </div>
        </div>
      </form>
    </div>
    <div class="card mt-3">
      <div class="card-body">
        <p class="form-control-label text-primary">{{ __('label.password_policy') }}</p>
        <p class="mb-2">{{ __('label.password_should_be') }}</p>
        <ul class="password-policy-list">
          <li>{{ __('label.password_charlen') }}</li>
          <li class="mb-2">{{ __('label.password_accept_text') }}</li>
          <p class="mb-2 pl-0">{{ __('label.password_combination_following') }}</p>
          <li>{{ __('label.password_accept_alpha_num') }}</li>
          <li>{{ __('label.password_accept_alpha_spechar') }}</li>
          <li>{{ __('label.password_accept_alpha_num_spechar') }}</li>
        </ul>
      </div>
    </div>
</div>
@endsection

@push('page_scripts')
<script src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript">
// intialize vuelidate
Vue.use(window.vuelidate.default);
const passwordValidate = (value, vm) => {
  if (value == '') return true
    return /^[a-zA-Z0-9!@#\?$%\^\&*\[\]{}+=._-]{8,32}$/.test(value)
}

let app = new Vue({
    el: '#reset-password-page',
    data() {
      return {
        password: '',
        confirm_password: '',
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
      password: {
        required,
        passwordValidate,
        //maxLength: maxLength(32),
        //minLength: minLength(8)
      },
      confirm_password: {
        required,
        sameAs: sameAs('password')
      }
    }
});
</script>
@endpush