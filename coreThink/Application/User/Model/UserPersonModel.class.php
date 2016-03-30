<?php
// +----------------------------------------------------------------------
// | OpenCMF [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.opencmf.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------
namespace User\Model;
use Think\Model;
/**
 * 个人用户模型
 * @author jry <598821125@qq.com>
 */
class UserPersonModel extends Model {
    /**
     * 数据库表名
     * @author jry <598821125@qq.com>
     */
    protected $tableName = 'user_person';

    /**
     * 自动验证规则
     * @author jry <598821125@qq.com>
     */
    protected $_validate = array(
        array('city', 'require', '请填写所在城市', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('summary', 'require', '请填写签名介绍', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    );
}
