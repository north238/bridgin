<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
        <div class="mx-auto max-w-[1100px] py-12 px-4 bg-white border-0 rounded-lg">
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
                    私たちのアプリケーションでは、ユーザーのプライバシーを尊重し、個人情報の保護に努めています。このプライバシーポリシーでは、収集する情報、利用方法、共有方法、保護方法について説明します。</p>

                <h2 class="text-xl font-bold mt-6 mb-2">1. 収集する情報</h2>
                <p class="mb-4">私たちは、サービスの提供に必要な範囲で、ユーザーの個人情報を収集します。収集する情報には、以下のものが含まれます。</p>
                <ul class="list-disc pl-5 mb-6">
                    <li>氏名、メールアドレス、住所などの連絡先情報</li>
                    <li>サービス利用履歴やアクセスログ</li>
                </ul>

                <h2 class="text-xl font-bold mt-6 mb-2">2. 情報の利用方法</h2>
                <p class="mb-4">収集した情報は、以下の目的で利用されます。</p>
                <ul class="list-disc pl-5 mb-6">
                    <li>サービスの提供および改善</li>
                    <li>カスタマーサポートの提供</li>
                    <li>新サービスやキャンペーンの案内</li>
                </ul>

                <h2 class="text-xl font-bold mt-6 mb-2">3. 情報の共有</h2>
                <p class="mb-4">私たちは、以下の場合を除き、ユーザーの個人情報を第三者に提供することはありません。</p>
                <ul class="list-disc pl-5 mb-6">
                    <li>ユーザーの同意がある場合</li>
                    <li>法令に基づく場合</li>
                    <li>サービスの提供に必要な範囲で、業務委託先に提供する場合</li>
                </ul>

                <h2 class="text-xl font-bold mt-6 mb-2">4. 情報の保護</h2>
                <p class="mb-6">私たちは、ユーザーの個人情報を適切に管理し、不正アクセス、紛失、破壊、改ざん、漏洩などのリスクに対して必要な措置を講じます。</p>

                <h2 class="text-xl font-bold mt-6 mb-2">5. プライバシーポリシーの変更</h2>
                <p class="mb-6">私たちは、法令の変更やサービス内容の変更に応じて、本プライバシーポリシーを変更することがあります。変更があった場合には、速やかにユーザーに通知します。</p>

                <p class="mt-6 text-left">このプライバシーポリシーに関するお問い合わせは、メールでご連絡ください:<a
                        href="mailto:support@bridgin-app.com"
                        class="text-blue-500 underline">support@bridgin-app.com</a></p>
            </div>
    </section>
</body>

</html>
