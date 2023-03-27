<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class QuotationController extends Controller
{
    private const FIXED_RATE     = 3;
    private const AGE_LOAD_TABLE = [
        [
            'min_age' => 18,
            'max_age' => 30,
            'load'    => 0.6,
        ],
        [
            'min_age' => 31,
            'max_age' => 40,
            'load'    => 0.7,
        ],
        [
            'min_age' => 41,
            'max_age' => 50,
            'load'    => 0.8,
        ],
        [
            'min_age' => 51,
            'max_age' => 60,
            'load'    => 0.9,
        ],
        [
            'min_age' => 61,
            'max_age' => 70,
            'load'    => 1,
        ],
    ];

    public function form(Request $request): View
    {
        if ($request->isMethod('post')) {
            $input        = $request->all();
            $input['age'] = implode(',', $input['age']);

            $response  = $this->store(new Request($input));
            $quotation = $response->getData(true);

            return view('quotation', $quotation);
        }

        return view('quotation');
    }

    public function store(Request $request): JsonResponse
    {
        $input = $request->except('_token');

        $ageLoadsSum  = 0;
        $ageLoadTable = new Collection(self::AGE_LOAD_TABLE);
        $startDate    = new Carbon($input['start_date']);
        $endDate      = new Carbon($input['end_date']);

        $tripLength = $startDate->diffInDays($endDate) + 1;

        foreach (explode(',', $input['age']) as $age) {
            $ageRanges   = $ageLoadTable->reject(function ($ageRange) use ($age) {
                return $ageRange['max_age'] < $age;
            });
            $ageLoadsSum += $ageRanges->first()['load'];
        }

        $input['total'] = self::FIXED_RATE * $tripLength * $ageLoadsSum;

        $quotation = Quotation::updateOrCreate($input);

        return response()->json([
            'total'        => round($quotation->total, 2),
            'currency_id'  => $quotation->currency,
            'quotation_id' => $quotation->id,
        ]);
    }
}
