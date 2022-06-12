<?php

namespace App\Imports;

use App\Models\Offer;
use Carbon\Carbon;
use Exception;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class OffersImport implements ToModel, WithHeadingRow, WithValidation, WithBatchInserts
{
    public function __construct($excel_id)
    {
        $this->excel_id = $excel_id;
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Offer([
            'title' => $row['title'] ?? 'Offer Title',
            'expiry_date' => Carbon::instance(Date::excelToDateTimeObject($row['expiry_date'])),
            'price' => $row['price'],
            'category_id' => 1,
            'description' => $row['description'] ?? ($row['title'] ?? 'Offer Description'),
            'offer_type_id' => 1,
            'user_id' => auth()->id(),
            'excel_id' => $this->excel_id
        ]);
    }

    public function rules(): array
    {
        return [
            '*.title' => 'required',
            '*.price' => 'required|numeric|min:1',
        ];
    }

    public function batchSize(): int
    {
        return 1000;
    }

}
