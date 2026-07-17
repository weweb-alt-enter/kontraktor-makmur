<?php

namespace App\Http\Controllers;

use App\Models\Testimoni;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimoni::with('portofolio')
            ->where('is_published', true)
            ->latest()
            ->paginate(12);

        return view('frontend.testimonials', compact('testimonials'));
    }
}