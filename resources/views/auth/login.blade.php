<!DOCTYPE html>
<html>

<head>
    <title>Đăng nhập</title>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    @include('main')
</head>

<body style="margin-top: 10%;">
    <div style="display: flex; justify-content: center;">
        <div class="card card-info" style="width: 50%;">
            <div class="card-header">
                <h3 class="card-title">Đăng nhập</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form class="form-horizontal" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" name="email" class="form-control" placeholder="Email" id="email">
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Mật khẩu</label>
                        <div class="col-sm-10">
                            <input type="password" name="password" class="form-control" placeholder="Mật khẩu" id="password">
                        </div>
                    </div>
                    <div id="error"></div>
                    <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="remember" id="remember">
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="button" class="btn btn-info float-right" id="loginBtn">Đăng nhập</button>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>
    </div>
</body>
<script>
    $('#loginBtn').click(function(e) {
        e.preventDefault();
        $('.card-body').find('.text-danger').remove();
        var email = $("#email").val();
        var password = $("#password").val();
        var remember = $("#remember").is(':checked');
        $.ajax({
            url: "{{ route('login_post') }}",
            type: 'POST',
            data: {
                email: email,
                password: password,
                remember: remember
            },
            success: function(response) {
                if (response.loginError) {
                    $('#error').append('<span class="text-danger">' + response.loginError + '</span>');
                }
                else window.location.href = "{{ route('productindex') }}";
            },
            error: function(response) {
                if (response.status == 422) {
                    $.each(response.responseJSON.errors, function(key, value) {
                        $('#' + key).closest('.form-group').append('<span class="text-danger">' + value[0] + '</span>');
                    });
                } 
                notification('error', 'Đăng nhập thất bại.');
            }
        });
    })
</script>

</html>