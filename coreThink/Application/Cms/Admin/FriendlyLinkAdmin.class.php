<?php
// +----------------------------------------------------------------------
// | OpenCMF [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.opencmf.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------
namespace Cms\Admin;
use Admin\Controller\AdminController;
use Common\Util\Think\Page;
/**
 * 友情链接控制器
 * @author jry <598821125@qq.com>
 */
class FriendlyLinkAdmin extends AdminController {
    /**
     * 默认方法
     * @author jry <598821125@qq.com>
     */
    public function index() {
        // 搜索
        $keyword = I('keyword', '', 'string');
        $condition = array('like','%'.$keyword.'%');
        $map['id|title'] = array($condition, $condition,'_multi'=>true);

        // 获取所有链接
        $p = !empty($_GET["p"]) ? $_GET["p"] : 1;
        $map['status'] = array('egt', '0');  // 禁用和正常状态
        $friendly_link_object = D('FriendlyLink');
        $data_list = $friendly_link_object
                   ->page($p, C('ADMIN_PAGE_ROWS'))
                   ->where($map)
                   ->order('sort desc,id desc')
                   ->select();
        $page = new Page(
            $friendly_link_object->where($map)->count(),
            C('ADMIN_PAGE_ROWS')
        );

        // 使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->setMetaTitle('友情链接列表')  // 设置页面标题
                ->addTopButton('addnew')    // 添加新增按钮
                ->addTopButton('resume')  // 添加启用按钮
                ->addTopButton('forbid')  // 添加禁用按钮
                ->setSearch('请输入ID/链接标题', U('index'))
                ->addTableColumn('id', 'ID')
                ->addTableColumn('title', '标题')
                ->addTableColumn('type', '类型', 'callback', array(D('FriendlyLink'), 'link_type'))
                ->addTableColumn('logo', 'Logo', 'picture')
                ->addTableColumn('create_time', '创建时间', 'time')
                ->addTableColumn('sort', '排序')
                ->addTableColumn('status', '状态', 'status')
                ->addTableColumn('right_button', '操作', 'btn')
                ->setTableDataList($data_list)     // 数据列表
                ->setTableDataPage($page->show())  // 数据列表分页
                ->addRightButton('edit')           // 添加编辑按钮
                ->addRightButton('forbid')  // 添加禁用/启用按钮
                ->addRightButton('delete')  // 添加删除按钮
                ->display();
    }

    /**
     * 新增文档
     * @author jry <598821125@qq.com>
     */
    public function add() {
        if (IS_POST) {
            $friendly_link_object = D('FriendlyLink');
            $data = $friendly_link_object->create();
            if ($data) {
                $id = $friendly_link_object->add();
                if ($id) {
                    $this->success('新增成功', U('index'));
                } else {
                    $this->error('新增失败');
                }
            } else {
                $this->error($friendly_link_object->getError());
            }
        } else {
            // 使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle('新增友情链接')  // 设置页面标题
                    ->setPostUrl(U('add'))      // 设置表单提交地址
                    ->addFormItem('title', 'text', '标题', '标题')
                    ->addFormItem('logo', 'picture', 'Logo', 'Logo')
                    ->addFormItem('url', 'text', '链接', '点击跳转链接')
                    ->addFormItem('type', 'radio', '类型', '链接类型', array('1' => '友情链接', '2' => '合作伙伴'))
                    ->addFormItem('sort', 'num', '排序', '用于显示的顺序')
                    ->display();
        }
    }

    /**
     * 编辑文章
     * @author jry <598821125@qq.com>
     */
    public function edit($id) {
        if (IS_POST) {
            $friendly_link_object = D('FriendlyLink');
            $data = $friendly_link_object->create();
            if ($data) {
                $id = $friendly_link_object->save();
                if ($id !== false) {
                    $this->success('更新成功', U('index'));
                } else {
                    $this->error('更新失败');
                }
            } else {
                $this->error($friendly_link_object->getError());
            }
        } else {
            // 使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle('编辑友情链接')  // 设置页面标题
                    ->setPostUrl(U('edit'))     // 设置表单提交地址
                    ->addFormItem('id', 'hidden', 'ID', 'ID')
                    ->addFormItem('title', 'text', '标题', '标题')
                    ->addFormItem('logo', 'picture', 'Logo', 'Logo')
                    ->addFormItem('url', 'text', '链接', '点击跳转链接')
                    ->addFormItem('type', 'radio', '类型', '链接类型', array('1' => '友情链接', '2' => '合作伙伴'))
                    ->addFormItem('sort', 'num', '排序', '用于显示的顺序')
                    ->setFormData(D('FriendlyLink')->find($id))
                    ->display();
        }
    }
}
