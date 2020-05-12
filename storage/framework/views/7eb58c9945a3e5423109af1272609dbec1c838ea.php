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

<?php if(session('status_notification')): ?>
    <div class="alert alert-info" role="alert">
        <?php echo e(session('status_notification')); ?>

    </div>
<?php endif; ?>
<?php /**PATH D:\Arsip Tugas\FINAL ASSIGMENT\SIAP_ITK\resources\views/alert.blade.php ENDPATH**/ ?>