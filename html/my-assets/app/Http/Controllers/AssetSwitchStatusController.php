<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssetSwitchStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AssetSwitchStatusController extends Controller
{

    /**
     * トグルスイッチがチェックされれば負債が表示される
     * この変更をデータベースに保存する
     * @param Request $request
     * @return 成功/失敗のセッション
     */
    public function userDisplayMethodChange(Request $request)
    {
        $userId = Auth::user()->id;
        $debutStatus = $request->input('debut-status');
        // ステータスがなければ'0'を代入し、それ以外は数値を反転させる
        $debutStatus = isset($debutStatus) ? ($debutStatus === '1' ? '0' : '1') : '0';

        try {
            DB::beginTransaction();
            AssetSwitchStatus::updateOrCreate(
                ['user_id' => $userId],
                ['debut_status' => $debutStatus, 'asset_type_status' => '0'],
            );

            DB::commit();

            session()->flash('success-message', '表示変更に成功しました。');
            return response()->json(['success-message' => '表示変更に成功しました。']);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error-message', '表示変更に失敗しました。' . $e->getMessage());
            return response()->json(['error-message' => '表示変更に失敗しました。' . $e->getMessage()]);
        }
    }
}
