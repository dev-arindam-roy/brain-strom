@php

$alertType = '';
if(isset($alertDetails) && !empty($alertDetails)) {
  $alertType = $alertDetails['type'];
}

@endphp

@extends('admin.layout.layout')
@section('page-title')
Dashboard
@endsection

@section('page-content')
<div class="row mb-2" id="operator-dashboard" v-cloak>
    <div class="col-sm-6">
      <h5 class="section-header">Dashboard</h5>
    </div>
</div>

<!-- Need For Alter -->
<input type="hidden" v-model.trim="alertType">
<!-- End Need For Alter -->

@endsection

@push('page_scripts')
<script type="text/javascript">
let app = new Vue({
    el: '#operator-dashboard',
    data() {
      return {
        showAlert: {!! !empty($showAlert) ? 'true' : 'false' !!},
        alertType: '{!! $alertType !!}'
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
    }
});
</script>
@endpush
