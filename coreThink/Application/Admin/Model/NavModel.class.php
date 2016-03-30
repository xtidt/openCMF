<?php
// +----------------------------------------------------------------------
// | OpenCMF [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.opencmf.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------
namespace Admin\Model;
use Think\Model;
use \Common\Util\Tree;
/**
 * 导航模型
 * @author jry <598821125@qq.com>
 */
class NavModel extends Model {
    /**
     * 数据库表名
     * @author jry <598821125@qq.com>
     */
    protected $tableName = 'admin_nav';

    /**
     * 查找后置操作
     * @author jry <598821125@qq.com>
     */
    protected function _after_find(&$result, $options) {
        // 处理不同导航类型
        switch ($result['type']) {
            case 'link':
                $result['url'] = $result['value'];
                if (!$result['url']) {
                    $result['href'] = C('HOME_PAGE');
                } else {
                    if (stristr($result['url'], 'http://')) {
                        $result['href'] = $result['url'];
                    } else {
                        $result['href'] = U($result['url'], null, true, true);
                    }
                }
                break;
            case 'module':
                $result['module_name'] = $result['value'];
                $result['href'] = U('/'. ucfirst($result['value']).'', null, false, true);
                break;
        }
    }

    /**
     * 查找后置操作
     * @author jry <598821125@qq.com>
     */
    protected function _after_select(&$result, $options) {
        foreach($result as &$record){
            $this->_after_find($record, $options);
        }
    }

    /**
     * 自动验证规则
     * @author jry <598821125@qq.com>
     */
    protected $_validate = array(
        array('name', '', '导航名称已存在', self::MUST_VALIDATE, 'unique', self::MODEL_BOTH),
        array('name', '/^[\w]+$/', '名称必须是纯英文，不包含下划线、空格及其他字符', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('title', 'require', '导航标题不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('type', 'require', '导航类型不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('url', '0,255', '链接长度为0-25个字符', self::EXISTS_VALIDATE, 'length',self::MODEL_BOTH),
    );

    /**
     * 自动完成规则
     * @author jry <598821125@qq.com>
     */
    protected $_auto = array(
        array('value', 'get_value_by_type', self::MODEL_BOTH, 'callback'),
        array('create_time', 'time', self::MODEL_INSERT, 'function'),
        array('update_time', 'time', self::MODEL_BOTH, 'function'),
        array('status', '1', self::MODEL_INSERT),
    );

    /**
     * 导航类型
     * @author jry <598821125@qq.com>
     */
    public function nav_type($id) {
        $list['link']   = '链接';
        $list['module'] = '模块';
        return $id ? $list[$id] : $list;
    }

    /**
     * 根据导航类型获取值
     * @author jry <598821125@qq.com>
     */
    public function get_value_by_type($value) {
        if (!$value) {
            switch (I('post.type')) {
                case 'link':
                    return I('post.url');
                    break;
                case 'module':
                    return I('post.module_name');
                    break;
            }
        } else {
            return $value;
        }
    }

    /**
     * 获取参数的所有父级导航
     * @param int $id 导航id
     * @return array 参数导航和父类的信息集合
     * @author jry <598821125@qq.com>
     */
    public function getParentNav($id) {
        if (empty($id)) {
            return false;
        }
        $con['status'] = 1;
        $nav_list = $this->where($con)->field(true)->select();
        $current_nav = $this->field(true)->find($cid); //获取当前导航的信息
        $result[] = $current_nav;
        $pid = $current_nav['pid'];
        while (true) {
            foreach ($nav_list as $key => $val) {
                if ($val['id'] == $pid) {
                    $pid = $val['pid'];
                    array_unshift($result, $val); //将父导航插入到第一个元素前
                }
            }
            // 已找到顶级导航或者没有任何父导航
            if ($pid == 0 || count($result) == 1) {
                break;
            }
        }
        return $result;
    }

    /**
     * 获取导航树，指定导航则返回指定导航的子导航树，不指定则返回所有导航树，指定导航若无子导航则返回同级导航
     * @param  integer $id    导航ID
     * @param  boolean $field 查询字段
     * @return array          导航树
     * @author jry <598821125@qq.com>
     */
    public function getNavTree($id = 0, $field = true) {
        // 获取当前导航信息
        if ((int)$id > 0) {
            $info = $this->find($id);
            $id   = $info['id'];
        }
        // 获取所有导航
        $map['status'] = array('eq', 1);
        $tree = new Tree();
        $list = $this->field($field)->where($map)->order('sort asc')->select();

        // 返回当前导航的子导航树
        $list = $tree->list_to_tree(
            $list,
            $pk = 'id',
            $pid = 'pid',
            $child = '_child',
            $root = (int)$id
        );
        if (!$list) {
            return $this->getSameLevelNavTree($id);
        }
        return $list;
    }

    /**
     * 获取同级导航树
     * @param  integer $id 导航ID
     * @return array       导航树
     * @author jry <598821125@qq.com>
     */
    public function getSameLevelNavTree($id = 0) {
        //获取当前导航信息
        if ((int)$id > 0) {
            $nav_info    = $this->find($id);
            $parent_info = $this->find($nav_info['pid']);
            $id   = $info['id'];
        }
        //获取所有导航
        $map['status'] = array('eq', 1);
        $map['pid']    = array('eq', $nav_info['pid']);
        $tree = new Tree();
        $list = $this->field($field)->where($map)->order('sort asc')->select();
        return $list;
    }
}
