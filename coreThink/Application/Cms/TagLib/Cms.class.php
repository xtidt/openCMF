<?php
// +----------------------------------------------------------------------
// | OpenCMF [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.opencmf.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------
namespace Cms\TagLib;
use Think\Template\TagLib;
/**
 * 标签库
 * @author jry <598821125@qq.com>
 */
class Cms extends TagLib {
    /**
     * 定义标签列表
     * @author jry <598821125@qq.com>
     */
    protected $tags = array(
        'breadcrumb'    => array('attr' => 'name,cid', 'close' => 1), //面包屑导航列表
        'category_list' => array('attr' => 'name,pid,limit,page,group', 'close' => 1), //栏目分类列表
        'article_list'  => array('attr' => 'name,cid,limit,page,order,child', 'close' => 1), //文章列表
        'new_list'      => array('attr' => 'name,doc_type,limit,order', 'close' => 1), //最新文章列表
        'slider_list'   => array('attr' => 'name,limit,page,order', 'close' => 1), //幻灯列表
        'notice_list'   => array('attr' => 'name,limit,page,order', 'close' => 1), //公告列表
        'footnav_list' => array('attr'  => 'name', 'close' => 1), //底部导航列表
        'friendly_link' => array('attr' => 'name,type,limit,page,length', 'close' => 1), //友情链接列表
    );

    /**
     * 面包屑导航列表
     * @author jry <598821125@qq.com>
     */
    public function _breadcrumb($tag, $content) {
        $name   = $tag['name'];
        $cid    = $tag['cid'];
        $group  = $tag['group'] ? : 1;
        $parse  = '<?php ';
        $parse .= '$__PARENT_CATEGORY__ = D("Cms/Category\')->getParentCategory('.$cid.', '.$group.');';
        $parse .= ' ?>';
        $parse .= '<volist name="__PARENT_CATEGORY__" id="'. $name .'">';
        $parse .= $content;
        $parse .= '</volist>';
        return $parse;
    }

    /**
     * 栏目分类列表
     * @author jry <598821125@qq.com>
     */
    public function _category_list($tag, $content) {
        $name   = $tag['name'];
        $pid    = $tag['pid'] ? : 0;
        $limit  = $tag['limit'] ? :10;
        $page   = $tag['page'] ? : 1;
        $group  = $tag['group'] ? : 1;
        $parse  = '<?php ';
        $parse .= '$__CATEGORYLIST__ = D("Cms/Category")->getCategoryTree('.$pid.', '.$limit.', '.$page.', '.$group.');';
        $parse .= ' ?>';
        $parse .= '<volist name="__CATEGORYLIST__" id="'. $name .'">';
        $parse .= $content;
        $parse .= '</volist>';
        return $parse;
    }

    /**
     * 文章列表
     * @author jry <598821125@qq.com>
     */
    public function _article_list($tag, $content) {
        $name   = $tag['name'];
        $cid    = $tag['cid'] ? : 1;
        $limit  = $tag['limit'] ? : 10;
        $page   = $tag['page'] ? : 1;
        $order  = $tag['order'] ? : '';
        $child  = $tag['child'] ? : '';
        $parse  = '<?php ';
        $parse .= '$map = array("status" => "1");';
        $parse .= '$__ARTICLE_LIST__ = D("Cms/Index")->getList('.$cid.', '.$limit.', '.$page.', "'.$order.'", "'.$child.'", $map);';
        $parse .= ' ?>';
        $parse .= '<volist name="__ARTICLE_LIST__" id="'. $name .'">';
        $parse .= $content;
        $parse .= '</volist>';
        return $parse;
    }

    /**
     * 最新文章列表
     * @author jry <598821125@qq.com>
     */
    public function _new_list($tag, $content) {
        $name   = $tag['name'];
        $doc_type = $tag['doc_type'];
        $limit  = $tag['limit'] ? : 10;
        $page   = $tag['page'] ? : 1;
        $order  = $tag['order'] ? : '';
        $parse  = '<?php ';
        $parse .= '$map = array("status" => "1");';
        $parse .= '$__ARTICLE_LIST__ = D("Cms/Index")->getNewList('.$doc_type.', '.$limit.', '.$page.', "'.$order.'", $map);';
        $parse .= ' ?>';
        $parse .= '<volist name="__ARTICLE_LIST__" id="'. $name .'">';
        $parse .= $content;
        $parse .= '</volist>';
        return $parse;
    }

    /**
     * 幻灯列表
     * @author jry <598821125@qq.com>
     */
    public function _slider_list($tag, $content) {
        $name   = $tag['name'];
        $limit  = $tag['limit'] ? : 10;
        $page   = $tag['page'] ? : 1;
        $order  = $tag['order'] ? : 'sort desc,id desc';
        $parse  = '<?php ';
        $parse .= '$map["status"] = array("eq", "1");';
        $parse .= '$__SLIDER_LIST__ = D("Cms/slider")->getList('.$limit.', '.$page.', "'.$order.'", $map);';
        $parse .= ' ?>';
        $parse .= '<volist name="__SLIDER_LIST__" id="'. $name .'">';
        $parse .= $content;
        $parse .= '</volist>';
        return $parse;
    }

    /**
     * 公告列表
     * @author jry <598821125@qq.com>
     */
    public function _notice_list($tag, $content) {
        $name   = $tag['name'];
        $limit  = $tag['limit'] ? : 10;
        $page   = $tag['page'] ? : 1;
        $order  = $tag['order'] ? : 'sort desc,id desc';
        $parse  = '<?php ';
        $parse .= '$map["status"] = array("eq", "1");';
        $parse .= '$__NOTICE_LIST__ = D("Cms/Notice")->getList('.$limit.', '.$page.', "'.$order.'", $map);';
        $parse .= ' ?>';
        $parse .= '<volist name="__NOTICE_LIST__" id="'. $name .'">';
        $parse .= $content;
        $parse .= '</volist>';
        return $parse;
    }

    /**
     * 底部导航
     * @author jry <598821125@qq.com>
     */
    public function _footnav_list($tag, $content) {
        $name   = $tag['name'];
        $parse  = '<?php ';
        $parse .= '$__FOOTNAVLIST__ = D("Cms/Footnav")->getTree();';
        $parse .= ' ?>';
        $parse .= '<volist name="__FOOTNAVLIST__" id="'. $name .'">';
        $parse .= $content;
        $parse .= '</volist>';
        return $parse;
    }

    /**
     * 友情链接
     * @author jry <598821125@qq.com>
     */
    public function _friendly_link($tag, $content) {
        $name   = $tag['name'];
        $type   = $tag['type'] ? : 1;
        $length  = $tag['length'];
        $offset = $tag['offset'];
        $parse  = '<?php ';
        $parse .= '$map["type"] = '.$type.';';
        $parse .= '$__LINKLIST__ = D("Cms/FriendlyLink")->where($map)->order("sort asc, id asc")->select();';
        $parse .= ' ?>';
        $parse .= '<volist name="__LINKLIST__" id="'. $name .'" length="' . $length . '" offset="' . $offset . '">';
        $parse .= $content;
        $parse .= '</volist>';
        return $parse;
    }
}
