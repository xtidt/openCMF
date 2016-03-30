<?php
// +----------------------------------------------------------------------
// | OpenCMF [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.opencmf.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------
namespace Admin\Controller;
use Common\Util\Tree;
/**
 * 链接控制器
 * @author jry <598821125@qq.com>
 */
class LinkController extends AdminController {
    /**
     * 链接列表
     * @author jry <598821125@qq.com>
     */
    public function index() {
        //搜索
        $keyword = I('keyword', '', 'string');
        $condition = array('like','%'.$keyword.'%');
        $map['id|title'] = array(
            $condition,
            $condition,
            '_multi'=>true
        );

        // 获取所有链接
        $map['status'] = array('egt', '0');  // 禁用和正常状态
        $data_list = D('Link')
                   ->where($map)
                   ->order('sort asc, id asc')
                   ->select();

        // 转换成树状列表
        $tree = new Tree();
        $data_list = $tree->toFormatTree($data_list);

        // 使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->setMetaTitle('链接列表') // 设置页面标题
                ->addTopButton('addnew')  // 添加新增按钮
                ->addTopButton('resume')  // 添加启用按钮
                ->addTopButton('forbid')  // 添加禁用按钮
                ->addTopButton('delete')  // 添加删除按钮
                ->setSearch('请输入ID/链接名称', U('index'))
                ->addTableColumn('id', 'ID')
                ->addTableColumn('icon', '图标', 'icon')
                ->addTableColumn('title_show', '标题')
                ->addTableColumn('sort', '排序')
                ->addTableColumn('status', '状态', 'status')
                ->addTableColumn('right_button', '操作', 'btn')
                ->setTableDataList($data_list)  // 数据列表
                ->addRightButton('edit')        // 添加编辑按钮
                ->addRightButton('forbid')      // 添加禁用/启用按钮
                ->addRightButton('delete')      // 添加删除按钮
                ->display();
    }

    /**
     * 新增链接
     * @author jry <598821125@qq.com>
     */
    public function add() {
        if (IS_POST) {
            $link_object = D('Link');
            $data = $link_object->create();
            if ($data) {
                $id = $link_object->add($data);
                if ($id) {
                    $this->success('新增成功', U('index'));
                } else {
                    $this->error('新增失败');
                }
            } else {
                $this->error($link_object->getError());
            }
        } else {
            // 使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle('新增链接')  // 设置页面标题
                    ->setPostUrl(U('add'))     // 设置表单提交地址
                    ->addFormItem('pid', 'select', '上级链接', '上级链接', select_list_as_tree('Link', null, '顶级链接'))
                    ->addFormItem('title', 'text', '链接标题', '链接前台显示标题')
                    ->addFormItem('url', 'text', '请填写外链URL地址', '支持http://格式或者TP的U函数解析格式')
                    ->addFormItem('icon', 'icon', '图标', '链接图标')
                    ->addFormItem('sort', 'num', '排序', '用于显示的顺序')
                    ->display();
        }
    }

    /**
     * 编辑链接
     * @author jry <598821125@qq.com>
     */
    public function edit($id) {
        if (IS_POST) {
            $link_object = D('Link');
            $data = $link_object->create();
            if ($data) {
                if ($link_object->save($data)) {
                    $this->success('更新成功', U('index'));
                } else {
                    $this->error('更新失败');
                }
            } else {
                $this->error($link_object->getError());
            }
        } else {
            $info = D('Link')->find($id);

            // 使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle('编辑链接')  // 设置页面标题
                    ->setPostUrl(U('edit'))    // 设置表单提交地址
                    ->addFormItem('id', 'hidden', 'ID', 'ID')
                    ->addFormItem('pid', 'select', '上级链接', '上级链接', select_list_as_tree('Link', null, '顶级链接'))
                    ->addFormItem('title', 'text', '链接标题', '链接前台显示标题')
                    ->addFormItem('url', 'text', '请填写外链URL地址', '支持http://格式或者TP的U函数解析格式')
                    ->addFormItem('icon', 'icon', '图标', '链接图标')
                    ->addFormItem('sort', 'num', '排序', '用于显示的顺序')
                    ->setFormData($info)
                    ->display();
        }
    }
}
