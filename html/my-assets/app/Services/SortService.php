<?php

namespace App\Services;

use Illuminate\Http\Request;

class SortService
{

  /**
   * 昇順降順を非同期で実装
   * aタグをクリックしたら処理が走る
   * 
   * ajaxで現状を取得する、データを並び替える、現在のデータを取得
   * →ソート専用のルートへ何がソートされるのかを送信
   * →Ajaxで実現したい（理由: 他の機能が壊れてしまうから）
   * 
   * data-sortに情報を送信する？
   * →バックに送信するにはセッションかAjax
   * 
   * セッションを使う？
   * →状態はどうやって確認する？
   * →jsで取得？セッションを送信する？
   * 
   * 別でviewへ渡すと表示している月と差異が生まれる
   * →取れたソートのデータを表示しているところへ渡す処理が必要
   * 
   * ajaxで取得したデータをそのまま渡す処理
   * →使用したい場所で取り出して使う
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
