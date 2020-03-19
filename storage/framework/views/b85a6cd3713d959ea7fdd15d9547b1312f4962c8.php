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

                            <table class="table table-bordered" id="users-table">
                                <thead>
                                <tr>
                                    <th>NIM</th>
                                    <th>Nama Lengkap</th>
                                    <th>E-mail</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
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
                    { data: 'MA_NamaLengkap', name: 'MA_NamaLengkap' },
                    { data: 'MA_Email', name: 'MA_Email' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' }
                ]
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Arsip Tugas\FINAL ASSIGMENT\SIAP_ITK\resources\views/manajemen_akun_mahasiswa/index.blade.php ENDPATH**/ ?>