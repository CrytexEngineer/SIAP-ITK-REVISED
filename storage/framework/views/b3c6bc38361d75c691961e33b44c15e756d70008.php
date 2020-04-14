<?php $__env->startSection('title','Modul Matakuliah'); ?>
<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Modul Matakuliah</div>

                    <div class="card-body">

                        <?php echo $__env->make('alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <a href="/matakuliah/create" class="btn btn-primary"><i class="fas fa-plus"></i> Input Data Baru</a>
                        <?php echo $__env->make('matakuliah.import', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <hr>

                        <table class="table table-bordered" id="users-table">
                            <thead>
                            <tr>
                                <th>Kode Matakuliah</th>
                                <th>Nama Matakuliah</th>
                                <th>Tahun Kurikulum</th>
                                <th>Kredit Kuliah</th>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-users')): ?>
                                <th width="85">Action</th>
                                    <?php endif; ?>
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
        $(function () {
            $('#users-table').DataTable({
                "scrollX": true,
                processing: true,
                ajax: '/matakuliah/json',
                columns: [
                    {data: 'MK_ID', name: 'MK_ID'},
                    {data: 'MK_Mata_Kuliah', name: 'MK_Mata_Kuliah'},
                    {data: 'MK_ThnKurikulum', name: 'MK_ThnKurikulum'},
                    {data: 'MK_KreditKuliah', name: 'MK_KreditKuliah'},
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-users')): ?>
                    {data: 'action', name: 'action'}],
                <?php endif; ?>
            })
        });


    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Kuli (ah)\Prodi\TA\PROJECT WEB SIAP\SIAP-ITK-REVISED\resources\views/matakuliah/index.blade.php ENDPATH**/ ?>