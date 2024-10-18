<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Index</title>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <!-- AdminLTE -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.1/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.1/dist/sweetalert2.min.css">
    <!-- jQuery Modal -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    <!-- Bootstrap JS -->
    
    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Product</a>
                </li>
            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">Đăng xuất</a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->

        <!-- Tìm kiếm -->
        <div class="card-body">
            <form id="filterForm">
                <div class="row">
                    <div class="col-sm-3">
                        <!-- text input -->
                        <div class="form-group">
                            <label for="filterName">Tên</label>
                            <input id="filterName" type="text" class="form-control" placeholder="Nhập họ tên" name="filterName">
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <!-- text input -->
                        <div class="form-group">
                            <label for="filterEmail">Email</label>
                            <input id="filterEmail" type="text" class="form-control" placeholder="Nhập email" name="filterEmail">
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <!-- text input -->
                        <div class="form-group">
                            <label for="filterRole">Nhóm</label>
                            <select id="filterRole" class="form-control select2" style="width: 100%;" name="filterRole">
                                <option value="">--</option>
                                @foreach ($roles as $role)
                                <option> {{ $role }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <!-- text input -->
                        <div class="form-group">

                            <label for="filterStatus">Trạng thái</label>
                            <select id="filterStatus" class="form-control select2" style="width: 100%;" name="filterStatus">
                                <option value="">--</option>
                                <option value="0">Tạm khóa</option>
                                <option value="1">Đang hoạt động</option>
                            </select>

                        </div>
                    </div>
                </div>

                <div class="float-right">
                    <button type="submit" class="btn btn-infor bg-gradient-info btn-sm" id="filterBtn" name="filterBtn">Tìm kiếm</button>
                    <button type="button" class="btn btn-secondary bg-gradient-secondary btn-sm" id="claerBtn" name="claerBtn">Xóa tìm</button>
                </div>

            </form>
        </div>
        <!-- Bảng -->
        <div class="wrapper">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <button type="button" class="btn btn-sm bg-gradient-primary" id="newUser">Thêm</button>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="usersTable" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Họ tên</th>
                                                <th>Email</th>
                                                <th>Nhóm</th>
                                                <th>Trạng thái</th>
                                                <th width="85px"></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->


        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- New User Modal -->
    <div class="modal fade show" id="newModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thêm nhân viên</h4>
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> -->
                </div>
                <div class="modal-body">
                    <div class="card card-primary">
                        <!-- form start -->
                        <form id="newForm">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Họ tên</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Họ tên">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <label for="password">Mật khẩu</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu">
                                </div>
                                <div class="form-group">
                                    <label for="group_role">Nhóm</label>
                                    <select class="form-control select2" id="group_role" name="group_role" style="width: 100%;">
                                        @foreach ($roles as $role)
                                        <option> {{ $role }} </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <!-- /.car-body -->
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" id="newCloseBtn" name="newCloseBtn" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="newSaveBtn" name="newSaveBtn">Lưu</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- Edit User Modal -->
    <div class="modal fade show" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Chỉnh sửa nhân viên</h4>
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> -->
                </div>
                <div class="modal-body">
                    <div class="card card-primary">
                        <!-- form start -->
                        <form id="editForm">
                            <div class="card-body">
                                <input type="hidden" id="edit_id" name="id"></input>
                                <div class="form-group">
                                    <label for="name">Họ tên</label>
                                    <input type="text" class="form-control" id="edit_name" name="name" placeholder="Họ tên">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" id="edit_email" name="email" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <label for="password">Mật khẩu</label>
                                    <input type="password" class="form-control" id="edit_password" name="password" placeholder="Mật khẩu">
                                </div>
                                <div class="form-group">
                                    <label for="group_role">Nhóm</label>
                                    <select class="form-control select2" id="edit_group_role" name="group_role" style="width: 100%;">
                                        @foreach ($roles as $role)
                                        <option>
                                            {{ $role }}
                                        </option>
                                        @endforeach
                                    </select>

                                </div>

                            </div>
                            <!-- /.car-body -->
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" id="editCloseBtn" name="editCloseBtn" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="editSaveBtn" name="editSaveBtn">Lưu</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- jQuery -->

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        //Table
        var table = $('#usersTable').DataTable({
            processing: true,
            searching: false,
            ajax: {
                url: "{{ route('getlistusers') }}",
                type: 'GET',
                dataType: 'json',
                data: function() {
                    return {
                        'filterName': $('#filterName').val(),
                        'filterEmail': $('#filterEmail').val(),
                        'filterRole': $('#filterRole').val(),
                        'filterStatus': $('#filterStatus').val()
                    }
                }

            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'group_role',
                    name: 'group_role'
                },
                {
                    data: 'is_active',
                    name: 'status',
                    render: function(data) {
                        if (data) {
                            return '<span style="color: green;">Đang hoạt động</span>';
                        } else {
                            return '<span style="color: red;">Tạm khóa</span>';
                        }
                    },
                    orderable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false
                },
            ],
            language: {
                emptyTable: 'Không có dữ liệu',
                lengthMenu: "HIển thị _MENU_ đơn vị",
                info: "Hiển thị từ _START_ ~ _END_ trong tổng số _TOTAL_ user",
                infoEmpty: "Hiển thị từ 0 ~ 0 trong tổng số 0 user",
                paginate: {
                    first: '«',
                    last: '»',
                    previous: '‹',
                    next: '›'
                },
            }
        });

        // Tìm kiếm
        $('#filterBtn').click(function(e) {
            e.preventDefault();
            console.log(111);
            table.ajax.reload();

        });
        $('#claerBtn').click(function() {
            $('#filterForm').trigger("reset");
            table.ajax.reload();
        })


        // New User
        $('#newUser').click(function() {
            $('#newForm').trigger("reset");
            $('#newModal').modal('show');
            $('.form-group').find('.text-danger').remove();
        })
        $('#newSaveBtn').click(function(e) {
            e.preventDefault();
            $('.form-group').find('.text-danger').remove();
            $.ajax({
                data: $('#newForm').serialize(),
                url: "{{ route('storeuser') }}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    console.log('Success:', data);
                    $('#newForm').trigger("reset");
                    var Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    Toast.fire({
                        icon: 'success',
                        title: 'Thêm nhân viên mới thành công.'
                    })
                    table.ajax.reload();
                },
                error: function(response) {
                    if (response.status === 422) {
                        $.each(response.responseJSON.errors, function(key, value) {
                            // console.log(key, value[0]);
                            $('#' + key).closest('.form-group').append('<span class="text-danger">' + value[0] + '</span>');
                        });
                    }
                    var Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    Toast.fire({
                        icon: 'error',
                        title: 'Thêm thất bại.'
                    })
                }
            });
        });

        $('#newCloseBtn').click(function(e) {
            e.preventDefault();
            $.modal.close();
        });


        // Edit 
        $('body').on('click', '.edit', function() {
            var edit_id = $(this).data('id');
            $('#editId').val(edit_id);
            $('.form-group').find('.text-danger').remove();
            $.get("{{ url('edit/') }}" + '/' + edit_id, function(data) {
                $('#editModal').modal();
                $('#edit_id').val(data.id);
                $('#edit_name').val(data.name);
                $('#edit_email').val(data.email);
                $('#edit_password').val(data.password);
                $('#edit_group_role').val(data.group_role);
            })
        })
        $('#editSaveBtn').click(function(e) {
            e.preventDefault();
            $.ajax({
                data: $('#editForm').serialize(),
                url: "{{ route('updateuser') }}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    console.log('Success:', data);
                    var Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    Toast.fire({
                        icon: 'success',
                        title: 'Chỉnh sửa thành công.'
                    })
                    table.ajax.reload(null, false);
                },
                error: function(response) {
                    if (response.status === 422) {
                        $.each(response.responseJSON.errors, function(key, value) {
                            $('#edit_' + key).closest('.form-group').append('<span class="text-danger">' + value[0] + '</span>');
                        });
                    }
                    var Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    Toast.fire({
                        icon: 'error',
                        title: 'Chỉnh sửa thất bại.'
                    })
                }
            });
        });
        $('#editCloseBtn').click(function(e) {
            e.preventDefault();
            $.modal.close();
        });

        // Delete
        $('body').on('click', '.delete', function() {
            var user_id = $(this).data('id');
            var user_name = $(this).data('name');
            Swal.fire({
                text: "Bạn có muốn xoá thành viên " + user_name + " không?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6e7881",
                confirmButtonText: "Có",
                cancelButtonText: "Hủy",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{route('deleteuser')}}",
                        method: 'POST',
                        data: {
                            id: user_id
                        },
                        success: function(response) {
                            table.ajax.reload(null, false);
                            var Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                            Toast.fire({
                                icon: 'success',
                                title: 'Xóa thành công.'
                            })
                        },
                        error: function(response) {
                            var Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                            Toast.fire({
                                icon: 'error',
                                title: 'Xóa thất bại.'
                            })
                        }
                    });
                }
            });
        });
        // Lock
        $('body').on('click', '.lock', function() {
            var user_id = $(this).data('id');
            var user_name = $(this).data('name');
            var user_status = $(this).data('status');
            var status = "";
            if (user_status == 1) status = 'khóa';
            else status = 'mở khóa';
            Swal.fire({
                text: "Bạn có muốn " + status + " thành viên " + user_name + " không?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6e7881",
                confirmButtonText: "Có",
                cancelButtonText: "Hủy",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{route('lockuser')}}",
                        method: 'POST',
                        data: {
                            id: user_id
                        },
                        success: function(response) {
                            // table.rows().invalidate().draw();
                            table.ajax.reload(null, false);
                            var Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                            Toast.fire({
                                icon: 'success',
                                title: 'Đã ' + status + ' thành công.'
                            })
                        },
                        error: function(response) {
                            var Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                            Toast.fire({
                                icon: 'error',
                                title: 'Đã ' + status + ' thất bại.'
                            })
                        }
                    });
                }
            });

        });
    </script>
    <script src="../../plugins/jquery/jquery.min.js"></script>

<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="../../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

<script src="../../dist/js/adminlte.min.js?v=3.2.0"></script>

<script src="../../dist/js/demo.js"></script>
</body>

</html>