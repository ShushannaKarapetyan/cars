<?php

namespace App\Http\Controllers;

use App\Car;
use App\Http\Requests\CarCreateRequest;
use App\Http\Requests\SearchRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CarsController extends Controller
{
    /**
     * @param SearchRequest $request
     * @return Factory|JsonResponse|View
     */
    public function index(SearchRequest $request)
    {
        if (request()->ajax()) {
            $cars = Car::query();

            if ($request->search) {
                $cars->where('make', 'LIKE', "%$request->search%");
            }

            $cars = $cars->paginate(10);

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
     * @param CarCreateRequest $request
     * @return array
     */
    public function store(CarCreateRequest $request)
    {
        Car::create($request->only([
                'make',
                'model',
                'year',
                'price',
            ]) + [
                'seller_id' => auth()->id(),
            ]);

        return ['message' => 'Car Created'];
    }
}
