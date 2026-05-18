<?= loadPartial('head') ?>
<?= loadPartial('navbar') ?>
<?= loadPartial('flash') ?>
<?= loadPartial('showcase-search', [
    'keywords' => $keywords ?? '',
    'location' => $location ?? '',
    'category' => $category ?? '',
]) ?>
<?= loadPartial('top-banner') ?>

<section class="container mx-auto p-4 mt-6">
    <h2 class="section-title text-2xl">Featured Openings</h2>
    <p class="section-intro">Hand-picked technology roles from employers on JobPH</p>
    <?php if (empty($listings)) : ?>
        <div class="panel empty-state">
            <p>No positions posted yet. Be the first employer on RightJob!</p>
            <a href="<?= url('/register') ?>" class="btn btn--primary">Create Employer Account</a>
        </div>
    <?php else : ?>
        <div class="jobs-grid">
            <?php foreach ($listings as $listing) : ?>
                <?php require basePath('App/views/partials/listing-card.php'); ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <div class="btn-center-wrap">
        <a href="<?= url('/listings') ?>" class="btn btn--primary">
            <i class="fa fa-compass"></i> Explore All Opportunities
        </a>
    </div>
</section>

<?= loadPartial('bottom-banner') ?>
<?= loadPartial('footer') ?>