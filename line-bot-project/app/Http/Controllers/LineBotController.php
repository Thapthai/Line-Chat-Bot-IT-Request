<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use LINE\Clients\MessagingApi\Api\MessagingApiApi;
use LINE\Clients\MessagingApi\Configuration;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use LINE\Clients\MessagingApi\ApiException;
use LINE\Clients\MessagingApi\Model\ReplyMessageRequest;
use LINE\Clients\MessagingApi\Model\TextMessage;


class LineBotController extends Controller
{
    protected $messagingApi;
    protected $httpClient;

    public function __construct()
    {
        $config = new Configuration();
        $config->setAccessToken(env('LINE_BOT_CHANNEL_ACCESS_TOKEN'));
        $this->messagingApi = new MessagingApiApi(client: new Client(), config: $config);
        $this->httpClient = new Client();
    }

    public function webhook(Request $request)
    {
        $events = $request->input('events', []);

        foreach ($events as $event) {
            $messageType = $event['message']['type'];
            if ($event['type'] == 'message') {
                $userText = $event['message']['text'] ?? null;
                $replyToken = $event['replyToken'];
                $line_id = $event['source']['userId'];

                if ($userText == 'แจ้งปัญหา') {

                    Ticket::create([
                        'title' => 'แจ้งปัญหา',
                        'line_id' => $line_id,
                        'status' => 'open'
                    ]);

                    $botMessage = new TextMessage([
                        'type' => 'text',
                        'text' => "เริ่มการแจ้งปัญหา กรุณาส่งข้อมูลหรือรูปภาพ (พิมพ์ 'สิ้นสุด' เพื่อจบ)"
                    ]);

                    $request = new ReplyMessageRequest([
                        'replyToken' => $replyToken,
                        'messages' => [$botMessage],
                    ]);

                    $this->messagingApi->replyMessage($request);
                }
            }

            $checkTicket = Ticket::where('line_id', $line_id)->where('status', 'open')->first();

            if ($checkTicket) {
                if ($messageType === 'image') {
                    $messageId = $event['message']['id'];
                    $imageUrl = "https://api-data.line.me/v2/bot/message/{$messageId}/content";

                    $response = $this->httpClient->get($imageUrl, [
                        'headers' => [
                            'Authorization' => 'Bearer ' . env('LINE_BOT_CHANNEL_ACCESS_TOKEN')
                        ]
                    ]);

                    $imageData = $response->getBody()->getContents();
                    $fileName = 'user_image_' . $messageId . '.jpg';
                    $path_img = "public/line_images/{$fileName}";
                    Storage::put($path_img, $imageData);

                    // อัปเดต path ของรูปภาพลงในฐานข้อมูล
                    $checkTicket->update([
                        'path_img' => $path_img
                    ]);

                    $botMessage = new TextMessage([
                        'type' => 'text',
                        'text' => "บันทึกรูปภาพแล้ว 'สิ้นสุด'"
                    ]);

                    $request = new ReplyMessageRequest([
                        'replyToken' => $replyToken,
                        'messages' => [$botMessage],
                    ]);

                    $this->messagingApi->replyMessage($request);
                } elseif ($messageType === 'text') {

                    if ($userText === 'สิ้นสุด') {
                        $checkTicket->update(['status' => 'end']);

                        $botMessage = new TextMessage([
                            'type' => 'text',
                            'text' => "จบการทำงานแล้ว ขอบคุณที่แจ้งปัญหา"
                        ]);

                        $request = new ReplyMessageRequest([
                            'replyToken' => $replyToken,
                            'messages' => [$botMessage],
                        ]);

                        $this->messagingApi->replyMessage($request);
                    } else {
                        $checkTicket->update(['description' => $userText]);

                        $botMessage = new TextMessage([
                            'type' => 'text',
                            'text' => "รับข้อความแล้ว: " . $userText
                        ]);

                        $request = new ReplyMessageRequest([
                            'replyToken' => $replyToken,
                            'messages' => [$botMessage],
                        ]);

                        $this->messagingApi->replyMessage($request);
                    }
                }
            } else {

                $botMessage = new TextMessage([
                    'type' => 'text',
                    'text' => "ยังไม่มีการแจ้งปัญหา กรุณาพิมพ์ 'แจ้งปัญหา' เพื่อเริ่มต้น"
                ]);

                $request = new ReplyMessageRequest([
                    'replyToken' => $replyToken,
                    'messages' => [$botMessage],
                ]);

                $this->messagingApi->replyMessage($request);
            }
        }

        return response()->json('OK');
    }
}
