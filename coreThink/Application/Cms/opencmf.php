<?php
// +----------------------------------------------------------------------
// | OpenCMF [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.opencmf.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------
// 模块信息配置
return array(
    // 模块信息
    'info' => array(
        'name'        => 'Cms',
        'title'       => 'CMS',
        'icon'        => 'fa fa-newspaper-o',
        'icon_color'  => '#9933FF',
        'description' => 'CMS门户模块',
        'developer'   => '南京科斯克网络科技有限公司',
        'website'     => 'http://www.opencmf.cn',
        'version'     => '1.2.0',
        'dependences' => array(
            'Admin'   => '1.1.0',
        )
    ),

    // 用户中心导航
    'user_nav' => array(
        'center' => array(
            '0' => array(
                'title' => '我的文档',
                'icon'  => 'fa fa-list',
                'url'   => 'Cms/Index/my',
            ),
        ),
    ),

    // 模块配置
    'config' => array(
        'need_check' => array(
            'title'   => '前台发布审核',
            'type'    => 'radio',
            'options' => array(
                '1'   => '需要',
                '0'   => '不需要',
            ),
            'value'   => '0',
        ),
        'toggle_comment' => array(
            'title'  => '是否允许评论文档',
            'type'   =>'radio',
            'options' => array(
                '1'   => '允许',
                '0'   => '不允许',
            ),
            'value'  => '1',
        ),
        'group_list' => array(
            'title'  => '栏目分组',
            'type'   =>'array',
            'value'  => '1:默认',
        ),
        'cate' => array(
            'title'  => '首页栏目自定义',
            'type'   =>'array',
            'value'  => 'a:1',
        ),
        'taglib' => array(
            'title'  => '加载标签库',
            'type'   =>'checkbox',
            'options'=> array(
                'Cms' => 'Cms',
            ),
            'value'  => array(
                '0'  => 'Cms',
            ),
        ),
    ),

    // 后台菜单及权限节点配置
    'admin_menu' => array(
        '1' => array(
            'id'    => '1',
            'pid'   => '0',
            'title' => 'CMS',
            'icon'  => 'fa fa-newspaper-o',
        ),
        '2' => array(
            'pid'   => '1',
            'title' => '内容管理',
            'icon'  => 'fa fa-folder-open-o',
        ),
        '3' => array(
            'pid'   => '2',
            'title' => '文章配置',
            'icon'  => 'fa fa-wrench',
            'url'   => 'Cms/Index/module_config',
        ),
        '4' => array(
            'pid'   => '2',
            'title' => '文档模型',
            'icon'  => 'fa fa-th-large',
            'url'   => 'Cms/Type/index',
        ),
        '5' => array(
            'pid'   => '4',
            'title' => '新增',
            'url'   => 'Cms/Type/add',
        ),
        '6' => array(
            'pid'   => '4',
            'title' => '编辑',
            'url'   => 'Cms/Type/edit',
        ),
        '7' => array(
            'pid'   => '4',
            'title' => '设置状态',
            'url'   => 'Cms/Type/setStatus',
        ),
        '8' => array(
            'pid'   => '4',
            'title' => '字段管理',
            'icon'  => 'fa fa-database',
            'url'   => 'Cms/Attribute/index',
        ),
        '9' => array(
            'pid'   => '8',
            'title' => '新增',
            'url'   => 'Cms/Attribute/add',
        ),
        '10' => array(
            'pid'   => '8',
            'title' => '编辑',
            'url'   => 'Cms/Attribute/edit',
        ),
        '11' => array(
            'pid'   => '8',
            'title' => '设置状态',
            'url'   => 'Cms/Attribute/setStatus',
        ),
        '12' => array(
            'pid'   => '2',
            'title' => '栏目分类',
            'icon'  => 'fa fa-navicon',
            'url'   => 'Cms/Category/index',
        ),
        '13' => array(
            'pid'   => '12',
            'title' => '新增',
            'url'   => 'Cms/Category/add',
        ),
        '14' => array(
            'pid'   => '12',
            'title' => '编辑',
            'url'   => 'Cms/Category/edit',
        ),
        '15' => array(
            'pid'   => '12',
            'title' => '设置状态',
            'url'   => 'Cms/Category/setStatus',
        ),
        '16' => array(
            'pid'   => '2',
            'title' => '文章管理',
            'icon'  => 'fa fa-edit',
            'url'   => 'Cms/Index/index',
        ),
        '17' => array(
            'pid'   => '2',
            'title' => '幻灯切换',
            'icon'  => 'fa fa-image',
            'url'   => 'Cms/Slider/index',
        ),
        '18' => array(
            'pid'   => '17',
            'title' => '新增',
            'url'   => 'Cms/Slider/add',
        ),
        '19' => array(
            'pid'   => '17',
            'title' => '编辑',
            'url'   => 'Cms/Slider/edit',
        ),
        '20' => array(
            'pid'   => '17',
            'title' => '设置状态',
            'url'   => 'Cms/Slider/setStatus',
        ),
        '21' => array(
            'pid'   => '2',
            'title' => '通知公告',
            'icon'  => 'fa fa-bullhorn',
            'url'   => 'Cms/Notice/index',
        ),
        '22' => array(
            'pid'   => '21',
            'title' => '新增',
            'url'   => 'Cms/Notice/add',
        ),
        '23' => array(
            'pid'   => '21',
            'title' => '编辑',
            'url'   => 'Cms/Notice/edit',
        ),
        '24' => array(
            'pid'   => '21',
            'title' => '设置状态',
            'url'   => 'Cms/Notice/setStatus',
        ),
        '25' => array(
            'pid'   => '2',
            'title' => '底部导航',
            'icon'  => 'fa fa-map-signs',
            'url'   => 'Cms/Footnav/index',
        ),
        '26' => array(
            'pid'   => '25',
            'title' => '新增',
            'url'   => 'Cms/Footnav/add',
        ),
        '27' => array(
            'pid'   => '25',
            'title' => '编辑',
            'url'   => 'Cms/Footnav/edit',
        ),
        '28' => array(
            'pid'   => '25',
            'title' => '设置状态',
            'url'   => 'Cms/Footnav/setStatus',
        ),
        '29' => array(
            'pid'   => '2',
            'title' => '友情链接',
            'icon'  => 'fa fa-link',
            'url'   => 'Cms/FriendlyLink/index',
        ),
        '30' => array(
            'pid'   => '29',
            'title' => '新增',
            'url'   => 'Cms/FriendlyLink/add',
        ),
        '31' => array(
            'pid'   => '29',
            'title' => '编辑',
            'url'   => 'Cms/FriendlyLink/edit',
        ),
        '32' => array(
            'pid'   => '29',
            'title' => '设置状态',
            'url'   => 'Cms/FriendlyLink/setStatus',
        ),
        '33' => array(
            'pid'   => '2',
            'title' => '回收站',
            'icon'  => 'fa fa-recycle',
            'url'   => 'Cms/Index/recycle',
        ),
        '34' => array(
            'pid'   => '33',
            'title' => '设置状态',
            'url'   => 'Cms/Notice/setStatus',
        ),
    )
);
