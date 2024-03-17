<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index() {

        $page = $data['page'] ?? 1;
        $perPage = $data['per_page'] ?? 10;

        $reviews = Review::paginate($perPage, ['*'], 'page', $page);
        return view('review.index', compact('reviews'));
    }

    public function update() {

        return view('index');
    }
}
