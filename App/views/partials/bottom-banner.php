<section class="container mx-auto my-8 px-4">
    <div class="cta-panel">
        <div>
            <h2 class="text-xl font-semibold m-0">Hiring for your team?</h2>
            <p class="mt-2 m-0">
                Publish a role in minutes and reach candidates actively browsing JobPH.
            </p>
        </div>
        <?php if (isEmployer()) : ?>
            <a href="<?= url('/listings/create') ?>" class="btn btn--primary btn--sm">
                <i class="fa fa-plus"></i> Post a Position
            </a>
        <?php elseif (!isLoggedIn()) : ?>
            <a href="<?= url('/register') ?>" class="btn btn--primary btn--sm">
                <i class="fa fa-user-plus"></i> Create Employer Account
            </a>
        <?php endif; ?>
    </div>
</section>