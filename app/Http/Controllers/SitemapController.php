<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Profile;
use App\Models\Page;
use Illuminate\Http\Request;

class SitemapController extends Controller {
	public function index() {
		$articles = Post::where( 'active', 1 )->orderBy( 'updated_at', 'desc' )->first();
		$pages    = Page::where( 'active', 1 )->orderBy( 'updated_at', 'desc' )->first();
		$profiles = Profile::where( 'active', 1 )->orderBy( 'updated_at', 'desc' )->first();

		return response()->view( 'sitemap.index', [
			'articles' => $articles,
			'pages'    => $pages,
			'profiles' => $profiles,
		] )->header( 'Content-Type', 'text/xml' );
	}

	public function articles() {
		$articles = Post::where( 'active', 1 )->orderBy( 'updated_at', 'desc' )->get();

		return response()->view( 'sitemap.articles', [
			'articles' => $articles,
		] )->header( 'Content-Type', 'text/xml' );
	}

	public function pages() {
		$pages = Page::where( 'active', 1 )->orderBy( 'updated_at', 'desc' )->get();

		return response()->view( 'sitemap.pages', [
			'pages' => $pages,
		] )->header( 'Content-Type', 'text/xml' );
	}

	public function profiles() {
		$profiles = Profile::where( 'active', 1 )->orderBy( 'updated_at', 'desc' )->get();

		return response()->view( 'sitemap.profiles', [
			'profiles' => $profiles,
		] )->header( 'Content-Type', 'text/xml' );
	}
}
