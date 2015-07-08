<?php

class ArticleController extends \BaseController {

    public function __construct()
    {
        $this->beforeFilter('auth', array('only' => array('create', 'store', 'edit', 'update', 'destroy')));
    }

    public function create()
    {
        return View::make('article.create');
    }

    /**
     * 文章预览
     */
    public function preview()
    {
        return Markdown::pares(Input::get('content'));
    }

    /**
     * 添加文章数据
     */
    public function store()
    {
        $rules = [
            'title'   => 'required|max:100',
            'content' => 'required',
            'tags'    => array('required', 'regex:/^\w+$|^(\w+,)+\w+$/'),
        ];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->passes()) {
            $article = Article::create(Input::only('title', 'content'));
            $article->user_id = Auth::id();
            $resolved_content = Markdown::parse(Input::get('content'));
            $article->resolved_content = $resolved_content;
            $tags = explode(',', Input::get('tags'));
            if (str_contains($resolved_content, '<p>')) {
                $start = strpos($resolved_content, '<p>');
                $length = strpos($resolved_content, '</p>') - $start - 3;
                $article->summary = substr($resolved_content, $start + 3, $length);
            } else if (str_contains($resolved_content, '</h')) {
                $start = strpos($resolved_content, '<h');
                $length = strpos($resolved_content, '</h') - $start - 4;
                $article->summary = substr($resolved_content, $start + 4, $length);
            }
            $article->save();
            foreach ($tags as $tagName) {
                $tag = Tag::whereName($tagName)->first();
                if (!$tag) {
                    $tag = Tag::create(array('name' => $tagName));
                }
                $tag->count++;
                $article->tags()->save($tag);
            }
            return Redirect::route('article.show', $article->id);
        } else {
            return Redirect::route('article.create')->withInput()->withErrors($validator);
        }
    }

    public function show($id)
    {
        return View::make('articles.show')->with('article', Article::find($id));
    }

    /**
     * @param $route
     * @param $request
     * @return mixed
     */
    public function canOperation($route, $request)
    {
        if (!(Auth::user()->is_admin or Auth::id() == Article::find(Route::input('article'))->user_id))
        {
            return Redirect::to('/');
        }
    }

    /**
     * @param $id
     * @return mixed
     * @文章信息更新
     */
    public function edit($id)
    {
        $article = Article::with('tags')->find($id);
        $tags = '';
        for ($i = 0, $len = count($article->tags); $i < $len; $i++) {
            $tags .= $article->tags[$i]->name . ($i == $len - 1 ? '' : ',');
        }
        $article->tags = $tags;
        return View::make('articles.edit')->with('article', $article);
    }

    /**
     * @param $id
     * @return mixed
     * @更新文章信息
     */
    public function update($id)
    {
        $rules = [
            'title'   => 'required|max:100',
            'content' => 'required',
            'tags'    => array('required', 'regex:/^\w+$|^(\w+,)+\w+$/'),
        ];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->passes()) {
            $article = Article::with('tags')->find($id);
            $article->update(Input::only('title', 'content'));
            $resolved_content = Markdown::parse(Input::get('content'));
            $article->resolved_content = $resolved_content;
            $tags = array_unique(explode(',', Input::get('tags')));
            if (str_contains($resolved_content, '<p>')) {
                $start = strpos($resolved_content, '<p>');
                $length = strpos($resolved_content, '</p>') - $start - 3;
                $article->summary = substr($resolved_content, $start + 3, $length);
            } elseif (str_contains($resolved_content, '</h')) {
                $start = strpos($resolved_content, '<h');
                $length = strpos($resolved_content, '</h') - $start - 4;
                $article->summary = substr($resolved_content, $start + 4, $length);
            }
            $article->save();
            foreach ($article->tags as $tag) {
                if (($index = array_search($tag->name, $tags)) !== false) {
                    unset($tags[$index]);
                } else {
                    $tag->count--;
                    $tag->save();
                    $article->tags()->detach($tag->id);
                }
            }
            foreach ($tags as $tagName) {
                $tag = Tag::whereName($tagName)->first();
                if (!$tag) {
                    $tag = Tag::create(array('name' => $tagName));
                }
                $tag->count++;
                $article->tags()->save($tag);
            }
            return Redirect::route('article.show', $article->id);
        } else {
            return Redirect::route('article.edit', $id)->withInput()->withErrors($validator);
        }
    }

    /**
     * @param $id
     * @return mixed
     * @删除文章信息
     */
    public function destroy($id)
    {
        $article = Article::find($id);
        foreach ($article->tags as $tag) {
            $tag->count--;
            $tag->save();
            $article->tags()->detach($tag->id);
        }
        $article->delete();
//        return Redirect::to('home');
        return Redirect::back();
    }

}