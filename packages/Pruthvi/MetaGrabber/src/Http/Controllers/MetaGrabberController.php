<?php

namespace Pruthvi\MetaGrabber\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Pruthvi\MetaGrabber\Http\MetaGrabber;

class MetaGrabberController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('metagrabber::index')->with('template', Config::get('metagrabber.master_template'));
    }

    public function metaBox()
    {
        return view('metagrabber::meta-box')->with('template', Config::get('metagrabber.master_template'));
    }


    public function getAllContent(Request $request)
    {
        $obj = new MetaGrabber($request->input('meta-grabber-url'));
        $meta = $obj->getMeta();

        if(!isset($meta['status'])) {
            return ['success' => true, 'meta' => $meta, 'images' => [$meta['image']]];
        } else {
            return ['error' => true, 'message' => 'data not found'];
        }
    }

    public function getContent(Request $request)
    {
        $obj = new MetaGrabber($request->input('meta-grabber-url'));
        $meta = $obj->getMeta();
        $content['title'] = $meta['title'];
        $content['description'] = $meta['description'];

        if(!isset($meta['status'])) {
            return ['success' => true, 'meta' => $content, 'images' => [$meta['image']]];
        } else {
            return ['error' => true, 'message' => 'data not found'];
        }
    }

    public function getImages(Request $request)
    {
        print_r($request->all());
        $obj = new MetaGrabber();
        //set url
        $obj->setUrl($request->input('meta-grabber-url'));
        $images = $obj->getImg();

        if($images) {
            return ['success' => true, 'data' => $images];
        } else {
            return ['error' => true, 'message' => 'data not found'];
        }
    }

}
