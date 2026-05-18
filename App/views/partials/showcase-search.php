<section class="showcase relative flex items-center">
    <div class="overlay absolute inset-0" aria-hidden="true"></div>
    <div class="container mx-auto z-10 relative pt-14 pb-12 px-4">
        <div class="showcase-content text-center max-w-3xl mx-auto">
            <p class="showcase-eyebrow">Find your dream job</p>
            <h2 class="showcase-title">Your Career Starts Here</h2>
            <p class="showcase-subtitle">Discover curated roles from startups and enterprise teams on JobPH</p>
        </div>
        <form method="GET" action="<?= url('/listings') ?>" class="search-panel" role="search">
            <div class="search-panel__grid">
                <label class="search-field search-field--grow">
                    <span class="search-field__label"><i class="fa fa-briefcase" aria-hidden="true"></i> Keywords</span>
                    <input
                        type="search"
                        name="keywords"
                        placeholder="Job title, skill, or company"
                        value="<?= e($keywords ?? '') ?>"
                        class="search-field__input"
                        autocomplete="off" />
                </label>
                <label class="search-field">
                    <span class="search-field__label"><i class="fa fa-layer-group" aria-hidden="true"></i> Category</span>
                    <select name="category" class="search-field__input search-field__select">
                        <?php foreach (jobCategories() as $slug => $label) : ?>
                            <option value="<?= e($slug) ?>" <?= ($category ?? '') === $slug ? 'selected' : '' ?>>
                                <?= e($label) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label class="search-field search-field--grow">
                    <span class="search-field__label"><i class="fa fa-location-dot" aria-hidden="true"></i> Location</span>
                    <input
                        type="text"
                        name="location"
                        placeholder="City or province"
                        value="<?= e($location ?? '') ?>"
                        class="search-field__input"
                        autocomplete="off" />
                </label>
                <button type="submit" class="btn btn--primary btn--search">
                    <i class="fa fa-search" aria-hidden="true"></i>
                    <span>Search Jobs</span>
                </button>
            </div>
        </form>
    </div>
</section>