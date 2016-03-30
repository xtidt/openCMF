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
 * 消息模型
 * @author jry <598821125@qq.com>
 */
class MessageModel extends Model {
    /**
     * 数据库表名
     * @author jry <598821125@qq.com>
     */
    protected $tableName = 'user_message';

    /**
     * 自动验证规则
     * @author jry <598821125@qq.com>
     */
    protected $_validate = array(
        array('title','require','消息必须填写', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('title', '1,1024', '消息长度为1-32个字符', self::EXISTS_VALIDATE, 'length', self::MODEL_BOTH),
        array('to_uid','require','收信人必须填写', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    );

    /**
     * 自动完成规则
     * @author jry <598821125@qq.com>
     */
    protected $_auto = array(
        array('is_read', '0', self::MODEL_INSERT),
        array('create_time', 'time', self::MODEL_INSERT, 'function'),
        array('update_time', 'time', self::MODEL_BOTH, 'function'),
        array('sort', '0', self::MODEL_INSERT),
        array('status', '1', self::MODEL_INSERT),
    );

    /**
     * 消息类型
     * @author jry <598821125@qq.com>
     */
    public function message_type($id) {
        $list[0] = '系统消息';
        $list[1] = '评论消息';
        return $id ? $list[$id] : $list;
    }

    /**
     * 发送消息
     * @author jry <598821125@qq.com>
     */
    public function sendMessage($send_data, $extra = true) {
        $msg_data['title']    = $send_data['title']; //消息标题
        $msg_data['content']  = $send_data['content'] ? : $send_data['title']; //消息内容
        $msg_data['to_uid']   = $send_data['to_uid']; //消息收信人ID
        $msg_data['type']     = $send_data['type'] ? : 0; //消息类型
        $msg_data['from_uid'] = $send_data['from_uid'] ? : 0; //消息发信人
        $data = $this->create($msg_data);
        if($data){
            $result = $this->add($data);
            if ($extra) {
                hook('SendMessage', $msg_data); //发送消息钩子，用于消息发送途径的扩展
            }
            return $result;
        }
    }

    /**
     * 获取当前用户未读消息数量
     * @param $type 消息类型
     * @author jry <598821125@qq.com>
     */
    public function newMessageCount($type = null) {
        $map['status'] = array('eq', 1);
        $map['to_uid'] = array('eq', is_login());
        $map['is_read'] = array('eq', 0);
        if($type !== null){
            $map['type'] = array('eq', $type);
        }
        return $this->where($map)->count();
    }
}
