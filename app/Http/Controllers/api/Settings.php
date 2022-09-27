<?php

namespace App\Http\Controllers\api;

use Validator;
use App\Http\Controllers\Controller;
use App\Models\Settings as ModelsSettings;
use Illuminate\Http\Request;

class Settings extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key'   => 'required',
            'value' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                $validator->errors()
            ], 400);
        }

        try {
            $settings = ModelsSettings::where('key', $request->key)->first();
            $settings->value = $request->value;
            $settings->save();

            return response()->json([
                'message' => 'Settings updated successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Settings update failed'
            ], 500);
        }
    }
}
