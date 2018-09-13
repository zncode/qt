<?php
namespace App226\Controller;
use Common\Api\CommonApi;
use Common\Api\STD3DesApi;
use Common\Api\WechatApi;
//use Common\Api\RedisApi;

header("content-type:text/html;charset=utf-8");
/**
 * 主页控制器(无需登录)
 * @author xuxiaowen
 **/
class IndexController extends AppController{
    public $domain; //当前域名
    public $path; //首页图片存放位置

    /**
     * 初始化
     */
    public function _initialize(){
        parent::_initialize();

        $this->domain = 'http://'.$_SERVER['HTTP_HOST'];
        if($this->domain == 'http://139.224.239.148'){
            $this->path   = $this->domain.'/Public/Upload/AppIndex/';
        }else{
            $this->path   = $this->domain.'/Upload/AppIndex/';
        }

    }
    
    /**
     * 获得首页广告图
     */
    public function adList(){
        $where = array('position_id'=>1,'is_del'=>0,'status'=>1);
        $list = M('ad')
            ->field("id,title,share_title,url,banner_type,is_share,content,share_pic,picture,share_url,is_statistics,statistics")
            ->where($where)
            ->order('sort asc')
            ->select();
        


        foreach($list as $key=>$val){
            $list[$key]['picture'] = WEB . $val['picture'];
            if(1==$val['is_share']){
                $list[$key]['share_pic'] = WEB . $val['share_pic'];
            }else{
                $list[$key]['url'] = WEB_APP . "/Index/adInfo/id/" . $val['id'];
            }
        }
        
        $this->jsonArr($list);
    }

    /**
     * 首页分类接口
     */
    public function typeLists(){
        $data = array(
            'title' => '分类',
            'content' => array(
                array('title'=>'山水', 'image'=>$this->path.'type/1.png', 'id'=>1),
                array('title'=>'花鸟', 'image'=>$this->path.'type/2.png', 'id'=>2),
                array('title'=>'人物', 'image'=>$this->path.'type/3.png', 'id'=>3),
                array('title'=>'风景', 'image'=>$this->path.'type/4.png', 'id'=>4),
                array('title'=>'静物', 'image'=>$this->path.'type/5.png', 'id'=>5),
                array('title'=>'书法', 'image'=>$this->path.'type/6.png', 'id'=>6),
                array('title'=>'水墨', 'image'=>$this->path.'type/7.png', 'id'=>7),
                array('title'=>'艺术家', 'image'=>$this->path.'type/8.png', 'id'=>8),
            ),
            'more' => '所有分类',
        );

        $this->jsonArr($data);
    }

    /**
     * 首页佳作接口
     */
    public function goodProductLists(){
        $data = array(
            'title' => '佳作',
            'content' => array(
                array('title'=>'富春山居图', 'image'=>$this->path.'good_product/1.png', 'id'=>1),
                array('title'=>'富春山居图', 'image'=>$this->path.'good_product/2.png', 'id'=>2),
                array('title'=>'富春山居图', 'image'=>$this->path.'good_product/3.png', 'id'=>3),
                array('title'=>'富春山居图', 'image'=>$this->path.'good_product/4.png', 'id'=>4),
            ),
            'more' => '查看更多',
        );

        $this->jsonArr($data);
    }

    /**
     * 首页新品接口
     */
    public function newProductLists(){
        $data = array(
            'title' => '佳作',
            'content' => array(
                array('title'=>'富春山居图', 'image'=>$this->path.'new_product/1.png', 'id'=>1, 'page_view'=>100, 'collection'=> 6),
                array('title'=>'富春山居图', 'image'=>$this->path.'new_product/2.png', 'id'=>2, 'page_view'=>100, 'collection'=> 6),
                array('title'=>'富春山居图', 'image'=>$this->path.'new_product/3.png', 'id'=>3, 'page_view'=>100, 'collection'=> 6),
            ),
            'more' => '查看更多',
        );

        $this->jsonArr($data);
    }

