<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/core/lib/RCatalog.php";
class RServer{

    
    /** @method string getCategories 
     * 
     * */
    public function getCategories(){
        $catalog = new RCatalog("goods");
        return json_encode($catalog->getItemsAt(0),JSON_UNESCAPED_UNICODE);
    }
    
    /**
     * @method string getItemsOf
     * @param integer id
     * */
    public function getItemsOf($id){
        $catalog = new RCatalog("goods");
        $id*=1;
        
        $data = $catalog->getChildrenOf($id);
        foreach($data as $i=>$v){
            $data[$i]['img'] = "http://".$_SERVER['HTTP_HOST']."/".RImages::getURL($v['image']);
        }
        return json_encode($data,JSON_UNESCAPED_UNICODE);
    }
    
    /** 
     * @method string search
     * @param integer id
     * @param float from
     * @param float to 
     * */
    public function search($id, $from, $to){
         $catalog = new RCatalog("goods");
         $id*=1; $from*=1; $to*=1;
         $data = $catalog->getByQuery($id, 0, " price<$to AND price>$from");
         
         foreach($data as $i=>$v){
            $data[$i]['img'] = "http://".$_SERVER['HTTP_HOST']."/".RImages::getURL($v['image']);
            }
         return json_encode($data,JSON_UNESCAPED_UNICODE);
    }
    
    
    /**
     * @method string getSimilar
     * @param integer id
     * */
    public function getSimilar($id){
        $catalog = new RCatalog("goods");
        $id*=1;
        $el = $catalog->getItemAt($id, 1);
        $data = $catalog->getByQuery($el['parent'],0," 1 ORDER  BY RAND() LIMIT 3");
        
        $res = [];
        foreach($data as $i=>$v){
            if($v['id']==$id) continue;
            $data[$i]['img'] = "http://".$_SERVER['HTTP_HOST']."/".RImages::getURL($v['image']);
            $res[] = $data[$i];
        }
        return json_encode($res,JSON_UNESCAPED_UNICODE);
    }
    
    /**
     * @method string details
     * @param integer id
     * */
    public function details($id){
        $catalog = new RCatalog("goods");
        $id*=1;
        
        $data = $catalog->getItemAt($id, 1);
        $data['img'] = "http://".$_SERVER['HTTP_HOST']."/".RImages::getURL($data['image']);
        return json_encode($data,JSON_UNESCAPED_UNICODE);
    }
    
    
    /**
     * @method string getPopulars
     * @param integer n
     * */
    public function getPopulars($n){
        $catalog = new RCatalog("goods");
        $n*=1;
        return json_encode($catalog->getAllByQuery(1, " ORDER BY views DESC LIMIT $n"));
    }
    
    /**
     * @method float getSum
     * @param float a
     * @param float b
     * */
    public function getSum($a, $b){
        return $a+$b;
    }
    
    /**
     * @method string getArticles
     * */
    public function getArticles(){
        $catalog = new RCatalog("news");
        
        $data = $catalog->getItemsAt(0);
        foreach($data as $i=>$v){
            $data[$i]['img'] = "http://".$_SERVER['HTTP_HOST']."/".RImages::getURL($v['img']);
            $data[$i]['published']= date("d.m.Y H:i",strtotime($v['published']));
            }
            
        return json_encode($data,JSON_UNESCAPED_UNICODE);
    }
    
    /**
     * @method string getArticleContent
     * @param integer id
     * 
     * */
    public function getArticleContent($id){
        $catalog = new RCatalog("news");
        $data = $catalog->getItemAt($id, 0);
        $data['img'] = "http://".$_SERVER['HTTP_HOST']."/".RImages::getURL($data['img']);
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    
} 