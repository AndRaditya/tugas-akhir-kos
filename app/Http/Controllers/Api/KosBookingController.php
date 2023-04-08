<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Services\KosBookingService;
use App\Services\NumberGeneratorService;
use DB;
use Illuminate\Support\Facades\Schema;

class KosBookingController extends Controller
{
    private $kosBookingService;
    private $numberGeneratorService;

    public function __construct(KosBookingService $kosBookingService, NumberGeneratorService $numberGeneratorService)
    {
        $this->kosBookingService = $kosBookingService;
        $this->numberGeneratorService = $numberGeneratorService;
    }

    public function getAll()
    {
        $result = $this->kosBookingService->getAll();

        return ResponseHelper::get($result);
    }

    public function get($id)
    {
        $result = $this->kosBookingService->get($id);
        return ResponseHelper::get($result);
    }

    public function create(request $request){
        return DB::transaction(function () use ($request){
            $data = $request->only(Schema::getColumnListing('kos_bookings'));
            $data['kode'] = $this->numberGeneratorService->generateNumber('BOOK');

            $kosBookingQuery = $this->kosBookingService->create($data);
            return ResponseHelper::create($kosBookingQuery);
        });
    }

    public function update($id, Request $request)
    {
        return DB::transaction(function () use ($id, $request) {
            $request = $request->only(Schema::getColumnListing('kos_bookings'));
            $request['updated_at'] = now();

            $container = $this->kosBookingService->update($id, $request);

            return ResponseHelper::put($container);
        });
    }

    public function delete($id)
    {
        $this->kosBookingService->delete($id);
        return ResponseHelper::delete();
    }
}