<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeModuleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module {folder} {name}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a complete module (Model, Migration, Controller, Views, Traits) inside a folder';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $folder = ucfirst($this->argument('folder')); // example: Admin
        $name   = ucfirst($this->argument('name'));   // example: Product

        $basePath = app_path($folder);
        $viewPath = resource_path("views/" . strtolower($folder) . "/" . strtolower($name));

        // Folder create
        // if (!File::exists($basePath)) {
        //     File::makeDirectory($basePath, 0755, true);
        // }
        if (!File::exists($viewPath)) {
            File::makeDirectory($viewPath, 0755, true);
        }

        // Model create
        $this->call('make:model', [
            'name' => "{$folder}/{$name}",
            '-m'   => true, // with Migration
        ]);

        // Controller create
        $this->call('make:controller', [
            'name' => "{$folder}/{$name}Controller",
            '--resource' => true,
        ]);

        // Trait create (Relation + Common Trait)
        $traitPath = app_path("Traits/{$name}Trait.php");
        if (!File::exists(app_path("Traits"))) {
            File::makeDirectory(app_path("Traits"), 0755, true);
        }
        if (!File::exists($traitPath)) {
            File::put($traitPath, $this->getTraitTemplate($name));
        }

        // View Files create
        foreach (['index', 'create', 'edit', 'show'] as $view) {
            File::put("{$viewPath}/{$view}.blade.php", "<h1>{$name} {$view} page</h1>");
        }

        $this->info("✅ {$name} Module created successfully inside {$folder}!");
    }
    protected function getTraitTemplate($name)
    {
        return <<<EOT
            <?php

            namespace App\Traits;

            trait {$name}Trait
            {
                // Define {$name} relationships here
            }
            EOT;
    }
}
