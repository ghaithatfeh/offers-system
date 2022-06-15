<?php

namespace App\Imports;

use App\Models\Offer;
use Carbon\Carbon;
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
            'price' => $row['price'],
            'expiry_date' => $row['expiry_date'],
            'description' => $row['description'] ?? ($row['title'] ?? 'Offer Description'),
            'category_id' => 1,
            'offer_type_id' => 1,
            'user_id' => auth()->id(),
            'excel_id' => $this->excel_id
        ]);
    }

    public function prepareForValidation($data, $index)
    {
        $data['expiry_date'] = isset($data['expiry_date']) ? Carbon::instance(Date::excelToDateTimeObject($data['expiry_date'])) : null;
        return $data;
    }

    public function rules(): array
    {
        return [
            '*.title' => 'required',
            '*.price' => 'required|numeric|min:1',
            '*.expiry_date' => 'nullable|after:yesterday'
        ];
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
