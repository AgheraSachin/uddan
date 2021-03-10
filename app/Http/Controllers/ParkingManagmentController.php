<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\ParkingLot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ParkingManagmentController extends Controller
{

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:parking_lots',
                'max_capacity_two_wheels' => 'required',
                'max_capacity_four_wheels' => 'required',
                'per_hour_charge_two_wheels' => 'required',
                'per_hour_charge_four_wheels' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }
            $result = ParkingLot::create($request->all());
            if ($result) {
                return response()->json(['status' => true, 'message' => 'parking premises register successfully.'], 200);
            } else {
                if ($result) {
                    return response()->json(['status' => true, 'message' => 'parking premises not register successfully.'], 200);
                }
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function book(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'vehicle_number' => 'required',
                'vehicle_type' => 'required',
                'parking_lot_id' => 'required|exists:parking_lots,id',
                'from' => 'required',
                'to' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }
            $charge = 0;
            $from = Carbon::parse($request->from);
            $to = Carbon::parse($request->to);
            $mins = $to->diffInMinutes($from, true);

            $count = Book::where('parking_lot_id', $request->parking_lot_id)->where('vehicle_type', $request->input('vehicle_type'))->where('from', '>=', $request->from)->where('from', '<=', $request->to)->count();
            $parkingLotData = ParkingLot::where('id', $request->parking_lot_id)->get();
            if ($request->vehicle_type == 'two') {
                if ($count >= $parkingLotData[0]->max_capacity_two_wheels) {
                    return response()->json(['status' => false, 'message' => "parking can't allocated as it is full"]);
                }
                $charge= ($mins/60)* $parkingLotData[0]->per_hour_charge_two_wheels;
            } else {
                if ($count >= $parkingLotData[0]->max_capacity_four_wheels) {
                    return response()->json(['status' => false, 'message' => "parking can't allocated as it is full"]);
                }
                $charge= ($mins/60)* $parkingLotData[0]->per_hour_charge_four_wheels;

            }


            $data = [
                'vehicle_number' => $request->input('vehicle_number'),
                'vehicle_type' => $request->input('vehicle_type'),
                'parking_lot_id' => $request->input('parking_lot_id'),
                'from' => $request->input('from'),
                'to' => $request->input('to'),
                'charge' => $charge,
            ];
            $result = Book::create($data);
            if ($result) {
                return response()->json(['status' => true, 'message' => 'parking allocated successfully.'], 200);
            } else {
                if ($result) {
                    return response()->json(['status' => true, 'message' => 'parking allocated successfully.'], 200);
                }
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function history(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'vehicle_number' => 'required|exists:book_history,vehicle_number',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }
            $history = Book::where('vehicle_number', $request->vehicle_number)->get();
            return response()->json(['status' => true, 'data' => $history], 200);

        } catch (\Exception $e) {
            dd($e);
        }
    }
}
