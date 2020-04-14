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
<?php /**PATH D:\Kuli (ah)\Prodi\TA\PROJECT WEB SIAP\SIAP-ITK-REVISED\resources\views/alert.blade.php ENDPATH**/ ?>