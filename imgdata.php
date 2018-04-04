<?php
class imgdata{
    public $imgsrc;
    public $imgdata;
    public $imgform;
    public function getdir($source){
        $this->imgsrc  = $source;
    }
    public function img2data(){
        $this->_imgfrom($this->imgsrc);
        return $this->imgdata=fread(fopen($this->imgsrc,'rb'),filesize($this->imgsrc));
    }
    public function data2img(){
        header("content-type:$this->imgform");
        echo $this->imgdata;
    }
    public function _imgfrom($imgsrc){
        $info=getimagesize($imgsrc);
        return $this->imgform = $info['mime'];
    }
}
?>