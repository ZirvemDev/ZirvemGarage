<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Doğrulama Mesajları
    |--------------------------------------------------------------------------
    |
    | Aşağıdaki dil satırları, doğrulayıcı sınıf tarafından kullanılan varsayılan hata mesajlarını içerir.
    | Bazı kuralların birden fazla versiyonu vardır, örneğin boyut kuralları gibi.
    | Bu mesajları burada dilediğiniz gibi ayarlayabilirsiniz.
    |
    */

    'accepted' => ':attribute alanı kabul edilmelidir.',
    'accepted_if' => ':attribute alanı, :other :value olduğunda kabul edilmelidir.',
    'active_url' => ':attribute geçerli bir URL olmalıdır.',
    'after' => ':attribute :date tarihinden sonra bir tarih olmalıdır.',
    'after_or_equal' => ':attribute :date tarihinden sonra veya bu tarihe eşit olmalıdır.',
    'alpha' => ':attribute sadece harflerden oluşmalıdır.',
    'alpha_dash' => ':attribute sadece harfler, rakamlar, tire ve alt çizgi içerebilir.',
    'alpha_num' => ':attribute sadece harfler ve rakamlar içerebilir.',
    'array' => ':attribute bir dizi olmalıdır.',
    'ascii' => ':attribute sadece tek baytlık alfasayısal karakterler ve semboller içermelidir.',
    'before' => ':attribute :date tarihinden önce bir tarih olmalıdır.',
    'before_or_equal' => ':attribute :date tarihinden önce veya bu tarihe eşit olmalıdır.',
    'between' => [
        'array' => ':attribute :min ile :max arasında öğe içermelidir.',
        'file' => ':attribute :min ile :max kilobayt arasında olmalıdır.',
        'numeric' => ':attribute :min ile :max arasında olmalıdır.',
        'string' => ':attribute :min ile :max karakter arasında olmalıdır.',
    ],
    'boolean' => ':attribute alanı doğru ya da yanlış olmalıdır.',
    'can' => ':attribute yetkisiz bir değer içeriyor.',
    'confirmed' => ':attribute onayı eşleşmiyor.',
    'current_password' => 'Parola yanlış.',
    'date' => ':attribute geçerli bir tarih olmalıdır.',
    'date_equals' => ':attribute :date ile eşit bir tarih olmalıdır.',
    'date_format' => ':attribute :format formatı ile eşleşmelidir.',
    'decimal' => ':attribute :decimal ondalık basamağa sahip olmalıdır.',
    'declined' => ':attribute reddedilmelidir.',
    'declined_if' => ':attribute, :other :value olduğunda reddedilmelidir.',
    'different' => ':attribute ve :other farklı olmalıdır.',
    'digits' => ':attribute :digits basamak olmalıdır.',
    'digits_between' => ':attribute :min ile :max basamak arasında olmalıdır.',
    'dimensions' => ':attribute geçersiz resim boyutlarına sahiptir.',
    'distinct' => ':attribute alanı yinelenen bir değere sahiptir.',
    'doesnt_end_with' => ':attribute şu değerlerden biri ile bitmemelidir: :values.',
    'doesnt_start_with' => ':attribute şu değerlerden biri ile başlamamalıdır: :values.',
    'email' => ':attribute geçerli bir e-posta adresi olmalıdır.',
    'ends_with' => ':attribute şu değerlerden biri ile bitmelidir: :values.',
    'enum' => 'Seçilen :attribute geçersiz.',
    'exists' => 'Seçilen :attribute geçersiz.',
    'extensions' => ':attribute şu uzantılardan birine sahip olmalıdır: :values.',
    'file' => ':attribute bir dosya olmalıdır.',
    'filled' => ':attribute alanının bir değeri olmalıdır.',
    'gt' => [
        'array' => ':attribute :value öğeden fazla olmalıdır.',
        'file' => ':attribute :value kilobayttan büyük olmalıdır.',
        'numeric' => ':attribute :value değerinden büyük olmalıdır.',
        'string' => ':attribute :value karakterden fazla olmalıdır.',
    ],
    'gte' => [
        'array' => ':attribute :value öğe veya daha fazlasına sahip olmalıdır.',
        'file' => ':attribute :value kilobayttan büyük veya eşit olmalıdır.',
        'numeric' => ':attribute :value değerine eşit veya daha büyük olmalıdır.',
        'string' => ':attribute :value karakter veya daha fazla olmalıdır.',
    ],
    'hex_color' => ':attribute geçerli bir onaltılık renk olmalıdır.',
    'image' => ':attribute bir resim olmalıdır.',
    'in' => 'Seçilen :attribute geçersiz.',
    'in_array' => ':attribute :other içinde mevcut olmalıdır.',
    'integer' => ':attribute bir tamsayı olmalıdır.',
    'ip' => ':attribute geçerli bir IP adresi olmalıdır.',
    'ipv4' => ':attribute geçerli bir IPv4 adresi olmalıdır.',
    'ipv6' => ':attribute geçerli bir IPv6 adresi olmalıdır.',
    'json' => ':attribute geçerli bir JSON dizesi olmalıdır.',
    'list' => ':attribute bir liste olmalıdır.',
    'lowercase' => ':attribute küçük harf olmalıdır.',
    'lt' => [
        'array' => ':attribute :value öğeden daha az olmalıdır.',
        'file' => ':attribute :value kilobayttan küçük olmalıdır.',
        'numeric' => ':attribute :value değerinden küçük olmalıdır.',
        'string' => ':attribute :value karakterden küçük olmalıdır.',
    ],
    'lte' => [
        'array' => ':attribute :value öğeden fazla olmamalıdır.',
        'file' => ':attribute :value kilobayttan küçük veya eşit olmalıdır.',
        'numeric' => ':attribute :value değerinden küçük veya eşit olmalıdır.',
        'string' => ':attribute :value karakterden küçük veya eşit olmalıdır.',
    ],
    'mac_address' => ':attribute geçerli bir MAC adresi olmalıdır.',
    'max' => [
        'array' => ':attribute :max öğeden fazla olamaz.',
        'file' => ':attribute :max kilobayttan büyük olamaz.',
        'numeric' => ':attribute :max değerinden büyük olamaz.',
        'string' => ':attribute :max karakterden fazla olamaz.',
    ],
    'max_digits' => ':attribute :max basamaktan fazla olamaz.',
    'mimes' => ':attribute şu dosya türlerinden biri olmalıdır: :values.',
    'mimetypes' => ':attribute şu dosya türlerinden biri olmalıdır: :values.',
    'min' => [
        'array' => ':attribute en az :min öğeye sahip olmalıdır.',
        'file' => ':attribute en az :min kilobayt olmalıdır.',
        'numeric' => ':attribute en az :min olmalıdır.',
        'string' => ':attribute en az :min karakter olmalıdır.',
    ],
    'min_digits' => ':attribute en az :min basamak olmalıdır.',
    'missing' => ':attribute alanı eksik olmalıdır.',
    'missing_if' => ':attribute, :other :value olduğunda eksik olmalıdır.',
    'missing_unless' => ':attribute, :other :value olmadıkça eksik olmalıdır.',
    'missing_with' => ':attribute, :values mevcut olduğunda eksik olmalıdır.',
    'missing_with_all' => ':attribute, :values mevcut olduğunda eksik olmalıdır.',
    'multiple_of' => ':attribute :value katı olmalıdır.',
    'not_in' => 'Seçilen :attribute geçersiz.',
    'not_regex' => ':attribute formatı geçersiz.',
    'numeric' => ':attribute bir sayı olmalıdır.',
    'password' => [
        'letters' => ':attribute en az bir harf içermelidir.',
        'mixed' => ':attribute en az bir büyük harf ve bir küçük harf içermelidir.',
        'numbers' => ':attribute en az bir sayı içermelidir.',
        'symbols' => ':attribute en az bir sembol içermelidir.',
        'uncompromised' => 'Seçilen :attribute bir veri sızıntısında bulundu. Lütfen farklı bir :attribute seçin.',
    ],
    'present' => ':attribute alanı mevcut olmalıdır.',
    'present_if' => ':attribute, :other :value olduğunda mevcut olmalıdır.',
    'present_unless' => ':attribute, :other :value olmadıkça mevcut olmalıdır.',
    'present_with' => ':attribute, :values mevcut olduğunda mevcut olmalıdır.',
    'present_with_all' => ':attribute, :values mevcut olduğunda mevcut olmalıdır.',
    'prohibited' => ':attribute alanı yasaktır.',
    'prohibited_if' => ':attribute alanı, :other :value olduğunda yasaktır.',
    'prohibited_unless' => ':attribute alanı, :other :values içinde olmadıkça yasaktır.',
    'prohibits' => ':attribute, :other alanının mevcut olmasını yasaklar.',
    'regex' => ':attribute formatı geçersiz.',
    'required' => ':attribute alanı zorunludur.',
    'required_array_keys' => ':attribute şu girişleri içermelidir: :values.',
    'required_if' => ':attribute alanı, :other :value olduğunda zorunludur.',
    'required_unless' => ':attribute alanı, :other :values içinde olmadıkça zorunludur.',
    'required_with' => ':attribute alanı, :values mevcut olduğunda zorunludur.',
    'required_with_all' => ':attribute alanı, :values mevcut olduğunda zorunludur.',
    'required_without' => ':attribute alanı, :values mevcut olmadığında zorunludur.',
    'required_without_all' => ':attribute alanı, :values içinden hiçbiri mevcut olmadığında zorunludur.',
    'same' => ':attribute ve :other eşleşmelidir.',
    'size' => [
        'array' => ':attribute :size öğe içermelidir.',
        'file' => ':attribute :size kilobayt olmalıdır.',
        'numeric' => ':attribute :size olmalıdır.',
        'string' => ':attribute :size karakter olmalıdır.',
    ],
    'starts_with' => ':attribute şu değerlerden biriyle başlamalıdır: :values.',
    'string' => ':attribute bir metin olmalıdır.',
    'timezone' => ':attribute geçerli bir saat dilimi olmalıdır.',
    'ulid' => ':attribute geçerli bir ULID olmalıdır.',
    'unique' => ':attribute zaten alınmış.',
    'uploaded' => ':attribute yüklenemedi.',
    'uppercase' => ':attribute büyük harf olmalıdır.',
    'url' => ':attribute geçerli bir URL olmalıdır.',
    'uuid' => ':attribute geçerli bir UUID olmalıdır.',


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

    'attributes' => [],

];
