<?php
namespace app\index\controller;
use app\index\controller\Base;
class Article extends Base
{

    public function index()
    {
    	$arid=input('arid');
    	$articles=db('article')->find($arid);
      $ralateres=$this->ralat($articles['keywords'],$articles['id']);
        // dump($ralateres); die;
        //对当前ar点击自增
    	db('article')->where('id','=',$arid)->setInc('click');
    	$cates=db('cate')->find($articles['cateid']);
      //查询推荐文章
    	$recres=db('article')->where(array('cateid'=>$cates['id'],'state'=>1))->limit(8)->select();
    	$this->assign(array(
    		'articles'=>$articles,
    		'cates'=>$cates,
    		'recres'=>$recres,
        'ralateres'=>$ralateres
    		));
        return $this->fetch('article');
    }


    public function ralat($keywords,$id){
        $arr=explode(',', $keywords);
        static $ralateres = array();
        foreach ($arr as $k=>$v) {
            $map['keywords']=['like','%'.$v.'%'];
            //相关文章id不能等于当前文章id，避免重复渲染
            $map['id']=['neq',$id];
            $artres=db('article')->where($map)->order('id desc')->limit(8)->select();
            //把当前查询出来的数组合并到$ralateres
            $ralateres=array_merge($ralateres,$artres);
        }
        //有关键词才去重
        if($ralateres){
        //去重处理
        $ralateres=arr_unique($ralateres);

        return $ralateres;

        }

    }








}
