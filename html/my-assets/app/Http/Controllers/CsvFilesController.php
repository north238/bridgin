<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CsvFilesController extends Controller
{
    // CSVのダウンロード機能
    // jsonで受け取ったデータを変換
    
    public function csvExport(Request $request)
    {
        $requestData =
            json_decode($request->input('export-data'), true);
        $csvHeader = ['id', 'category_name', 'name', 'amount', 'registration_date', 'created_at'];
        
        $fileName = $requestData[0]['registration_date'] . '.csv';

        $response = new StreamedResponse(function () use ($csvHeader, $requestData) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $csvHeader);

            foreach ($requestData as $row) {
                $rowData = [
                    $row['id'],
                    $row['category']['name'],
                    $row['name'],
                    $row['amount'],
                    $row['registration_date'],
                    $row['created_at'],
                ];
                fputcsv($handle, $rowData);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename=' . $fileName);

        return $response;
    }
}
