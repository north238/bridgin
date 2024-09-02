<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Services\CsvUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use League\Csv\Statement;
use League\Csv\SyntaxError;

class CsvFileUploadController extends Controller
{
    private  $csvUploadService;
    private  $asset;

    public function __construct(CsvUploadService $csvUploadService, Asset $asset)
    {
        $this->csvUploadService = $csvUploadService;
        $this->asset = $asset;
    }

    public function upload(Request $request)
    {
        $file = $request->file('upload-file');
        $extension = $file->getClientOriginalExtension();
        $fileMTime = date("Ymd_His", $file->getMTime());
        $dir = 'upFiles';
        $fileName = $fileMTime . '.' . $extension;

        // ファイルのバリデーション
        $validationResult = $this->csvUploadService->validationFile($file);
        if ($validationResult === false) {
            return redirect()->back()->with('error-message', session('error-message'));
        }

        // ファイルを保存
        $file->storeAs($dir, $fileName);
        $filePath = Storage::path("$dir/$fileName");

        // ファイルが保存できない時にエラーを返却
        if (empty($filePath)) {
            Log::error('ファイルの読み込みに失敗しました。', ['filePath' => $filePath]);
            return
                redirect()->back()->with('error-message', 'ファイルの読み込みに失敗しました。');
        }

        // CSVファイルの読み取り
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);

        $csvHeaders = $csv->getHeader();
        // カラムが一致しない場合にはエラーを返却
        if (!empty($this->csvUploadService->removeUnwantedColumns($csvHeaders))) {
            Log::error('アップロードしたファイルのカラム名が異なります。', ['csvHeaders' => json_encode($csvHeaders)]);
            // 失敗した場合ファイルを削除
            Storage::delete($filePath);
            return
                redirect()->back()->with('error-message', 'アップロードしたファイルのカラム名が異なります。');
        }
        try {
            $records = Statement::create()->process($csv);
            $errorList = $this->csvUploadService->validateCsvRecords($records);
            // エラーがあればエラー内容を返却
            if (count($errorList) > 0) {
                Log::error('ファイル内でエラーが発生しています。', ['errorList' => json_encode($errorList)]);
                // 失敗した場合ファイルを削除
                Storage::delete($filePath);
                return redirect()->back()->with('errorList', $errorList);
            }
        } catch (SyntaxError $e) {
            $duplicates = $e->duplicateColumnNames();
            Log::error('ファイルに重複したカラム名が存在しています。', ['duplicates' => json_encode($duplicates)]);
            // 失敗した場合ファイルを削除
            Storage::delete($filePath);
            return
                redirect()->back()->with('error-message', 'ファイルに重複したカラム名が存在しています。');
        }

        // 保存後、ファイルを削除
        Storage::delete($filePath);

        return redirect()->back();
    }
}
