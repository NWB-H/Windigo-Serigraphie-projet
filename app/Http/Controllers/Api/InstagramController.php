<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Http;

class InstagramController extends Controller
{
    public function getPosts()
    {
        $accessToken = env('INSTAGRAM_ACCESS_TOKEN');
        $userId = env('INSTAGRAM_USER_ID');

        $url = "https://graph.instagram.com/{$userId}/media";

        $response = Http::get($url, [
            'fields' => 'id,caption,media_type,media_url,permalink,timestamp,username',
            'access_token' => $accessToken,
        ]);

        return response()->json($response->json());
    }
}
