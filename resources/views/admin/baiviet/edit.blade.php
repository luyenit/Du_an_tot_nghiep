@extends('admin.layout')

@section('title')
    {{-- {{ $title }} --}}
@endsection

@section('css')
@endsection

@section('content')
    <div class="content-page">

        <div class="content">

            <!-- Start Content-->
            <div class="container-xxl">
                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0"> {{ $title }} </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"></h5>
                            </div><!-- end card header -->

                            <div class="card-body">
                                <form action="{{ route('baiviets.update', $post->id) }}" method="POST"
                                    enctype="multipart/form-data">

                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="anh_bai_viet" class="form-label">Hình ảnh bài viết </label>
                                        <input type="file" id="anh_bai_viet" name="anh_bai_viet" class="form-control">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="tieu_de_bai_viet">Tiêu đề bài viết</label>
                                        <input type="text" name="tieu_de_bai_viet" value="{{ $post->tieu_de_bai_viet }}"
                                            class="form-control">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="noi_dung">Nội dung</label>
                                        <textarea type="text" name="noi_dung" class="form-control">{{ $post->noi_dung }}</textarea>

                                        <div class="mb-3">
                                            <label for="user_id" class="form-label">Tác giả</label>
                                            <select class="form-select" name="user_id" id="user_id">
                                                @foreach ($user as $id => $ho_ten)
                                                    <option value="{{ $id }}"
                                                        {{ $id == $post->user_id ? 'selected' : '' }}>
                                                        {{ $ho_ten }} </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group  mb-3">
                                            <label for="ngay_dang">Ngày Đăng:</label>
                                            <input type="date" name="ngay_dang" value="{{ $post->ngay_dang }}"
                                                class="form-control">
                                        </div>

                                        <div class="mb-3">
                                            <label for="is_active" class="form-label">Trạng thái</label>
                                            <div class="col-sm-10 mb-3 d-flex gap-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="is_active"
                                                        id="trang_thai_show" value="0"
                                                        {{ old('is_active', $post->is_active) == '0' ? 'checked' : ' ?>' }}>
                                                    <label
                                                        class="form-check-label
                                                        text-success"
                                                        for="trang_thai_show">Hiển
                                                        thị</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="is_active"
                                                        id="trang_thai_hide" value="1"
                                                        {{ old('is_active', $post->is_active) == '1' ? 'checked' : '' }}>
                                                    <label class="form-check-label text-danger"
                                                        for="trang_thai_hide">Ẩn</label>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- container-fluid -->
@endsection

@section('js')
@endsection
