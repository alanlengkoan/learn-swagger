<?php

namespace App\Http\Controllers\api;

use Validator;
use App\Http\Controllers\Controller;
use App\Models\Employees;
use App\Models\Overtimes;
use App\Models\Settings;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Overtime extends Controller
{
    /**
     * @OA\Patch(
     *     path="/settings",
     *     description="Settings",
     *     @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *        type="object",
     *        @OA\Property(property="key", type="string", example="overtime_method"),
     *        @OA\Property(property="value", type="integer"),
     *      ),
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Settings updated successfully",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Settings process failed",
     *     )
     * )
     */
    public function settings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key'   => 'required',
            'value' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => $validator->errors()
                ],
                400
            );
        }

        try {
            $settings = Settings::where('key', $request->key)->first();
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

    /**
     * @OA\Post(
     *     path="/employees",
     *     description="Employees",
     *     @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *        type="object",
     *        @OA\Property(property="name", type="string", example="alan"),
     *        @OA\Property(property="salary", type="integer", example=2000000),
     *      ),
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Employees process successfully",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Employees process failed",
     *     )
     * )
     */
    public function employees(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name'   => 'required|string|min:2|max:50|unique:employees',
            'salary' => 'required|numeric|min:2000000|max:10000000',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => $validator->errors()
                ],
                400
            );
        }

        try {
            Employees::updateOrCreate(
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

    /**
     * @OA\Post(
     *     path="/overtimes",
     *     description="Overtimes",
     *     @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *        type="object",
     *        @OA\Property(property="employee_id", type="integer", example=1),
     *        @OA\Property(property="date", type="string", example="2021-01-01"),
     *        @OA\Property(property="time_started", type="string", example="08:30"),
     *        @OA\Property(property="time_ended", type="string", example="17:00"),
     *      ),
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Overtimers process successfully",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Overtimes process failed",
     *     )
     * )
     */
    public function overtimes(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id'  => 'required|exists:employees,id',
            'date'         => 'required|date_format:Y-m-d|unique:overtimes,date,NULL,id,employee_id,' . $request->employee_id,
            'time_started' => 'required|date_format:H:i|before:time_ended',
            'time_ended'   => 'required|date_format:H:i|after:time_started',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => $validator->errors()
                ],
                400
            );
        }

        try {
            $overtimes               = new Overtimes();
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

    /**
     * @OA\Get(
     *     path="/overtime-pays/calculate",
     *     description="Overtime pays calculate",
     *     @OA\Parameter(
     *         name="month",
     *         in="query",
     *         description="For month and year",
     *         required=true,
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Overtimer pays calculate successfully",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Overtimer pays calculate failed",
     *     )
     * )
     */
    public function overtime_calculate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'month' => 'required|date_format:Y-m',
        ]);

        if ($validator->fails()) {
            return response()->json([
                [
                    'message' => $validator->errors()
                ]
            ], 400);
        }

        try {
            $parsing = Carbon::parse($request->month);

            $get_employees = Employees::get();

            $response = [];
            foreach ($get_employees as $employee) {
                $get_overtimes = Overtimes::where('employee_id', $employee->id)->whereMonth('created_at', '=', $parsing->format('m'))->whereYear('created_at', '=', $parsing->format('Y'))->get();

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

            return response()->json([
                'message' => $response
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Overtime calculate process failed'
            ], 500);
        }
    }
}
