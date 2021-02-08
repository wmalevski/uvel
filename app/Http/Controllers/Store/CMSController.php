<?php

namespace App\Http\Controllers\Store;

use Illuminate\Support\Facades\View;
use App\CMS;

class CMSController extends BaseController{

	public function showPrivacyPolicyPage(){
		return View::make('store.pages.cms.privacy_policy', array(
			'title' => CMS::get('privacy_policy', true),
			'page_content' => CMS::get('privacy_policy')
		));
	}

	public function showAboutUsPage(){
		return View::make('store.pages.cms.about_us',array(
			'title' => CMS::get('about_us', true),
			'page_content' => CMS::get('about_us')
		));
	}

	public function showCookiesPolicyPage(){
		return View::make('store.pages.cms.cookies_policy',array(
			'title' => CMS::get('cookies_policy', true),
			'page_content' => CMS::get('cookies_policy')
		));
	}

}