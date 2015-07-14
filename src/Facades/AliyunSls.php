<?php
namespace Latrell\AliyunSls\Facades;

use Illuminate\Support\Facades\Facade;

class AliyunSls extends Facade
{

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'aliyun.sls';
	}
}