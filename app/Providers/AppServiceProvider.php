<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Folder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
		
		view()->composer('*', function($view) {

			$data = Folder::where('parent_id', 0)->get();
			$data->map(function ($item, $key) {
				$keys = $item->tree_id;
				$keys = explode(',', $keys);

				$list = array();

				foreach ($keys as $key) {
					$obj = new \stdClass;

					$folder = Folder::find($key);
					$obj->id = $key;
					$obj->value = $folder->name;
					array_push($list, $obj);
				}
				return $item->parentNodes = json_encode($list, JSON_HEX_APOS|JSON_HEX_QUOT);
			});

            $view->with('folders', $data);
        });
    }
}
