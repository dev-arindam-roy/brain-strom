<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('page-title')</title>
  <link rel="icon" href="{{ asset('public/assets/img/favicon.png') }}" type="image/png">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="{{ asset('public/assets/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/assets/dist/css/fonts/open-sans.css') }}">
  <link rel="stylesheet" href="{{ asset('public/assets/plugins/bootstrap-5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/assets/plugins/vue-select/vue-select.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/assets/dist/css/suitex.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/assets/dist/css/suitex.css') }}">
  <!-- custom css -->
  @stack('page_styles')
  <style>
    .swal2-title {
      font-size: 20px !important;
    }
    h5.section-header span {
      color: #525f7f;
    }
    /* Hiding content before Vue App's initialisation */
    [v-cloak] {display: none}
    .oxp nav ul { justify-content: flex-end!important; }
  </style>
</head>

<body class="sidebar-mini">
  <div id="toastr"></div>
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    @include('admin.layout.header')
  </nav>
  <div class="wrapper">
    <aside class="main-sidebar">
      @include('admin.layout.sidebar')
    </aside>

    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid">
          @yield('page-content')
      </section>
    </div>
  </div>
  <footer class="main-footer">
    @include('admin.layout.footer')
  </footer>

  <script src="{{ asset('public/assets/plugins/vuejs/vue.min.js') }}"></script>
  <script src="{{ asset('public/assets/plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('public/assets/plugins/bootstrap-5-bundle.min.js') }}"></script>
  <script src="{{ asset('public/assets/plugins/vuelidate/vuelidate.min.js') }}"></script>
  <script src="{{ asset('public/assets/plugins/vuelidate/validators.min.js') }}"></script>
  <script src="{{ asset('public/assets/plugins/vue-toasted.min.js') }}"></script>
  <script src="{{ asset('public/assets/plugins/sweetAlert.min.js') }}"></script>
  <script src="{{ asset('public/assets/plugins/moment.min.js') }}"></script>
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
