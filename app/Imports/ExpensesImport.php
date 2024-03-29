<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Expense;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ExpensesImport implements ToModel, WithStartRow
{
    protected $userId;
    protected $categories;
    public $categoryCounts;
    public function __construct(int $userId)
    {
        $this->userId = $userId;
        $this->categories = Category::all();
        $this->categoryCounts = [];
    }

    /**
    * @param array $row
    *
    * @return Model|Expense
    */
    public function model(array $row)
    {
        if (!$this->rowHasAllValues($row)) { return null; }
        $category = $this->matchCategory($row[3]);
        $this->countCategories($category->name);

        // Convert the Excel serial number to a date
        $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[2]);

        $expense = new Expense([
            'name' => $row[0],
            'amount' => $row[1],
            'date' => $date->format('Y-m-d'),
            'category_id' => $category->id,
        ]);
        $expense->user_id = $this->userId;

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

    private function matchCategory($categoryName)
    {
        $category = $this->categories->firstWhere('name', $categoryName);
        if ($category) {
            return $category;
        }
        return $this->categories->firstWhere('name', 'Sin categoría');
    }

    private function countCategories($category)
    {
        if (!isset($this->categoryCounts[$category])) {
            $this->categoryCounts[$category] = 0;
        }
        $this->categoryCounts[$category]++;
    }
}
