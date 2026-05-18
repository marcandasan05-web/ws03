<?= loadPartial('head') ?>
<?= loadPartial('navbar') ?>

<section class="container mx-auto p-4 mt-12">
    <div class="bg-white rounded-lg p-10 text-center max-w-lg mx-auto shadow-md">
        <p class="h2-style"><?= e($status ?? '404') ?></p>
        <p class="text-lg text-gray-600 my-6"><?= e($message ?? 'Something went wrong.') ?></p>
        <a href="<?= url('/listings') ?>" class="btn-accent inline-block px-6 py-3 rounded">
            Browse Open Positions
        </a>
    </div>
</section>

<?= loadPartial('footer') ?>
