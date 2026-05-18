<?= loadPartial('head') ?>
<?= loadPartial('navbar') ?>
<?= loadPartial('flash') ?>

<section class="flex justify-center items-center mt-8 mb-12 px-4">
    <div class="panel w-full max-w-2xl p-8">
        <h2 class="text-3xl text-center font-bold mb-2 text-primary-brand">Post a New Position</h2>
        <p class="text-center text-gray-500 mb-6">Reach candidates browsing RightJob today</p>

        <form method="POST" action="<?= url('/listings') ?>">
            <h3 class="text-xl font-bold mb-4 text-primary-brand border-b pb-2">Role Information</h3>
            <?php
            $fields = [
                'title' => ['label' => 'Job Title', 'type' => 'text'],
                'description' => ['label' => 'Description', 'type' => 'textarea'],
                'salary' => ['label' => 'Annual Salary (USD)', 'type' => 'text'],
                'requirements' => ['label' => 'Requirements', 'type' => 'text'],
                'benefits' => ['label' => 'Benefits', 'type' => 'text'],
                'tags' => ['label' => 'Skills / Tags (comma separated)', 'type' => 'text'],
            ];
            foreach ($fields as $name => $meta) :
                $val = $listing[$name] ?? '';
            ?>
            <div class="mb-4">
                <label class="block mb-1 font-medium"><?= $meta['label'] ?></label>
                <?php if ($meta['type'] === 'textarea') : ?>
                    <textarea name="<?= $name ?>" class="w-full px-4 py-2 border rounded" rows="4"><?= e($val) ?></textarea>
                <?php else : ?>
                    <input type="text" name="<?= $name ?>" value="<?= e($val) ?>" class="w-full px-4 py-2 border rounded" />
                <?php endif; ?>
                <?php if (!empty($errors[$name])) : ?><p class="text-red-600 text-sm mt-1"><?= e($errors[$name]) ?></p><?php endif; ?>
            </div>
            <?php endforeach; ?>

            <h3 class="text-xl font-bold mb-4 mt-6 text-primary-brand border-b pb-2">Company & Location</h3>
            <?php
            $locFields = ['company', 'address', 'city', 'state', 'phone', 'email'];
            foreach ($locFields as $name) :
                $val = $listing[$name] ?? '';
            ?>
            <div class="mb-4">
                <label class="block mb-1 font-medium"><?= ucfirst($name) ?><?= $name === 'email' ? ' (for applications)' : '' ?></label>
                <input type="<?= $name === 'email' ? 'email' : 'text' ?>" name="<?= $name ?>" value="<?= e($val) ?>" class="w-full px-4 py-2 border rounded" />
                <?php if (!empty($errors[$name])) : ?><p class="text-red-600 text-sm mt-1"><?= e($errors[$name]) ?></p><?php endif; ?>
            </div>
            <?php endforeach; ?>

            <button type="submit" class="w-full btn-accent py-3 rounded my-3 font-semibold">Publish Position</button>
            <a href="<?= url('/listings') ?>" class="block text-center w-full bg-red-500 text-white py-2 rounded">Cancel</a>
        </form>
    </div>
</section>

<?= loadPartial('footer') ?>
