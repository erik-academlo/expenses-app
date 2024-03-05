<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\StoreExpenseUsingExcelRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Jobs\ImportExpensesExcelJob;
use App\Models\Expense;
use Illuminate\Http\Request;

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
        $excel = $request->file('file')->store('excels');
        ImportExpensesExcelJob::dispatch($excel, auth()->user());

        return Response(['message' => 'Importing expenses...'], 201);
    }

    public function count()
    {
        // improves performance querying the database instead of using the Eloquent ORM and loading all the records into memory
        $user = auth()->user();
        $result = $user->expenses()
            ->join('categories', 'expenses.category_id', '=', 'categories.id')
            ->selectRaw('categories.name, COUNT(*) as total')
            ->groupBy('categories.name')
            ->pluck('total', 'categories.name');
        return Response($result, 200);
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
     * @param  UpdateExpenseRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateExpenseRequest $request, $id)
    {
        $expense = Expense::findOrFail($id);
        $expense->update($request->all());
        return Response($expense, 200);
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
