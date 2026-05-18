<footer class="bg-blue-900 text-white mt-16">
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-briefcase text-3xl brand-logo"></i>
                <div>
                    <h3 class="text-xl font-bold m-0">JobPH</h3>
                    <p class="text-gray-300 text-sm mt-1">Careers done right, every single day.</p>
                </div>
            </div>
            <div class="flex flex-wrap gap-4 text-sm">
                <a href="<?= url('/') ?>" class="hover:underline">Home</a>
                <a href="<?= url('/listings') ?>" class="hover:underline">Browse Jobs</a>
                <a href="<?= url('/register') ?>" class="hover:underline">Sign Up</a>
                <a href="<?= url('/login') ?>" class="hover:underline">Login</a>
            </div>
        </div>
    </div>
    <div class="copy-right">
        <hr class="border-blue-800 my-4 w-full opacity-30">
        <p class="text-xs text-center text-slate-700 pb-2">
            &copy; <?= date('Y') ?> JobPH. All rights reserved.
        </p>
    </div>
</footer>

</body>

</html>