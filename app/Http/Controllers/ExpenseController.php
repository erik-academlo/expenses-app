<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\StoreExpenseUsingExcelRequest;
use App\Imports\ExpensesImport;
use App\Models\Expense;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $expenses = $user->expenses()->get();
        return Response($expenses, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreExpenseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExpenseRequest $request)
    {
        $expense = new Expense($request->all());
        $expense->user_id = auth()->user()->id;
        $expense->save();
        return Response($expense, 201);
    }

    public function storeUsingExcel(StoreExpenseUsingExcelRequest $request)
    {

        $excel = request()->file('file');
        Excel::import(new ExpensesImport, $excel);

        return Response(['message' => 'Expenses imported successfully'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
