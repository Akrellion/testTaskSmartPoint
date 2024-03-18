<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use Illuminate\Support\Facades\Artisan;

class ReviewController extends Controller
{
    public function index(ReviewRequest $request) {
        $data = $request->validated();

        $page = $data['page'] ?? 1;
        $perPage = $data['per_page'] ?? 10;

        $reviews = Review::paginate($perPage, ['*'], 'page', $page);
        return view('review.index', compact('reviews'));
    }

    public function update() {
        Artisan::call('app:hotel-parser');

        return redirect()->route('review.index');
    }
}
