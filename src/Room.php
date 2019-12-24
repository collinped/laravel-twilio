<?php


namespace Collinped\TwilioVideo;


use Illuminate\Support\Str;

class Room extends TwilioVideo
{
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

    public function get($identifier)
    {
        //Return a specific room by unique name or Sid
        return $this->twilio->video->v1->rooms($identifier)
            ->fetch();
    }

    public function create($uniqueName, $type = 'group', array $params = [])
    {
        $params['uniqueName'] = ($uniqueName ?: Str::random(40));
        $params['type'] = $type;

        return $this->twilio->video->v1->rooms
            ->create($params);
    }

    //TODO - Extend on the object to enableRecording
    public function withRecording()
    {
        //Check that the type is group or group-small
        //Enable recording
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
