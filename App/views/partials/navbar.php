<header class="site-header bg-blue-900 text-white p-4 shadow-md">
    <div class="container mx-auto flex flex-wrap justify-between items-center gap-4">
        <h1 class="text-2xl md:text-3xl font-semibold m-0">
            <a href="<?= url('/') ?>" class="flex items-center gap-2 no-underline">
                <i class="fa-solid fa-briefcase brand-logo text-3xl"></i>
                <span class="brand-logo">Job<span style="color:#60a5fa">PH</span></span>
            </a>
        </h1>
        <nav class="flex flex-wrap items-center gap-2 text-sm md:text-base">
            <a href="<?= url('/listings') ?>" class="nav-link">Browse Jobs</a>
            <?php if (isLoggedIn()) : ?>
                <span class="user-greeting hidden md:inline"><i class="fa fa-user-circle"></i> <?= e(currentUser()['name']) ?></span>
                <?php if (isEmployer()) : ?>
                    <a href="<?= url('/listings/create') ?>" class="btn btn--primary btn--sm">
                        <i class="fa fa-plus"></i> Post a Job
                    </a>
                <?php endif; ?>
                <form method="POST" action="<?= url('/logout') ?>" class="inline">
                    <button type="submit" class="btn-outline btn btn--sm cursor-pointer">Logout</button>
                </form>
            <?php else : ?>
                <a href="<?= url('/login') ?>" class="btn-outline btn btn--sm">Login</a>
                <a href="<?= url('/register') ?>" class="btn btn--primary btn--sm">Register</a>
            <?php endif; ?>
        </nav>
    </div>
</header>