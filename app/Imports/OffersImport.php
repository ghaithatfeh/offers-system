<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Offer;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class OffersImport implements ToModel, WithHeadingRow
{
    public $categories;

    public function __construct()
    {
        $this->categories = Category::select(['id', 'name_en'])->get();
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $category = $this->categories->where('name_en', $row['category'])->first();
        return new Offer([
            'title' => $row['title'] ?? 'Offer Title',
            'expiry_date' => Carbon::instance(Date::excelToDateTimeObject($row['expiry_date'])),
            'price' => $row['price'] ?? 0,
            'category_id' => $category->id ?? 1,
            // 'category_id' => 1,
            'description' => $row['description'] ?? ($row['title'] ?? 'Offer Title'),
            'offer_type_id' => 1,
            'user_id' => auth()->id()
        ]);
    }
}