    /**
     * 首页艺术家接口
     */
    public function artistLists(){
        $data = array(
            'title' => '签约艺术家',
            'content' => array(
                array('title'=>'油画-风景', 'name'=>'陈正帅', 'description'=>'艺术是一场永不止步的旅行', 'image'=>$this->path.'artist/1.png', 'id'=>1),
                array('title'=>'油画-风景', 'name'=>'陈正帅', 'description'=>'艺术是一场永不止步的旅行', 'image'=>$this->path.'artist/2.png', 'id'=>2),
                array('title'=>'油画-风景', 'name'=>'陈正帅', 'description'=>'艺术是一场永不止步的旅行', 'image'=>$this->path.'artist/3.png', 'id'=>3),
                array('title'=>'油画-风景', 'name'=>'陈正帅', 'description'=>'艺术是一场永不止步的旅行', 'image'=>$this->path.'artist/4.png', 'id'=>4),
                array('title'=>'油画-风景', 'name'=>'陈正帅', 'description'=>'艺术是一场永不止步的旅行', 'image'=>$this->path.'artist/5.png', 'id'=>5),
            ),
            'more' => '查看更多',
        );

        $this->jsonArr($data);
    }

    /**
     * 首页寻宝接口
     */
    public function searchProductLists(){
        $data = array(
            'title' => '寻宝',
            'content' => array(
                array('title'=>'富春山居图', 'name'=>'王浩', 'image'=>$this->path.'search_product/1.png', 'id'=>1),
                array('title'=>'富春山居图', 'name'=>'王浩', 'image'=>$this->path.'search_product/2.png', 'id'=>2),
                array('title'=>'富春山居图', 'name'=>'王浩', 'image'=>$this->path.'search_product/3.png', 'id'=>3),
                array('title'=>'富春山居图', 'name'=>'王浩', 'image'=>$this->path.'search_product/4.png', 'id'=>4),
            ),
            'more' => '查看更多',
        );

        $this->jsonArr($data);
    }

    /**
     * 首页专题接口
     */
    public function subjectLists(){
        $data = array(
            'title' => '专题',
            'content' => array(
                array('title'=>'共42幅作品 ￥19420起', 'image'=>$this->path.'subject/1.png', 'id'=>1),
                array('title'=>'共42幅作品 ￥19420起', 'image'=>$this->path.'subject/2.png', 'id'=>2),
                array('title'=>'共42幅作品 ￥19420起', 'image'=>$this->path.'subject/3.png', 'id'=>3),
            ),
            'more' => '查看更多',
        );

        $this->jsonArr($data);
    }

    /**
     * 首页画展接口
     */
    public function artExhibitionLists(){
        $data = array(
            'title' => '画展',
            'content' => array(
                array('title'=>'延缓的时间群展', 'date'=>'2018.04.22 - 04.26', 'address'=>'北京市朝阳区望京soho大厦', 'type'=>'免费', 'page_view'=>100, 'comment'=>0, 'image'=>$this->path.'art_exhibition/1.png', 'id'=>1),
                array('title'=>'延缓的时间群展', 'date'=>'2018.04.22 - 04.26', 'address'=>'北京市朝阳区望京soho大厦', 'type'=>'免费', 'page_view'=>100, 'comment'=>0, 'image'=>$this->path.'art_exhibition/2.png', 'id'=>2),
            ),
            'more' => '查看更多',
        );

        $this->jsonArr($data);
    }

    //首页资讯列表
    public function newsLists(){

        $where['is_top'] = 1;

        $Circles = M('art_circles');
        $list = $Circles
            ->field("id,title,describe,hitnum,pageview,CONCAT('".WEB."',`picture`) AS `picture`,CONCAT('".WEB."',`share`) AS `share`,CONCAT('".WEB."',`pic1`,',','".WEB."',`pic2`,',','".WEB."',`pic3`) AS `pic`,from_unixtime(`add_time`,'%Y-%m-%d') as `add_time`,CONCAT('".WEB_APP."/Find/circlesInfo/id/',`id`) AS detail_link")
            ->where($where)
            ->order('add_time desc,id desc')
            ->limit(2)
            ->select();
        foreach($list as $key=>$val){
            $list[$key]['comment_num'] = M('circles_comment')->where(array('circles_id'=>$val['id']))->count();
            if(UID){
                $res1 = M('circles_hit')->where(array('user_id'=>UID,'circles_id'=>$val['id']))->find();
            }
            $list[$key]['hit_status'] = $res1 == NULL ? 0 : 1;
        }

        $this->jsonArr($list);
    }

