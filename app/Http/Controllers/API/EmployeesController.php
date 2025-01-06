<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Employees;
use App\Http\Resources\EmployeesResource;
use App\Http\Controllers\API\BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;

class EmployeesController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $employees = Employees::all();
        return $this->sendResponse(EmployeesResource::collection($employees), 'Employees retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $request->validate([
            'employees' => 'required|file|mimes:csv,txt'
        ]);

        $file_path = $request->file('employees')->getRealPath();
        LazyCollection::make(function () use ($file_path) {
                    $handle = fopen($file_path, 'r');

                    while (($line = fgetcsv($handle, 4096)) !== false) {
                        $dataString = implode(", ", $line);
                        $row = explode(',', $dataString); 
                        yield $row;
                    }

                    fclose($handle);
                })
                ->skip(1)
                ->chunk(1000)
                ->each(function (LazyCollection $chunk) {

                    $records = $chunk->map(function ($row) {
//                        echo date('H:i:s', strtotime($row[8]));
//                        print_r($row);
//                        if($row[0]==178566){
//                            exit;
//                        }
                        
                                return [
                            "emp_id" => $row[0],
                            "prefix" => $row[1],
                            "first_name" => $row[2],
                            "middle_initial" => $row[3],
                            "last_name" => $row[4],
                            "gender" => $row[5],
                            "email" => $row[6],
                            "dob" => date('Y-m-d', strtotime($row[7])),
                            "tob" => date('H:i:s', strtotime($row[8])),
                            "age" => $row[9],
                            "doj" => date('Y-m-d', strtotime($row[10])),
                            "age_in_company" => $row[11],
                            "phone_no" => $row[12],
                            "place" => $row[13],
                            "country" => $row[14],
                            "city" => $row[15],
                            "zip" => $row[16],
                            "region" => $row[17],
                            "username" => $row[18]
                                ];
                            })->toArray();
//print_R($records[1]);exit;
                    DB::table('employees')->insertOrIgnore($records);
                });

        return $this->sendResponse('', 'Employees data imported successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $employee = Employees::where('emp_id', $id)->get();

        if (is_null($employee)) {
            return $this->sendError('Employee not found.');
        }

        return $this->sendResponse(new EmployeesResource($employee), 'Employee retrieved successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employees $employee) {
        $employee->delete();
        return $this->sendResponse([], "Employee's detail deleted successfully.");
    }
}
