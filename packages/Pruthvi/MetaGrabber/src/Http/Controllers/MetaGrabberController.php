<?php

namespace Pruthvi\MetaGrabber\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
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
        return view('metagrabber::index');
    }


    public function getContent(Request $request)
    {
        $obj = new MetaGrabber();
        //set url
        $obj->setUrl($request->input('meta-grabber-url'));
        $meta = $obj->getMeta();
        $images = $obj->getImg();

        if($meta) {
            return ['success' => true, 'meta' => $meta, 'images' => $images];
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
