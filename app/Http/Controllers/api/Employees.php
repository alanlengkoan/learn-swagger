<?php

namespace App\Http\Controllers\api;

use Validator;
use App\Http\Controllers\Controller;
use App\Models\Employees as ModelsEmployees;
use Illuminate\Http\Request;

class Employees extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'   => 'required|string|min:2|max:50|unique:employees',
            'salary' => 'required|numeric|min:2000000|max:10000000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                $validator->errors()
            ], 400);
        }

        try {
            ModelsEmployees::updateOrCreate(
                [
                    'id' => $request->id,
                ],
                [
                    'name'   => $request->name,
                    'salary' => $request->salary,
                ]
            );

            return response()->json([
                'message' => 'Employees process successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Employees process failed'
            ], 500);
        }
    }
}
