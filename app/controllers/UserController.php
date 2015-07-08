<?php

class UserController extends \BaseController {

    public function articles(User $user)
    {
        return View::make('home')->with('user', $user)->with('articles', Article::with('tags')->where('user_id', '=', $user->id)->orderBy('created_at', 'desc')->get());
    }

}