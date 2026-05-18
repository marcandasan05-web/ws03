<?php if ($msg = getFlash('success_message')) : ?>
    <div class="container mx-auto mt-4 px-4">
        <div class="message-success"><?= e($msg) ?></div>
    </div>
<?php endif; ?>
<?php if ($msg = getFlash('error_message')) : ?>
    <div class="container mx-auto mt-4 px-4">
        <div class="message-error"><?= e($msg) ?></div>
    </div>
<?php endif; ?>



