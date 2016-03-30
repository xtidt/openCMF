<?php
// +----------------------------------------------------------------------
// | OpenCMF [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.opencmf.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------

/**
 * OpenCMF全局配置文件
 */
$_config = array(
    /**
     * 产品配置
     * 根据OpenCMF用户协议：
     * 任何情况下使用OpenCMF均需获取官方授权（除了开源版本即CoreThink），违者追究法律责任，授权联系：admin@opencmf.cn
     */
    'PRODUCT_NAME'    => 'OpenCMF',                      // 产品名称
    'PRODUCT_LOGO'    => '<b><span class="open" style="color: #a5aeb4;">Core</span><span class="cmf" style="color: #3fa9f5;">Think</span></b>',  // 产品Logo
    'CURRENT_VERSION' => '1.2.0',                        // 当前版本号
    'DEVELOP_VERSION' => 'release',                      // 开发版本号
    'BUILD_VERSION'   => '201601222050',                 // 编译标记
    'PRODUCT_MODEL'   => 'corethink',                    // 产品型号
    'PRODUCT_TITLE'   => '开源版',                        // 产品标题
    'WEBSITE_DOMAIN'  => 'http://www.corethink.cn',      // 官方网址
    'UPDATE_URL'      => '/appstore/home/core/update',   // 官方更新网址
    'COMPANY_NAME'    => '南京科斯克网络科技有限公司',     // 公司名称
    'DEVELOP_TEAM'    => '南京科斯克网络科技有限公司',     // 当前项目开发团队名称

    // 产品简介
    'PRODUCT_INFO'    => 'OpenCMF是一套基于统一核心的通用互联网+信息化服务解决方案，追求简单、高效、卓越。可轻松实现支持多终端的WEB产品快速搭建、部署、上线。系统功能采用模块化、组件化、插件化等开放化低耦合设计，应用商城拥有丰富的功能模块、插件、主题，便于用户灵活扩展和二次开发。',

    // 公司简介
    'COMPANY_INFO'    => '南京科斯克网络科技有限公司是一家新兴的互联网+项目技术解决方案提供商。我们用敏锐的视角洞察IT市场的每一次变革,我们顶着时代变迁的浪潮站在了前沿,以开拓互联网行业新渠道为己任。',

    // 系统主页地址配置
    'HOME_PAGE'       => (is_ssl()?'https://':'http://').$_SERVER['HTTP_HOST'].__ROOT__,

    // URL模式
    'URL_MODEL' => '3',

    // 全局过滤配置
    'DEFAULT_FILTER' => '', //TP默认为htmlspecialchars

    // 预先加载的标签库
    'TAGLIB_PRE_LOAD' => 'Home\\TagLib\\Opencmf',

    // URL配置
    'URL_CASE_INSENSITIVE' => true,  // 不区分大小写

    // 应用配置
    'DEFAULT_MODULE'     => 'Home',
    'MODULE_DENY_LIST'   => array('Common'),
    'MODULE_ALLOW_LIST'  => array('Home','Install'),

    // 模板相关配置
    'TMPL_PARSE_STRING'  => array(
        '__PUBLIC__'     => __ROOT__.'/Public',
        '__CUI__'        => __ROOT__.'/Public/libs/cui',
        '__ADMIN_IMG__'  => __ROOT__.'/'.APP_PATH.'Admin/View/Public/img',
        '__ADMIN_CSS__'  => __ROOT__.'/'.APP_PATH.'Admin/View/Public/css',
        '__ADMIN_JS__'   => __ROOT__.'/'.APP_PATH.'Admin/View/Public/js',
        '__ADMIN_LIBS__' => __ROOT__.'/'.APP_PATH.'Admin/View/Public/libs',
        '__HOME_IMG__'   => __ROOT__.'/'.APP_PATH.'Home/View/Public/img',
        '__HOME_CSS__'   => __ROOT__.'/'.APP_PATH.'Home/View/Public/css',
        '__HOME_JS__'    => __ROOT__.'/'.APP_PATH.'Home/View/Public/js',
        '__HOME_LIBS__'  => __ROOT__.'/'.APP_PATH.'Home/View/Public/libs',
    ),

    // 系统功能模板
    'USER_CENTER_SIDE'    => APP_PATH.'User/View/Index/side.html',
    'USER_CENTER_FORM'    => APP_PATH.'User/View/Builder/form.html',
    'USER_CENTER_LIST'    => APP_PATH.'User/View/Builder/list.html',
    'USER_LOGIN_MODAL'    => APP_PATH.'User/View/User/login_modal.html',
    'HOME_PUBLIC_LAYOUT'  => APP_PATH.'Home/View/Public/layout.html',
    'ADMIN_PUBLIC_LAYOUT' => APP_PATH.'Admin/View/Public/layout.html',

    // 错误页面模板
    'TMPL_ACTION_ERROR'   => APP_PATH.'Home/View/Public/think/error.html',      // 错误跳转对应的模板文件
    'TMPL_ACTION_SUCCESS' => APP_PATH.'Home/View/Public/think/success.html',    // 成功跳转对应的模板文件
    'TMPL_EXCEPTION_FILE' => APP_PATH.'Home/View/Public/think/exception.html',  // 异常页面的模板文件

    // 文件上传默认驱动
    'UPLOAD_DRIVER' => 'Local',

    // 文件上传相关配置
    'UPLOAD_CONFIG' => array(
        'mimes'    => '',                        // 允许上传的文件MiMe类型
        'maxSize'  => 2*1024*1024,               // 上传的文件大小限制 (0-不做限制，默认为2M，后台配置会覆盖此值)
        'autoSub'  => true,                      // 自动子目录保存文件
        'subName'  => array('date', 'Y-m-d'),    // 子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
        'rootPath' => './Uploads/',              // 保存根路径
        'savePath' => '',                        // 保存路径
        'saveName' => array('uniqid', ''),       // 上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
        'saveExt'  => '',                        // 文件保存后缀，空则使用原后缀
        'replace'  => false,                     // 存在同名是否覆盖
        'hash'     => true,                      // 是否生成hash编码
        'callback' => false,                     // 检测文件是否存在回调函数，如果存在返回文件信息数组
    ),
);

