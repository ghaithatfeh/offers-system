<?php

namespace App\Http\Controllers;

use App\Imports\OffersImport;
use App\Models\ExcelFile;
use App\Models\Offer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

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
            return view('excel.import');

        elseif ($request->isMethod('post')) {
            $request->validate([
                // 'file' => 'required|mimes:xlsx|max:2048'
            ]);
            $file = $request->file('file');
            $file_name = time() . '_' . $file->getClientOriginalName();

            $row_count = count(Excel::toArray(new OffersImport(1), $file)[0]);
            if ($row_count == 0)
                throw ValidationException::withMessages(['File is empty!!']);

            try {
                $excel = ExcelFile::create(['name' => $file_name, 'user_id' => auth()->id()]);
                Excel::import(new OffersImport($excel->id), $file);
                $file->move('uploaded_images/excel_files', $file_name);
            } catch (ValidationException $e) {
                $excel->delete();
                return back()->withErrors($e->errors());
            }

            return redirect('/bulk-offers');
        }
    }

    public function destroy(ExcelFile $bulk_offer)
    {
        if (file_exists('uploaded_images/excel_files/' . $bulk_offer->name))
            unlink('uploaded_images/excel_files/' . $bulk_offer->name);
        $bulk_offer->delete();
        return redirect('/bulk-offers');
    }
}
