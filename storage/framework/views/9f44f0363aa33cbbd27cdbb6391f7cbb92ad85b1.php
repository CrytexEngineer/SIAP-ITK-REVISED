<?php $__env->startSection('title', 'Manajemen Akun Mahasiswa'); ?>
<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><?php echo $__env->yieldContent('title'); ?></div>

                    <div class="card-body">
                        <?php if(session('status')): ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo e(session('status')); ?>

                            </div>
                        <?php endif; ?>

                        <?php if(session('status_failed')): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo e(session('status_failed')); ?>

                            </div>
                        <?php endif; ?>

                        <a href="/akunmahasiswa/create" class="btn btn-primary"><i class="fas fa-plus"></i> Input Data Baru</a>
                            <?php echo $__env->make('matakuliah.import', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <hr>

                        <table class="table table-bordered" id="users-table">
                            <thead>
                            <tr>
                                <th>NIM</th>
                                <th>Nama Lengkap</th>
                                <th>E-mail</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th width="85">Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        $(function() {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/akunmahasiswa/json',
                columns: [
                    { data: 'MA_Nrp', name: 'MA_Nrp' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'action', name: 'action' }
                ]
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Arsip Tugas\FINAL ASSIGMENT\SIAP_ITK\resources\views/mahasiswa/mahasiswa.blade.php ENDPATH**/ ?>
