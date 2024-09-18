

<?php $__env->startSection('title'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-page">

        <div class="content">

            <!-- Start Content-->
            <div class="container-xxl">
                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0"> Tạo mã khuyến mãi </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"></h5>
                            </div><!-- end card header -->

                            <div class="card-body">
                                <form action="<?php echo e(route('khuyenmais.store')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <div class="form-group">
                                        <label for="ten_khuyen_mai">Tên Khuyến Mãi</label>
                                        <input type="text" name="ten_khuyen_mai" class="form-control" required>
                                    </div>
                                
                                    <div class="form-group">
                                        <label for="gia_tri_khuyen_mai">Giá Trị Khuyến Mãi:</label>
                                        <input type="number" name="gia_tri_khuyen_mai" class="form-control" required>
                                    </div>
                                
                                    <div class="form-group">
                                        <label for="so_luong_ma">Số Lần Sử Dụng:</label>
                                        <input type="number" name="so_luong_ma" class="form-control" required>
                                    </div>
                                
                                    <div class="form-group">
                                        <label for="ngay_bat_dau">Ngày Bắt Đầu:</label>
                                        <input type="date" name="ngay_bat_dau" class="form-control" required>
                                    </div>
                                
                                    <div class="form-group">
                                        <label for="ngay_ket_thuc">Ngày Kết Thúc:</label>
                                        <input type="date" name="ngay_ket_thuc" class="form-control" required>
                                    </div>
                                
                                    
                                    <div class="mb-3">
                                        <label for="is_active" class="form-label">Trạng thái</label>
                                        <div class="col-sm-10 mb-3 d-flex gap-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="is_active" id="trang_thai_show" value="0" <?php echo e(old('is_active') == '0' ? 'checked' : ''); ?>>
                                                <label class="form-check-label text-success" for="trang_thai_show">Hiển thị</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="is_active" id="trang_thai_hide" value="1" <?php echo e(old('is_active') == '1' ? 'checked' : ''); ?>>
                                                <label class="form-check-label text-danger" for="trang_thai_hide">Ẩn</label>
                                            </div>
                                            <?php $__errorArgs = ['is_active'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="invalid-feedback">
                                                    <?php echo e($message); ?>

                                                </div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">Tạo Khuyến Mãi</button>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- container-fluid -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
   
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\datn\du_an_tot_nghiep\resources\views/admin/khuyenmai/create.blade.php ENDPATH**/ ?>