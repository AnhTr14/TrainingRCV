<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sản phẩm</title>
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
                    <a href="{{ route('productindex') }}" class="nav-link" style="color:#007bff;">Sản phẩm</a>
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
                    <div class="col-sm-10">
                        <h1>Chi tiết sản phẩm</h1>
                    </div>
                    <div>
                        <a href="{{ route('productindex') }}">Sản phẩm</a>
                    </div>
                    <div>
                        <p> &nbsp > &nbsp</p>
                    </div>
                    <div>
                        <a href="#">Chi tiết sản phẩm</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card-default">
                    <form id="addForm" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="hidden" id="id" name="id" value="{{ $product->id }}"></input>
                                    <div class="form-group">
                                        <label for="productName">Tên sản phẩm</label>
                                        <input type="text" value="{{ $product->product_name }}" class="form-control" id="productName" placeholder="Nhập tên sản phẩm" name="productName">
                                    </div>
                                    <div class="form-group">
                                        <label for="productPrice">Giá bán</label>
                                        <input type="number" value="{{ $product->product_price }}" class="form-control" id="productPrice" placeholder="Nhập giá bán" min="0" name="productPrice">
                                    </div>
                                    <div class="form-group">
                                        <label for="productDescription">Mô tả</label>
                                        <textarea class="form-control" id="productDescription" rows="3" placeholder="Mô tả sản phẩm" name="productDescription">{{ $product->description }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="productStatus">Trạng thái</label>
                                        <select class="form-control" id="productStatus" name="productStatus">
                                            <option value="2" {{ $product->is_sale == 2 ? 'selected' : '' }}>Đang bán</option>
                                            <option value="1" {{ $product->is_sale == 1 ? 'selected' : '' }}>Hết hàng</option>
                                            <option value="0" {{ $product->is_sale == 0 ? 'selected' : '' }}>Ngừng bán</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="productImage">Hình ảnh</label>
                                        <div class="mt-5 text-center">
                                            @php
                                            $image = "/storage/" . $product->product_image
                                            @endphp
                                            <img id="imagePreview" src="{{ asset($image) }}" alt="Product Image" class="img-fluid">
                                        </div>
                                        <div class="custom-file mb-3" style="margin-top: 20px;">
                                            <label class="custom-file-label" for="productImage" id="productImageLabel">Chọn ảnh</label>
                                            <input type="file" class="custom-file-input" id="productImage" name="productImage">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button type="reset" class="btn btn-secondary mr-2" id="cancelBtn" name="cancelBtn">Hủy</button>
                                <button type="button" class="btn btn-primary" id="saveBtn" name="saveBtn">Lưu</button>
                            </div>
                        </div>
                    </form>
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

        var current_user_id = $('#current-id').data('current-id');

        $("#productImage").on("change", function(e) {
            var fileName = $(this).val().split("\\").pop();
            $("#productImageLabel").html(fileName);

            var file = $("#productImage")[0].files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        });

        $('#saveBtn').click(function(e) {
            e.preventDefault();
            var productName = $("#productName").val().replace(/\s+/g, ' ');
            var formData = new FormData();
            $('.form-group').find('.text-danger').remove();
            formData.append('id', $("#id").val());
            formData.append('productName', productName);
            formData.append('productPrice', $("#productPrice").val());
            formData.append('productDescription', $("#productDescription").val());
            formData.append('productStatus', $("#productStatus").val());
            formData.append('productImage', $("#productImage")[0].files[0]);
            formData.append('currentUserId', current_user_id);
            $.ajax({
                processData: false,
                contentType: false,
                data: formData,
                type: "POST",
                url: "{{ route('updateproduct') }}",
                success: function(response) {
                    notification('success', 'Chỉnh sửa sản phẩm thành công.');
                    setTimeout(function() {
                        window.location.href = "{{ route('productindex') }}";
                    }, 1500);
                },
                error: function(response) {
                    if (response.status === 422) {
                        $.each(response.responseJSON.errors, function(key, value) {
                            $("#" + key).closest('.form-group').append('<span class="text-danger">' + value[0] + '</span>');
                        });
                    }
                    notification('error', 'Chỉnh sửa sản phẩm thất bại.');
                }
            })
        })

        $('#cancelBtn').click(function() {
            window.location.href = "{{ route('productindex') }}";
        })
    </script>


</body>