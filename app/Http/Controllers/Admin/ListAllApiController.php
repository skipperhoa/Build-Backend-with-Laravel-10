<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ListAllApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {


       $search = $request->input('search');

    $routes = collect(Route::getRoutes())->map(function ($route) {
        return [
            'method' => implode('|', $route->methods()),
            'uri' => $route->uri(),
            'name' => $route->getName(),
            'action' => $route->getActionName(),
        ];
    });

    if ($search) {
        $routes = $routes->filter(function ($route) use ($search) {
            return str_contains(strtolower($route['uri']), strtolower($search))
                || str_contains(strtolower($route['name']), strtolower($search))
                || str_contains(strtolower($route['action']), strtolower($search));
        });
    }

    $perPage = 15;
    $page = $request->input('page', 1);
    $paginatedRoutes = new \Illuminate\Pagination\LengthAwarePaginator(
        $routes->forPage($page, $perPage),
        $routes->count(),
        $perPage,
        $page,
        ['path' => $request->url(), 'query' => $request->query()]
    );


    return view('api.list', compact('paginatedRoutes'));


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
