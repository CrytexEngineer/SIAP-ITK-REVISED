<?php $__env->startSection('title','Input Data program_studi'); ?>
<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Input Data Program Studi</div>

                    <div class="card-body">

                        <?php echo $__env->make('validation_error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <?php echo e(Form::open(['url'=>'program_studi'])); ?>


                        <?php echo csrf_field(); ?>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">Kode Program Studi</label>
                            <div class="col-md-3">
                                <?php echo e(Form::text('PS_Kode_Prodi',null,['class'=>'form-control','placeholder'=>'Kode Program Studi'])); ?>

                            </div>
                        </div>

                        <?php echo $__env->make('program_studi.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-3">

                                <?php echo e(Form::submit('Simpan Data',['class'=>'btn btn-primary'])); ?>

                                <a href="/Program Studi" class="btn btn-primary">Kembali</a>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Arsip Tugas\FINAL ASSIGMENT\SIAP_ITK\resources\views/program_studi/create.blade.php ENDPATH**/ ?>