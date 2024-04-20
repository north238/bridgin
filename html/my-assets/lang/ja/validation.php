<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute は受け入れられる必要があります。',
    'accepted_if' => ':attribute は :other が :value の場合に受け入れられる必要があります。',
    'active_url' => ':attribute は有効なURLである必要があります。',
    'after' => ':attribute は :date よりも後の日付である必要があります。',
    'after_or_equal' => ':attribute は :date 以降の日付である必要があります。',
    'alpha' => ':attribute は文字だけを含む必要があります。',
    'alpha_dash' => ':attribute は文字、数字、ダッシュ、アンダースコアだけを含む必要があります。',
    'alpha_num' => ':attribute は文字と数字だけを含む必要があります。',
    'array' => ':attribute は配列である必要があります。',
    'ascii' => ':attribute は半角英数字と記号だけを含む必要があります。',
    'before' => ':attribute は :date よりも前の日付である必要があります。',
    'before_or_equal' => ':attribute は :date 以前の日付であるか同じ日付である必要があります。',
    'between' => [
        'array' => ':attribute は :min から :max 個のアイテムを持つ必要があります。',
        'file' => ':attribute は :min から :max キロバイトの間である必要があります。',
        'numeric' => ':attribute は :min から :max の間である必要があります。',
        'string' => ':attribute は :min から :max 文字の間である必要があります。',
    ],
    'boolean' => ':attribute は true または false である必要があります。',
    'can' => ':attribute には許可されていない値が含まれています。',
    'confirmed' => ':attribute の確認が一致しません。',
    'current_password' => 'パスワードが正しくありません。',
    'date' => ':attribute は有効な日付である必要があります。',
    'date_equals' => ':attribute は :date と同じ日付である必要があります。',
    'date_format' => ':attribute は :format 形式と一致する必要があります。',
    'decimal' => ':attribute は :decimal 桁の小数を持つ必要があります。',
    'declined' => ':attribute は拒否される必要があります。',
    'declined_if' => ':attribute は :other が :value の場合に拒否される必要があります。',
    'different' => ':attribute と :other は異なる必要があります。',
    'digits' => ':attribute は :digits 桁である必要があります。',
    'digits_between' => ':attribute は :min から :max 桁の間である必要があります。',
    'dimensions' => ':attribute は無効な画像の寸法です。',
    'distinct' => ':attribute に重複した値があります。',
    'doesnt_end_with' => ':attribute は次のいずれかで終わってはいけません: :values。',
    'doesnt_start_with' => ':attribute は次のいずれかで始まってはいけません: :values。',
    'email' => ':attribute は有効なメールアドレスである必要があります。',
    'ends_with' => ':attribute は次のいずれかで終わる必要があります: :values。',
    'enum' => '選択された :attribute は無効です。',
    'exists' => '選択された :attribute は無効です。',
    'extensions' => ':attribute は次のいずれかの拡張子を持つ必要があります: :values。',
    'file' => ':attribute はファイルである必要があります。',
    'filled' => ':attribute に値を入力してください。',
    'gt' => [
        'array' => ':attribute は :value 個より多くのアイテムを持つ必要があります。',
        'file' => ':attribute は :value キロバイトより大きくなければなりません。',
        'numeric' => ':attribute は :value より大きくなければなりません。',
        'string' => ':attribute は :value 文字より多くなければなりません。',
    ],
    'gte' => [
        'array' => ':attribute は :value 個以上のアイテムを持つ必要があります。',
        'file' => ':attribute は :value キロバイト以上でなければなりません。',
        'numeric' => ':attribute は :value 以上でなければなりません。',
        'string' => ':attribute は :value 文字以上でなければなりません。',
    ],
    'hex_color' => ':attribute は有効な16進カラーである必要があります。',
    'image' => ':attribute は画像である必要があります。',
    'in' => '選択された :attribute は無効です。',
    'in_array' => ':attribute は :other に存在する必要があります。',
    'integer' => ':attribute は整数である必要があります。',
    'ip' => ':attribute は有効なIPアドレスである必要があります。',
    'ipv4' => ':attribute は有効なIPv4アドレスである必要があります。',
    'ipv6' => ':attribute は有効なIPv6アドレスである必要があります。',
    'json' => ':attribute は有効なJSON文字列である必要があります。',
    'lowercase' => ':attribute は小文字である必要があります。',
    'lt' => [
        'array' => ':attribute は :value 個未満のアイテムを持つ必要があります。',
        'file' => ':attribute は :value キロバイト未満でなければなりません。',
        'numeric' => ':attribute は :value 未満でなければなりません。',
        'string' => ':attribute は :value 文字未満でなければなりません。',
    ],
    'lte' => [
        'array' => ':attribute は :value 個以上のアイテムを持つことはできません。',
        'file' => ':attribute は :value キロバイト以下でなければなりません。',
        'numeric' => ':attribute は :value 以下でなければなりません。',
        'string' => ':attribute は :value 文字以下でなければなりません。',
    ],
    'mac_address' => ':attribute は有効なMACアドレスである必要があります。',
    'max' => [
        'array' => ':attribute は :max 個を超えるアイテムを持つことはできません。',
        'file' => ':attribute は :max キロバイトを超えることはできません。',
        'numeric' => ':attribute は :max を超えることはできません。',
        'string' => ':attribute は :max 文字を超えることはできません。',
    ],
    'max_digits' => ':attribute は :max 桁を超えることはできません。',
    'mimes' => ':attribute は次のタイプのファイルである必要があります: :values。',
    'mimetypes' => ':attribute は次のタイプのファイルである必要があります: :values。',
    'min' => [
        'array' => ':attribute は少なくとも :min 個のアイテムを持つ必要があります。',
        'file' => ':attribute は少なくとも :min キロバイトである必要があります。',
        'numeric' => ':attribute は少なくとも :min である必要があります。',
        'string' => ':attribute は少なくとも :min 文字である必要があります。',
    ],
    'min_digits' => ':attribute は少なくとも :min 桁を持つ必要があります。',
    'missing' => ':attribute は存在している必要があります。',
    'missing_if' => ':attribute は :other が :value の場合に存在している必要があります。',
    'missing_unless' => ':attribute は :other が :value でない限り存在している必要があります。',
    'missing_with' => ':values が存在する場合、:attribute は存在している必要があります。',
    'missing_with_all' => ':values が存在する場合、:attribute は存在している必要があります。',
    'multiple_of' => ':attribute は :value の倍数である必要があります。',
    'not_in' => '選択された :attribute は無効です。',
    'not_regex' => ':attribute の形式が無効です。',
    'numeric' => ':attribute は数値である必要があります。',
    'password' => [
        'letters' => ':attribute には少なくとも1つの文字が含まれている必要があります。',
        'mixed' => ':attribute には少なくとも1つの大文字と1つの小文字の文字が含まれている必要があります。',
        'numbers' => ':attribute には少なくとも1つの数字が含まれている必要があります。',
        'symbols' => ':attribute には少なくとも1つの記号が含まれている必要があります。',
        'uncompromised' => '指定された :attribute はデータリークに登場しました。別の :attribute を選択してください。',
    ],
    'present' => ':attribute は存在している必要があります。',
    'present_if' => ':other が :value の場合、:attribute は存在している必要があります。',
    'present_unless' => ':other が :value である限り、:attribute は存在している必要があります。',
    'present_with' => ':values が存在する場合、:attribute は存在している必要があります。',
    'present_with_all' => ':values が存在する場合、:attribute は存在している必要があります。',
    'prohibited' => ':attribute は禁止されています。',
    'prohibited_if' => ':other が :value の場合、:attribute は禁止されています。',
    'prohibited_unless' => ':other が :values に含まれていない限り、:attribute は禁止されています。',
    'prohibits' => ':attribute によって :other が存在することが禁止されています。',
    'regex' => ':attribute の形式が無効です。',
    'required' => ':attribute は必須です。',
    'required_array_keys' => ':attribute には、次のエントリが含まれている必要があります: :values。',
    'required_if' => ':other が :value の場合、:attribute は必須です。',
    'required_if_accepted' => ':other が承認されている場合、:attribute は必須です。',
    'required_unless' => ':other が :values に含まれていない場合、:attribute は必須です。',
    'required_with' => ':values が存在する場合、:attribute は必須です。',
    'required_with_all' => ':values が存在する場合、:attribute は必須です。',
    'required_without' => ':values が存在しない場合、:attribute は必須です。',
    'required_without_all' => ':values のいずれも存在しない場合、:attribute は必須です。',
    'same' => ':attribute は :other と一致する必要があります。',
    'size' => [
        'array' => ':attribute は :size 個のアイテムを含んでいる必要があります。',
        'file' => ':attribute は :size キロバイトである必要があります。',
        'numeric' => ':attribute は :size である必要があります。',
        'string' => ':attribute は :size 文字である必要があります。',
    ],
    'starts_with' => ':attribute は次のいずれかで始まる必要があります: :values。',
    'string' => ':attribute は文字列である必要があります。',
    'timezone' => ':attribute は有効なタイムゾーンである必要があります。',
    'unique' => ':attribute はすでに存在します。',
    'uploaded' => ':attribute のアップロードに失敗しました。',
    'uppercase' => ':attribute は大文字である必要があります。',
    'url' => ':attribute は有効なURLである必要があります。',
    'ulid' => ':attribute は有効なULIDである必要があります。',
    'uuid' => ':attribute は有効なUUIDである必要があります。',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
        'registration_date' => [
            'before_or_equal' => '登録日には今日より前の日付を入力してください。'
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        "name" => "資産名",
        "amount" => "資産額",
        "registration_date" => "登録日",
        "category" => "カテゴリ",
        "genre" => "ジャンル"
    ],

];
