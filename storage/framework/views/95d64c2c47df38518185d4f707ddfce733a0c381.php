<?php $__env->startSection('title', 'Edit Data Pegawai'); ?>
<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><?php echo $__env->yieldContent('title'); ?></div>

                    <div class="card-body">
                        <?php echo e(Form::model($users, ['url'=>'manajemen_akun/pegawai/'.$users->email, 'method'=>'PUT'])); ?>

                        <?php echo csrf_field(); ?>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label text-md-right">E-mail</label>
                            <div class="col-md-4">
                                <?php echo e(Form::text('PE_Nip', null, ['class'=>'form-control', 'placeholder'=> 'NIP Pegawai'])); ?>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label text-md-right">Nama Lengkap</label>
                            <div class="col-md-6">
                                <?php echo e(Form::text('name', null, ['class'=>'form-control', 'placeholder'=> 'Nama Pegawai'])); ?>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label text-md-right">E-mail</label>
                            <div class="col-md-4">
                                <?php echo e(Form::text('email', null, ['class'=>'form-control', 'placeholder'=> 'E-Mail Pegawai'])); ?>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label text-md-right">Role</label>
                            <div class="col-md-4">
                                <?php echo e(Form::select('role', ['1' => 'SuperAdmin', '2' => 'Admin', '3' =>'Observer', '4'=>'Wakil Rektor',
                                  '5'=>'Tendik Jurusan', '6'=>'Tendik Pusat', '7'=>'Ketua Prodi','8'=>'Kepala Jurusan','9'=>'Dosen Pengampu'])); ?>


                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-2">
                                <?php echo e(Form::submit('Simpan Data', ['class'=>'btn btn-primary'])); ?>

                                <a href="/akunpegawai" class="btn btn-primary">Kembali</a>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Arsip Tugas\FINAL ASSIGMENT\SIAP_ITK\resources\views/manajemen_akun/edit_pegawai.blade.php ENDPATH**/ ?>