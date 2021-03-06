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
        if ($request->isMethod('get')) {
            return view('excel.import', [
                'categories' => Category::where('status', 1)->get(),
                'cities' => City::where('status', 1)->get(),
            ]);
        } elseif ($request->isMethod('post')) {
            $request->validate([
                'category_id' => 'required',
                'file' => 'required|mimes:xlsx|max:2048',
            ]);
            $file = $request->file('file');
            $file_name = time() . '_' . $file->getClientOriginalName();

            try {
                $excel = ExcelFile::create(['name' => $file_name, 'user_id' => auth()->id()]);
                $import = new OffersImport($excel->id);
                $import->import($file);
                $file->move('uploaded_images/excel_files', $file_name);
            } catch (ValidationException $e) {
                $excel->delete();
                return back()->with('file', $e->errors());
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
