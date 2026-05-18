<?= loadPartial('head') ?>
<?= loadPartial('navbar') ?>
<?= loadPartial('flash') ?>

<section class="container mx-auto px-4">
    <div class="bg-white auth-card rounded-lg shadow-md">
        <h2 class="text-3xl font-bold text-center mb-2 text-primary-brand">Join JobPH</h2>
        <p class="text-center text-gray-500 mb-6">Create your account to apply or post jobs</p>

        <form method="POST" action="<?= url('/register') ?>">
            <div class="mb-4">
                <label class="block mb-1 font-medium">Full Name</label>
                <input type="text" name="name" required value="<?= e($name ?? '') ?>"
                    class="w-full px-4 py-2 border rounded" />
                <?php if (!empty($errors['name'])) : ?><p class="text-red-600 text-sm mt-1"><?= e($errors['name']) ?></p><?php endif; ?>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Email</label>
                <input type="email" name="email" required value="<?= e($email ?? '') ?>"
                    class="w-full px-4 py-2 border rounded" />
                <?php if (!empty($errors['email'])) : ?><p class="text-red-600 text-sm mt-1"><?= e($errors['email']) ?></p><?php endif; ?>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Account Type</label>
                <select name="role" class="w-full px-4 py-2 border rounded">
                    <option value="user" <?= ($role ?? '') === 'user' ? 'selected' : '' ?>>Job Seeker</option>
                    <option value="employer" <?= ($role ?? '') === 'employer' ? 'selected' : '' ?>>Employer / Recruiter</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Password</label>
                <input type="password" name="password" required class="w-full px-4 py-2 border rounded" />
                <?php if (!empty($errors['password'])) : ?><p class="text-red-600 text-sm mt-1"><?= e($errors['password']) ?></p><?php endif; ?>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Confirm Password</label>
                <input type="password" name="password_confirm" required class="w-full px-4 py-2 border rounded" />
                <?php if (!empty($errors['password_confirm'])) : ?><p class="text-red-600 text-sm mt-1"><?= e($errors['password_confirm']) ?></p><?php endif; ?>
            </div>
            <button type="submit" class="w-full btn-accent py-3 rounded my-3">Create Account</button>
        </form>

        <p class="text-center text-sm mt-4">
            Already registered? <a href="<?= url('/login') ?>" class="text-primary-brand font-semibold">Sign in</a>
        </p>
    </div>
</section>

<?= loadPartial('footer') ?>