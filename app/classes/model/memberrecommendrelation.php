<?php
/**
 * 会员推荐关系数据模型
 *
 * @package    app
 * @version    1.0
 * @author     Ray zyr.wxl@gmail.com
 * @license    MIT License
 * @copyright  2015 PMonkey Team
 * @link       http://mnzone.cn
 *
 * @extends  	\Orm\Model
 */
class Model_MemberRecommendRelation extends \Orm\Model{

    /**
     * @var  string  table name to overwrite assumption
     */
    protected static $_table_name = 'members_recommends_relations';

    protected static $_primary_key = array('id');

    /**
     * @var array	defined observers
     */
    protected static $_observers = array(
        'Orm\\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'property' => 'created_at',
            'mysql_timestamp' => false
        ),
        'Orm\\Observer_UpdatedAt' => array(
            'events' => array('before_update'),
            'property' => 'updated_at',
            'mysql_timestamp' => false
        ),
        'Orm\\Observer_Typing' => array(
            'events' => array('after_load', 'before_save', 'after_save')
        )
    );

    /**
     * @var array	has_one relationships
     */
    protected static $_belongs_to = array(
        'master' => array(
            'model_to' => 'Model_People',
            'key_from' => 'master_id',
            'key_to'   => 'parent_id',
        ),
        'member' => array(
            'model_to' => 'Model_People',
            'key_from' => 'member_id',
            'key_to'   => 'parent_id',
        ),
    );

    /**
     * 上级会员
     * @param $id 会员ID
     * @return array
     */
    public static function parentMember($id){
        $members = \Model_MemberRecommendRelation::query()
            ->where(['member_id' => $id])
            ->order_by('depth', 'ASC')
            ->get();
        return $members;
    }

    /**
     * 下级会员
     *
     * @param $id 主用户ID
     * @return array 所有下级会员集合
     */
    public static function childMembers($id){
        $members = \Model_MemberRecommendRelation::query()
            ->where(['master_id' => $id])
            ->order_by('depth', 'ASC')
            ->get();
        return $members;
    }

    /**
     * 添加推荐关系
     *
     * @param $master_id    推荐人用户ID
     * @param $member_id    被推荐人用户ID
     * @param int $depth    关系深度
     * @param string $from  推荐方式
     * @return bool
     * @throws Exception
     */
    public static function addRelation($master_id, $member_id, $depth = 2, $from = 'QRCODE'){

        if($master_id == $member_id){
            return false;
        }
        
        //查询被推荐人是否已存在关系库中
        $members = \Model_MemberRecommendRelation::parentMember($member_id);
        if($members){
            return false;
        }

        //查询推荐人关系树
        $members = \Model_MemberRecommendRelation::parentMember($master_id);

        //添加一级推荐关系
        $relation = \Model_MemberRecommendRelation::forge([
            'master_id' => $master_id,
            'member_id' => $member_id,
            'depth' => 1,
            'from' => $from
        ]);
        $relation->save();

        //添加多级推荐关系
        $index = 2;
        foreach($members as $member){
            if($depth < $index){
                break;
            }
            $data = [
                'master_id' => $member->master_id,
                'member_id' => $member_id,
                'depth' => $index,
                'from' => $from
            ];
            $relation = \Model_MemberRecommendRelation::forge($data);
            $relation->save();
            $index ++;
        }

        return true;
    }
}