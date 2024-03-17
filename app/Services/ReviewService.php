<?php


namespace App\Services;


use App\Models\Review;
use DateTime;

class ReviewService
{

    public function save($reviews)
    {
        foreach ($reviews as $key => $review) {
            if (!$review['text_title'] && !$review['text_like'] && !$review['text_dislike']) {
                unset($reviews[$key]);
                continue;
            }

            $reviews[$key]['date_publication'] = $this->formatDate($review['date_publication']);
        }

        Review::truncate();
        Review::insert($reviews);
    }

    protected function formatDate($dateString)
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
