<!DOCTYPE html>
<html lang="en">

<head>
    <title>Vai trò</title>
    @include('main')
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper" data-current-id="{{ auth()->user()->id }}" id="current-id">

        <!-- Navbar -->
        <nav class="navbar navbar-expand navbar-white navbar-light">

            <ul class="navbar-nav">
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('userindex') }}" class="nav-link">Thành viên</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('productindex') }}" class="nav-link">Sản phẩm</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link" style="color:#007bff;">Vai trò</a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">

                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <p>{{ auth()->user()->name }}</p>
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
                        <h1>Vai trò</h1>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <!-- Bảng -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                @can('Create Role')
                                <div class="card-header">
                                    <button type="button" class="btn btn-primary" id="newBtn" data-toggle="modal">
                                        <i class="fas fa-plus"></i>&nbsp Thêm
                                    </button>
                                </div>
                                @endcan
                                <div class="card-body">
                                    <table id="rolesTable" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Tên</th>
                                                <th>Guard name</th>
                                                <th style="width: 30px"></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Detail Modal -->
            <div class="modal fade" id="detailModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Các quyền</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card-primary">
                                <form id="editForm">
                                    <div class="form-group">
                                        <label for="edit_roleName">Vai trò</label>
                                        <input type="text" class="form-control" id="role_name" name="role_name" placeholder="Tên">
                                    </div>
                                </form>
                                <div id="selected-count" class="mb-3"></div>
                                <table id="permissionsTable" class="table table-bordered table-hover" style="width: 100%;">
                                    <input type="hidden" id="role_id" name="role_id"></input>
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" id="closeBtn" name="closeBtn" data-dismiss="modal">Đóng</button>
                            @can('Edit Role')
                            <button type="button" class="btn btn-primary" id="saveBtn" name="saveBtn">Lưu</button>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>

            <!-- New role Modal -->
            <div class="modal fade" id="newModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Thêm vai trò</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card card-primary">
                                <!-- form start -->
                                <form id="newForm">
                                    <div class="card-body">
                                        <input type="hidden" id="new_id" name="new_id"></input>
                                        <div class="form-group">
                                            <label for="new_name">Tên</label>
                                            <input type="text" class="form-control" id="new_name" name="new_name" placeholder="Tên">
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
            <!-- New role Modal end-->

    </div>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        //Role Table
        var roleTable = $('#rolesTable').DataTable({
            processing: true,
            searching: false,
            responsive: true,
            ajax: {
                url: "{{ route('getlistroles') }}",
                type: 'GET',
                dataType: 'json',

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
                    data: 'guard_name',
                    name: 'guard_name'
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
                info: "Hiển thị từ _START_ ~ _END_ trong tổng số _TOTAL_ vai trò",
                infoEmpty: "Hiển thị từ 0 ~ 0 trong tổng số 0 vai trò",
                paginate: {
                    first: '«',
                    last: '»',
                    previous: '‹',
                    next: '›'
                },
            }
        });

        //Permission Table
        var permissionTable = $('#permissionsTable').DataTable({
            processing: true,
            searching: false,
            responsive: true,
            paginate: false,
            ajax: {
                url: "{{ route('getlistpermissions') }}",
                type: 'GET',
                dataType: 'json',
                data: function() {
                    return {
                        'roleId': $('#role_id').val()
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
                    data: 'checked',
                    name: 'checked',
                    orderable: false
                },
            ],
            language: {
                emptyTable: 'Không có dữ liệu',
                lengthMenu: "HIển thị _MENU_ đơn vị",
                info: "Tổng: _TOTAL_ quyền",
                infoEmpty: "Hiển thị từ 0 ~ 0 trong tổng số 0 quyền",
                paginate: {
                    first: '«',
                    last: '»',
                    previous: '‹',
                    next: '›'
                },
            },
            drawCallback: function() {
            updateSelectedCount();
        }
        });

        function updateSelectedCount() {
            var count = $("input:checkbox:checked").length;
            $('#selected-count').text('Quyền đã chọn: ' + count);
        }

        // Listen for changes in the checkboxes
        $('#permissionsTable tbody').on('change', 'input[type="checkbox"]', function() {
            updateSelectedCount();
        });

        // New
        $('#newBtn').click(function() {
            $('#newForm').trigger("reset");
            $('#newModal').modal('show');
            $('.form-group').find('.text-danger').remove();
        })
        $('#newSaveBtn').click(function() {
            $('.form-group').find('.text-danger').remove();
            var name = $('#new_name').val().replace(/\s+/g, ' ');
            $.ajax({
                data: {
                    name
                },
                url: "{{ route('storerole') }}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    notification('success', 'Thêm vai trò mới thành công.');
                    roleTable.ajax.reload(null, false);
                    $('#newModal').modal('hide');
                },
                error: function(response) {
                    if (response.status === 422) {
                        $.each(response.responseJSON.errors, function(key, value) {
                            $('#new_' + key).closest('.form-group').append('<span class="text-danger">' + value[0] + '</span>');
                        });
                    }
                    notification('error', 'Thêm vai trò mới thất bại.');
                }
            });
        });

        // Detail
        $('body').on('click', '.info', function() {
            var roleId = $(this).data('id');
            var roleName = $(this).data('name');
            $('#role_name').val(roleName);
            $('#role_id').val(roleId);
            permissionTable.ajax.reload();
            $('#detailModal').modal();
        });
        // Change Permission
        $('#saveBtn').click(function() {
            var checked = Array();
            var roleId = $('#role_id').val();
            var roleName = $('#role_name').val().replace(/\s+/g, ' ');
            $("input:checkbox:checked").each(function() {
                checked.push($(this).data('name'));
            });
            $.ajax({
                data: {
                    roleId,
                    roleName,
                    checked
                },
                url: "{{ route('changepermission') }}",
                type: "post",
                success: function(response) {
                    $('#detailModal').modal('hide');
                    notification('success', 'Chỉnh sửa vai trò thành công.');
                    roleTable.ajax.reload(null, false);
                },
                error: function(response) {
                    if (response.status === 422) {
                        $.each(response.responseJSON.errors, function(key, value) {
                            $('#role_name').closest('.form-group').append('<span class="text-danger">' + value[0] + '</span>');
                        });
                    }
                    notification('error', 'Chỉnh sửa vai trò thất bại.');
                }
            })

        });

        // // Delete
        // $('body').on('click', '.delete', function() {
        //     var id = $(this).data('id');
        //     var name = $(this).data('name');
        //     Swal.fire({
        //         text: "Bạn có muốn xoá role " + name + " không?",
        //         icon: "warning",
        //         showCancelButton: true,
        //         confirmButtonColor: "#d33",
        //         cancelButtonColor: "#6e7881",
        //         confirmButtonText: "Có",
        //         cancelButtonText: "Hủy",
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             $.ajax({
        //                 url: "{{route('deleterole')}}",
        //                 method: 'POST',
        //                 data: {
        //                     id: id
        //                 },
        //                 success: function(response) {
        //                     notification('success', 'Xóa thành công.');
        //                 },
        //                 error: function(response) {
        //                     notification('success', 'Xóa thất bại.');
        //                 }
        //             });
        //         }
        //     });
        // });
    </script>

</body>

</html>