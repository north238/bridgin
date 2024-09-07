<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://use.fontawesome.com/releases/v6.2.0/css/all.css" rel="stylesheet">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-slate-50">
    <nav class="bg-white border-b border-gray-100 sm:mb-10">
        <div class="max-w-7xl mx-auto pr-4 sm:px-6 lg:px-8">
            <div class="flex h-16">
                <div class="overflow-hidden shrink-0 flex items-center max-w-[170px] sm:max-w-[200px]">
                    <img src="{{ asset('/images/bridgin_v2/bridgin_v2_fill_none.svg') }}">
                </div>
            </div>
        </div>
    </nav>
    <section class="my-5 text-slate-800">
        <div class="mx-auto max-w-[1100px] py-6 px-4 bg-white border-0 shadow-md rounded-lg">
            <div class="container mx-auto px-4 py-8 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between pr-2">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">プライバシーポリシー</h2>
                    <a href="{{ route('register') }}" id="create-back-btn"
                        class="text-sm text-blue-600 dark:text-blue-500"><i
                            class="fa-solid fa-angle-left mr-2"></i><span
                            class="hover:underline">{{ __('back_btn') }}</span></a>
                </div>
                <hr class="h-px mb-6 mt-3 bg-gray-200 border-1 dark:border-dark_border dark:bg-dark_bg">

                <p class="mb-6">
                    私たちのアプリケーション「bridgin」では、ユーザーのプライバシーを尊重し、個人情報の保護に努めています。本プライバシーポリシーは、資産管理を目的としたサービスの提供に関連して、収集する情報、利用方法、共有方法、保護方法について説明します。
                </p>

                <h2 class="text-xl font-bold mt-6 mb-2">1. 収集する情報</h2>
                <p class="mb-4">私たちは、サービスの提供に必要な範囲で、ユーザーの個人情報を収集します。収集する情報には、以下のものが含まれます。</p>
                <ul class="list-disc pl-5 mb-6">
                    <li>氏名、メールアドレスなどの連絡先情報</li>
                    <li>アカウント情報（ユーザーID、パスワードなど）</li>
                    <li>資産情報（資産の種類、評価額、取引履歴など）</li>
                    <li>デバイス情報（IPアドレス、ブラウザの種類、デバイスIDなど）</li>
                    <li>アクセスログやCookieに基づく利用履歴</li>
                </ul>

                <h2 class="text-xl font-bold mt-6 mb-2">2. 情報の利用方法</h2>
                <p class="mb-4">収集した情報は、以下の目的で利用されます。</p>
                <ul class="list-disc pl-5 mb-6">
                    <li>サービスの提供および改善（例：ユーザーの資産情報を適切に管理し、最適化するため）</li>
                    <li>カスタマーサポートの提供</li>
                    <li>新サービスやキャンペーンの案内</li>
                    <li>セキュリティ対策および不正行為の防止</li>
                    <li>法的義務の遵守</li>
                </ul>

                <h2 class="text-xl font-bold mt-6 mb-2">3. 情報の共有</h2>
                <p class="mb-4">私たちは、以下の場合を除き、ユーザーの個人情報を第三者に提供することはありません。</p>
                <ul class="list-disc pl-5 mb-6">
                    <li>ユーザーの同意がある場合</li>
                    <li>法令に基づく場合</li>
                    <li>サービスの提供に必要な範囲で、業務委託先に提供する場合</li>
                </ul>

                <h2 class="text-xl font-bold mt-6 mb-2">4. 情報の保護</h2>
                <p class="mb-6">私たちは、ユーザーの個人情報を適切に管理し、以下の対策を講じます。</p>
                <ul class="list-disc pl-5 mb-6">
                    <li>SSL/TLSによるデータの暗号化</li>
                    <li>アクセス制御による不正アクセスの防止</li>
                    <li>定期的なセキュリティチェックと更新</li>
                </ul>

                <h2 class="text-xl font-bold mt-6 mb-2">5. プライバシーポリシーの変更</h2>
                <p class="mb-6">私たちは、法令の変更やサービス内容の変更に応じて、本プライバシーポリシーを変更することがあります。変更があった場合には、速やかにユーザーに通知します。</p>

                <p class="mt-6 text-left">このプライバシーポリシーに関するお問い合わせは、メールでご連絡ください:<a href="mailto:support@bridgin-app.com"
                        class="text-blue-500 underline">support@bridgin-app.com</a></p>
            </div>
    </section>

    @vite(['resources/js/app.js'])
</body>


</html>
