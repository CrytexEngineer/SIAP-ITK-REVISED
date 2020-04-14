<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Users</div>

                    <div class="card-body">
                        <?php if(session('status')): ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo e(session('status')); ?>

                            </div>
                        <?php endif; ?>

                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Roles</th>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-users')): ?>
                                    <th scope="col">Actions</th>
                                <?php endif; ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <th scope="row"><?php echo e($user->PE_Nip); ?></th>
                                    <td><?php echo e($user->PE_Nama); ?></td>
                                    <td><?php echo e($user->PE_Email); ?></td>
                                    <td><?php echo e(implode(', ', $user->roles()->get()->pluck('role_name')->toArray())); ?></td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-users')): ?>
                                        <td>
                                            <a href="<?php echo e(route('admin.users.edit', $user->PE_Nip)); ?>"><button type="button" class="btn btn-primary float-left">Edit</button></a>
                                            <form action="<?php echo e(route('admin.users.destroy', $user->PE_Nip)); ?>" method="POST" class="float-left">
                                                <?php echo csrf_field(); ?>
                                                <?php echo e(method_field('DELETE')); ?>

                                                <button type="submit" class="btn btn-warning">Delete</button>
                                            </form>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Kuli (ah)\Prodi\TA\PROJECT WEB SIAP\SIAP-ITK-REVISED\resources\views/admin/users/index.blade.php ENDPATH**/ ?>