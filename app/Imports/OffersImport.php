<?php

namespace App\Imports;

use App\Models\Offer;
use App\Models\OfferTag;
use App\Models\Tag;
use App\Models\TargetArea;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\BeforeImport;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class OffersImport implements
    ToModel,
    WithHeadingRow,
    WithValidation,
    WithBatchInserts,
    WithEvents
{
    use RegistersEventListeners, Importable;

    private static $rows = 0;
    private static $excel_id;
    private static $all_tags = [];

    public function __construct($excel_id)
    {
        self::$excel_id = $excel_id;
    }

    public function model(array $row)
    {
        if (isset($row['tags']))
            self::$all_tags[] = explode("\n", $row['tags']);
        else
            self::$all_tags[] = null;

        ++self::$rows;

        return new Offer([
            'title' => ($row['title'] ?? $row['العنوان']) ?? 'Offer Title',
            'price' => $row['price'],
            'expiry_date' => $row['expiry_date'],
            'description' => $row['description'] ?? (($row['title'] ?? $row['العنوان']) ?? 'Offer Description'),
            'category_id' => request()->category_id,
            'offer_type_id' => 1,
            'user_id' => auth()->id(),
            'excel_id' => self::$excel_id
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
            '*.expiry_date' => 'nullable|after:yesterday',
            '*.tags' => 'nullable|string'
        ];
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public static function afterImport(AfterImport $event)
    {
        if (self::$rows == 0)
            throw ValidationException::withMessages(['file' => __('This file is empty !!')]);

        $offers = Offer::select('id')->where('excel_id', self::$excel_id)->get();
        foreach ($offers as $index => $offer) {
            $tags_data = [];
            $target_areas_data = [];
            if (self::$all_tags[$index] != null) {
                foreach (self::$all_tags[$index] as $tag_name) {
                    $tag = Tag::firstOrCreate(['name' => $tag_name]);
                    $tags_data[] = [
                        'offer_id' => $offer->id,
                        'tag_id' => $tag->id
                    ];
                }
                OfferTag::insert($tags_data);
            }
            if (request()->has('cities')) {
                foreach (request()->cities as $city)
                    $target_areas_data[] = [
                        'offer_id' => $offer->id,
                        'city_id' => $city
                    ];
                TargetArea::insert($target_areas_data);
            }
        }
    }
}
