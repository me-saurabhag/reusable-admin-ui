<?php

namespace ReusableAdminUi\\Console;

use Illuminate\\Console\\Command;

class InstallCommand extends Command
{
    protected $signature = 'admin-ui:install
        {--force : Overwrite previously published package files}';

    protected $description = 'Publish Reusable Admin UI assets and configure Vite entry points.';

    /**
     * Package-owned assets and starter files required by the default auth pages.
     *
     * @var array<int, string>
     */
    private array $publishTags = [
        'admin-ui-config',
        'admin-ui-assets',
        'admin-ui-core',
        'admin-ui-auth',
    ];

    /**
     * The package's page-specific entries. Each page remains an independent
     * Vite entry so its CSS and JavaScript are not loaded by unrelated pages.
     *
     * @var array<int, string>
     */
    private array $viteEntries = [
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/css/pages/auth/login.css',
        'resources/js/pages/LoginPage.js',
        'resources/css/pages/auth/register.css',
        'resources/js/pages/RegisterPage.js',
        'resources/css/pages/auth/forgot-password.css',
        'resources/js/pages/ForgotPasswordPage.js',
    ];

    public function handle(): int
    {
        $this->components->info('Installing Reusable Admin UI assets...');

        foreach ($this->publishTags as $tag) {
            $options = ['--tag' => $tag];

            if ($this->option('force')) {
                $options['--force'] = true;
            }

            $this->call('vendor:publish', $options);
        }

        if (! $this->updateViteConfig()) {
            $this->components->warn(
                'Package assets were published, but Vite entries could not be added automatically. ' .
                'Please review vite.config.js and add the Admin UI entries shown in the installation guide.'
            );

            return self::FAILURE;
        }

        $this->newLine();
        $this->components->info('Reusable Admin UI installation completed.');
        $this->line('Next, run: <fg=yellow>npm run build</>');
        $this->line('Page CSS and JavaScript are registered as separate Vite entries.');

        return self::SUCCESS;
    }

    private function updateViteConfig(): bool
    {
        $viteConfigPath = base_path('vite.config.js');

        if (! is_file($viteConfigPath) || ! is_readable($viteConfigPath)) {
            $this->components->error('Could not find a readable vite.config.js in the Laravel project root.');
            return false;
        }

        $contents = file_get_contents($viteConfigPath);

        if ($contents === false) {
            $this->components->error('Could not read vite.config.js.');
            return false;
        }

        // Laravel's standard Vite configuration uses an input array. We only
        // update that array and leave all other project configuration intact.
        if (! preg_match('/(\\binput\\s*:\\s*\\[)([\\s\\S]*?)(\\])/', $contents, $matches, PREG_OFFSET_CAPTURE)) {
            $this->components->error('Could not locate the standard input: [ ... ] array in vite.config.js.');
            return false;
        }

        $entries = $matches[2][0];
        $missingEntries = [];

        foreach ($this->viteEntries as $entry) {
            $quotedEntry = preg_quote($entry, '/');

            if (! preg_match('/[\\\'"]' . $quotedEntry . '[\\\'"]/', $entries)) {
                $missingEntries[] = $entry;
            }
        }

        if ($missingEntries === []) {
            $this->components->info('Vite already contains all required Admin UI entries.');
            return true;
        }

        $closingBracketOffset = $matches[3][1];
        $beforeClosingBracket = substr($contents, 0, $closingBracketOffset);
        $trimmedBeforeClosingBracket = rtrim($beforeClosingBracket);

        // Keep valid JavaScript syntax whether the existing final entry has a
        // trailing comma or not.
        $needsComma = $trimmedBeforeClosingBracket !== ''
            && ! str_ends_with($trimmedBeforeClosingBracket, ',');

        $addition = $needsComma ? ',' : '';
        $addition .= "\n                // Reusable Admin UI page entries";

        foreach ($missingEntries as $entry) {
            $addition .= "\n                '" . $entry . "',";
        }

        $addition .= "\n            ";

        $updated = $trimmedBeforeClosingBracket
            . $addition
            . substr($contents, $closingBracketOffset);

        if (file_put_contents($viteConfigPath, $updated) === false) {
            $this->components->error('Could not update vite.config.js. Check file permissions.');
            return false;
        }

        $this->components->info('Added ' . count($missingEntries) . ' missing Vite entr' . (count($missingEntries) === 1 ? 'y' : 'ies') . '.');

        return true;
    }
}
