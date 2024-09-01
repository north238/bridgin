<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use League\Csv\Statement;

class CsvFileUploadController extends Controller
{
    public function upload(Request $request)
    {
        $file = $request->file('upload-file');
        $fileSize = $file->getSize();
        $mineType = $file->getMimeType();
        $extension = $file->getClientOriginalExtension();
        $fileMTime = date("Ymd_His", $file->getMTime());

        if (empty($file)) {
            return redirect()->back()->with('error-message', 'アップロードファイルが見つかりません。');
        }

        if ($fileSize > 5242880) {
            return redirect()->back()->with('error-message', 'ファイルサイズは5MB以上になっています。');
        }

        if ($mineType !== 'text/csv') {
            return redirect()->back()->with('error-message', '選択しているファイル形式はCSVではありません。');
        }

        if ($extension !== 'csv') {
            return redirect()->back()->with('error-message', '選択しているファイル形式はCSVではありません。');
        }

        $dir = 'upFiles';
        $fileName = $fileMTime . '.' . $extension;
        $file->storeAs($dir, $fileName);

        $directory = Storage::path('upFiles');
        dd($directory);
        $filePath = Storage::path('upFiles/{$fileName}');
        dd($filePath);
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);

        return redirect()->back();
    }
}
