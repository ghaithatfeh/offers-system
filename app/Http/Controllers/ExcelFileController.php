<?php

namespace App\Http\Controllers;

use App\Imports\OffersImport;
use App\Models\Category;
use App\Models\City;
use App\Models\ExcelFile;
use App\Models\Offer;
use App\Models\OfferTag;
use App\Models\Tag;
use App\Models\TargetArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class ExcelFileController extends Controller
{
    public function index()
    {
        $files = ExcelFile::where('user_id', auth()->id())->orderByDesc('id')->paginate(10);
        return view('excel.index', ['files' => $files]);
    }

    public function show(ExcelFile $bulk_offer)
    {
        if ($bulk_offer->user->id != auth()->id())
            return abort(403);

        $offers = DB::table('offers')->where('excel_id', $bulk_offer->id)->paginate(10);
        return view('excel.view', [
            'offers' => $offers,
            'excel_file' => $bulk_offer
        ]);
    }

    public function importFromExcel(Request $request)
    {
        if ($request->isMethod('get'))
            return view('excel.import', [
                'categories' => Category::where('status', 1)->get(),
                'cities' => City::where('status', 1)->get(),
                'tags' => Tag::all()
            ]);

        elseif ($request->isMethod('post')) {
            $request->validate([
                'category_id' => 'required',
                'file' => 'required|mimes:xlsx|max:2048',
            ]);
            $file = $request->file('file');
            $file_name = time() . '_' . $file->getClientOriginalName();

            $row_count = count(Excel::toArray(new OffersImport(), $file)[0]);
            if ($row_count == 0)
                throw ValidationException::withMessages(['file' => __('This file is empty !!')]);

            try {
                $excel = ExcelFile::create(['name' => $file_name, 'user_id' => auth()->id()]);
                Excel::import(new OffersImport($excel->id), $file);
                $file->move('uploaded_images/excel_files', $file_name);
            } catch (ValidationException $e) {
                $excel->delete();
                return back()->with('file', $e->errors());
            }

            if ($request->has('cities') || $request->has('tags')) {
                $offers_ids = Offer::select('id')->where('excel_id', $excel->id)->pluck('id')->toArray();
                foreach ($offers_ids as $offer_id) {
                    $target_areas_data = [];
                    $tags_data = [];
                    if ($request->has('cities')) {
                        foreach ($request->cities as $city)
                            $target_areas_data[] = ['offer_id' => $offer_id, 'city_id' => $city];
                        TargetArea::insert($target_areas_data);
                    }
                    if ($request->has('tags')) {
                        foreach ($request->tags as $tag)
                            $tags_data[] = ['offer_id' => $offer_id, 'tag_id' => $tag];
                        OfferTag::insert($tags_data);
                    }
                }
            }

            return redirect('/bulk-offers');
        }
    }

    public function destroy(ExcelFile $bulk_offer)
    {
        if (auth()->id() != $bulk_offer->user_id)
            return abort(403);

        File::delete('uploaded_images/excel_files/' . $bulk_offer->name);

        foreach ($bulk_offer->offers as $offer)
            foreach ($offer->images as $image)
                File::delete('uploaded_images/' . $image->name);

        $bulk_offer->delete();
        return redirect('/bulk-offers');
    }
}
