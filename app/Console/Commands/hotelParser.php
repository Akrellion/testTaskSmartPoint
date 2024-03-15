<?php

namespace App\Console\Commands;

use App\Models\Review;
use DateTime;
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

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $html = Http::get('https://101hotels.com/opinions/hotel/volzhskiy/gostinitsa_ahtuba.html#reviews-container');

        $crawler = new Crawler($html);

        $rows = [];
        $rows = $crawler->filter('.review-container')->each(function (Crawler $node) {
            $row = [
                'author' => $this->getInnerText($node->filter('.reviewer')),
                'rating' => $this->getInnerText($node->filter('.review-score')),
                'text_like' => $this->getInnerText($node->filter('.review-pro')),
                'text_dislike' => $this->getInnerText($node->filter('.review-contra')),
                'date_publication' => $this->toTimestamp($this->getInnerText($node->filter('.review-date')))
            ];
            if (!$row['text_like'] && !$row['text_dislike']) {
                return null;
            }

            return $row;
        });
        $rows = array_filter($rows);

        Review::insert($rows);
    }


    protected function getInnerText($selector)
    {
        return $selector->count() ? $selector->innerText() : null;
    }


    protected function toTimestamp($dateString)
    {
        $mohthRelations = [
            'янв'  => '01',
            'февр' => '02',
            'март' => '03',
            'апр'  => '04',
            'май'  => '05',
            'июнь' => '06',
            'июль' => '07',
            'авг'  => '08',
            'сент' => '09',
            'окт'  => '10',
            'нояб' => '11',
            'дек'  => '12'
        ];
        $dateArray = explode(' ', $dateString);
        $dateArray[1] = $mohthRelations[mb_strtolower($dateArray[1])];
        $dateString = implode('.', $dateArray);

        $dateTime = new DateTime($dateString);

        return $dateTime->format('Y-m-d');
    }
}
