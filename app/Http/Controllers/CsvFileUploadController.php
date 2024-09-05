<?php

namespace App\Http\Controllers;

use App\Services\CsvUploadService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use League\Csv\Statement;
use League\Csv\SyntaxError;

class CsvFileUploadController extends Controller
{
    private $dir = 'upFiles';
    private  $csvUploadService;

    public function __construct(CsvUploadService $csvUploadService)
    {
        $this->csvUploadService = $csvUploadService;
    }

    public function upload(Request $request)
    {
        $file = $request->file('upload-file');
        if (empty($file)) {
            Log::error('アップロードファイルが見つかりません。');
            return
                redirect()->back()->with('error-message', 'アップロードファイルが見つかりません。');
        }

        // ファイルのバリデーション
        if (!$this->csvUploadService->validationFile($file)) {
            return
                redirect()->back()->with('error-message', session('error-message'));
        }

        $fileName = $this->generateFileName($file);
        $filePath = $this->saveUploadFile($file, $fileName);

        // ファイルが保存できない時にエラーを返却
        if (empty($filePath)) {
            Log::error('ファイルの読み込みに失敗しました。', ['filePath' => $filePath]);
            return
                redirect()->back()->with('error-message', 'ファイルの読み込みに失敗しました。');
        }

        // ファイル内のバリデーションチェックとテーブルへの保存処理
        $status = $this->processCsvFile($filePath, $fileName);
        if ($status === false) {
            Storage::delete("$this->dir/$fileName");
            return redirect()->back();
        }

        Storage::delete("$this->dir/$fileName");
        return redirect()->back()->with('success-message', 'ファイルが正常に保存されました。');
    }

    /**
     * ファイル名の作成
     *
     * @param \Illuminate\Http\UploadedFile $file アップロードされたファイル
     * @return string $fileName ユニークなファイル名
     */
    private function generateFileName($file)
    {
        $extension = $file->getClientOriginalExtension();
        $fileMTime = date("Ymd_His", $file->getMTime());
        $fileName = $fileMTime . '.' . $extension;

        return $fileName;
    }

    /**
     * ファイルの保存とファイルパス生成
     *
     * @param \Illuminate\Http\UploadedFile $file アップロードされたファイル
     * @param string $fileName ユニークなファイル名
     * @return string $filePath ファイルの保存処理とファイルパスを取得
     */
    private function saveUploadFile($file, $fileName)
    {
        // ファイルを保存
        $file->storeAs($this->dir, $fileName);
        $filePath = Storage::path("$this->dir/$fileName");

        return $filePath;
    }

    /**
     * CSVファイルの読み取り処理とバリデーションを実行
     *
     * @param string $filePath 処理するCSVファイルのパス
     * @param string $fileName ファイル名
     * @return \Illuminate\Http\RedirectResponse|\League\Csv\ResultSet CSVレコードのコレクション、またはエラーがあればリダイレクトレスポンスを返却
     *
     * @throws \League\Csv\Exception CSV処理中に発生する一般的な例外
     * @throws \League\Csv\SyntaxError CSVの構文エラーや重複するカラム名が検出された場合に発生する例外
     * @throws \Exception 予期しないエラーが発生した場合に発生する一般的な例外
     */
    private function processCsvFile($filePath, $fileName)
    {
        try {
            // CSVファイルの読み取り
            $csv = Reader::createFromPath($filePath, 'r');
            $csv->setHeaderOffset(0);
            $csvHeaders = $csv->getHeader();
            $status = true;

            // カラム名の検証
            if (!$this->csvUploadService->validateCsvHeaders($filePath, $csvHeaders)) {
                session()->flash('error-message', 'アップロードしたファイルのカラム名が異なります。');
                $status = false;
                return $status;
            }

            // CSV読み込み処理とバリデーション
            $records = Statement::create()->process($csv);
            $errorList = $this->csvUploadService->validateCsvRecords($records);
            if (count($errorList) > 0) {
                Log::error('ファイル内でエラーが発生しています。', ['errorList' => json_encode($errorList, JSON_UNESCAPED_UNICODE)]); // エラーメッセージを日本語のまま出力
                session()->flash('errorList', $errorList);
                $status = false;
                return $status;
            }

            // CSVファイルをDBに保存する
            if (!$this->csvUploadService->saveAssetsFromCsv($records)) {
                $status = false;
                return $status;
            }
            return $status;
        } catch (SyntaxError $e) {
            Log::error('ファイルに重複したカラム名が存在しています。', ['duplicates' => json_encode($e->duplicateColumnNames())]);
            return $this->handleFileError($fileName, 'ファイルに重複したカラム名が存在しています。');
        } catch (Exception $e) {
            Log::error('予期しないエラーが発生しました。', ['message' => $e->getMessage()]);
            return $this->handleFileError($fileName, '予期しないエラーが発生しました。');
        }
    }

    /**
     * ファイルのエラー処理
     *
     * @param string $fileName ファイル名
     * @param string $message エラーメッセージ
     * @return \Illuminate\Http\RedirectResponse リダイレクトレスポンスを返却
     */
    private function handleFileError($fileName, $message)
    {
        Storage::delete("$this->dir/$fileName");
        session()->flash('error-message', $message);
        $status = false;
        return $status;
    }
}
