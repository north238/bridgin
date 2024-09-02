<?php

namespace App\Services;

use App\Models\Asset;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
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
    private $withoutColumns = ["id", "asset_type_flg", "memo", "created_at", "updated_at", "deleted_at"];
    private  $asset;

    public function __construct(Asset $asset)
    {
        $this->asset = $asset;
    }

    /**
     * バリデーションの設定
     */
    private function validationRules()
    {
        return [
            'カテゴリID' => 'required|string',
            'ユーザーID' => 'required|string',
            '名称' => 'required|string|max:30',
            '金額' => 'required|string|min:-9999999999999|max:9999999999999',
            '登録日' => 'required|string',
        ];
    }

    private function validationMessages()
    {
        return [
            'カテゴリID.required' => 'カテゴリIDは必須です。',
            'ユーザーID.required' => 'ユーザーIDは必須です。',
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
     * ファイルのバリデーション
     * - アップロードファイルがない
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

        if (empty($file)) {
            Log::error('アップロードファイルが見つかりません。', ['file' => json_encode($file)]);
            session()->flash('error-message', 'アップロードファイルが見つかりません。');
            return false;
        }

        if ($fileSize > 5242880) {
            Log::error('ファイルサイズが5MB以上になっています。', ['fileSize' => $fileSize]);
            session()->flash('error-message', 'ファイルサイズが5MB以上になっています。');
            return false;
        }

        if ($mineType !== 'text/csv') {
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
     * 不要なカラムを除外
     *
     * @param array $csvHeaders CSVファイルから取得したカラム名
     * @return array  除外後のカラム名の配列
     */
    public function removeUnwantedColumns($csvHeaders)
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
            $errCount++;
        }

        return $errorList;
    }
}
