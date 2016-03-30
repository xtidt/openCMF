<?php
// +----------------------------------------------------------------------
// | OpenCMF [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.opencmf.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------
namespace Cms\Model;
use Think\Model;
use Common\Util\Tree;
/**
 * 底部导航模型
 * @author jry <598821125@qq.com>
 */
class FootnavModel extends Model {
    /**
     * 模块名称
     * @author jry <598821125@qq.com>
     */
    public $moduleName = 'Cms';

    /**
     * 数据库表名
     * @author jry <598821125@qq.com>
     */
    protected $tableName = 'cms_footnav';

    /**
     * 自动验证规则
     * @author jry <598821125@qq.com>
     */
    protected $_validate = array(
        array('title', 'require', '标题不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('url', '0,255', '链接长度为0-25个字符', self::EXISTS_VALIDATE, 'length',self::MODEL_BOTH),
    );

    /**
     * 自动完成规则
     * @author jry <598821125@qq.com>
     */
    protected $_auto = array(
        array('create_time', 'time', self::MODEL_INSERT, 'function'),
        array('update_time', 'time', self::MODEL_BOTH, 'function'),
        array('sort', '0', self::MODEL_INSERT),
        array('status', '1', self::MODEL_INSERT),
    );

    /**
     * 获取所有导航
     * @author jry <598821125@qq.com>
     */
    public function getTree() {
        $con = array();
        $con['status'] = 1;
        $link_list = $this->where($con)->order('sort asc, id asc')->select();
        foreach ($link_list as $key => &$value) {
            if (!stristr($value['url'], 'http://') && !stristr($value['url'], 'https://')) {
                $value['url'] = U($value['url']);
            }
        }
        $tree = new tree();
        return $tree->list_to_tree($link_list);
    }
}
