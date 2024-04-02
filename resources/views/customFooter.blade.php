<footer class="fixed bottom-0 right-0 z-20 w-full p-1 bg-white border-t border-gray-200 shadow md:flex md:items-center md:justify-between md:p-4 dark:bg-gray-800 dark:border-gray-600">
    <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© {{ \App\Settings\GeneralSettings::copyright() }}
        <a href="https://github.com/bumicode/erp" class="hover:underline">{{ (new \App\Settings\GeneralSettings)->site_name }}</a>. code with ❤ from sukabumi
    </span>
</footer>
