@extends('layouts.main')
@section('content')
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Дата</th>
            <th scope="col">Автор</th>
            <th scope="col">Рейтинг</th>
            <th scope="col">Текст отзыва</th>
        </tr>
        </thead>
        <tbody>
        @foreach($reviews as $review)
            <tr>
                <td>{{ $review->date_publication }}</td>
                <td>{{ $review->author }}</td>
                <td>{{ $review->rating }}</td>
                <td>
                    <div>
                        {{ $review->text_title }}
                    </div>
                    <div>
                        {{ $review->text_like }}
                    </div>
                    <div>
                        {{ $review->text_dislike }}
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="mt-3">
        {{ $reviews->withQueryString()->links() }}
    </div>
@endsection
