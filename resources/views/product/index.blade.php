<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sản phẩm</title>
    @include('main')
    <style>
        .popover img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="navbar navbar-expand navbar-white navbar-light">

            <ul class="navbar-nav">
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('userindex') }}" class="nav-link">Thành viên</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link" style="color:#007bff;">Sản phẩm</a>
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
                    <div class="col-sm-11">
                        <h1>Danh sách sản phẩm</h1>
                    </div>
                    <div>
                        <h2></h2>
                        <a href="#">Sản phẩm</a>
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
                                <input id="filterName" type="text" class="form-control" placeholder="Nhập tên sản phẩm" name="filterName">
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="filterStatus">Trạng thái</label>
                                <select id="filterStatus" class="form-control select2" style="width: 100%;" name="filterStatus">
                                    <option value="">--</option>
                                    <option value="2">Đang bán</option>
                                    <option value="1">Hết hàng</option>
                                    <option value="0">Ngừng bán</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="filterFrom">Giá bán từ</label>
                                <input id="filterFrom" type="number" class="form-control" placeholder="Nhập giá tối thiểu" name="filterFrom" onkeydown="return event.key !== 'e'">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="filterTo">Giá bán đến</label>
                                <input id="filterTo" type="number" class="form-control" placeholder="Nhập giá tối đa" name="filterTo" onkeydown="return event.key !== 'e'">
                            </div>
                        </div>
                    </div>

                    <div class="float-right">
                        <button type="submit" class="btn btn-primary bg-gradient-primary btn-sm" id="filterBtn" name="filterBtn"><i class="fas fa-search"></i> Tìm kiếm</button>
                        <button type="button" class="btn btn-secondary bg-gradient-secondary btn-sm" id="clearBtn" name="clearBtn"><i class="fas fa-x"></i>Xóa tìm</button>
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
                            @can('Create Product')
                            <div class="card-header">
                                <button type="button" class="btn btn-primary" id="newBtn">
                                    <i class="fas fa-plus"></i>&nbsp Thêm
                                </button>
                            </div>
                            @endcan
                            <div class="card-body">
                                <table id="productsTable" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Mô tả</th>
                                            <th>Giá</th>
                                            <th>Tình trạng</th>
                                            <th style="width: 65px;"></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        //Table
        var table = $('#productsTable').DataTable({
            processing: true,
            searching: false,
            responsive: true,
            ajax: {
                url: "{{ route('getlistproducts') }}",
                type: 'GET',
                dataType: 'json',
                data: function() {
                    return {
                        'filterName': $('#filterName').val(),
                        'filterStatus': $('#filterStatus').val(),
                        'filterFrom': $('#filterFrom').val(),
                        'filterTo': $('#filterTo').val()
                    }
                }
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'product_name',
                    name: 'product_name'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'product_price',
                    name: 'product_price'
                },
                {
                    data: 'is_sales',
                    name: 'status',
                    render: function(data) {
                        if (data == 2) {
                            return '<span style="color: green;">Đang bán</span>';
                        }
                        if (data == 1) {
                            return '<span style="color: green;">Hết hàng</span>';
                        } else {
                            return '<span style="color: red;">Ngừng bán</span>';
                        }
                    },
                    orderable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false
                },
                {
                    data: 'product_image',
                    name: 'product_image'
                },
            ],
            language: {
                emptyTable: 'Không có dữ liệu',
                lengthMenu: "HIển thị _MENU_ đơn vị",
                info: "Hiển thị từ _START_ ~ _END_ trong tổng số _TOTAL_ sản phẩm",
                infoEmpty: "Hiển thị từ 0 ~ 0 trong tổng số 0 sản phẩm",
                paginate: {
                    first: '«',
                    last: '»',
                    previous: '‹',
                    next: '›'
                },
            },
            //Over mouse
            drawCallback: function() {
                $('[data-toggle="popover"]').popover({
                    html: true,
                    trigger: 'hover',
                    placement: 'right',
                    content: function() {
                        return '<img src="' + $(this).data('img') + '" />';
                    }

                });
            },
        });
        table.column(6).visible(false);

        // Tìm kiếm
        $('#filterBtn').click(function(e) {
            e.preventDefault();
            table.ajax.reload();
        });
        $('#clearBtn').click(function() {
            $('#filterForm').trigger("reset");
            table.ajax.reload();
        })

        // Thêm
        $('#newBtn').click(function() {
            window.location.href = "{{ route('addproduct') }}";
        })

        // Xóa
        $('body').on('click', '.delete', function() {
            var product_id = $(this).data('id');
            var product_name = $(this).data('name');
            Swal.fire({
                text: "Bạn có muốn xoá sản phẩm " + product_name + " không?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6e7881",
                confirmButtonText: "Có",
                cancelButtonText: "Hủy",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{route('deleteproduct')}}",
                        method: 'POST',
                        data: {
                            id: product_id
                        },
                        success: function(response) {
                            table.ajax.reload(null, false);
                            notification('success', 'Xóa sản phẩm thành công.');
                        },
                        error: function(response) {
                            notification('error', 'Xóa sản phẩm thất bại');
                        }
                    });
                }
            });
        });

        //Sửa
        $('body').on('click', '.edit', function() {
            var id = $(this).data('id');
            var url = "{{ route('detailproduct', 'id') }}";
            url = url.replace('id', id);
            window.location.href = url;
        });
    </script>


</body>

</html>