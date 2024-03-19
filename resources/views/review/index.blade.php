@extends('layouts.main')
@section('content')
    <div>
        <a class="btn btn-primary mb-3 mt-3" href="{{ route('review.update') }}">Обновить отзывы</a>
    </div>
    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger text-nowrap overflow-hidden">{{ session('error') }}</div>
        @endif
    </div>
    <table class="table">
        <thead>
        <tr>
            <th class="text-lg-center" scope="col">Дата</th>
            <th class="text-lg-center" scope="col">Автор</th>
            <th class="text-lg-center" scope="col">Рейтинг</th>
            <th scope="col">Текст отзыва</th>
        </tr>
        </thead>
        <tbody>
        @foreach($reviews as $review)
            <tr>
                <td>{{ \Carbon\Carbon::parse($review->date_publication)->format('d.m.Y')}}</td>
                <td class="text-lg-center">{{ $review->author }}</td>
                <td class="text-lg-center">{{ $review->rating }}</td>
                <td>
                    <div class="mb-2">
                        <b>{{ $review->text_title }}</b>
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
