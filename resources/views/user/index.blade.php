<!DOCTYPE html>
<html lang="en">

<head>
    <title>Thành viên</title>
    @include('main')
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper" data-current-id="{{ auth()->user()->id }}" id="current-id">

        <!-- Navbar -->
        <nav class="navbar navbar-expand navbar-white navbar-light">

            <ul class="navbar-nav">
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link" style="color:#007bff;">Thành viên</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('productindex') }}" class="nav-link">Sản phẩm</a>
                </li>
                @can('View Role')
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('roleindex') }}" class="nav-link">Vai trò</a>
                </li>
                @endcan
            </ul>

            <ul class="navbar-nav ml-auto">

                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <p id="currentName">{{ auth()->user()->name }}</p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                        <a href="{{ route('logout') }}" class="dropdown-item">
                            Đăng xuất
                        </a>
                    </div>
                </li>

            </ul>
        </nav>

        <!-- Content header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Danh sách thành viên</h1>
                    </div>
                </div>

            </div>
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
                                    <option value="{{ $role->id }}"> {{ $role->name }} </option>
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
                        <button type="submit" class="btn btn-primary bg-gradient-primary btn-sm" id="filterBtn" name="filterBtn"><i class="fas fa-search"></i> Tìm kiếm</button>
                        <button type="button" class="btn btn-secondary bg-gradient-secondary btn-sm" id="clearBtn" name="clearBtn">Xóa tìm</button>
                    </div>

                </form>
            </div>
        </section>

        <!-- Content -->
        <!-- Bảng -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            @can('Create User')
                            <div class="card-header">
                                <button type="button" class="btn btn-primary" id="newBtn" data-toggle="modal">
                                    <i class="fas fa-plus"></i>&nbsp Thêm
                                </button>
                                <a class="button btn btn-info float-right" href="{{ route('exportuser') }}"><i class="fas fa-file-export"></i>&nbsp Export</a>
                                <form action="{{ route('importuser') }}" method="POST" enctype="multipart/form-data" id="fileForm">
                                    @csrf
                                    <input type="file" name="file" id="file" required>
                                    <button class="button btn btn-info" type="button" id="importFile">Upload</button>
                                </form>
                                
                                
                            </div>
                            @endcan
                            <div class="card-body">
                                <table id="usersTable" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Họ tên</th>
                                            <th>Email</th>
                                            <th>Nhóm</th>
                                            <th>Trạng thái</th>
                                            <th width="100px"></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </section>


        <!-- Modal -->
        <!-- New user Modal -->
        <div class="modal fade" id="newModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Thêm thành viên</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
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
                                        <label for="role">Nhóm</label>
                                        <select class="form-control select2" id="role" name="role" style="width: 100%;">
                                            <option value="">--</option>
                                            @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"> {{ $role->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </form>
                            <!-- form end -->
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" id="newCloseBtn" name="newCloseBtn" data-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-primary" id="newSaveBtn" name="newSaveBtn">Lưu</button>
                    </div>
                </div>

            </div>

        </div>
        <!-- New user Modal end-->

        <!-- Edit user Modal -->
        <div class="modal fade" id="editModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Chỉnh sửa thành viên</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card card-primary">
                            <!-- form start -->
                            <form id="editForm">
                                <div class="card-body">
                                    <input type="hidden" id="current_id_edit" name="current_id_edit"></input>
                                    <input type="hidden" id="edit_id" name="id"></input>
                                    <div class="form-group">
                                        <label for="name">Họ tên</label>
                                        <input type="text" class="form-control" id="edit_name" name="name" placeholder="Họ tên">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" class="form-control" id="edit_email" name="email" placeholder="Email">
                                    </div>
                                    <div class="form-group" id="passworDiv">
                                        <label for="password">Mật khẩu</label>
                                        <input type="password" class="form-control" id="edit_password" name="password" placeholder="Mật khẩu">
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_role">Nhóm</label>
                                        <select class="form-control select2" id="edit_role" name="role" style="width: 100%;">
                                            @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" id="{{ $role->id }}" class="edit_role"> {{ $role->name }} </option>
                                            @endforeach
                                        </select>

                                    </div>

                                </div>
                                <!-- /.car-body -->
                            </form>
                            <!-- form end -->
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" id="editCloseBtn" name="editCloseBtn" data-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-primary" id="editSaveBtn" name="editSaveBtn">Lưu</button>
                    </div>
                </div>

            </div>

        </div>
        <!-- Edit user Modal end-->

    </div>

    <script>
        var current_user_id = $('#current-id').data('current-id');

        //Table
        var table = $('#usersTable').DataTable({
            processing: true,
            searching: false,
            responsive: true,
            rowReorder: true,
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
                    data: 'role_name',
                    name: 'role_name'
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
                info: "Hiển thị từ _START_ ~ _END_ trong tổng số _TOTAL_ thành viên",
                infoEmpty: "Hiển thị từ 0 ~ 0 trong tổng số 0 thành viên",
                paginate: {
                    first: '«',
                    last: '»',
                    previous: '‹',
                    next: '›'
                },
            }
        });

        // Import File
        $('#importFile').click(function(e) {
            e.preventDefault();
            $("#fileForm").find('.text-danger').remove();
            var formData = new FormData();
            var file = $("#file")[0].files[0];
            formData.append('file', file);
            $.ajax({
                processData: false,
                contentType: false,
                data: formData,
                type: "POST",
                url: "{{ route('importuser') }}",
                success: function(response) {
                    notification('success', 'Import file thành công');
                    window.location.href = "{{ route('download') }}";
                    table.ajax.reload();
                },
                error: function(response) {
                    
                    if (response.status === 422) {
                        $.each(response.responseJSON.errors, function(key, value) {
                            console.log(key);
                            $("#" + key+ "Form").append('<span class="text-danger"><br>' + value[0] + '</span>');
                        });
                    }
                    notification('error', 'Thêm sản phẩm mới thất bại.');
                }
            })

        })

        // Tìm kiếm
        $('#filterBtn').click(function(e) {
            e.preventDefault();
            table.ajax.reload();

        });
        $('#clearBtn').click(function(e) {
            e.preventDefault();
            $('#filterForm').trigger("reset");
            table.ajax.reload();
        })

        // New User
        $('#newBtn').click(function() {
            $('#newForm').trigger("reset");
            $('#newModal').modal('show');
            $('.form-group').find('.text-danger').remove();
        })
        $('#newSaveBtn').click(function(e) {
            $('.form-group').find('.text-danger').remove();
            $.ajax({
                data: $('#newForm').serialize(),
                url: "{{ route('storeuser') }}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    $('#newForm').trigger("reset");
                    notification('success', 'Thêm thành viên mới thành công.');
                    table.ajax.reload(function(json) {
                        table.rows().order([0, 'desc']).draw(false);
                    });
                    $('#newModal').modal('hide');
                },
                error: function(response) {
                    if (response.status === 422) {
                        $.each(response.responseJSON.errors, function(key, value) {
                            $('#' + key).closest('.form-group').append('<span class="text-danger">' + value[0] + '</span>');
                        });
                    }
                    notification('error', 'Thêm thành viên mới thất bại.');
                }
            });
        });

        $('#exportBtn').click(function() {
            $.get("{{ route('exportuser') }}")
        });

        // Edit 
        $('body').on('click', '.edit', function() {
            $('#editForm').trigger("reset");
            $('#edit_role').prop('disabled', '');
            $('#edit_name').prop('disabled', '');
            $('#passworDiv').prop('hidden', '');
            $('#edit_role').prop('disabled', false);
            $('#editSaveBtn').prop('hidden', '');
            var edit_id = $(this).data('id');
            $('#editId').val(edit_id);
            $('#current_id_edit').val(current_user_id)
            $('.form-group').find('.text-danger').remove();

            $.get("{{ url('user/edit/') }}" + '/' + edit_id, function(data) {
                $('#editModal').modal();
                $('#edit_id').val(data.id);
                $('#edit_name').val(data.name);
                $('#edit_email').val(data.email);
                $('#edit_email').prop('disabled', 'disabled');
                if ((data.roles[0])) {
                    $('#' + data.roles[0].id).prop("selected", true);
                    var role_name = data.roles[0].name;
                    if (current_user_id == edit_id) {
                        $('#edit_role').prop('disabled', 'disabled');
                    } else {
                        if (data.roles[0].id == 1) {
                            $('#edit_role').prop('disabled', 'disabled');
                            $('#edit_name').prop('disabled', 'disabled');
                            $('#passworDiv').prop('hidden', 'true');
                            $('#editSaveBtn').prop('hidden', 'true');
                        }
                    }
                }
            })
        })
        $('#editSaveBtn').click(function(e) {
            $('.form-group').find('.text-danger').remove();
            $.ajax({
                data: $('#editForm').serialize(),
                url: "{{ route('updateuser') }}",
                type: "POST",
                dataType: 'json',
                success: function(response) {
                    notification('success', 'Chỉnh sửa thành viên thành công.');
                    if (response.id == current_user_id) {
                        window.location.href = "{{ route('logout') }}";
                    } else {
                        table.ajax.reload(null, false);
                        $('#editModal').modal('hide');
                    };
                },
                error: function(response) {
                    if (response.status == 422) {
                        $.each(response.responseJSON.errors, function(key, value) {
                            $('#edit_' + key).closest('.form-group').append('<span class="text-danger">' + value[0] + '</span>');
                        });
                    }
                    notification('error', 'Chỉnh sửa thành viên thất bại.');
                }
            });
        });

        // Delete
        $('body').on('click', '.delete', function() {
            var user_id = $(this).data('id');
            var user_name = $(this).data('name');
            if (user_id != current_user_id) {
                Swal.fire({
                    text: "Bạn có muốn xoá " + user_name + " không?",
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
                                notification('success', 'Xóa thành viên thành công.');
                            },
                            error: function(response) {
                                title = "Xóa thành viên thất bại.";
                                if (response.status === 400) {
                                    title = "Không thể xóa người có quyền Admin."
                                }
                                notification('error', title);
                            }
                        });
                    }
                });
            } else {
                notification('error', "Không thể xóa chính mình");
            }
        });
        // Lock
        $('body').on('click', '.lock', function() {
            console.log(current_user_id);
            var user_id = $(this).data('id');
            var user_name = $(this).data('name');
            var user_status = $(this).data('status');
            var status = "";
            if (user_status == 1) status = 'khóa';
            else status = 'mở khóa';
            if (user_id != current_user_id) {
                Swal.fire({
                    text: "Bạn có muốn " + status + " " + user_name + " không?",
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
                                table.ajax.reload(null, false);
                                title = 'Đã ' + status + ' thành công.'
                                notification('success', title);
                            },
                            error: function(response) {
                                title = 'Đã ' + status + ' thất bại.';
                                if (response.status === 400) {
                                    title = "Không thể " + status + " người có quyền Admin."
                                }
                                notification('error', title);
                            }
                        });
                    }
                });
            } else {
                notification('error', "Không thể khóa chính mình");
            }
        });
        
        $('#usersTable').on('click', '.edit-link', function(e) {
            e.preventDefault();
            $('#editForm').trigger("reset");
            $('#edit_role').prop('disabled', '');
            $('#edit_name').prop('disabled', '');
            $('#passworDiv').prop('hidden', '');
            $('#edit_role').prop('disabled', false);
            $('#editSaveBtn').prop('hidden', '');
            var edit_id = $(this).data('id');
            $('#editId').val(edit_id);
            $('#current_id_edit').val(current_user_id)
            $('.form-group').find('.text-danger').remove();

            $.get("{{ url('user/edit/') }}" + '/' + edit_id, function(data) {
                $('#editModal').modal();
                $('#edit_id').val(data.id);
                $('#edit_name').val(data.name);
                $('#edit_email').val(data.email);
                $('#edit_email').prop('disabled', 'disabled');
                if ((data.roles[0])) {
                    $('#' + data.roles[0].id).prop("selected", true);
                    var role_name = data.roles[0].name;
                    if (current_user_id == edit_id) {
                        $('#edit_role').prop('disabled', 'disabled');
                    } else {
                        if (data.roles[0].id == 1) {
                            $('#edit_role').prop('disabled', 'disabled');
                            $('#edit_name').prop('disabled', 'disabled');
                            $('#passworDiv').prop('hidden', 'true');
                            $('#editSaveBtn').prop('hidden', 'true');
                        }
                    }
                }
            })
        })
    </script>

</body>

</html>