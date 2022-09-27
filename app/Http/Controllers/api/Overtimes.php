<?php

namespace App\Http\Controllers\api;

use Validator;
use App\Http\Controllers\Controller;
use App\Models\Employees;
use App\Models\Overtimes as ModelsOvertimes;
use App\Models\Settings;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Overtimes extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id'  => 'required|exists:employees,id',
            'date'         => 'required|date_format:Y-m-d|unique:overtimes,date,NULL,id,employee_id,' . $request->employee_id,
            'time_started' => 'required|date_format:H:i|before:time_ended',
            'time_ended'   => 'required|date_format:H:i|after:time_started',
        ]);

        if ($validator->fails()) {
            return response()->json([
                $validator->errors()
            ], 400);
        }

        try {
            $overtimes               = new ModelsOvertimes();
            $overtimes->employee_id  = $request->employee_id;
            $overtimes->date         = $request->date;
            $overtimes->time_started = $request->time_started;
            $overtimes->time_ended   = $request->time_ended;
            $overtimes->save();

            return response()->json([
                'message' => 'Overtimes process successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Overtimes process failed'
            ], 500);
        }
    }

    public function overtime_calculate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'month' => 'required|date_format:Y-m',
        ]);

        if ($validator->fails()) {
            return response()->json([
                $validator->errors()
            ], 400);
        }

        $parsing = Carbon::parse($request->month);

        $get_employees = Employees::get();

        $response = [];
        foreach ($get_employees as $employee) {
            $get_overtimes = ModelsOvertimes::where('employee_id', $employee->id)->whereMonth('created_at', '=', $parsing->format('m'))->whereYear('created_at', '=', $parsing->format('Y'))->get();

            $overtimes = [];
            foreach ($get_overtimes as $overtime) {
                $startTime         = Carbon::parse($overtime->time_started);
                $endTime           = Carbon::parse($overtime->time_ended);
                $diffMinutes       = $endTime->diffInMinutes($startTime);
                $diffHours         = $endTime->diffInHours($startTime);
                $overtime_duration = ($diffMinutes > 105) ? $diffHours : floor($diffHours);

                $overtimes[] = [
                    'id'                => $overtime->id,
                    'date'              => $overtime->date,
                    'time_started'      => $overtime->time_started,
                    'time_ended'        => $overtime->time_ended,
                    'overtime_duration' => $overtime_duration,
                ];
            }

            $get_overtime_method = Settings::where('key', 'overtime_method')
                ->join('references', 'references.id', '=', 'settings.value')
                ->first();


            $search     = ['salary', 'overtime_duration_total'];
            $replace    = ['$salary', '$overtime_duration_total'];
            $expression = str_replace($search, $replace, $get_overtime_method->expression);

            $salary                  = $employee->salary;
            $overtime_duration_total = array_sum(array_column($overtimes, 'overtime_duration'));

            $response[] = [
                'id'                      => $employee->id,
                'name'                    => $employee->name,
                'salary'                  => $employee->salary,
                'overtimes'               => $overtimes,
                'overtime_duration_total' => $overtime_duration_total,
                'amount'                  => eval('return ' . $expression . ';'),
            ];
        }

        return response()->json($response, 200);
    }
}
