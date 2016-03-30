<?php
// +----------------------------------------------------------------------
// | OpenCMF [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.opencmf.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------
namespace Home\TagLib;
use Think\Template\TagLib;
/**
 * 标签库
 * @author jry <598821125@qq.com>
 */
class Opencmf extends TagLib {
    /**
     * 定义标签列表
     * @author jry <598821125@qq.com>
     */
    protected $tags = array(
        'sql_query'   => array('attr' => 'sql,result', 'close' => 0), //SQL查询
        'nav_list'    => array('attr' => 'name,pid', 'close' => 1),   //导航列表
    );

    /**
     * SQL查询
     */
    public function _sql_query($tag, $content) {
        $sql    =    $tag['sql'];
        $result =    !empty($tag['result']) ? $tag['result'] : 'result';
        $parse  =    '<?php $'.$result.' = M()->query("'.$sql.'");';
        $parse .=    'if($'.$result.'):?>'.$content;
        $parse .=    "<?php endif;?>";
        return $parse;
    }

    /**
     * 导航列表
     */
    public function _nav_list($tag, $content) {
        $name   = $tag['name'];
        $pid    = $tag['pid'] ? : 0;
        $parse  = '<?php ';
        $parse .= '$_nav_list = D(\'Admin/Nav\')->getNavTree('.$pid.');';
        $parse .= ' ?>';
        $parse .= '<volist name="_nav_list" id="'. $name .'">';
        $parse .= $content;
        $parse .= '</volist>';
        return $parse;
    }
}
