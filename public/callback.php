<?php // callback.php
define("LINE_MESSAGING_API_CHANNEL_SECRET", 'ec68c63b493064bedb0c8eccf7f328d6');
define("LINE_MESSAGING_API_CHANNEL_TOKEN", 'DqC0E6bwB9GJjUsZdCdyhtC1b6KXlp/DXoBnzPbt1/v+z0p0FCzHk5XAbO9nm2HQL8AoawkXmbJmMabvXfKrdJeueUzpp27IKe8kDox3Y4U2hjOjsM2l32hIc47h7TrPHrhtfeRQyXLwALD3yP1EJAdB04t89/1O/w1cDnyilFU=');

require __DIR__."/../vendor/autoload.php";

$bot = new \LINE\LINEBot(
    new \LINE\LINEBot\HTTPClient\CurlHTTPClient(LINE_MESSAGING_API_CHANNEL_TOKEN),
    ['channelSecret' => LINE_MESSAGING_API_CHANNEL_SECRET]
);

$signature = $_SERVER["HTTP_".\LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
$body = file_get_contents("php://input");

$events = $bot->parseEventRequest($body, $signature);

foreach ($events as $event) {
    if ($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage) {
        $reply_token = $event->getReplyToken();
        $text = $event->getText();
        $bot->replyText($reply_token, $text);
        $text = $event->getUserId();
        $bot->replyText($reply_token, $text);
    }
}

echo "OK";