<?php

class TagsController extends \BaseController {

    public function __construct()
    {
        $this->beforeFilter('auth', array('only' => array('create', 'store', 'edit', 'update', 'destroy')));
        $this->beforeFilter('csrf', array('only' => array('store', 'update', 'destroy')));
    }

    public function edit($id)
    {
        return View::make('tags.edit')->with('tag', Tag::find($id));
    }

    public function update($id)
    {
        $rules = array(
            'name' => array('required', 'regex:/^\w+$/'),
        );
        $validator = Validator::make(Input::only('name'), $rules);
        if ($validator->passes()) {
            Tag::find($id)->update(Input::only('name'));
            return Redirect::back()->with('message', array('type' => 'success', 'content' => 'Modify tag successfully'));
        } else {
            return Redirect::back()->withInput()->withErrors($validator);
        }
    }
    /**
     * @删除标签
     */
    public function destroy($id)
    {
        $tag = Tag::find($id);
        $tag->count = 0;
        $tag->save();
        foreach ($tag->articles as $article) {
            $tag->articles()->detach($article->id);
        }
        return Redirect::back();
    }

    public function articles($id)
    {
        $tag = Tag::find($id);
        $articles = $tag->articles()->orderBy('created_at', 'desc')->paginate(10);
        return View::make('articles.specificTag')->with('tag', $tag)->with('articles', $articles);
    }

}