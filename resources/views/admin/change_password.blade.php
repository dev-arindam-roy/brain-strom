
<!-- Modal -->
<div class="modal fade" id="changePasswordModal" v-cloak data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">{{ __('label.change_password_title') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div v-if="errors.length > 0" class="col-12 alert alert-danger fade show" :class="{}" role="alert" :data-count="errors.length">
            <div v-for="(error,index) in errors" :key="index">
                <li>@{{ error }}</li>
            </div>
        </div>
        <form id="form" @submit.prevent="onSubmit" method="POST">
            @csrf
            <div class="form-group">
                <label class='form-control-label'>{{ __('label.new_password') }}</label>
                <input type="password" v-model.trim="password" name="password" class="form-control" placeholder="{{ __('label.new_password') }}">
                <div class="text-danger" v-if="!$v.password.required && $v.password.$error">{{ __('validation.password.required') }}</div>
                <div class="text-danger" v-if="!$v.password.passwordValidate && $v.password.$error">{{ __('validation.password.validate') }}</div>
            </div>
            <div class="form-group">
                <label class='form-control-label'>{{ __('label.confirm_password') }}</label>
                <input type="password" v-model.trim="confirm_password" name="confirm_password" class="form-control" placeholder="{{ __('label.confirm_password') }}">
                <div class="text-danger" v-if="!$v.confirm_password.required && $v.confirm_password.$error">{{ __('validation.confirm_password.required') }}</div>
                <div class="text-danger" v-if="!$v.confirm_password.sameAs && $v.confirm_password.required">{{ __('validation.confirm_password.notmatch') }}</div>
            </div>
            <div class="row justify-content-center">
                <div class="col-6 text-center">
                    <button type="submit" class="btn btn-outline-primary">
                        {{ __('label.btn.change') }}
                    </button>
                    <p class="form-control-label text-primary mt-2">
                        <a href="javascript:void(0);" @click="showHidePwdPc">{{ __('label.password_policy') }}</a>
                    </p>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer" v-if="password_policy==true">
        <div class="card mt-3">
            <div class="card-body">
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
    </div>
  </div>
</div>

@push('page_scripts')


@endpush