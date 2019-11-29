<?php

namespace App\Http\Controllers;

use Abraham\TwitterOAuth\TwitterOAuth;

use Illuminate\Http\Request;
use App\Post;

class TwitterController extends Controller
{
    public function twitter()
    {
        $twitter = new TwitterOAuth(
            config('twitter.consumer_key'),
            config('twitter.consumer_secret')
        );

        # 認証用のrequest_tokenを取得
        $token = $twitter->oauth('oauth/request_token', array(
            'oauth_callback' => config('twitter.callback_url')
        ));

        # 認証画面で認証を行うためSessionに入れる
        session(array(
            'oauth_token'        => $token['oauth_token'],
            'oauth_token_secret' => $token['oauth_token_secret'],
        ));

        # 認証画面へ移動させる
        ## 毎回認証をさせたい場合： 'oauth/authorize'
        ## 再認証が不要な場合： 'oauth/authenticate'
        $url = $twitter->url('oauth/authenticate', array(
            'oauth_token' => $token['oauth_token'],
        ));

        return redirect($url);
    }

    public function index()
    {
        return view('twitter/index');
    }

    public function store(Request $request)
    {
        $twitter = new TwitterOAuth(
            config('twitter.consumer_key'),
            config('twitter.consumer_secret'),
            config('twitter.access_token'),
            config('twitter.access_token_secret')
        );

        // ユーザー特定
        $userInfo    = $twitter->get('account/verify_credentials');
        $tw_name     = $userInfo->name;
        $screen_name = $userInfo->screen_name;
        $followers   = $userInfo->followers_count;

        // ユーザーのフォロー
        $twitter->post('friendships/create', array('screen_name' => "always_protein", 'follow' => 'true'));

        // 投稿内容取得
        $comment = $request->comment;
        
        // 画像投稿
        $media1 = $twitter->upload('media/upload', ['media' => $request->file('file')]);
        
        // 投稿 (テキスト ＋ 画像)
        $parameters = array(
            'status'    => $comment,
            'media_ids' => $media1->media_id_string
        );
        $result = $twitter->post("statuses/update", $parameters);

        // DB登録        
        $post = new Post;
        $post->comment = $request->comment;

        $uploadedFile = $request->file('file')->getClientOriginalName();
        $path = \Storage::putFileAs('',$request->file('file'), $uploadedFile);
        $post->img = \Storage::disk('public')->url($path);
        $post->save();

        return redirect('/');
    }
}
