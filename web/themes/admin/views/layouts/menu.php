<?php

use yii\helpers\Url;

echo \yii\widgets\Menu::widget([
    'options' => ['class' => 'sidebar-menu treeview'],
    'items' => [
        ['label' => 'Navigation', 'options' => ['class' => 'header']],
        ['label' => "<i class='fa fa-home'></i> <span>Home</span>", 'url' => Url::to(['/backend/default/index'], true)],
        ['label' => "<i class='fa fa-youtube-play'></i> <span>Banner</span>", 'url' => Url::to(['/backend/banner/index'], true)],
        ['label' => "<i class='fa fa-image'></i> <span>Theme</span>", 'url' => Url::to(['/backend/theme/index'], true)],
        ['label' => "<i class='fa fa-refresh'></i> <span>General Settings</span>", 'url' => Url::to(['/backend/setting'], true)],
        ['label' => "<i class='fa fa-align-justify'></i> <span>Menu Manager</span>", 'url' => Url::to(['/backend/menu/index'], true)],
        ['label' => "<i class='fa fa-book'></i> <span>Course Manager</span>", 'url' => Url::to(['/backend/course/index'], true)],
        ['label' => "<i class='fa fa-universal-access'></i> <span>Subject Manager</span>", 'url' => Url::to(['/backend/subject/index'], true)],
        ['label' => "<i class='fa fa-rupee'></i> <span>Order Manager</span>", 'url' => Url::to(['/backend/order/index'], true)],
        /*['label' => "<i class='fa fa-picture-o'></i> <span>Media Manager</span>", 'url' => Url::to(['/backend/media/index'], true)],*/
        
        ['label' => "<i class='fa fa-users'></i> <span>Teacher Manager</span>",
            'url' => ['#'],
            'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
            'items' => [
                ['label' => 'Attendance Manager', 'url' => Url::to(['/backend/teacher/attendance'], true)],
                ['label' => 'Export Teacher Attendance', 'url' => Url::to(['/backend/teacher/export'], true)],
            ],
        ],
        
        ['label' => "<i class='fa fa-users'></i> <span>User Manager</span>",
            'url' => ['#'],
            'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
            'items' => [
                ['label' => 'Create User', 'url' => Url::to(['/backend/user/create'], true)],
                ['label' => 'List All Users', 'url' => Url::to(['/backend/user/index'], true)],
            ],
        ],
        ['label' => "<i class='fa fa-edit'></i> <span>Pages Manager</span>",
            'url' => ['#'],
            'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
            'items' => [
                ['label' => 'List All Page Categories', 'url' => Url::to(['/backend/pagecategory/index'], true)],
                ['label' => 'Create Page Category', 'url' => Url::to(['/backend/pagecategory/create'], true)],
                ['label' => 'Create Page', 'url' => Url::to(['/backend/page/create'], true)],
                ['label' => 'List All Pages', 'url' => Url::to(['/backend/page/index'], true)],
                ['label' => 'Manage Comments', 'url' => Url::to(['/backend/comment/index'], true)],
            ],
        ],
        ['label' => "<i class='fa fa-minus'></i> <span>Logout</span>", 'url' => Url::to(['/site/logout'], true)],
    ],
    'submenuTemplate' => "\n<ul class='treeview-menu'>\n{items}\n</ul>\n",
    'encodeLabels' => false, //allows you to use html in labels
    'activateParents' => true,]);

