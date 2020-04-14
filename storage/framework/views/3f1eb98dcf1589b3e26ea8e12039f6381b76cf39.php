<?php $__env->startSection('title','Edit Data matakuliah'); ?>
<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Edit Data matakuliah</div>

                    <div class="card-body">


                        <?php echo e(Form::model($subject,['url'=>'matakuliah/'.$subject->MK_ID,'method'=>'PUT'])); ?>


                        <?php echo csrf_field(); ?>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label text-md-right">Kode matakuliah</label>
                            <div class="col-md-6">
                                <?php echo e(Form::text('MK_ID',null,['class'=>'form-control','placeholder'=>'Kode matakuliah','readonly'=>''])); ?>

                            </div>
                        </div>

                        <?php echo $__env->make('matakuliah.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-2">

                                <?php echo e(Form::submit('Simpan Data',['class'=>'btn btn-primary'])); ?>

                                <a href="/matakuliah" class="btn btn-primary">Kembali</a>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Arsip Tugas\FINAL ASSIGMENT\SIAP_ITK\resources\views/matakuliah/edit.blade.php ENDPATH**/ ?>