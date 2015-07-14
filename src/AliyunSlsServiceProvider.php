<?php
namespace Latrell\AliyunSls;

use Illuminate\Support\ServiceProvider;

class AliyunSlsServiceProvider extends ServiceProvider
{

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->handleConfigs();
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton('aliyun.sls', function ($app) {
			$config = $app->config->get('latrell-aliyun-sls');
			return new AliyunSls($config['endpoint'], $config['access_key_id'], $config['access_key'], $config['project'], $config['logstore']);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [
			'aliyun.sls'
		];
	}

	private function handleConfigs()
	{
		$configPath = __DIR__ . '/../config/latrell-aliyun-sls.php';

		$this->publishes([
			$configPath => config_path('latrell-aliyun-sls.php')
		]);

		$this->mergeConfigFrom($configPath, 'latrell-aliyun-sls');
	}
}
