<?php

namespace App\Console\Commands;

use App\Services\ReviewService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class hotelParser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:hotel-parser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Take comment data';

    protected ReviewService $service;

    public function __construct(ReviewService $service)
    {
        parent::__construct();

        $this->service = $service;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $html = Http::get('https://101hotels.com/opinions/hotel/volzhskiy/gostinitsa_ahtuba.html#reviews-container');

            $crawler = new Crawler($html);

            $rows = $crawler->filter('.review-container')->each(function (Crawler $node) {
                $row = [
                    'author' => $this->getInnerText($node->filter('.reviewer')),
                    'rating' => $this->getInnerText($node->filter('.review-score')),
                    'text_title' => $this->getInnerText($node->filter('.review-title')),
                    'text_like' => $this->getInnerText($node->filter('.review-pro')),
                    'text_dislike' => $this->getInnerText($node->filter('.review-contra')),
                    'date_publication' => $this->getInnerText($node->filter('.review-date'))
                ];

                return $row;
            });

            $this->service->save($rows);

            $successText = 'Обновление отзывов выполнено';
            $this->info($successText);
            session()->flash('message', $successText);

        } catch (Exception $e) {
            $errorText = 'Ошибка выполнения скрипта: ' . $e->getMessage();
            $this->info($errorText);
            session()->flash('error', $errorText);
        }

    }

    protected function getInnerText($selector)
    {
        return $selector->count() ? $selector->innerText() : null;
    }
}
