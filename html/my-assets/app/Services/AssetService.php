<?php

namespace App\Services;

use Illuminate\Http\Request;

class AssetService
{

  /**
   * 昇順降順を非同期で実装
   */
  
  public function sortIndex($requestData)
  {
    if(session()->has('sort-data')) {
      $sortSession = session()->get('sort-data');
      $sortOrder = $sortSession->order;   // 何を（カラム名）
      $sortType = $sortSession->type;     // 昇順or降順(ソート)
    } else {
      $sortOrder = $requestData->order;
      $sortType = $requestData->type;
    }

    $sortData =
      ['order' => $sortOrder, 'type' => $sortType];

    return $sortData;
  }
}
