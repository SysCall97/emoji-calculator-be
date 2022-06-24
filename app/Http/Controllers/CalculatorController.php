<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CalculatorController extends Controller
{
    public function index(Request $request) {
        try {
            $request->validate([
                'input1' => 'required|numeric',
                'input2' => 'required|numeric',
                'operation' => 'required'
            ]);
            $code = 200;
            $message = null;
            $result = null;
            $input1 = $request->input1;
            $input2 = $request->input2;
            $operation = $request->operation;

            if($operation === "+") $result = $input1 + $input2;
            else if($operation === "-") $result = $input1 - $input2;
            else if($operation === "*") $result = $input1 * $input2;
            else if($operation === "/") {
                if($input2 == 0) {
                    $message = "Cannot divide by zero";
                    $code = 400;
                }
                else $result = $input1 / $input2;
            }
            return response()->json([
                'data' => $result,
                'errors' => ['message'=> [$message]]
            ], $code);
        } catch (ValidationException $exception) {
            return response()->json([
                'data'    => null,
                'errors' => $exception->errors(),
            ], 422);
        }
    }
}
