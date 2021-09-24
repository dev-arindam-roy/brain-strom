<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('page-title')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="{{ asset('public/assets/img/favicon.png') }}" type="image/gif" sizes="16x16">
  <link rel="stylesheet" href="{{ asset('public/assets/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/assets/dist/css/fonts/open-sans.css') }}">
  <link rel="stylesheet" href="{{ asset('public/assets/plugins/bootstrap-5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/assets/dist/css/suitex.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/assets/dist/css/suitex.css') }}">

  @stack('page_styles')
  <style>
    /* Hiding content before Vue App's initialisation */
    [v-cloak] {display: none}
    
  </style>
</head>

<body class="hold-transition login-page bg-white">
  <div id="toastr"></div>
  <div class="login-box">
    <div class="login-logo">
      <h2 class="mb-0 d-inline-block font-weight-bold">
        Brain
      </h2>
      <h1 class="text-primary d-inline-block">
        Storm <!--span class="logo-span"></span-->
      </h1>
    </div>
    <div class="card">
        @yield('page-content')
    </div>
  </div>
  
  <script src="{{ asset('public/assets/plugins/vuejs/vue.min.js') }}"></script>
  <script src="{{ asset('public/assets/plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('public/assets/plugins/bootstrap-5-bundle.min.js') }}"></script>
  <script src="{{ asset('public/assets/plugins/vuelidate/vuelidate.min.js') }}"></script>
  <script src="{{ asset('public/assets/plugins/vuelidate/validators.min.js') }}"></script>
  <script src="{{ asset('public/assets/plugins/vue-toasted.min.js') }}"></script>
  <script src="{{ asset('public/assets/plugins/sweetAlert.min.js') }}"></script>
  <script src="{{ asset('public/assets/dist/js/suitex.min.js') }}"></script>
  <script src="{{ asset('public/js/app.js') }}"></script>

  <script type="text/javascript">
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    });
    // intialize vuelidate
    Vue.use(window.vuelidate.default);
    // import rules from vuelidate
    const {required, requiredIf, numeric, minValue, maxValue, minLength, maxLength, email, sameAs, helpers} = window.validators;
    
    let navBarVue = new Vue({
      el: '#toastr',
      mounted() {
        // Toastr initialization
        @if(session()->has('msg') && session()->has('msg_class'))
          @if(session()->get('msg_class') == 'alert alert-danger')
            this.$toastr.e("{!! session()->get('msg') !!}", "{{ session()->get('msg_title') }}");
          @endif

          @if(session()->get('msg_class') == 'alert alert-success')
            this.$toastr.s("{!! session()->get('msg') !!}", "{{ session()->get('msg_title') }}");
          @endif
        @endif
      }
    })
  </script>
  <!-- custom script -->
  
  @stack('page_scripts')
</body>

</html>