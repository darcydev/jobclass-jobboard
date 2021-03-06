<?php
/**
 * JobClass - Job Board Web Application
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: https://bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from CodeCanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
 */

namespace App\Http\Middleware;

use Closure;
use Prologue\Alerts\Facades\Alert;

class DemoRestriction
{
	/**
	 * @param \Illuminate\Http\Request $request
	 * @param Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (isDemo()) {
			$message = t('demo_mode_message');
			
			if ($request->ajax()) {
				$result = [
					'success' => false,
					'msg'     => $message,
				];
				
				return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
			} else {
				if (isFromAdminPanel()) {
					Alert::info($message)->flash();
				} else {
					flash($message)->info();
				}
				
				return redirect()->back();
			}
		}
		
		return $next($request);
	}
}
