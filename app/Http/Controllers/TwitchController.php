<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Streams;
use App\Models\Streamers;

use Illuminate\Support\Facades\Http;

/**
 * Class TwitchController
 *
 * @author  cmsf <cesarmsfelipe@gmail.com>
 * @package App\Http\Controllers
 */
class TwitchController extends Controller
{
    protected $headers = [
        'Authorization' => "Bearer e1wlww25qpoew82axu3m566feqzvaz",
        "Client-id" => "xd72gmt643nbmegt9990z4c4iuvmc1"
    ];
    /**
     * Undocumentefunctiond
     *
     * @return void
     */
    public function getTopStreams()
    {
        $data = Http::withHeaders($this->headers)
            ->get("https://api.twitch.tv/helix/streams?first=100");
        $data = $data->json();
        $response = $data['data'];
        foreach ($response as $key => $value) {
            $response[$key]['thumbnail_url'] = str_replace("{width}", "262", $response[$key]['thumbnail_url']);
            $response[$key]['thumbnail_url'] = str_replace("{height}", "147", $response[$key]['thumbnail_url']);
            $this->setStream($value);
        }
        return $response;
    }
    public function SetStream($data)
    {
        /** @var \App\Models\Streams $stream */
        $stream = Streams::where('id_streamer', $data['id'])->first();
        if (!$stream) {
            Streams::create([
                'id_streamer' => $data['id'],
                'language' => $data['language'],
                'source' => 'Twitch',
                'user_login' => $data['user_login'],
                'user_name' => $data['user_name'],
                'url' => 'https://twitch.tv/' . $data['user_login'],
            ]);
        }
    }

    public function getStreamer(Request $request)
    {
        $id = $request->all();
        $data = Http::withHeaders($this->headers)
            ->get("https://api.twitch.tv/helix/users?id=" . $id['id']);
        $data = $data->json();
        return $this->setStreamer($data, $id['id']);

    }
    public function setStreamer($data, $id)
    {

        /** @var \App\Models\Streamers $streamer */
        $streamer = Streamers::where('id_streamer', $id)->first();
        if (!$streamer) {
           $streamer =  Streamers::create([
                'id_streamer' => $id,
                'broadcaster_type' => $data['data'][0]['broadcaster_type'],
                'description' => $data['data'][0]['description'],
                'display_name' => $data['data'][0]['display_name'],
                'offline_image_url' => $data['data'][0]['offline_image_url'],
                'profile_image_url' => $data['data'][0]['profile_image_url'],
            ]);
        }
        return $streamer;
    }
}
