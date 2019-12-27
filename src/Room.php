<?php


namespace Collinped\TwilioVideo;

use Illuminate\Support\Str;

class Room extends TwilioVideo
{
    protected $shouldRecord = false;
    protected $roomType = 'peer-to-peer';
    protected $callbackUrl;
    protected $roomName;

    public function all(array $params = [], $limit = null, $page= null)
    {
        //Retrieve by status
        //Retrieve by uniqueName
        //Retrieve by completed
        $allRooms = $this->twilio->video->v1->rooms->read($params, $limit, $page);

        $rooms = array_map(function($room) {
            return $room->uniqueName;
        }, $allRooms);

        return response()->json($rooms);
    }

    public function get($roomIdentifier)
    {
        //Return a specific room by unique name or Sid
        return $this->twilio->video->v1->rooms($roomIdentifier)
            ->fetch();
    }

    public function create($uniqueName = null, $type = 'group', array $params = [])
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

    public function name($roomName)
    {
        $this->roomName = $roomName;
        return $this;
    }

    public function callbackUrl($url)
    {
        $this->callbackUrl = $url;
        return $this;
    }

    public function peerToPeer()
    {
        $this->roomType = 'peer-to-peer';
        return $this;
    }

    public function group()
    {
        $this->roomType = 'group';
        return $this;
    }

    public function groupSmall()
    {
        $this->roomType = 'group-small';
        return $this;
    }

    public function type($roomType)
    {
        $this->roomType = $roomType;
        return $this;
    }

    //TODO - Extend on the object to enableRecording
    public function withRecording()
    {
        if ($this->roomType !== 'peer-to-peer') {
            $this->shouldRecord = true;
        }
        return $this;
    }

    public function complete($room)
    {
        return $this->twilio->video->v1->rooms($room)
            ->update("completed");
    }

    public function getParticipant($room, $name)
    {
        return $this->twilio->video->rooms($room)
            ->participants($name)
            ->fetch();
    }

    public function removeParticipant($room, $name)
    {
        return $this->twilio->video->v1->rooms($room)
            ->participants($name)
            ->update(array("status" => "disconnected"));;
    }

    public function getParticipants($room, $status = 'connected')
    {
        //status = connected or disconnected
        return $this->twilio->video->v1->rooms($room)
            ->participants->read([
                "status" => $status
            ]);
    }

    public function getRecordings($roomSid)
    {
        return $this->twilio->video->v1->recordings
            ->read(array(
                "groupingSid" => array($roomSid)
            ),
                20
            );
    }
}
