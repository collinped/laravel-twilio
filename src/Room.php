<?php


namespace Collinped\TwilioVideo;

use Illuminate\Support\Str;

class Room extends TwilioVideo
{
    protected $shouldRecord = false;
    protected $roomType = 'peer-to-peer';
    protected $callbackUrl;
    protected $roomName;
    protected $roomSid;

    public function all(array $params = [], $limit = null, $page= null)
    {
        $allowedStatuses = [
            'in-progress',
            'completed'
        ];

        if (isset($params['status'])) {
            //Compare the values of the status to the allowedStatuses
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

    public function withRecording()
    {
        if ($this->roomType !== 'peer-to-peer') {
            $this->shouldRecord = true;
        }
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
            ->update(array("status" => "disconnected"));;
    }

    public function getParticipants($roomSid, $status = 'connected')
    {
        //status = connected or disconnected
        return $this->twilio->video->v1->rooms($roomSid)
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
