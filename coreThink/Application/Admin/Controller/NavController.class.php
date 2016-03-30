<?php
// +----------------------------------------------------------------------
// | OpenCMF [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.opencmf.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------
namespace Admin\Controller;
use \Common\Util\Tree;
/**
 * 导航控制器
 * @author jry <598821125@qq.com>
 */
class NavController extends AdminController {
    /**
     * 导航列表
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

        // 获取所有导航
        $map['status'] = array('egt', '0');  // 禁用和正常状态
        $data_list = D('Nav')
                   ->where($map)
                   ->order('sort asc, id asc')
                   ->select();

        // 转换成树状列表
        $tree = new Tree();
        $data_list = $tree->toFormatTree($data_list);

        // 使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->setMetaTitle('导航列表') // 设置页面标题
                ->addTopButton('addnew')  // 添加新增按钮
                ->addTopButton('resume')  // 添加启用按钮
                ->addTopButton('forbid')  // 添加禁用按钮
                ->addTopButton('delete')  // 添加删除按钮
                ->setSearch('请输入ID/导航名称', U('index'))
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

    // 根据导航类型设置表单项目
    private $extra_html = <<<EOF
    <script type="text/javascript">
        $(function(){
            $('select[name="type"]').change(function() {
                var type = $(this).val();
                // 链接类型
                if (type == 'link') {
                    $('.item_url').removeClass('hidden');
                    $('.item_module_name').addClass('hidden');
                // 模块类型
                } else if (type == 'module') {
                    $('.item_url').addClass('hidden');
                    $('.item_module_name').removeClass('hidden');
                } else {
                    $('.item_url').addClass('hidden');
                    $('.item_module_name').addClass('hidden');
                }
            });
        });
    </script>
EOF;

    /**
     * 新增导航
     * @author jry <598821125@qq.com>
     */
    public function add() {
        if (IS_POST) {
            $nav_object = D('Nav');
            $data = $nav_object->create();
            if ($data) {
                $id = $nav_object->add($data);
                if ($id) {
                    $this->success('新增成功', U('index'));
                } else {
                    $this->error('新增失败');
                }
            } else {
                $this->error($nav_object->getError());
            }
        } else {
            // 使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle('新增导航')  // 设置页面标题
                    ->setPostUrl(U('add'))     // 设置表单提交地址
                    ->addFormItem('pid', 'select', '上级导航', '上级导航', select_list_as_tree('Nav', null, '顶级导航'))
                    ->addFormItem('name', 'text', '导航名称', '名称一般为英文单词')
                    ->addFormItem('title', 'text', '导航标题', '导航前台显示标题')
                    ->addFormItem('type', 'select', '导航类型', '导航类型', D('Nav')->nav_type())
                    ->addFormItem('url', 'text', '请填写外链URL地址', '支持http://格式或者TP的U函数解析格式', null, 'hidden')
                    ->addFormItem('module_name', 'select', '模块', '选择的模块需要具有前台页面', select_list_as_tree('Module', null, null, 'name'),'hidden')
                    ->addFormItem('target', 'radio', '打开方式', '打开方式', array('' => '当前窗口','_blank' => '新窗口打开'))
                    ->addFormItem('icon', 'icon', '图标', '导航图标')
                    ->addFormItem('sort', 'num', '排序', '用于显示的顺序')
                    ->setExtraHtml($this->extra_html)
                    ->display();
        }
    }

    /**
     * 编辑导航
     * @author jry <598821125@qq.com>
     */
    public function edit($id) {
        if (IS_POST) {
            $nav_object = D('Nav');
            $data = $nav_object->create();
            if ($data) {
                if ($nav_object->save($data)) {
                    $this->success('更新成功', U('index'));
                } else {
                    $this->error('更新失败');
                }
            } else {
                $this->error($nav_object->getError());
            }
        } else {
            $info = D('Nav')->find($id);

            // 使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle('编辑导航')  // 设置页面标题
                    ->setPostUrl(U('edit'))    // 设置表单提交地址
                    ->addFormItem('id', 'hidden', 'ID', 'ID')
                    ->addFormItem('pid', 'select', '上级导航', '上级导航', select_list_as_tree('Nav', null, '顶级导航'))
                    ->addFormItem('name', 'text', '导航名称', '名称一般为英文单词')
                    ->addFormItem('title', 'text', '导航标题', '导航前台显示标题')
                    ->addFormItem('type', 'select', '导航类型', '导航类型', D('Nav')->nav_type())
                    ->addFormItem('url', 'text', '请填写外链URL地址', '支持http://格式或者TP的U函数解析格式', null, $info['url'] ? : 'hidden')
                    ->addFormItem('module_name', 'select', '模块', '选择的模块需要具有前台页面', select_list_as_tree('Module', null, null, 'name'), $info['module_name'] ? : 'hidden')
                    ->addFormItem('target', 'radio', '打开方式', '打开方式', array('' => '当前窗口','_blank' => '新窗口打开'))
                    ->addFormItem('icon', 'icon', '图标', '导航图标')
                    ->addFormItem('sort', 'num', '排序', '用于显示的顺序')
                    ->setFormData($info)
                    ->setExtraHtml($this->extra_html)
                    ->display();
        }
    }
}
