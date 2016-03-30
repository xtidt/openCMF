<?php
// +----------------------------------------------------------------------
// | OpenCMF [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.opencmf.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------
namespace Cms\Controller;
use Home\Controller\HomeController;
use Common\Util\Think\Page;
/**
 * 文章控制器
 * @author jry <598821125@qq.com>
 */
class NoticeController extends HomeController {
    /**
     * 文章信息
     * @author jry <598821125@qq.com>
     */
    public function detail($id) {
        $info = D('Notice')->find($id);
        if ($info['status'] !== '1') {
            $this->error('该公告不存在或已禁用');
        }
        $this->assign('info', $info);
        $this->assign('meta_title', $info['title']);
        Cookie('__forward__', $_SERVER['REQUEST_URI']);
        $this->display();
    }
}
