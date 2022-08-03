<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class notification
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $token;
    public $message;
    public function __construct($token,$message)
    {
        $this->token=$token;
        $this->message=$message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $SERVER_API_KEY='AAAACIU4Yhk:APA91bGBOKbSvvlUnOYHyUqfcmK6W-iXzn_qh9k636JxcqQsmV1kuGwHnIosditCThJkK4hAmNHjHDK6HjUjNVDto5XZjjpwWjFdRO6czT0IYMNx25ASXMIAB0RWlawPEWeCqfdkSNpE';

        $token_1 =$this->token;

        $data = [

            "registration_ids" => [
                $token_1
            ],

            "notification" => [

                "title" => 'One Planet',

                "body" => $this->message,

                "sound"=> "default"

            ],

        ];

        $dataString = json_encode($data);

        $headers = [

            'Authorization: key=' . $SERVER_API_KEY,

            'Content-Type: application/json',

        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

       dd ($response);
    }
}
