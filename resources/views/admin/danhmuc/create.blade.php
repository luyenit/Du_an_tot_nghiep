@extends('admin.layout')

@section('css')
@endsection

@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-xxl">
                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">{{ $title }}</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('danhmucs.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="ten_danh_muc" class="form-label">Tên danh mục</label>
                                                <input type="text" id="ten_danh_muc" name="ten_danh_muc"
                                                    class="form-control @error('ten_danh_muc') is-invalid @enderror"
                                                    value="{{ old('ten_danh_muc') }}">
                                                @error('ten_danh_muc')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="anh_danh_muc" class="form-label">Hình ảnh</label>
                                                <input type="file" id="anh_danh_muc" name="anh_danh_muc" value="{{ old('anh_danh_muc') }}"
                                                    class="form-control @error('anh_danh_muc') is-invalid @enderror">
                                                @error('anh_danh_muc')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                                <div class="mt-2">
                                                    <img id="imagePreview" src="#" alt="Hình ảnh preview"
                                                        style="display: none; width:200px;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="trang_thai" class="form-label">Trạng thái</label>
                                            <div class="col-sm-10 mb-3 d-flex gap-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="is_active"
                                                        id="trang_thai_show" value="1"
                                                        {{ old('is_active') == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label text-success" for="trang_thai_show">Hiển
                                                        thị</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="is_active"
                                                        value="0" id="trang_thai_hide"
                                                        {{ old('is_active') == 0 ? 'checked' : '' }}>
                                                    <label class="form-check-label text-danger"
                                                        for="trang_thai_hide">Ẩn</label>
                                                </div>
                                                @error('is_active')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button type="submit" class="btn btn-success">Thêm mới</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('anh_danh_muc');
            const imagePreview = document.getElementById('imagePreview');

            fileInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.style.display = 'block';
                    };

                    reader.readAsDataURL(file);
                } else {
                    imagePreview.src = '#';
                    imagePreview.style.display = 'none';
                }
            });
        });
    </script>
@endsection
