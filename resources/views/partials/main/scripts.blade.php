
@push('scripts')
    <script>
        $(document).ready(function () {

            let log_err_status = @if((session('log_action', 0) == 1 && (session()->has('alert.danger') || !empty($errors->all()))) || session('sign_action', 0) == 1){{ '1' }}@else{{ '0' }}@endif;
            if (log_err_status == '1') {
                $('#login').addClass('show-modal');
                @php session()->forget('log_action');
                     session()->forget('sign_action'); @endphp
            }

            let reg_err_status = @if(session('reg_action', 0) == 1 && (session()->has('alert.danger') || !empty($errors->all()))){{ '1' }}@else{{ '0' }}@endif;
            if (reg_err_status == '1') {
                $('#register').addClass('show-modal');
                @php session()->forget('reg_action'); @endphp
            }

            let suc_status = @if(session('down_reg', 0) == 1){{ '1' }}@else{{ '0' }}@endif;
            if (suc_status == '1') {
                $('.success-server').text('{{ config('app.name') }}');
                $('#success').addClass('show-modal');

                @php session()->forget('reg_action'); @endphp

                let down_reg = '{{ session()->get("down_reg", "0") }}';
                if (down_reg != '0') {
                    window.open("{{ route('download.registrationData') }}", "Download");
                }
            }

            $('.modal_register .modal__close').on('click', function (e) {
                $('#register').removeClass('show-modal');
            });
            $('.modal_login .modal__close').on('click', function (e) {
                $('#login').removeClass('show-modal');
            });
            $('.modal_success .modal__close').on('click', function (e) {
                $('#success').removeClass('show-modal');
            });
            $('.modal_roadmap .modal__close').on('click', function (e) {
                $('#roadmap').removeClass('show-modal');
            });



            $('.loginSubmit').on('click', function (e) {
                let error = false;
                $('#login-email-err').addClass('hide');
                $('#login-password-err').addClass('hide');

                if ($('#login-email').val() == '') {
                    $('#login-email-err').removeClass('hide');
                    error = true;
                }
                if ($('#login-password').val() == '') {
                    $('#login-password-err').removeClass('hide');
                    error = true;
                }
                if (error === false) {
                    $('#loginForm').submit();
                }
            });


            $('.registerSubmit').on('click', function (e) {
                let error = false;
                $('.modal__check').addClass('register-ok');
                $('#register-name-err').addClass('hide');
                $('#register-email-err').addClass('hide');
                $('#register-password-err').addClass('hide');
                $('#register-password_confirmation-err').addClass('hide');
                $('#register-ok-err').addClass('hide');

                if ($('#register-name').val() == '') {
                    $('#register-name-err').removeClass('hide');
                    error = true;
                }
                if ($('#register-email').val() == '') {
                    $('#register-email-err').removeClass('hide');
                    error = true;
                }
                if ($('#register-password').val() == '') {
                    $('#register-password-err').removeClass('hide');
                    error = true;
                }
                if ($('#register-password_confirmation').val() == '') {
                    $('#register-password_confirmation-err').removeClass('hide');
                    error = true;
                }
                if(!$("#register-ok").is(':checked')) {
                    $('#register-ok-err').removeClass('hide');
                    $('.modal__check').removeClass('register-ok');
                    error = true;
                }
                if (error === false) {
                    $('#register').removeClass('show-modal');
                    $('#registerForm').submit();
                }
            });
        });
    </script>

    <script>
        $(document).mouseup(function (e) {

            let modal__body = $(".modal__body");
            if (modal__body.has(e.target).length === 0){
                $('#register, #login, #success, #roadmap').removeClass('show-modal');
                body.style.overflow = 'auto';
            }
        });

        $(document).ready(function(){
            $.protip();
        });

    </script>
@endpush
