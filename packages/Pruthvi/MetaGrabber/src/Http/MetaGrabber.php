<?php

/**
 * Created by PhpStorm.
 * User: pruthvi
 * Date: 7/9/15
 * Time: 4:22 PM
 */
namespace Pruthvi\MetaGrabber\Http;
use Illuminate\Support\Facades\Config;
use Pruthvi\MetaGrabber\Http\ImageUrlFormatter;

class MetaGrabber
{
    protected $url = '';
    protected $html;
    protected $document;
    protected $base;
    protected $headers;
    protected $user_agent;
    protected $mg_image_width;
    protected $mg_image_height;

    public function __construct($url)
    {
        // Store url
        $this->url = $url;
        $this->mg_image_width = Config::get('metagrabber.mg_image_width');
        $this->mg_image_height = Config::get('metagrabber.height');
    }

    /**
     * Loads the HTML from the url if not already done.
     */
    public function load()
    {
        // Return if already loaded
        if ($this->document)
            return;

        $this->url = str_replace('https', 'http', $this->url);

        if (self::getDocument($this->url) == '') {
            return 404;
        }


        $this->document = self::getDocument($this->url);

        // Get the base url
        $this->base = self::getBase($this->document);
        if (!$this->base)
            $this->base = $this->url;
    }

    /**
     * function to fetch all images , title and description
     * @return string
     */
    public function getMeta()
    {
        $large_image_width = $this->mg_image_width;
        $large_image_height = $this->mg_image_height;

        // Makes sure we're loaded
        $this->load();
        if ($this->load() == 404) {
            $metaData = array();
            $metaData['status'] = '404 not found';
            return $metaData;
        }
        // Image collection array

        $images = array();
        $xp = new \domxpath($this->document);

        // get all meta tags from document
        $metas = $this->document->getElementsByTagName('meta');

        $metaData = array();
        $metaData['description'] = '';
        // loop throug all meta tags
        foreach ($metas as $meta) {

            $metaData[$meta->getAttribute('property')] = $meta->getAttribute('content');
            if (strtolower($meta->getAttribute('name')) == 'description') {
                $metaData['description'] = $meta->getAttribute('content');
            }
            if (strtolower($meta->getAttribute('itemprop')) == 'image') {
                if (strpos($this->url, 'http://') === false) {
                    $this->url = 'http://' . $this->url;
                }

                $metaData['itempropimage'] = $this->url . "/" . $meta->getAttribute('content');
            }
        }

        // get title
        $title = $this->document->getElementsByTagName('title')->item(0)->textContent;
        $metaData['title'] = trim($title);
        // get description
        if (isset($metaData['og:description'])) {
            $metaData['description'] = $metaData['og:description'];
        } else {
            $metaData['description'] = $metaData['description'];
        }

        if (count($metaData) > 0 && isset($metaData['og:image'])) {
            if (strpos($metaData['og:image'], 'http:') === false) {
                $metaData['image'] = 'http:' . $metaData['og:image'];
            }

            $metaData['image'] = $metaData['og:image'];
        } else if (isset($metaData['itempropimage'])) {
            $metaData['image'] = $metaData['itempropimage'];
        }

        if (isset($metaData['image'])) {
            @$imageString = file_get_contents($metaData['image']);
        }

        if (empty($imageString) || !isset($metaData['image']) || $metaData['image'] == '') {
            $image_list = $xp->query("//img[@src]");
            $images = array();

            //loop all images and find required size image
            for ($i = 0; $i < $image_list->length; $i++) {

                $actualImage = $image_list->item($i)->getAttribute("src");

                $ImageUrlFormatter = new ImageUrlFormatter();
                $img = $ImageUrlFormatter->format($this->url, $actualImage);
                $ext = trim(pathinfo($img, PATHINFO_EXTENSION));

                if ($img && $ext != 'gif') {
                    list($width, $height, $type, $attr) = @getimagesize($img);

                    if ($i > 0) {

                        if ($width > $large_image_width || $height > $large_image_height)
                        {
                            $large_image = $img;
                            $large_image_width = $width;
                            $large_image_height = $height;
                        }

                    } else {
                        $large_image = $img;
                        $large_image_width = $width;
                        $large_image_height = $height;
                    }

                    if ($width < $this->mg_image_width || $height < $this->mg_image_height) {
                        continue;
                    } else {
                        if($width >= $this->mg_image_width && $height >= $this->mg_image_height)
                        {
                            $large_image = $img;
                            break;
                        }
                    }
                }

            }
        }
        //check if no image data is present assign it to blank
        if (count($images) <= 0 && !isset($metaData['image'])) {
            $metaData['image'] = '';
        }
        if (isset($large_image))
            $metaData['image'] = $large_image;

        if (!array_keys($metaData, 'description')) {
            // $metaData['description'] = '';
        }

        //hack for search google link
        if (isset($metaData['image']) && strpos($metaData['image'], 'search')) {
            $rebuildUrl = parse_url($this->url);
            $search = array_values($metaData);
            $metaData['image'] = $rebuildUrl['scheme'] . "://" . $rebuildUrl['host'] . $search[1];
        }

        if( $metaData['title'] == "" || $metaData['description'] == "") {
            $metaData['title'] = ucfirst($this->__extractName($this->url));
        }

        return $metaData;
    }

    private function __extractName($url) {
        $domain = parse_url($url, PHP_URL_HOST);
        if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $list)) {
            return substr($list['domain'], 0, strpos($list['domain'], "."));
        }
        return false;
    }

    /**
     * Gets the html of a url and loads it up in a DOMDocument.
     *
     * @param type $url
     *
     * @return DOMDocument
     */
    private function getDocument($url)
    {
        $url = str_replace("&amp;", '&', $url);

        //$this->headers[] = 'Connection: Keep-Alive';
        $this->headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
        $this->user_agent = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)';

        // Set up and execute a request for the HTML
        $process = curl_init($url);
        curl_setopt($process, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($process, CURLOPT_HEADER, 0);
        curl_setopt($process, CURLOPT_USERAGENT, $this->user_agent);
        curl_setopt($process, CURLOPT_TIMEOUT, 30);
        curl_setopt($process, CURLOPT_HTTPGET, true);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
        // execute curl response
        $response = curl_exec($process);

        $httpCode = curl_getinfo($process, CURLINFO_HTTP_CODE);

        curl_close($process);
        // check if http code is valid( Status Ok) then go ahead else return document
        if ($httpCode == 200) {
            // Create DOM document
            $document = new \DOMDocument();

            // Load response into document, if we got any
            if ($response) {
                libxml_use_internal_errors(true);
                $document->loadHTML('<?xml encoding="UTF-8">' . $response);
                libxml_clear_errors();
                return $document;
            }
        } else {
            return '';
        }
    }


    /**
     * Tries to get the base tag href from the given document.
     *
     * @param DOMDocument $document
     *
     * @return null
     */
    private static function getBase(\DOMDocument $document)
    {
        $tags = $document->getElementsByTagName('base');

        foreach ($tags as $tag)
            return $tag->getAttribute('href');

        return NULL;
    }

    /* GET ALL META TAGS*/

//    //Check the url

}