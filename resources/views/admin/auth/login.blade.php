@php
if(isset($_COOKIE['brainStormAdminEmail']) && $_COOKIE['brainStormAdminEmail'] != '') {
  $username_email = $_COOKIE['brainStormAdminEmail'];
} else {
  $username_email = old('username_email');
}

$password = '';
if(isset($_COOKIE['brainStormAdminPassword']) && $_COOKIE['brainStormAdminPassword'] != '') {
  $password = $_COOKIE['brainStormAdminPassword'];
}

$isRememberMeChecked = false;
if(isset($_COOKIE['brainStormAdminEmail']) && $_COOKIE['brainStormAdminEmail'] != ''
  && isset($_COOKIE['brainStormAdminPassword']) && $_COOKIE['brainStormAdminPassword'] != '') {
    $isRememberMeChecked = true;
}
@endphp

@extends('admin.auth.layout.layout')

@section('page-title')
Administrator Login
@endsection

@section('page-content')
<div class="card-body login-card-body" id="login-page" v-cloak>
    <!-- <p class="login-box-msg"></p> -->
    <p class="text-md font-weight-bold text-primary text-center">Administrator Login</p>
    <hr class="m-2">
    <div class="px-4">
      @if($errors->validationErrors->any())
        <div class="col-12 alert alert-danger alert-dismissible fade show" role="alert">
          @foreach($errors->validationErrors->all() as $error)
            <li style="font-size: 12px;">{!! $error !!}</li>
          @endforeach
          <button type="button" class="close text-light" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif
      <form id="loginForm" @submit.prevent="onSubmit" action="" method="POST">
        @csrf
        <label class='form-control-label'>Username or Email:</label>
        <div class="input-group">
          <input type="text" class="form-control" name="username_email" v-model="username_email" placeholder="Username or Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="text-danger mb-3" v-if="!$v.username_email.required && $v.username_email.$error">Username or Email is required.</div>
        @if($errors->validationErrors->has('username_email'))
          <div class="text-danger mb-3">{!! $errors->validationErrors->first('username_email') !!}</div>
        @endif

        <label class='form-control-label'>Password:</label>
        <div class="input-group">
          <input type="password" class="form-control" name="password" v-model="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="text-danger mb-3" v-if="!$v.password.required && $v.password.$error">Password is required.</div>
        @if($errors->validationErrors->has('password'))
          <div class="text-danger mb-3">{!! $errors->validationErrors->first('password') !!}</div>
        @endif

        <div class="row mt-3">
          <div class="col-6">
          <button type="submit" class="btn btn-outline-primary">Login</button>
          </div>
          <div class="col-6 text-right">
            <input type="checkbox" class="form-check-input" name="remember_me" id="remember_me" value="1" :checked="isRememberMeChecked"> 
            <label class="form-control-label" for="remember_me">Remember Me</label>
          </div>
        </div>
      </form> 
    </div>
    <div class="row">
      <div class="col-8 mt-2">
      <div class="px-4">
        <a href=""><p class="text-primary mb-0">Forgot Password?</p></a>
      </div>
      </div>
    </div>
</div>
@endsection

@push('page_scripts')
<script type="text/javascript">
let app = new Vue({
    el: '#login-page',
    data() {
      return {
        username_email: "{{ $username_email }}",
        password: "{{ $password }}",
        isRememberMeChecked: "{{ $isRememberMeChecked }}",
      }
    },
    mounted() {
      
    },
    methods: {
      onSubmit() {
        this.$v.$touch();
        if (!this.$v.$error) {
            document.getElementById('loginForm').submit();
        }
      }
    },
    validations: {
      username_email: {
        required,
      },
      password: {
        required,
      }
    }
});
</script>
@endpush