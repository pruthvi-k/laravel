<?php

/**
 * Created by PhpStorm.
 * User: pruthvi
 * Date: 7/9/15
 * Time: 4:22 PM
 */
namespace Pruthvi\MetaGrabber\Http;

class MetaGrabber
{
    protected $url = '';
    protected $html;

    /**
     * @param $url
     */
    public function setUrl($url){
        $this->url = $url;
        $this->html = file_get_contents($this->url);
    }

    //Check the url
    public function checkUrl(){

        //valid url given...?
        if (filter_var($this->url, FILTER_VALIDATE_URL) === FALSE){
            return false;
        }else{

            //cek the url status
            $array = @get_headers($this->url);
            $status = $array[0];
            if(strpos($status,"200") or strpos($status,"301")){
                return true;
            }
            return false;
        }
    }

    //getting meta tags
    public function getMeta($attr=null){
        if($attr){
            $meta = get_meta_tags($this->url);
            return isset($meta[$attr]) ? $meta[$attr] : 'No meta found';
        }
        return get_meta_tags($this->url);
    }

    private function explodeTitle($a,$b,$c){
        $y = explode($b,$a);
        $x = explode($c,$y[1]);
        return $x[0];
    }

    //getting title
    public function getTitle(){
        return $this->explodeTitle($this->html,"<title>","</title>");
    }

    //get the Domain
    public function getDomain(){
        $dmn = parse_url($this->url);
        return $dmn['host'];
    }

    //getting images with DOMdocument
    /**
     * @return array
     */
    public function getImg(){
        $html = $this->html;
        $doc = new \DOMDocument;

        @$doc->loadHTML($html);
        $tags = $doc ->getElementsByTagName('img');

        $arr = array();

        foreach ($tags as $tag) {

            $arr[] = $tag->getAttribute('src');
        }

        //return only the first image
        if(!empty($arr))
            return $arr;//$arr[0];


    }
}