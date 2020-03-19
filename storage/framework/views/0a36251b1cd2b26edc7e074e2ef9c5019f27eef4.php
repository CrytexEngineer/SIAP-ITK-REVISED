<a href="" class="btn btn-success" data-toggle="modal" data-target="#importExcel"><i class="fas fa-file-upload"></i> Import Excel</a>
<!-- Import Excel -->
<div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" action="<?php echo e(route('import_matakuliah')); ?>" enctype="multipart/form-data"> /* EDIT DISINI */
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
                </div>
                <div class="modal-body">

                    <?php echo e(csrf_field()); ?>


                    <label>Pilih file excel</label>
                    <div class="form-group">
                        <input type="file" name="file" required="required">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php /**PATH D:\Arsip Tugas\FINAL ASSIGMENT\SIAP_ITK\resources\views/matakuliah/import.blade.php ENDPATH**/ ?>