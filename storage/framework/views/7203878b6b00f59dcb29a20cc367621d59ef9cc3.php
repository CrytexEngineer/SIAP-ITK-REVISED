<?php $__env->startSection('title','Modul Kelas'); ?>
<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Modul Kelas</div>

                    <div class="card-body">

                        <?php echo $__env->make('alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



                        <a href="/kelas/create" class="btn btn-primary"><i class="fas fa-plus"></i> Input Data Baru</a>

                        <?php echo $__env->make('kelas.import', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <hr>

                        <table class="table table-bordered" id="users-table" style="overflow-x:auto;">
                            <thead>
                            <tr>
                                <th>Matakuliah</th>
                                <th>Kelas</th>
                                <th>Ruangan</th>
                                <th>Program Studi</th>
                                <th>Tahun</th>
                                <th>Semester</th>
                                <th>Daya Tampung</th>
                                <th>Jumlah Kelas Terisi</th>
                                <th>NIP Pengajar</th>
                                <th>Nama Pengajar</th>
                                <th>Hari</th>
                                <th>Jam Mulai</th>
                                <th>Jam Usai</th>
                                <th width="70">Action</th>
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
                serverSide: true,
                ajax: '/kelas/json',
                columns: [
                    {data: 'MK_Mata_Kuliah', name: 'KE_KR_MK_ID'},
                    {data: 'KE_Kelas', name: 'KE_Kelas'},

                    {data: 'KE_Jadwal_Ruangan', name: 'KE_Jadwal_Ruangan'},
                    {data: 'PS_Nama', name: 'KE_KodeJurusan'},

                    {data: 'KE_Tahun', name: 'KE_Tahun'},
                    {data: 'KE_IDSemester', name: 'KE_IDSemester'},
                    {data: 'KE_DayaTampung', name: 'KE_IDSemester'},
                    {data: 'KE_Terisi', name: 'KE_Terisi'},


                    {data: 'KE_PE_NIPPengajar', name: 'KE_PE_NIPPengajar'},
                    {data: 'PE_Nama', name: 'KE_PE_NIPPengajar'},

                    {data: 'KE_Jadwal_IDHari', name: 'KE_Jadwal_IDHari'},
                    {data: 'KE_Jadwal_JamMulai', name: 'KE_Jadwal_JamMulai'},
                    {data: 'KE_Jadwal_JamUsai', name: 'KE_Jadwal_JamUsai'},
                    {data: 'action', name: 'action'}
                ]
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Arsip Tugas\FINAL ASSIGMENT\SIAP_ITK\resources\views/kelas/index.blade.php ENDPATH**/ ?>