<?php

namespace App\Http\Controllers;

use App\Car;
use App\Http\Requests\CarsRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CarsController extends Controller
{
    public function index(Request $request)
    {
        $cars = Car::query();

        if ($request->search) {
            $searchQuery = $request->search;
            $cars->where('make', 'LIKE', "%$searchQuery%");
        }

        $cars = $cars->orderByDesc('created_at')->paginate(10);

        if (request()->ajax()) {
            return response()->json([
                'cars' => $cars,
            ]);
        }

        return view('cars.index');
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        return view('cars.create');
    }

    /**
     * @param CarsRequest $request
     * @return array
     */
    public function store(CarsRequest $request)
    {
        $carsData = $request->only([
                'make',
                'model',
                'year',
                'price',
            ]) + [
                'seller_id' => auth()->id(),
            ];

        Car::create($carsData);

        return ["message" => 'Car Created'];
    }
}
