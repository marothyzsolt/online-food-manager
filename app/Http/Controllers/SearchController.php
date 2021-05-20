<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SearchController extends Controller
{
    public function index(Request $request): Response
    {
        $results = Item::where('id', '>', 0);
        if ($searchString = $request->get('search')) {
            $results = $results->where(function ($q) use ($searchString) {
                $q->where('name', 'LIKE', '%' . $searchString . '%')
                ->orWhere('description', 'LIKE', '%' . $searchString . '%');
            });
        }
        if ($restaurantId = $request->get('restaurant')) {
            $results->where('restaurant_id', $restaurantId);
        }

        $results = $results->get();

        return $this->view('search.search', compact('results', 'searchString', 'restaurantId'));
    }
}
