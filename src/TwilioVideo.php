<?php

namespace Collinped\Twilio;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TwilioVideo
{
    protected bool $shouldRecord = false;

    protected string $roomType = 'peer-to-peer';

    protected ?string $statusCallback = null;

    protected string $roomName;

    protected string $roomSid;

    protected string $participantSid;

    private \Twilio\Rest\Client $twilio;

    /**
     * @param  \Twilio\Rest\Client  $twilio
     */
    public function __construct(Client $twilio)
    {
        $this->twilio = $twilio;
    }

    public function sdk(): \Twilio\Rest\Video
    {
        return $this->twilio->video;
    }

    public function exists($params = [])
    {
        $videoRoom = $this->twilio->video->v1->rooms->read($params);

        if (! empty($videoRoom)) {
            return false;
        }

        return true;
    }

    public function all(array $params = [], $limit = null, $page = null)
    {
        $allowedStatuses = [
            'in-progress',
            'completed',
        ];

        if (isset($params['status'])) {
            if (! in_array($params['status'], $allowedStatuses)) {
                $params['status'] = null;
            }
        }

        if (isset($params['name'])) {
            $params['uniqueName'] = $params['name'];
        }

        $allRooms = $this->twilio->video->v1->rooms->read($params, $limit, $page);

        $rooms = array_map(function ($room) {
            return $room->uniqueName;
        }, $allRooms);

        return response()->json($rooms);
    }

    public function get($roomIdentifier = null)
    {
        if ($roomIdentifier) {
            $this->room = $roomIdentifier;
        }

        return $this->twilio->video->v1->rooms($this->room)
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
        if ($this->statusCallback) {
            $params['statusCallback'] = $this->statusCallback;
        }

        $params['enableTurn'] = true;

        return $this->twilio->video->v1->rooms
            ->create($params);
    }

    public function complete($roomSid)
    {
        return $this->twilio->video->v1->rooms($roomSid)
            ->update('completed');
    }

    public function getParticipant()
    {
        return $this->twilio->video->rooms($this->roomSid)
            ->participants($this->participantSid)
            ->fetch();
    }

    public function getParticipantRules()
    {
        return $this->twilio->video
            ->rooms($this->roomSid)
            ->participants($this->participantSid)
            ->subscribeRules->fetch();
    }

    public function updateParticipantRules(array $rules = [])
    {
        if (empty($rules)) {
            $rules = [
                ['type' => 'include', 'all' => true],
            ];
        }

        return $this->twilio->video
            ->rooms($this->roomSid)
            ->participants($this->participantSid)
            ->subscribeRules->update([
                'rules' => $rules,
            ]);
    }

    public function getParticipantTrackList()
    {
        return $this->twilio->video
            ->rooms($this->roomSid)
            ->participants($this->participantSid)
            ->subscribeRules
            ->read();
    }

    public function getParticipantTrack($trackSid)
    {
        return $this->twilio->video
            ->rooms($this->roomSid)
            ->participants($this->participantSid)
            ->subscribedTracks($trackSid)
            ->fetch();
    }

    public function removeParticipant()
    {
        return $this->twilio->video->v1
            ->rooms($this->roomSid)
            ->participants($this->participantSid)
            ->update([
                'status' => 'disconnected',
            ]);
    }

    public function getParticipants($roomSid, $status = 'connected')
    {
//        if ($status !== 'connected' || $status !== 'disconnected') {
//            // Throw an error
//        }
        return $this->twilio->video->v1->rooms($roomSid)
            ->participants->read([
                'status' => $status,
            ]);
    }

    public function getRecording($recordingSid)
    {
        return $this->twilio->video->v1
            ->recordings($recordingSid)
            ->fetch();
    }

    public function getRecordingMedia($recordingSid)
    {
        $client = new Client();
        $uri = "https://video.twilio.com/v1/Recordings/$recordingSid/Media";
        $response = $client->request('GET', $uri);
        $mediaLocation = $response->getContent()['redirect_to'];
        $media_content = file_get_contents($mediaLocation);
        Storage::disk('local')->put($recordingSid.'.mkv', $media_content);
        $path = Storage::disk('local')->url('app/'.$recordingSid.'.mkv');

        return response()->download($path);
    }

    public function deleteRecording($recordingSid)
    {
        return $this->twilio->video->v1->recordings($recordingSid)
            ->delete();
    }

    /**
     * This feature is only available in Twilio Enterprise Edition. For further information contact the Twilio sales team.
     *
     * @return mixed
     */
    public function getRecordingSettings()
    {
        return $this->twilio->video->v1->getRecordingSettings()
            ->fetch();
    }

    /**
     * This feature is only available in Twilio Enterprise Edition. For further information contact the Twilio sales team.
     * https://www.twilio.com/docs/video/api/external-s3-recordings
     * https://www.twilio.com/docs/video/api/encrypted-recordings
     *
     * @param  array  $settings
     * @return mixed
     */
    public function setAwsRecordingSettings($name, $settings = [])
    {
        return  $this->twilio->video->v1->recordingSettings()
            ->create($name, $settings);
    }

    public function getCompositions()
    {
        return $this->twilio->video->compositions
            ->read([
                'roomSid' => $this->roomSid,
            ]);
    }

    public function getCompletedCompositions()
    {
        $compositionArray = [];
        $compositionArray['status'] = 'completed';
        if ($this->roomSid) {
            $compositionArray['roomSid'] = $this->roomSid;
        }

        return $this->twilio->video->compositions
            ->read($compositionArray);
    }

    public function deleteComposition($compositionSid)
    {
        return $this->twilio->video
            ->compositions($compositionSid)
            ->delete();
    }

    public function composeParticipantMedia($includeAllAudio = false)
    {
        return $this->twilio->video->compositions->create($this->roomSid, [
            'audioSources' => ($includeAllAudio ? '*' : $this->participantSid),
            'videoLayout' => [
                'single' => [
                    'video_sources' => [$this->participantSid],
                ],
            ],
            'statusCallback' => $this->statusCallback,
            'format' => 'mp4',
        ]);
    }

    public function composeRoomMediaGrid()
    {
        return $this->twilio->video->compositions->create($this->roomSid, [
            'audioSources' => '*',
            'videoLayout' => [
                'grid' => [
                    'video_sources' => ['*'],
                ],
            ],
            'statusCallback' => $this->statusCallback,
            'format' => 'mp4',
        ]);
    }

    public function room($roomSid)
    {
        $this->roomSid = $roomSid;

        return $this;
    }

    public function participant($participantSid)
    {
        $this->participantSid = $participantSid;

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
     * @param  string  $statusCallback
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
            // error that peer this is not allowed in this mode
            return $this;
        } else {
            $this->shouldRecord = true;
        }

        return $this;
    }

    public function withoutRecording()
    {
        $this->shouldRecord = false;

        return $this;
    }
}
