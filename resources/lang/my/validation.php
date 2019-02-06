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

    'accepted'             => ':attribute hendaklah diterima.',
    'active_url'           => ':attribute bukan URL yang sah.',
    'after'                => ':attribute hendaklah selepas :date.',
    'after_or_equal'       => ':attribute hendaklah pada atau selepas :date.',
    'alpha'                => ':attribute hanya boleh mengandungi huruf.',
    'alpha_dash'           => ':attribute hanya boleh mengandungi huruf, nombor dan sengkang(-).',
    'alpha_num'            => ':attribute hanya boleh mengandungi huruf dan nombor.',
    'array'                => ':attribute hendaklah dalam format array.',
    'before'               => ':attribute hendaklah sebelum :date.',
    'before_or_equal'      => ':attribute hendaklah pada atau sebelum :date.',
    'between'              => [
        'numeric' => ':attribute hendaklah diantara :min dan :max.',
        'file'    => ':attribute hendaklah diantara :min dan :max kilobait.',
        'string'  => ':attribute hendaklah diantara :min dan :max abjad.',
        'array'   => ':attribute hendaklah mengandungi antara :min dan :max item.',
    ],
    'boolean'              => 'Input :attribute hendaklah benar atau tidak.',
    'confirmed'            => 'Pengesahan :attribute tidak sepadan.',
    'date'                 => ':attribute bukan tarikh yang sah.',
    'date_format'          => ':attribute tidak sepadan dengan format :format.',
    'different'            => ':attribute dan :other hendaklah berbeza.',
    'digits'               => ':attribute hendaklah :digits digit.',
    'digits_between'       => ':attribute hendaklah diantara :min dan :max digit.',
    'dimensions'           => ':attribut mengandungi dimensi gambar yang tidak sah.',
    'distinct'             => 'Input :attribute mengandungi nilai yang sama.',
    'email'                => ':attribute hendaklah merupakan alamat emel yang sah.',
    'exists'               => 'Input :attribute yang dipilih adalah tidak sah.',
    'file'                 => ':attribute hendaklah dalam format fail.',
    'filled'               => 'Input :attribute hendaklah mempunyai nilai.',
    'image'                => ':attribute hendaklah merupakan gambar.',
    'in'                   => 'Input :attribute yang dipilih adalah tidak sah.',
    'in_array'             => 'Input :attribute tidak wujud dalam :other.',
    'integer'              => ':attribute hendaklah merupakan nombor asli.',
    'ip'                   => ':attribute hendaklah merupakan alamat IP yang sah.',
    'ipv4'                 => ':attribute hendaklah merupakan alamat IPv4 yang sah.',
    'ipv6'                 => ':attribute hendaklah merupakan alamat IPv6 yang sah.',
    'json'                 => ':attribute hendaklah merupakan data JSON yang sah.',
    'max'                  => [
        'numeric' => ':attribute hendaklah tidak lebih dari :max.',
        'file'    => ':attribute hendaklah tidak lebih dari :max kilobait.',
        'string'  => ':attribute hendaklah tidak lebih dari :max abjad.',
        'array'   => ':attribute hendaklah tidak mengandungi lebih dari :max item.',
    ],
    'mimes'                => ':attribute hendaklah merupakan fail jenis: :values.',
    'mimetypes'            => ':attribute hendaklah merupakan fail jenis: :values.',
    'min'                  => [
        'numeric' => ':attribute hendaklah sekurang-kurangnya :min.',
        'file'    => ':attribute hendaklah sekurang-kurangnya :min kilobait.',
        'string'  => ':attribute hendaklah sekurang-kurangnya :min abjad.',
        'array'   => ':attribute hendaklah mengandungi sekurang-kurangnya :min item.',
    ],
    'not_in'               => 'Input :attribute yang dipilih adalah tidak sah.',
    'numeric'              => ':attribute hendaklah merupakan nombor.',
    'present'              => 'Input :attribute hendaklah wujud.',
    'regex'                => 'Format:attribute tidak sah.',
    'required'             => 'Input :attribute wajib diisi.',
    'required_if'          => 'Input :attribute wajib diisi jika :other adalah :value.',
    'required_unless'      => 'Input :attribute wajib diisi kecuali :other adalah :values.',
    'required_with'        => 'Input :attribute wajib diisi jika :values wujud.',
    'required_with_all'    => 'Input :attribute wajib diisi jika :values wujud.',
    'required_without'     => 'Input :attribute wajib diisi jika :values tidak wujud.',
    'required_without_all' => 'Input :attribute wajib diisi jika tiada :values yang wujud.',
    'same'                 => ':attribute dan :other hendaklah sepadan.',
    'size'                 => [
        'numeric' => ':attribute hendaklah :size.',
        'file'    => ':attribute hendaklah :size kilobait.',
        'string'  => ':attribute hendaklah :size abjad.',
        'array'   => ':attribute hendaklah mengandungi :size item.',
    ],
    'string'               => ':attribute hendaklah dalam bentuk ayat.',
    'timezone'             => ':attribute hendaklah zon yang sah.',
    'unique'               => ':attribute sudah digunakan.',
    'uploaded'             => ':attribute gagal untuk dimuat naik.',
    'url'                  => 'Format :attribute tidak sah.',

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

        'email' => 'emel',
        'password' => 'kata laluan',
        'password_confirmation' => 'pengesahan kata laluan',
        'username' => 'id pengguna',
        'uname' => 'nama setiausaha penaja',
        'phone' => 'no telefon',
        'fax' => 'no faks',
        'is_union' => 'adalah kesatuan',
        'registered_at' => 'tarikh penubuhan',
        'name' => 'nama',
        'address1' => 'alamat1',
        'address2' => 'alamat2',
        'address3' => 'alamat3',
        'state_id' => 'id negeri',
        'district_id' => 'id daerah',
        'postcode' => 'poskod',
        'sector_id' => 'id sektor',
        'designation' => 'jawatan',
        'office-province' => 'pejabat wilayah',
        '' => '',
        '' => '',
        '' => '',
        '' => '',
        '' => '',
        '' => '',
        '' => '',
        '' => '',
        '' => '',
        '' => '',
    ],

];
