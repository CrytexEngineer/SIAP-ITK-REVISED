<?php $__env->startSection('title','Modul Program Studi'); ?>
<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Modul Program Studi</div>

                    <div class="card-body">

                        <?php echo $__env->make('alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php echo $__env->make('validation_error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <a href="/program_studi/create" class="btn btn-primary"><i class="fas fa-plus"></i> Input Data Baru</a>

                        <?php echo $__env->make('program_studi.import', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <hr>
                        <table class="table table-bordered" id="users-table">
                            <thead>
                            <tr>
                                <th width="150">Kode Program Studi</th>
                                <th>Nama Program Studi</th>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('change')): ?>
                                <th width="50">Action</th>
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
        $(function() {
            $('#users-table').DataTable({
                dom: 'Blfrtip',
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "scrollX": true,
                processing: true,
                serverSide: true,
                ajax: '/program_studi/json',
                columns: [
                    { data: 'PS_Kode_Prodi', name: 'PS_Kode_Prodi' },
                    { data: 'PS_Nama', name: 'PS_Nama' },
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('change')): ?>
                    { data: 'action', name: 'action' }
                    <?php endif; ?>
                ]
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Arsip Tugas\FINAL ASSIGMENT\SIAP_ITK\resources\views/program_studi/index.blade.php ENDPATH**/ ?>