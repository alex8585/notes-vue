<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class telegramBot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram_bot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //Telegram::addCommand(\Telegram\Bot\Commands\HelpCommand::class);
        //$comands = Telegram::getCommands();
        //dd($comands);

        $this->lastId = 198098330;
        while (true) {
            sleep(1);
            $msgs = Telegram::getUpdates();
            //dd($msgs);
            foreach ($msgs as $msg) {

                if ($msg->update_id > $this->lastId) {
                    $this->respond($msg);
                    $this->lastId = $msg->update_id;
                }
            }
        }
    }



    public function respond($msg)
    {


        $chatid = $msg['message']['chat']['id'];
        $text = $msg['message']['text'];

        switch ($text) {
            case '/start':

                break;
            case '/menu':
                $this->showMenu($chatid);
                break;
            case '/website':

                break;
            case '/contact';

                break;
            default:
                $txt = 'I do not understand what you just said. Please choose an option';
                $this->sendMsg($txt, $chatid);
        }
    }

    public function sendMsg($txt, $chatid)
    {
        $response = Telegram::sendMessage([
            'chat_id' => $chatid,
            'text' => $txt
        ]);
    }

    public function showMenu($chatid)
    {
        $message = '';
        $message .=  '/website' . chr(10);
        $message .= '/contact' . chr(10);

        $response = Telegram::sendMessage([
            'chat_id' => $chatid,
            'text' => $message
        ]);
    }
}
