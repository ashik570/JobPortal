<?php echo app('translator')->get('english.VERIFICATION_MAIL_ADDRESS', ['name' => $name]); ?>
<?php echo app('translator')->get('english.VERIFICATION_MAIL_BODY', ['title' => $title, 'code' => $code]); ?>

<br>
<?php echo app('translator')->get('english.VERIFICATION_MAIL_REGARDS'); ?>
<img src="<?php echo e($message->embed(public_path() . '/img/swapnoloke.png')); ?>" alt="<?php echo app('translator')->get('english.COMPANY_NAME_SL'); ?>" />
<?php echo app('translator')->get('english.VERIFICATION_MAIL_COMPANY_INFO'); ?><?php /**PATH D:\xampp\htdocs\dysin\resources\views/website/frontend/template/mail.blade.php ENDPATH**/ ?>