    /**
     * 首页合作伙伴接口
     */
    public function partnerLists(){
        $data = array(
            'title' => '合作伙伴',
            'content' => array(
                array('title'=>'中央美术学院', 'image'=>$this->path.'partner/1.png', 'id'=>1),
                array('title'=>'中央美术学院', 'image'=>$this->path.'partner/2.png', 'id'=>2),
                array('title'=>'中央美术学院', 'image'=>$this->path.'partner/3.png', 'id'=>3),
                array('title'=>'中央美术学院', 'image'=>$this->path.'partner/4.png', 'id'=>4),
                array('title'=>'中央美术学院', 'image'=>$this->path.'partner/5.png', 'id'=>5),
                array('title'=>'中央美术学院', 'image'=>$this->path.'partner/6.png', 'id'=>6),
                array('title'=>'中央美术学院', 'image'=>$this->path.'partner/7.png', 'id'=>7),
                array('title'=>'中央美术学院', 'image'=>$this->path.'partner/8.png', 'id'=>8),
                array('title'=>'中央美术学院', 'image'=>$this->path.'partner/9.png', 'id'=>3),
            ),
            'more' => $this->path.'partner/more.png',
        );

        $this->jsonArr($data);
    }

    /**
     * 推荐画作接口
     */
    public function recommendGoodsLists(){
        $Goods = M("goods");
        $p = I('get.p') ? I('get.p') : 1;
        $where['a.status'] = 1;
        $where['a.is_enquiry'] = 0;
        $where['a.is_best'] = 1;
        $where['a.is_sell'] = 0;

        $count=$Goods->table("win_goods a")
            ->join("win_artist as b on a.artist_id=b.id")
            ->where($where)
            ->count();// 查询满足要求的总记录数

        $num = 6;
        $page = ceil($count/$num);

        $list = $Goods->table("win_goods a")
            ->field("a.id,CONCAT('".WEB."',a.`thumb`) AS `picture`,b.name as artist, a.size")
            ->join("win_artist as b on a.artist_id=b.id")
            ->join('win_goods_picture as c on c.gid=a.id')
            ->where($where)
            ->order("a.sort asc,a.pageview desc")
            ->limit('0,'.($p*$num))
            ->select();

        foreach($list as $key=>$val){
            if(UID){
                $res = M('goods_collect')->where(array('user_id'=>UID,'goods_id'=>$val['id']))->find();
                $list[$key]['is_collect'] = isset($res) ? 1 : 0;//1收藏0未收藏
            }else{
                $list[$key]['is_collect'] = 0;
            }
        }
        $lists['worksSelected'] = $list;
        $lists['page'] = $page;
        $this->jsonArr($lists);
    }

    /**
     * 传输json 数组
     * @author xuxiaowen
     */
    public function jsonArr($list){
        $arr['msg']="请求成功";
        $arr['flag']="200";
        $arr['response']=$list === null ? array() : $list;

        $this->ajaxReturn($arr,"json");
    }

    /**
     * Ajax方式返回数据到客户端
     * @access protected
     * @param mixed $data 要返回的数据
     * @param String $type AJAX返回数据格式
     * @param int $json_option 传递给json_encode的option参数
     * @return void
     */
    public function ajaxReturn($data,$type='',$json_option=0) {
        if(empty($type)) $type  =   C('DEFAULT_AJAX_RETURN');
        switch (strtoupper($type)){
            case 'JSON' :
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:application/json; charset=utf-8');
                exit(json_encode($data,$json_option));
            case 'XML'  :
                // 返回xml格式数据
                header('Content-Type:text/xml; charset=utf-8');
                exit(xml_encode($data));
            case 'JSONP':
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:application/json; charset=utf-8');
                $handler  =   isset($_GET[C('VAR_JSONP_HANDLER')]) ? $_GET[C('VAR_JSONP_HANDLER')] : C('DEFAULT_JSONP_HANDLER');
                exit($handler.'('.json_encode($data,$json_option).');');
            case 'EVAL' :
                // 返回可执行的js脚本
                header('Content-Type:text/html; charset=utf-8');
                exit($data);
            default     :
                // 用于扩展其他返回格式数据
                Hook::listen('ajax_return',$data);
        }
    }
}