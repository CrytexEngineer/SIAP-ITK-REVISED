<?php $__env->startSection('title','Input Data Kelas'); ?>
<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Input Data Kelas</div>

                    <div class="card-body">
                        <?php echo $__env->make('validation_error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <?php echo e(Form::open(['url'=>'kelas'])); ?>


                        <?php echo $__env->make('kelas.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <?php echo csrf_field(); ?>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-3">
                                <?php echo e(Form::submit('Simpan Data',['class'=>'btn btn-primary'])); ?>

                                <a href="/kelas" class="btn btn-primary">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Arsip Tugas\FINAL ASSIGMENT\SIAP_ITK\resources\views/kelas/create.blade.php ENDPATH**/ ?>