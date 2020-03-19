<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><?php echo e(__('Register')); ?></div>

                    <div class="card-body">
                        <?php echo e(Form::open(['url'=>'manajemen_akun/pegawai'])); ?>

                         <?php echo csrf_field(); ?>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">NIP</label>

                                <div class="col-md-6">
                                    <?php echo e(Form::text('PE_Nip', null, ['class'=>'form-control', 'placeholder'=> 'NIP Pegawai'])); ?>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Alamat Email')); ?></label>

                                <div class="col-md-6">
                                    <?php echo e(Form::text('email', null, ['class'=>'form-control', 'placeholder'=> 'Alamat Email Pegawai'])); ?>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Nama Lengkap</label>

                                <div class="col-md-6">
                                    <?php echo e(Form::text('name', null, ['class'=>'form-control', 'placeholder'=> 'Nama Pegawai'])); ?>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Tipe Pegawai</label>

                                <div class="col-md-6">
                                    <select id="role" name="role" class="form-control">
                                        <option value="1">Super Admin</option>
                                        <option value="2">Admin</option>
                                        <option value="3">Observer</option>
                                        <option value="4">Wakil Rektor</option>
                                        <option value="5">Ketua Prodin</option>
                                        <option value="6">Kepala Jurusan</option>
                                        <option value="7">Tendik Jurusan</option>
                                        <option value="8">Tendik Pusat</option>
                                        <option value="9">Dosen Pengampu</option>
                                    </select>
                                    

                                    
                                    
                                    
                                    
                                    
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Password')); ?></label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> " name="password" required autocomplete="new-password">

                                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Confirm Password')); ?></label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <?php echo e(Form::submit('Simpan Data',['class'=>'btn btn-primary'])); ?>

                                    <a href="/manajemen_akun/pegawai" class="btn btn-primary">Kembali</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Arsip Tugas\FINAL ASSIGMENT\SIAP_ITK\resources\views/manajemen_akun/create_pegawai.blade.php ENDPATH**/ ?>