<?php $__env->startSection('title','Modul Program Studi'); ?>
<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Modul Program Studi</div>

                    <div class="card-body">

                        <?php echo $__env->make('alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <a href="/program_studi/create" class="btn btn-primary"><i class="fas fa-plus"></i> Input Data Baru</a>
                        <?php echo $__env->make('program_studi.import', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <hr>
                        <table class="table table-bordered" id="users-table">
                            <thead>
                            <tr>
                                <th>Kode Program Studi</th>
                                <th>Nama Program Studi</th>
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
                "scrollX": true,
                processing: true,
                serverSide: true,
                ajax: '/program_studi/json', //DIGANTI SESUAI CONTROLLER
                columns: [
                    { data: 'PS_Kode_Prodi', name: 'PS_Kode_Prodi' }, //SESUAIKAN DB
                    { data: 'PS_Nama', name: 'PS_Nama' }, //SESUAIKAN DB
                    { data: 'action', name: 'action' }
                ]
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Arsip Tugas\FINAL ASSIGMENT\SIAP_ITK\resources\views/program_studi/index.blade.php ENDPATH**/ ?>