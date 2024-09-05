<?php

namespace App\Services;

use App\Models\Asset;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class CsvUploadService
{
    // csvカラム名とDBカラム名のマッピング
    private $headerMapping = [
        "カテゴリID" => "category_id",
        "ユーザーID" => "user_id",
        "名称" => "name",
        "金額" => "amount",
        "登録日" => "registration_date",
        "資産タイプ" => "asset_type_flg",
        "メモ" => "memo",
        "作成日" => "created_at",
        "更新日" => "updated_at",
        "削除日" => "deleted_at"
    ];

    // 除外するカラム
    private $withoutColumns = ["id", "user_id", "asset_type_flg", "memo", "created_at", "updated_at", "deleted_at"];

    // 許可するファイル形式
    private $allowedMimeTypes = ['text/csv', 'text/plain'];
    private  $asset;

    public function __construct(Asset $asset)
    {
        $this->asset = $asset;
    }

    /**
     * ファイルのバリデーション
     * - ファイルサイズが5MB以上
     * - mine-typeがtext/csvでない場合
     * - 拡張子が.csvでない場合
     *
     * @param \Illuminate\Http\UploadedFile $file アップロードされたファイル
     * @return bool true|false
     */
    public function validationFile($file)
    {
        $fileSize = $file->getSize();
        $mineType = $file->getMimeType();
        $extension = $file->getClientOriginalExtension();

        if ($fileSize > 5242880) {
            Log::error('ファイルサイズが5MB以上になっています。', ['fileSize' => $fileSize]);
            session()->flash('error-message', 'ファイルサイズが5MB以上になっています。');
            return false;
        }

        if (!in_array($mineType, $this->allowedMimeTypes)) {
            Log::error('選択しているファイル形式はCSVではありません。', ['mineType' => $mineType]);
            session()->flash('error-message', '選択しているファイル形式はCSVではありません。');
            return false;
        }

        if ($extension !== 'csv') {
            Log::error('選択しているファイル形式はCSVではありません。', ['extension' => $extension]);
            session()->flash('error-message', '選択しているファイル形式はCSVではありません。');
            return false;
        }

        return true;
    }

    /**
     * CSVヘッダーをバリデート
     *
     * @param string $filePath ファイルのパス
     * @param array $csvHeaders CSVのヘッダー行
     * @return bool エラーがあればfalseを返し、エラーがなければtrueを返却
     */
    public function validateCsvHeaders($filePath, $csvHeaders)
    {
        if (!empty($this->removeUnwantedColumns($csvHeaders))) {
            Log::error('アップロードしたファイルのカラム名が異なります。', ['csvHeaders' => json_encode($csvHeaders, JSON_UNESCAPED_UNICODE)]);
            Storage::delete($filePath);
            return false;
        }
        return true;
    }

    /**
     * 不要なカラムを除外
     *
     * @param array $csvHeaders CSVファイルから取得したカラム名
     * @return array  除外後のカラム名の配列
     */
    private function removeUnwantedColumns($csvHeaders)
    {
        // 日本語から英語に変換
        $mappedHeaders = array_map(function ($header) {
            return $this->headerMapping[$header] ?? $header;
        }, $csvHeaders);

        // DBのカラム名を取得
        $columns = Schema::getColumnListing($this->asset->getTable());

        $columnsWithoutArray = array_diff($columns, $this->withoutColumns);

        return array_diff($mappedHeaders, $columnsWithoutArray);
    }

    /**
     * アップロードされたCSVレコードのバリデーションを行い、エラーを検出する
     *
     * @param \League\Csv\ResultSet $records CSVファイルから取得したレコードの結果セット
     * @return array $errorList エラーメッセージの配列
     */
    public function validateCsvRecords($records)
    {
        $userId = Auth::user()->id;
        $errorList = [];
        $errCount = 1;
        foreach ($records as $record) {
            $validator = Validator::make(
                $record,
                $this->validationRules(),
                $this->validationMessages()
            );
            if ($validator->fails() === true) {
                $errorList[$errCount] = $validator->errors()->all();
            }
            // 登録日の厳密なバリデーション
            if (!preg_match(config('validation.patterns.date_format'), $record['登録日'])) {
                $errorList[$errCount][] = config('validation.message.date_error');
            }

            // 既存データの重複をチェック
            $exists = Asset::where('name', trim($record['名称']))
                ->where('user_id', $userId)
                ->where('registration_date', trim($record['登録日']))
                ->exists();

            if ($exists) {
                $errorList[$errCount][] = config('validation.message.duplication_error');
            }
            $errCount++;
        }
        return $errorList;
    }

    /**
     * バリデーションの設定
     */
    private function validationRules()
    {
        return [
            'カテゴリID' => 'required|string',
            '名称' => 'required|string|max:30',
            '金額' => 'required|string|min:-9999999999999|max:9999999999999',
            '登録日' => 'required|string',
        ];
    }

    private function validationMessages()
    {
        return [
            'カテゴリID.required' => 'カテゴリIDは必須です。',
            '名称.required' => '名称は必須です。',
            '名称.max' => '名称は30文字以内でなければなりません。',
            '金額.required' => '金額は必須です。',
            '金額.string' => '金額は数値でなければなりません。',
            '金額.min' => '金額は指定された範囲内でなければなりません。',
            '金額.max' => '金額は指定された範囲内でなければなりません。',
            '登録日.required' => '登録日は必須です。',
            '登録日.string' => '登録日は正しい日付形式でなければなりません。',
        ];
    }

    /**
     * 保存したいデータをassetテーブルに保存する処理
     * - DBへの保存はcreateを採用
     * - save()よりDBへの負荷が少ないため
     *
     * @param \League\Csv\Statement $records CSVファイルから読み込まれたデータのコレクション
     * @return \Illuminate\Http\RedirectResponse エラーが発生した場合のリダイレクトレスポンス
     * @throws \Exception データベース操作中に発生したエラー
     */
    public function saveAssetsFromCsv($records)
    {
        $userId = Auth::user()->id;
        DB::beginTransaction();
        try {
            foreach ($records as $record) {
                Asset::create([
                    'category_id' => trim($record['カテゴリID']),
                    'user_id' => $userId,
                    'name' => trim($record['名称']),
                    'amount' => str_replace(',', '', trim($record['金額'])),
                    'registration_date' => trim($record['登録日']),
                    'asset_type_flg' => 1,
                    'memo' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('データの保存中にエラーが発生しました。', ['message' => $e->getMessage()]);
            session()->flash('error-message', 'データの保存中にエラーが発生しました。');
            return false;
        }
    }
}
