<?php


namespace Collinped\TwilioVideo;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

class Recording extends TwilioVideo
{
    public function get($recordingSid)
    {
        //Retrieve a recording
        return $this->twilio->video->v1->recordings($recordingSid)
            ->fetch();
    }

    public function getMedia($recordingSid)
    {
        $client = new Client();
        //Retrieve the actual recording media
        $uri = "https://video.twilio.com/v1/Recordings/$recordingSid/Media";
        $response = $client->request("GET", $uri);
        $mediaLocation = $response->getContent()["redirect_to"];
        $media_content = file_get_contents($mediaLocation);
        Storage::disk('local')->put($recordingSid, $media_content);
        $path = Storage::url($recordingSid);

        return response()->download($path);

    }

    public function delete($recordingSid)
    {
        //Delete the recording
        return $this->twilio->video->v1->recordings($recordingSid)
            ->delete();
    }


}
