<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | such as the size rules. Feel free to tweak each of these messages.
    |
     */
    'delivery_charge_min'      => 'يجب ان تكون قيمة التوصيل اكبر من صفر',
    'order_min_cost_gte_value' => 'يجب ان يكون الحد الادنى للطلب اكبر من القيمة',
    'accepted'                 => ' :attribute يجب عليك تحديد',
    'block_words'              => 'عذرا لقد إستخدمت إسم محظور',
    'block_num'                => 'عذرا لقد إستخدمت رقم محظور',
    'active_url'               => 'الحقل :attribute لا يُمثّل رابطًا صحيحًا',
    'after'                    => 'يجب على الحقل :attribute أن يكون تاريخًا لاحقًا للتاريخ :date.',
    'after_or_equal'           => ':attribute يجب أن يكون بعد أو يساوى  :date.',
    'alpha'                    => 'يجب أن لا يحتوي الحقل :attribute سوى على حروف',
    'alpha_dash'               => 'يجب أن لا يحتوي الحقل :attribute على حروف، أرقام ومطّات.',
    'alpha_num'                => 'يجب أن يحتوي :attribute على حروفٍ وأرقامٍ فقط',
    'array'                    => 'يجب أن يكون الحقل :attribute ًمصفوفة',
    'before'                   => 'يجب على الحقل :attribute أن يكون تاريخًا سابقًا للتاريخ :date.',
    'before_or_equal'          => 'The :attribute must be a date before or equal to :date.',
    'between'                  => [
        'numeric' => 'يجب أن تكون قيمة :attribute بين :min و :max.',
        'file'    => 'يجب أن يكون حجم الملف :attribute بين :min و :max كيلوبايت.',
        'string'  => 'يجب أن يكون عدد حروف النّص :attribute بين :min و :max',
        'array'   => 'يجب أن يحتوي :attribute على عدد من العناصر بين :min و :max'
    ],
    'boolean'                  => 'يجب أن تكون قيمة الحقل :attribute إما true أو false ',
    'confirmed'                => 'حقل التأكيد غير مُطابق للحقل :attribute',
    'date'                     => 'الحقل :attribute ليس تاريخًا صحيحًا',
    'date_format'              => 'لا يتوافق الحقل :attribute مع الشكل :format.',
    'different'                => 'يجب أن يكون الحقلان :attribute و :other مُختلفان',
    'digits'                   => 'يجب أن يحتوي الحقل :attribute على :digits رقمًا/أرقام',
    'digits_between'           => 'فضلا يجب أن أقل طول للرقم :min و اعلى طول :max ',
    'dimensions'               => 'الـ :attribute يحتوي على أبعاد صورة غير صالحة.',
    'distinct'                 => 'للحقل :attribute قيمة مُكرّرة.',
    'email'                    => 'يجب أن يكون :attribute عنوان بريد إلكتروني صحيح البُنية',
    'exists'                   => 'الحقل :attribute غير صحيح',
    'file'                     => 'الـ :attribute يجب أن يكون من ملفا.',
    'filled'                   => 'الحقل :attribute إجباري',
    'image'                    => 'يجب أن يكون الحقل :attribute صورةً',
    'in'                       => 'الحقل :attribute غير صحيح',
    'in_array'                 => 'الحقل :attribute غير موجود في :other.',
    'integer'                  => 'يجب أن يكون الحقل :attribute عددًا صحيحًا',
    'ip'                       => 'يجب أن يكون الحقل :attribute عنوان IP ذا بُنية صحيحة',
    'json'                     => 'يجب أن يكون الحقل :attribute نصا من نوع JSON.',
    'max'                      => [
        'numeric' => 'يجب أن تكون قيمة الحقل :attribute مساوية أو أصغر لـ :max.',
        'file'    => 'يجب أن لا يتجاوز حجم الملف :attribute :max كيلوبايت',
        'string'  => 'يجب أن لا يتجاوز طول النّص :attribute :max حروفٍ/حرفًا',
        'array'   => 'يجب أن لا يحتوي الحقل :attribute على أكثر من :max عناصر/عنصر.'
    ],
    'mimes'                    => 'يجب أن يكون الحقل ملفًا من نوع : :values.',
    'mimetypes'                => 'يجب أن يكون الحقل ملفًا من نوع : :values.',
    'min'                      => [
        'numeric' => 'يجب أن تكون قيمة الحقل :attribute مساوية أو أكبر لـ :min.',
        'file'    => 'يجب أن يكون حجم الملف :attribute على الأقل :min كيلوبايت',
        'string'  => 'يجب أن يكون طول النص :attribute على الأقل :min حروفٍ/حرفًا',
        'array'   => 'يجب أن يحتوي الحقل :attribute على الأقل على :min عُنصرًا/عناصر'
    ],
    'not_in'                   => 'الحقل :attribute لاغٍ',
    'numeric'                  => 'يجب على الحقل :attribute أن يكون رقمًا',
    'present'                  => 'يجب تقديم الحقل :attribute',
    'regex'                    => 'صيغة الحقل :attribute .غير صحيحة',
    'required'                 => 'حقل :attribute مطلوب.',
    'required_if'              => 'حقل :attribute مطلوب في حال ما إذا كان :other يساوي :value.',
    'required_unless'          => 'حقل :attribute مطلوب في حال ما لم يكن :other يساوي :values.',
    'required_with'            => 'حقل :attribute إذا توفّر :values.',
    'required_with_all'        => 'حقل :attribute إذا توفّر :values.',
    'required_without'         => 'حقل :attribute إذا لم يتوفّر :values.',
    'required_without_all'     => 'حقل :attribute إذا لم يتوفّر :values.',
    'same'                     => 'يجب أن يتطابق الحقل :attribute مع :other',
    'size'                     => [
        'numeric' => 'يجب أن تكون قيمة الحقل :attribute مساوية لـ :size',
        'file'    => 'يجب أن يكون حجم الملف :attribute :size كيلوبايت',
        'string'  => 'يجب أن يحتوي النص :attribute على :size حروفٍ/حرفًا بالظبط',
        'array'   => 'يجب أن يحتوي الحقل :attribute على :size عنصرٍ/عناصر بالظبط'
    ],
    'string'                   => 'يجب أن يكون الحقل :attribute نصآ.',
    'timezone'                 => 'يجب أن يكون :attribute نطاقًا زمنيًا صحيحًا',
    'unique'                   => 'قيمة الحقل :attribute مُستخدمة من قبل',
    'uploaded'                 => 'فشل في تحميل الـ :attribute',
    'url'                      => 'صيغة الرابط :attribute غير صحيحة',
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
    'custom'                   => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
            'today'     => 'اليوم'
        ]
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
    'attributes'               => [
        'name'                            => 'الاسم',
        'username'                        => 'اسم المُستخدم',
        'email'                           => 'البريد الالكتروني',
        'first_name'                      => 'الاسم',
        'last_name'                       => 'اسم العائلة',
        'password'                        => 'كلمة المرور',
        'password_confirmation'           => 'تأكيد كلمة المرور',
        'city'                            => 'المدينة',
        'country'                         => 'الدولة',
        'address'                         => 'العنوان',
        'phone'                           => 'الهاتف',
        'mobile'                          => 'الجوال',
        'age'                             => 'العمر',
        'sex'                             => 'الجنس',
        'gender'                          => 'النوع',
        'day'                             => 'اليوم',
        'month'                           => 'الشهر',
        'year'                            => 'السنة',
        'hour'                            => 'ساعة',
        'minute'                          => 'دقيقة',
        'second'                          => 'ثانية',
        'title'                           => 'العنوان',
        'content'                         => 'المُحتوى',
        'description'                     => 'الوصف',
        'excerpt'                         => 'المُلخص',
        'date'                            => 'التاريخ',
        'time'                            => 'الوقت',
        'available'                       => 'مُتاح',
        'size'                            => 'الحجم',
        'g-recaptcha-response'            => 'التأكيد البشرى',
        'login'                           => 'البريد الالكترونى أو رقم الجوال',
        'type'                            => 'نوع التسجيل',
        'code'                            => 'الكود',
        'access_token'                    => 'التوكن',
        'provider'                        => 'مقدم الخدمة',
        'consumer'                        => 'مزود الخدمة',
        'city_ids'                        => 'المدن',
        'accepted'                        => 'الموافقة على الشروط والاحكام',
        'commercial_number'               => 'رقم السجل التجارى',
        'commercial_image'                => 'صورة السجل التجارى',
        'bank_name'                       => 'اسم البنك',
        'bank_iban'                       => 'رقم الايبان',
        'license_image'                   => 'صورة رخصة التخليص الجمروكى',
        'old_password'                    => 'كلمة المرور القديمة',
        'new_password'                    => 'كلمة المرور الجديدة',
        'provider_id'                     => 'التوكن',
        'appointments.*'                  => 'مواعيد الحدث',
        'event_type_ids.*'                => 'أنواع الحدث',
        'event_type_ids'                  => 'أنواع الحدث',
        'target_group_ids'                => 'الفئات المستهدفة بالحدث',
        'target_group_ids.*'              => 'الفئات المستهدفه بالحدث',
        'image'                           => 'صورة',
        'avatar'                          => 'صورة',
        'en.name'                         => 'الاسم بالانجليزى',
        'ar.name'                         => 'الاسم بالعربى',
        'ar.title'                        => 'العنوان باللغة العربية',
        'en.title'                        => 'العنوان باللغة الإنجليزية',
        'en.description'                  => 'التفاصيل باللغة الإنجليزية',
        'ar.description'                  => 'التفاصيل باللغة العربية',
        'categories.*'                    => 'عنصر الأقسام',
        'start_date'                      => 'تاريخ البداية',
        'end_date'                        => 'تاريخ النهاية',
        'today'                           => 'اليوم',
        'date'                            => 'تاريخ',
        'properties'                      => 'الحقول الاضافية',
        'account_number'                  => 'رقم الحساب',
        'orders'                          => 'الطلبات',
        'properties'                      => 'الحقول الإضافية',
        'options'                         => 'الخيارات ',
        'options.*.ar.name'               => 'الخيار باللغة العربية',
        'options.*.en.name'               => 'الخيار باللغة الانجليزية',
        'value'                           => 'قيمة',
        'country_code'                    => 'كود الدولة',
        'user_address_id'                 => 'عنوان المستخدم',
        'amount'                          => 'الكمية',
        'category_id'                     => 'القسم',
        'details'                         => 'التفاصيل',
        'offer_price'                     => 'عرض السعر',
        'filter'                          => 'التصفية',
        'product_id'                      => 'المنتج',
        'user_id'                         => 'المستخدم',
        'request_offer_quantity_created'  => 'لقد تم انشاء طلبك بنجاح',
        'notes'                           => 'ملاحظات',
        'request_offer_quantity_id'       => 'رقم طلب التسعير',
        'reply_request_offer_quantity_id' => 'رقم الرد علي الطلب',
        'company_id'                      => 'المتجر',
        'product_name'                    => 'اسم المنتج',
        'invoice'                         => 'الفاتورة',
        'units'                           => 'الوحدات',
        'units.*'                         => 'الوحدة',
        'units.*.unit_id'                 => 'الوحدة',
        'units.*.id'                      => 'الوحدة',
        'units.*.en.name'                 => 'اسم الوحدة بالانجليزي',
        'units.*.ar.name'                 => 'اسم الوحدة بالعربي',
        'units.*.price'                   => 'سعر الوحدة',
        'units.*.delivery_price'          => 'سعر شحن الوحدة',
        'units.*.quantity'                => 'كمية الوحدة',
        'barcode'                         => 'الباركود',
        'latitude'                        => 'المكان ع الخريطة',
        'longitude'                       => 'المكان ع الخريطة',
        'body'                            => 'المحتوي',
        'price'                           => 'السعر'
    ]
];
