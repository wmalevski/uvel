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

    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => 'The :attribute may only contain letters.',
    'alpha_dash'           => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num'            => 'The :attribute may only contain letters and numbers.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'The :attribute must be a date before :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => ':attribute може да бъде от :min до :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => 'Полето :attribute не съвпада.',
    'date'                 => 'Полето :attribute трябва да е валидна дата.',
    'date_format'          => 'The :attribute does not match the format :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => 'Полето :attribute може да бъде от :min до :max digits.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'Полето :attribute трябва да е валиден email адрес.',
    'exists'               => 'The selected :attribute is invalid.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => 'The :attribute must be an image.',
    'in'                   => 'The selected :attribute is invalid.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'The :attribute must be an integer.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => 'The :attribute may not be greater than :max characters.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => ':attribute трябва да е валидно.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'The :attribute must be at least :min characters.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'numeric'              => 'Полето :attribute трябва да е число.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'The :attribute format is invalid.',
    'required'             => 'Полето :attribute е задължително.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'Полето :attribute съдържа име, което вече е използвано.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'The :attribute format is invalid.',

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
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        //Global
        'name' => 'Име',
        'slug' => 'Име',
        'title' => 'Заглавие',
        'material' => 'Материал',
        'discount' => 'Отстъпка',
        'location' => 'Адрес',
        'phone' => 'Телефон',
        'type' => 'Тип',
        'price' => 'Цена',
        'email' => 'Имейл',
        'password' => 'Парола',
        'size' => 'Размер',
        'model' => 'Модел',
        'weight' => 'Тегло',
        'quantity' => 'Количество',
        'amount' => 'Количество',
        'code' => 'Код',
        'color' => 'Цвят',
        'style' => 'Стил',
        'contour' => 'Контур',
        'currency ' => 'Курс',
        'g-recaptcha-response' => 'за валидация',
        'message' => 'Съобщение',
        'comment' => 'Коментар',
        'content' => 'Описание',
        'city' => 'Град',
        'street' => 'Улица',
        'street_number' => 'Номер',
        'postcode' => 'Пощенски код',
        'country' => 'Държава',
        'payment_method' => 'Начин на плащане',
        'shipping_method' => 'Начин на получаване',
        'first_name' => 'Име',
        'last_name' => 'Фамилия',

        //Repairs
        'customer_name' => 'Име на клиент',
        'customer_phone' => 'Телефон на клиент',
        'date_returned'=> 'Дата на връщане',

        //Orders
        'store_id' => 'Магазин',
        'gross_weight' => 'Брутно тегло',
        'material_id' => 'Материал',
        'retail_price_id' => 'Цена на грам',
        'mat_quantity.*' => 'Количество',

        //ProductOthers
        'type_id' => 'Тип',

        //Products
        'store_to_id' => 'Магазин',

        //Materials
        'parent_id' => 'Наследява',
        'cash_group' => 'Касова група',

        //Stones
        'nomenclature_id' => 'Име(Номенклатура)',
        'size_id' => 'Размер',
        'style_id' => 'Стил',
        'contour_id' => 'Контур',

        //Currencies
        'currency' => 'Валута',

        //Models
        'jewel' => 'Бижу',
        'jewel_id' => 'Бижу',
        'jewelsTypes'  => 'Вид',
        'wholesale_prices' => 'Цена на едро',
        'workmanship' => 'Изработка',
        'retail_price' => 'Цена на грам',
        'stone_amount.*' => 'Брой камъни',
        'stone_weight.*' => 'Тегло камъни',
        'storeTo' => 'Магазин',
        'carat' => 'Карат',
        'deposit' => 'Капаро',
        'stock_price.*' => 'Цената',
        'material_id.*' => 'Материал',
        'retail_price_id.*' => 'Цена на грам',

        //Blog
        'images' => 'за снимка',
        'title.bg' => 'Заглавие на Български',
        'title.en' => 'Заглавие на Английски',
        'images.bg' => 'Снимка (Български)',
        'images.en' => 'Снимка (Английски)',
        'content.bg' => 'Съдържание на Български',
        'content.en' => 'Съдържение на Английски',
        'excerpt.bg' => 'Описание на Български',
        'excerpt.en' => 'Описание на Английски',

        //Expenses
        'additional_info' => 'Кратко Описание',
        'expense_amount' => 'Сума',

        //Cash groups
        'label' => 'За'
    ],

];
