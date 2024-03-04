<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Expense;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ExpensesImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return Model|Expense
    */
    public function model(array $row)
    {
        if (!$this->rowHasAllValues($row)) { return null; }

        $categoryId = Category::where('name', 'Sin categoría')->first()->id;

        // Convert the Excel serial number to a date
        $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[2]);

        $expense = new Expense([
            'name' => $row[0],
            'amount' => $row[1],
            'date' => $date->format('Y-m-d'),
            'category_id' => $categoryId,
        ]);

        $expense->user_id = auth()->user()->id;

        return $expense;
    }
    public function startRow(): int
    {
        return 2;
    }

    // Verify if the values exist at indices 0, 1, and 2
    private function rowHasAllValues($row) :bool
    {
        if (!isset($row[0]) || !isset($row[1]) || !isset($row[2])) {
            return false;
        }
        return true;
    }
}
