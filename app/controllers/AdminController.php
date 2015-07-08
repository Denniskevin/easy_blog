<?php

class AdminController extends \BaseController {

    public function articles()
    {
        return View::make('admin.articles.list')->with('articles', Article::with('user', 'tags')->orderBy('created_at', 'desc')->get())->with('page', 'articles');
    }

    public function tags() {
        return View::make('admin.tags.list')->with('tags', Tag::all()->orderBy('count', 'desc'));
    }
}