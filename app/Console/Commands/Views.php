<?php

namespace App\Console\Commands;

use File;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Views extends Command {

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'adminViews:view {name} {--blade=*}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create Views, Model, Controller for admine panel';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public $name;

	public function __construct() {
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {
		$options = $this->options();
		$this->name = $this->argument('name');

		$destinationPath = getcwd() . '/resources/views/admin/' . $this->name;
		if (!File::isDirectory($destinationPath)) {
			File::makeDirectory($destinationPath);
		}

		$templates = [
			'index' => getcwd() . '/resources/views/vendor/templates/index.php',
			'create' => getcwd() . '/resources/views/vendor/templates/create.php',
			'edit' => getcwd() . '/resources/views/vendor/templates/edit.php',
		];

		$current_templates = [];

		if (count($options["blade"]) !== 0) {
			$params = str_split($options["blade"][0]);
			foreach ($params as $paramtr) {
				switch ($paramtr) {
				case 'i':
					$current_templates['index'] = $templates['index'];
					break;
				case 'c':
					$current_templates['create'] = $templates['create'];
					break;

				case 'e':
					$current_templates['edit'] = $templates['edit'];
					break;
				default:
					echo 'Nie znany argument';
					echo "\n";
					die;
				}
			}
			$this->createFiles($current_templates, $destinationPath);
		} else {
			$this->createFiles($templates, $destinationPath);
		}
	}

	public function createFiles($templates, $destinationPath) {
		$controllerPath = 'Admin/' . ucfirst($this->name) . 'Controller';
		if (!File::isDirectory($controllerPath)) {
			$createController = Artisan::call('make:controller', [
				'name' => $controllerPath,
			], '');
		}
		$modelPath = str_plural(ucfirst($this->name));

		if (!File::isDirectory($modelPath)) {
			$createController = Artisan::call('make:model', [
				'name' => $modelPath,
			]);
		}
		foreach ($templates as $key => $value) {
			$this->replaceInFile($value, $this->name);

			if (copy($value, $destinationPath . '/' . $key . '.blade.php')) {
				echo $key . '.php is created...';
				echo "\n";
			} else {
				echo 'Creating ' . $key . '.php failed...';
				echo "\n";
			}
		}
	}

	public function replaceInFile($file, $text) {
		$str = file_get_contents($file);

		$str = str_replace('templateName', $text, $str);

		file_put_contents($file, $str);
	}

}
