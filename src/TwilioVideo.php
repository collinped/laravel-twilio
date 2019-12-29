<?php


namespace Collinped\Twilio;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TwilioVideo extends Twilio
{
    protected $shouldRecord = false;
    protected $roomType = 'peer-to-peer';
    /**
     * @var null|string
     */
    protected $statusCallback = null;

    protected $roomName;
    protected $roomSid;

    public function all(array $params = [], $limit = null, $page= null)
    {
        $allowedStatuses = [
            'in-progress',
            'completed'
        ];

        if (isset($params['status'])) {
            if (!in_array($params['status'], $allowedStatuses)) {
                $params['status'] = null;
            }
        }

        if (isset($params['name'])) {
            $params['uniqueName'] = $params['name'];
        }

        $allRooms = $this->twilio->video->v1->rooms->read($params, $limit, $page);

        $rooms = array_map(function($room) {
            return $room->uniqueName;
        }, $allRooms);

        return response()->json($rooms);
    }

    public function get($roomIdentifier)
    {
        return $this->twilio->video->v1->rooms($roomIdentifier)
            ->fetch();
    }

    public function create($uniqueName = null, array $params = [])
    {
        if ($uniqueName) {
            $this->roomName = $uniqueName;
        }
        $params['uniqueName'] = ($this->roomName ?: Str::random(40));
        $params['type'] = $this->roomType;
        if ($this->roomType !== 'peer-to-peer') {
            $params['recordParticipantsOnConnect'] = $this->shouldRecord;
        }

        return $this->twilio->video->v1->rooms
            ->create($params);
    }

    public function room($roomSid)
    {
        $this->roomSid;

        return $this;
    }

    public function name($roomName)
    {
        $this->roomName = $roomName;

        return $this;
    }

    /**
     * Set the status callback.
     *
     * @param string $statusCallback
     * @return $this
     */
    public function statusCallback($statusCallback)
    {
        $this->statusCallback = $statusCallback;

        return $this;
    }

    public function type($roomType)
    {
        $this->roomType = $roomType;

        return $this;
    }

    public function withRecording()
    {
        if ($this->roomType !== 'peer-to-peer') {
            $this->shouldRecord = true;
        }

        return $this;
    }

    public function withoutRecording()
    {
        $this->shouldRecord = false;

        return $this;
    }

    public function complete($roomSid)
    {
        return $this->twilio->video->v1->rooms($roomSid)
            ->update("completed");
    }

    public function getParticipant($roomSid, $name)
    {
        return $this->twilio->video->rooms($roomSid)
            ->participants($name)
            ->fetch();
    }

    public function removeParticipant($roomSid, $name)
    {
        return $this->twilio->video->v1->rooms($roomSid)
            ->participants($name)
            ->update(array("status" => "disconnected"));
    }

    public function getParticipants($roomSid, $status = 'connected')
    {
        //status = connected or disconnected
        return $this->twilio->video->v1->rooms($roomSid)
            ->participants->read([
                "status" => $status
            ]);
    }

    //Recording
    public function getRecording($recordingSid)
    {
        return $this->twilio->video->v1->recordings($recordingSid)
            ->fetch();
    }

    public function getRecordingMedia($recordingSid)
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

    public function deleteRecording($recordingSid)
    {
        //Delete the recording
        return $this->twilio->video->v1->recordings($recordingSid)
            ->delete();
    }
}
