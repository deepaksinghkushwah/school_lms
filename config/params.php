<?php

return [
    'user.passwordResetTokenExpire' => 3600,
    'adminName' => 'Super Administrator',
    'dateFormat' => 'l d, M Y',
    'tempPathOs' => str_replace("\\", "/", realpath(dirname('../'))) . "/temp/",
    'profileImagePathOs' => str_replace("\\", "/", realpath(dirname('../'))) . "/images/profile/",
    'profileImagePathWeb' => '/images/profile/',
    'attachmentPathOs' => str_replace("\\", "/", realpath(dirname('../'))) . "/images/attachments/",
    'attachmentPathWeb' => '/images/attachments/',
    'bannerPathOs' => str_replace("\\", "/", realpath(dirname('../'))) . "/images/banners/",
    'bannerPathWeb' => '/images/banners/',
    'mediaPathOs' => str_replace("\\", "/", realpath(dirname('../'))) . "/media/",
    'mediaPathWeb' => '/media/',
    'contentAttachmentPathOs' => str_replace("\\", "/", realpath(dirname('../'))) . "/content/attachments/",
    'contentAttachmentPathWeb' => '/content/attachments/',
    'themePathOs' => str_replace("\\", "/", realpath(dirname('../'))) . "/custom-theme/",
    'themePathWeb' => '/custom-theme/',
    'videoPathOs' => str_replace("\\", "/", realpath(dirname('../'))) . "/videos/",
    'videoPathWeb' => '/videos/',
    'status' => [
        '1' => 'Active',
        '0' => 'Inactive'
    ],
    'menu' => [
        'locations' => [
            'left' => 'Left',
            'right' => 'Right',
            'top' => 'Top',
            'bottom' => 'Bottom',
        ],
        'types' => [
            '1' => 'Dropdown',
            '2' => 'List'
        ],
        'item_type' => [
            '1' => 'Indivisual',
            '2' => 'Category'
        ],
    ],
    'payUMoney' => [
        'merchantKey' => 'jdju1hrr',
        'merchantSalt' => 'm2jVrcFbMo',
        'sandboxUrl' => 'https://sandboxsecure.payu.in/_payment', //https://sandboxsecure.payu.in/_payment
        'liveUrl' => 'https://secure.payu.in/_payment', //https://secure.payu.in/_payment
        'testCard' => [
            [
                'cardType' => 'VISA',
                'cardName' => 'Test',
                'cardNumber' => '4102001037141112',
                'expiry' => '05/20',
                'cvv' => '123',
                'otp' => '123456'
            ],
            [
                'cardType' => 'MASTER',
                'cardName' => 'Test',
                'cardNumber' => '5123456789012346',
                'expiry' => '05/20',
                'cvv' => '123',
                'otp' => '123456'
            ]
        ]
    ],
    'paytm' => [
        'env' => 'TEST',
        'test' => [            
            'PAYTM_MERCHANT_KEY' => 'bKMfNxPPf_QdZppa!wt48E',
            'PAYTM_MERCHANT_MID' => 'DIY12386817555501617',
            'PAYTM_MERCHANT_WEBSITE' => 'DIYtestingweb',
            'PAYTM_STATUS_QUERY_NEW_URL' => 'https://securegw-stage.paytm.in/merchant-status/getTxnStatus',
            'PAYTM_TXN_URL' => 'https://securegw-stage.paytm.in/theia/processTransaction',            
        ],
        'live' => [            
            'PAYTM_MERCHANT_KEY' => 'bKMfNxPPf_QdZppa!wt48E',
            'PAYTM_MERCHANT_MID' => 'DIY12386817555501617',
            'PAYTM_MERCHANT_WEBSITE' => 'DIYtestingweb',
            'PAYTM_STATUS_QUERY_NEW_URL' => 'https://securegw.paytm.in/merchant-status/getTxnStatus',
            'PAYTM_TXN_URL' => 'https://securegw.paytm.in/theia/processTransaction'
        ],
    ]
];

