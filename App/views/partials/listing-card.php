<article class="job-card">
    <div class="job-card__body">
        <div class="job-card__header">
            <?php if (!empty($listing->category)) : ?>
                <span class="category-badge"><?= e(categoryLabel($listing->category)) ?></span>
            <?php endif; ?>
            <h2 class="job-card__title"><?= e($listing->title) ?></h2>
            <?php if (!empty($listing->company)) : ?>
                <p class="job-card__company">
                    <i class="fa fa-building" aria-hidden="true"></i>
                    <?= e($listing->company) ?>
                </p>
            <?php endif; ?>
        </div>
        <p class="job-card__description"><?= e($listing->description) ?></p>
        <ul class="job-card__meta">
            <li>
                <i class="fa fa-money-bill-wave" aria-hidden="true"></i>
                <span><strong>Salary</strong> <?= formatSalary($listing->salary) ?></span>
            </li>
            <li>
                <i class="fa fa-location-dot" aria-hidden="true"></i>
                <span><strong>Location</strong> <?= e($listing->city) ?>, <?= e($listing->state) ?></span>
            </li>
        </ul>
        <?php $tags = formatTagList($listing->tags ?? null); ?>
        <?php if (!empty($tags)) : ?>
            <div class="job-card__tags">
                <?php foreach (array_slice($tags, 0, 4) as $tag) : ?>
                    <span class="tag-pill"><?= e($tag) ?></span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="job-card__footer">
        <a href="listing?id=<?= $listing->id ?>" class="btn btn--secondary btn--sm">
            View Position <i class="fa fa-arrow-right" aria-hidden="true"></i>
        </a>
    </div>
</article>