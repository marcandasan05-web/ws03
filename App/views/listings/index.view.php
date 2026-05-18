<?= loadPartial('head') ?>
<?= loadPartial('navbar') ?>
<?= loadPartial('flash') ?>
<?= loadPartial('showcase-search', [
    'keywords' => $keywords ?? '',
    'location' => $location ?? '',
    'category' => $category ?? '',
]) ?>

<section class="container mx-auto p-4 mt-6">
    <h2 class="section-title text-2xl">
        <?php if (!empty($keywords) || !empty($location) || !empty($category)) : ?>
            Search Results
        <?php else : ?>
            All Open Positions
        <?php endif; ?>
    </h2>
    <p class="section-intro">
        <?= count($listings) ?> <?= count($listings) === 1 ? 'role' : 'roles' ?> available
    </p>

    <?php if (!empty($keywords) || !empty($location) || !empty($category)) : ?>
        <div class="filter-summary">
            Showing matches
            <?php if ($keywords) : ?>
                for <span class="filter-chip"><?= e($keywords) ?></span>
            <?php endif; ?>
            <?php if ($category) : ?>
                in <span class="filter-chip"><?= e(categoryLabel($category)) ?></span>
            <?php endif; ?>
            <?php if ($location) : ?>
                near <span class="filter-chip"><?= e($location) ?></span>
            <?php endif; ?>
            <a href="<?= url('/listings') ?>" class="filter-clear">Clear all filters</a>
        </div>
    <?php endif; ?>

    <?php if (empty($listings)) : ?>
        <div class="panel empty-state">
            <p>No positions match your search. Try different keywords, category, or location.</p>
            <a href="<?= url('/listings') ?>" class="btn btn--primary">View All Jobs</a>
        </div>
    <?php else : ?>
        <div class="jobs-grid">
            <?php foreach ($listings as $listing) : ?>
                <?php require basePath('App/views/partials/listing-card.php'); ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<?= loadPartial('bottom-banner') ?>
<?= loadPartial('footer') ?>
