<?= loadPartial('head') ?>
<?= loadPartial('navbar') ?>
<?= loadPartial('flash') ?>
<?= loadPartial('top-banner') ?>

<section class="container mx-auto p-4 mt-4">
    <div class="panel detail-panel">
        <div class="flex flex-wrap justify-between items-center gap-3 mb-4">
            <a class="back-to-listings" href="<?= url('/listings') ?>">
                <i class="fa fa-arrow-left"></i> Back to listings
            </a>
            <?php if (!empty($canManage)) : ?>
                <div class="flex gap-2">
                    <a href="<?= url('/listings/' . $listing->id . '/edit') ?>" class="btn btn--primary btn--sm">
                        <i class="fa fa-pen"></i> Edit
                    </a>
                    <a href="<?= url('/listings/' . $listing->id . '/delete') ?>" class="btn btn--sm bg-red-500 text-white">
                        <i class="fa fa-trash"></i> Delete
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <?php if (!empty($listing->category)) : ?>
            <span class="category-badge mb-2"><?= e(categoryLabel($listing->category)) ?></span>
        <?php endif; ?>
        <h1 class="text-2xl font-bold text-primary-brand mt-2"><?= e($listing->title) ?></h1>
        <?php if (!empty($listing->company)) : ?>
            <p class="text-lg mt-1 text-gray-600"><i class="fa fa-building"></i> <?= e($listing->company) ?></p>
        <?php endif; ?>
        <p class="text-gray-700 mt-4 leading-relaxed"><?= e($listing->description) ?></p>

        <ul class="detail-meta">
            <li><strong>Salary:</strong> <?= formatSalary($listing->salary) ?></li>
            <li><strong>Location:</strong> <?= e($listing->city) ?>, <?= e($listing->state) ?></li>
            <?php if (!empty($listing->address)) : ?><li><strong>Address:</strong> <?= e($listing->address) ?></li><?php endif; ?>
            <?php if (!empty($listing->phone)) : ?><li><strong>Phone:</strong> <?= e($listing->phone) ?></li><?php endif; ?>
        </ul>
        <?php $tags = formatTagList($listing->tags ?? null); ?>
        <?php if (!empty($tags)) : ?>
            <div class="job-card__tags mb-2">
                <?php foreach ($tags as $tag) : ?>
                    <span class="tag-pill"><?= e($tag) ?></span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="container mx-auto p-4 pb-8">
    <h2 class="text-xl font-semibold mb-3 text-primary-brand" style="font-family: var(--font-heading);">Role Details</h2>
    <div class="panel p-6 mb-6">
        <h3 class="font-semibold mb-2 text-primary-brand">Requirements</h3>
        <p class="text-gray-700 leading-relaxed"><?= e($listing->requirements ?: 'Contact employer for full requirements.') ?></p>
        <h3 class="font-semibold mt-5 mb-2 text-primary-brand">Benefits</h3>
        <p class="text-gray-700 leading-relaxed"><?= e($listing->benefits ?: 'Discuss benefits during the interview process.') ?></p>
    </div>
    <div class="btn-center-wrap">
        <a href="mailto:<?= e($listing->email) ?>?subject=Application%20for%20<?= rawurlencode($listing->title) ?>"
            class="btn btn--primary">
            <i class="fa fa-paper-plane"></i> Apply via Email
        </a>
    </div>
</section>

<?= loadPartial('bottom-banner') ?>
<?= loadPartial('footer') ?>
