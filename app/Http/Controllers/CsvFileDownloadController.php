<?php

namespace App\Http\Controllers;

use App\Services\AssetService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CsvFileDownloadController extends Controller
{
    /**
     * @var array CSVのヘッダー
     */
    protected $csvHeader = [
        'registration_date',
        'id',
        'name',
        'genre_id',
        'genre_name',
        'category_id',
        'category_name',
        'amount',
        'created_at'
    ];

    /**
     * @var AssetService $assetService
     */
    private $assetService;

    public function __construct(
        AssetService $assetService
    ) {
        $this->assetService = $assetService;
    }

    /**
     * リクエストデータを受け取り、CSV形式に変換する
     *
     * @param \Illuminate\Http\Request $request リクエストデータ
     * @return array $csvData CSV形式に変換されたデータ
     */
    public function getFormRequestData(Request $request)
    {
        $requestData = $request->input('export-data');
        $csvData = json_decode($requestData, true);

        return $this->downloadCSV($csvData);
    }

    /**
     * CSVファイルをダウンロードする
     *
     * @param array $csvData 整形されたデータ
     * @return \Illuminate\Http\Response $response ダウンロードファイルを返却
     */
    public function downloadCSV($csvData)
    {

        $response = $this->exportToCSV($csvData);
        $fileName = $this->createFilename($csvData);
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename=' . $fileName);

        return $response;
    }

    /**
     * CSVが出力できる形に整える
     *
     * @param array $data データの配列
     * @return \Symfony\Component\HttpFoundation\StreamedResponse $response CSV出力用のレスポンス
     */
    public function exportToCSV($data)
    {
        // ヘッダーを追加
        $headers = $this->csvHeader;

        $response = new StreamedResponse(function () use ($headers, $data) {

            $handle = fopen('php://output', 'w');
            fputcsv($handle, $headers);
            if (empty($data) === true) {
                fputcsv($handle, ['データが存在しません。']);
            } else {
                $this->insertRows($handle, $data);
            }
            fclose($handle);
        });

        return $response;
    }

    /**
     * 挿入データの出力
     *
     * @param resource $handle CSVファイルのハンドル
     * @param array $data データの配列
     * @return array $result 必要なデータを抽出した配列
     */
    public function insertRows($handle, $data)
    {

        foreach ($data as $row) {
            $result = [
                $row['registration_date'],
                $row['id'],
                $row['name'],
                $row['genre_id'],
                $row['genre_name'],
                $row['category_id'],
                $row['category_name'],
                $row['amount'],
                $row['created_at'],
            ];
            fputcsv($handle, $result);
        }

        return $result;
    }

    /**
     * ファイル名を生成
     *
     * @param array $csvData 整形されたデータ
     * @return string $fileName
     */
    public function createFilename($csvData)
    {

        $latestDate = $csvData[0]['registration_date'];
        $formatDataString = $this->assetService->getCsvFilename($latestDate);
        $fileName = 'brigen_' . $formatDataString . '.csv';

        return $fileName;
    }
}
