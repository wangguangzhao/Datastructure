<?php
/*
	有向图数据结构的解释及算法
*/
/*
	有向图实体
*/
class Undigraph{
	
	private $node = array(); //节点数组
	private $nodelen = 0; //节点数量
	private $line = array(); //连接线
	private $linelen = 0; //连接线数量

	public function __construct(){

	}
	/*
		添加节点
		@return Boolean
	*/
	public function addNode($node){
		if($this->hasNode($node)!== false || empty($node)){
			$this->setException("节点已存在或添加节点为空");
			return false;
		}
		$this->node[] = $node;
		$this->nodelen++;
		return true;

	}
	/*
		删除节点
		@return Boolean
	*/
	public function delNode($node){
		$key = $this->hasNode($node);
		if($key === false) return true;
		//删除关联关系
		$nodelink = $this->getLinkNode($node);
		if(!empty($nodelink)){
			foreach($nodelink as $lnode){
				$this->delline($node,$lnode);
			}	
		}
		unset($this->node[$key]);
		$this->nodelen--;
		return true;
	}
	/*
		添加关系
		@return Boolean
	*/
	public function addLine($nodeOne,$nodeTwo){
		$oneKey = $this->hasNode($nodeOne);
		$twoKey = $this->hasNode($nodeTwo);
		if($oneKey===false ||$twoKey == false || $this->hasline($nodeOne,$nodeTwo)  || $this->linelen>$this->nodelen*$this->nodelen) return ture;
		
		$this->line[$oneKey][$twoKey] = 1;
		$this->linelen++;
	}
	/*
		获取node的关联节点
		@param $next = true: 找当前节点之后的关联节点
		@return array
	*/
	private function getLinkNode($node,$next=false){
		$nodearr = array();
		$key = $this->hasNode($node);

		if($key === false || empty($this->line)) return $nodearr;
		//关联节点
		foreach($this->line[$key] as $k => $value){
			if($value ==1){
				if($next) {
					if($k > $key) $nodearr[$k] = $this->node[$k];
				}else{
					$nodearr[$k] = $this->node[$k];
				}

				
			}
		}
		ksort($nodearr);
		return $nodearr;

	}

	/*
		删除节点关系
		@return boolean
	*/
	public function delline($nodeOne,$nodeTwo){
		if(!$this->hasline($nodeOne,$nodeTwo)) return ture;
		$oneKey = $this->hasNode($nodeOne);
		$twoKey = $this->hasNode($nodeTwo);
		$this->line[$oneKey][$twoKey]=0;
		$this->line[$twoKey][$oneKey]=0;
		$this->linelen--;
		return true;
	}
	/*
		判断节点是否存在不存在返回false
		@return boolean
	*/
	public function hasNode($node){
		return array_search($node, $this->node);
	}
	/*
		判断节点间是否存在关联
		@return Boolean
	*/
	private function hasline($nodeOne,$nodeTwo){
		$nodeOnekey = $this->hasNode($nodeOne);
		$nodeTwokey = $this->hasNode($nodeTwo);

		if($nodeOnekey === false || $nodeTwokey  === false){
			$this->setException("{$nodeOne} 或 {$nodeTwo} 节点不存在");
			return false;
		}
		if(empty($this->line)) return  false;
		return $this->line[$nodeOnekey][$nodeTwokey] ;

	}
	//打印矩阵
	public function printDigraph($node){
		echo "图矩阵：\n";
		echo "	";
		for($i=0;$i<$this->nodelen;$i++){
			echo $this->node[$i]."		";
		}
		echo "\n";
		for($i=0;$i<$this->nodelen;$i++){
			echo $this->node[$i]."	";
			for($j=0;$j<$this->nodelen;$j++){
				if($this->line[$i][$j]){
					echo "1		";
				}else{
					echo "0		";
				}
			}
			echo "\n";
		}
		 

	}
	
	//获取节点数量
	public function getNodelen(){
		return $this->nodelen;
	}
	//获取关联数量
	public function getLinelen(){
		return $this->linelen;
	}
	//设置异常
	public function setException($message){

	}
}

//添加节点
$obj = new Undigraph();
$obj->addNode("A");
$obj->addNode("B");
$obj->addNode("C");
$obj->addNode("D");
$obj->addNode("E");
$obj->addNode("F");


$obj->addLine('A','B');
$obj->addLine('A','E');
$obj->addLine('E','F');
$obj->addLine('B','D');
$obj->addLine('B','C');
$obj->addLine('C','B');
$obj->addLine('C','D');
$obj->addLine('D','E');
$obj->addLine('D','D');
// $obj->delHLine('B','C');
var_dump($obj->getNodelen());	
var_dump($obj->getLinelen());
echo "打印图信息：";
$obj->printDigraph('A');

 