// 获取数据库配置信息，手动修改数据库配置请修改./Data/db.php，这里无需改动
if (is_file('./Data/db.php')) {
    $db_config = include './Data/db.php';  // 包含数据库连接配置
} else {
    // 开启开发部署模式
    if (@$_SERVER[ENV_PRE.'DEV_MODE'] === 'true') {
        // 数据库配置
        $db_config = array(
            'DB_TYPE'   => $_SERVER[ENV_PRE.'DB_TYPE'] ? : 'mysql',           // 数据库类型
            'DB_HOST'   => $_SERVER[ENV_PRE.'DB_HOST'] ? : '127.0.0.1',       // 服务器地址
            'DB_NAME'   => $_SERVER[ENV_PRE.'DB_NAME'] ? : 'opencmf',       // 数据库名
            'DB_USER'   => $_SERVER[ENV_PRE.'DB_USER'] ? : 'root',            // 用户名
            'DB_PWD'    => $_SERVER[ENV_PRE.'DB_PWD']  ? : '',                // 密码
            'DB_PORT'   => $_SERVER[ENV_PRE.'DB_PORT'] ? : '3306',            // 端口
            'DB_PREFIX' => $_SERVER[ENV_PRE.'DB_PREFIX'] ? : 'oc_',           // 数据库表前缀
        );
    } else {
        // 数据库配置
        $db_config = array(
            'DB_TYPE'   => 'mysql',           // 数据库类型
            'DB_HOST'   => '127.0.0.1',       // 服务器地址
            'DB_NAME'   => 'opencmf',       // 数据库名
            'DB_USER'   => 'root',            // 用户名
            'DB_PWD'    => '',                // 密码
            'DB_PORT'   => '3306',            // 端口
            'DB_PREFIX' => 'oc_',             // 数据库表前缀
        );
    }
}

// 如果数据表字段名采用大小写混合需配置此项
$db_config['DB_PARAMS'] = array(\PDO::ATTR_CASE => \PDO::CASE_NATURAL);

// 返回合并的配置
return array_merge(
    $_config,                                      // 系统全局默认配置
    $db_config,                                    // 数据库配置数组
    include APP_PATH.'/Common/Builder/config.php'  // 包含Builder配置
);
