<?php

namespace App\Http\Controllers;
use App\Imports\CategoryCollection;
use App\Imports\Categoryİmporter;
use App\Jobs\addCategory;
use App\Models\category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;


class CategoryController extends Controller
{
    public function index()
    {
        addCategory::dispatch()->delay(now()->addMinutes(5));
        return response("sıraya alındınız");
    }
}
