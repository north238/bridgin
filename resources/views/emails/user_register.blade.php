@component('emails.message')
<p>
下記の内容で登録がありました。<br>
登録内容をDBで確認してください。
</p>
<p style="font-weight: bold; font-size:16px;">
氏名: {{ $user->name }}<br>
メールアドレス: {{ $user->email }}<br>
プロバイダー: {{ $user->provider }}<br>
プロバイダーID: {{ $user->provider_id }}<br>
</p>
@endcomponent