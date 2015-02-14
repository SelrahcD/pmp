<?php namespace Pmp\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}



	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'Pmp\Services\Registrar'
		);

		$this->app->bind(
			'Pmp\Domain\Model\User\UserRepository',
			'Pmp\Infrastructure\Repositories\UserDoctrineOrmRepository'
		);

		$this->app->bind(
			'Pmp\Domain\Model\Quote\QuoteRepository',
			'Pmp\Infrastructure\Repositories\QuoteDoctrineOrmRepository'
		);

		$this->app->bind(
			'Pmp\Domain\Model\Market\MarketRepository',
			'Pmp\Infrastructure\Repositories\MarketDoctrineOrmRepository'
		);

		$this->app->bind(
			'Pmp\Domain\Model\Agency\AgencyRepository',
			'Pmp\Infrastructure\Repositories\AgencyDoctrineOrmRepository'
		);
	}

}
