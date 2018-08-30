<?php

use Cake\Core\Configure;

//Config for Countries
Configure::write('Admin.Tables.Countries.header', [
    'id' => [
        'label' => __d('ittvn', 'Id'),
        'sort' => true,
        'filter' => 'text'
    ],
    'name' => [
        'label' => __d('ittvn', 'Country'),
        'sort' => true,
        'filter' => 'text'
    ],
    'slug' => [
        'label' => __d('ittvn', 'Slug'),
        'sort' => true,
        'filter' => 'text'
    ],
    'code' => [
        'label' => __d('ittvn', 'Code'),
        'sort' => true,
        'filter' => 'text'
    ]
]);

Configure::write('Admin.Forms.Countries', [
    'main' => [
        'default' => [
            'label' => 'Default',
            'name' => [
                'type' => 'text'
            ],
            'slug' => [
                'type' => 'text'
            ],
            'code' => [
                'type' => 'text'
            ],
        ]
    ],
    'sidebar' => [
        'action' => [
            'label' => 'Action',
        ]
    ]
]);

//Config for Provinces
Configure::write('Admin.Tables.Provinces.header', [
    'id' => [
        'label' => __d('ittvn', 'Id'),
        'sort' => true,
        'filter' => 'text'
    ],
    'name' => [
        'label' => __d('ittvn', 'Province'),
        'sort' => true,
        'filter' => 'text'
    ],
    'slug' => [
        'label' => __d('ittvn', 'Slug'),
        'sort' => true,
        'filter' => 'text'
    ],
    'country_id' => [
        'label' => __d('ittvn', 'Country'),
        'sort' => true,
        'filter' => 'text'
    ]
]);

Configure::write('Admin.Forms.Provinces', [
    'main' => [
        'default' => [
            'label' => 'Default',
            'name' => [
                'type' => 'text'
            ],
            'slug' => [
                'type' => 'text'
            ]
        ]
    ],
    'sidebar' => [
        'action' => [
            'label' => 'Action',
            'country_id' => [
                'type' => 'select',
                'options' => 'countries'
            ]
        ]
    ]
]);

//Config for Cities
Configure::write('Admin.Tables.Cities.header', [
    'id' => [
        'label' => __d('ittvn', 'Id'),
        'sort' => true,
        'filter' => 'text'
    ],
    'name' => [
        'label' => __d('ittvn', 'City'),
        'sort' => true,
        'filter' => 'text'
    ],
    'slug' => [
        'label' => __d('ittvn', 'Slug'),
        'sort' => true,
        'filter' => 'text'
    ],
    'province_id' => [
        'label' => __d('ittvn', 'Province'),
        'sort' => true,
        'filter' => 'text'
    ],
    'country_id' => [
        'label' => __d('ittvn', 'Country'),
        'sort' => true,
        'filter' => 'text'
    ]
]);

Configure::write('Admin.Forms.Cities', [
    'main' => [
        'default' => [
            'label' => 'Default',
            'name' => [
                'type' => 'text'
            ],
            'slug' => [
                'type' => 'text'
            ]
        ]
    ],
    'sidebar' => [
        'action' => [
            'label' => 'Action',
            'country_id' => [
                'type' => 'select',
                'options' => 'countries'
            ],
            'province_id' => [
                'type' => 'select',
                'options' => 'provinces',
            ]
        ]
    ]
]);

//Config for Wards
Configure::write('Admin.Tables.Wards.header', [
    'id' => [
        'label' => __d('ittvn', 'Id'),
        'sort' => true,
        'filter' => 'text'
    ],
    'name' => [
        'label' => __d('ittvn', 'Ward'),
        'sort' => true,
        'filter' => 'text'
    ],
    'slug' => [
        'label' => __d('ittvn', 'Slug'),
        'sort' => true,
        'filter' => 'text'
    ],
    'city_id' => [
        'label' => __d('ittvn', 'City'),
        'sort' => true,
        'filter' => 'text'
    ],
    'province_id' => [
        'label' => __d('ittvn', 'Province'),
        'sort' => true,
        'filter' => 'text'
    ],
    'country_id' => [
        'label' => __d('ittvn', 'Country'),
        'sort' => true,
        'filter' => 'text'
    ]
]);

Configure::write('Admin.Forms.Wards', [
    'main' => [
        'default' => [
            'label' => 'Default',
            'name' => [
                'type' => 'text'
            ],
            'slug' => [
                'type' => 'text'
            ]
        ]
    ],
    'sidebar' => [
        'action' => [
            'label' => 'Action',
            'country_id' => [
                'type' => 'select',
                'options' => 'countries',
                'value' => 243
            ],
            'province_id' => [
                'type' => 'select',
                'options' => 'provinces',
            ],
            'city_id' => [
                'type' => 'select',
                'options' => 'cities',
            ]
        ]
    ]
]);

Configure::write('dataCountries', [
    '278' => 'An Giang',
    '280' => 'Bà Rịa - Vũng Tàu',
    '282' => 'Bắc Giang',
    '281' => 'Bắc Kạn',
    '279' => 'Bạc Liêu',
    '283' => 'Bắc Ninh',
    '284' => 'Bến Tre',
    '285' => 'Bình Dương',
    '286' => 'Bình Phước',
    '287' => 'Bình Thuận',
    '316' => 'Bình Định',
    '289' => 'Cà Mau',
    '290' => 'Cần Thơ',
    '288' => 'Cao Bằng',
    '293' => 'Gia Lai',
    '295' => 'Hà Giang',
    '296' => 'Hà Nam',
    '297' => 'Hà Nội',
    '299' => 'Hà Tĩnh',
    '300' => 'Hải Dương',
    '301' => 'Hải Phòng',
    '319' => 'Hậu Giang',
    '294' => 'Hồ Chí Minh',
    '302' => 'Hoà Bình',
    '320' => 'Hưng Yên',
    '321' => 'Khánh Hòa',
    '322' => 'Kiên Giang',
    '323' => 'Kon Tum',
    '304' => 'Lai Châu',
    '306' => 'Lâm Đồng',
    '305' => 'Lạng Sơn',
    '324' => 'Lào Cai',
    '325' => 'Long An',
    '326' => 'Nam Định',
    '327' => 'Nghệ An',
    '307' => 'Ninh Bình',
    '328' => 'Ninh Thuận',
    '329' => 'Phú Thọ',
    '308' => 'Phú Yên',
    '309' => 'Quảng Bình',
    '310' => 'Quảng Nam',
    '311' => 'Quảng Ngãi',
    '330' => 'Quảng Ninh',
    '312' => 'Quảng Trị',
    '313' => 'Sóc Trăng',
    '331' => 'Sơn La',
    '332' => 'Tây Ninh',
    '333' => 'Thái Bình',
    '334' => 'Thái Nguyên',
    '335' => 'Thanh Hóa',
    '303' => 'Thừa Thiên Huế',
    '336' => 'Tiền Giang',
    '314' => 'Trà Vinh',
    '315' => 'Tuyên Quang',
    '337' => 'Vĩnh Long',
    '338' => 'Vĩnh Phúc',
    '339' => 'Yên Bái',
    '291' => 'Đà Nẵng',
    '292' => 'Đắk Lắk',
    '340' => 'Đắk Nông',
    '341' => 'Điện Biên',
    '317' => 'Đồng Nai',
    '318' => 'Đồng Tháp',
]);
