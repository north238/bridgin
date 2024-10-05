<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckBrowser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 検知したい内部ブラウザのUser-Agentリスト
        $internalBrowsers = ['Line', 'FBAV', 'FBAN', 'Instagram', 'Twitter', 'MicroMessenger'];

        // 許可されたドメインのリストを設定
        $allowedDomains = ['bridgin-app.com'];

        // URLのホスト部分を解析
        $redirectUrl = $request->get('redirect_to', config('app.url'));
        $parsedUrl = parse_url($redirectUrl, PHP_URL_HOST);

        // 許可されたドメインかどうかを確認
        if (!in_array($parsedUrl, $allowedDomains)) {
            $redirectUrl = config('app.url');
        }

        foreach ($internalBrowsers as $browser) {
            if (strpos($request->header('User-Agent'), $browser) !== false) {
                // 外部ブラウザで開くようにリダイレクト
                return redirect()->away($redirectUrl)->with('error-message', 'お使いのブラウザではこのページを表示できません。外部ブラウザで開いてください。');
            }
        }

        return $next($request);
    }
}
