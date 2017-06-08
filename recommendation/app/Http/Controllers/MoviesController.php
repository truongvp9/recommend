<?php

namespace App\Http\Controllers;

use Session;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Movie;

use App\History;

use App\Rate;

class MoviesController extends Controller 
{

public function index(Movie $movie,Rate $rate){
        $movies = $movie->where('id','>',200)->paginate(15);
	    // print_r($movies);
	    // die();
	    $page = isset($_GET['page'])  ? intval($_GET['page']) : 0;
        if ($page <= 0) $page = 0;
        $limit = 15;
        $total = $users = DB::table('movies')->count('id');
        $offset = $page*$limit;
        if ($offset < $total) {
              $users = DB::table('movies')->skip($offset)->take($limit)->get()->toArray();
        } else {
          $users = [];
        }
        $data['item'] = $movies;
        $data['page'] = $page;
        $data['next'] = $offset < $total;
        $uid = Auth::id();
        $result = $rate->where('user_id',$uid)->get();
        $r = array();
        foreach ($result as $value ) {
           $r[] = $value->video_id;
        }
        $data['rate'] = $movie->findMany($r);
        return view('movies',$data);
     }

     //
     public function view(Rate $rate){
        $uid = Auth::id();
        $rate->where('user_id',$uid)->get();
     }

     //
     public function recommend(Request $request,Rate $rate, Movie $movie){
        $page = isset($_GET['page'])  ? intval($_GET['page']) : 0;
        if ($page <= 0) $page = 0;
        $limit = 15;    
        $offset = $page*$limit;
        $recommend = (array) json_decode($_POST['irecommend']);
        $list = $recommend['itemScores'];
        
        // todo: change recommend data
        $data['item'] = $movie->paginate(15);
        $data['page'] = $page;
        $total = count($data['item']);
        $data['next'] = $offset < $total;
        $uid = Auth::id();
        $result = $rate->where('user_id',$uid)->get();
        $r = array();
        foreach ($result as $value ) {
           $r[] = $value->video_id;
        }
        $i = array();
        foreach($list as $value){
            $i[] = $value->item;
        }
        //print_r($);
        //die();
        $data['rate'] = $movie->findMany($r);
        $data['item'] = $movie->wherein('MovieLensId',$i)->paginate(15);
        return view('recommend',$data);
     }

     public function getRateVideo(Rate $rate, Movie $movie) {
         $uid = Auth::id();
         $result = $rate->where('user_id',$uid)->get();
         $r = array();
         foreach ($result as $value ) {
            $r[] = $value->video_id;
         }
         return $movie->findMany($r);
     }
     
     public function create(){
        echo 'create';
     }

     public function store(Rate $rate){
        //  write to rate   
        $uid = Auth::id();
        $id = $_POST['id'];
        $rating = $_POST['rate'];
        $option = $_GET['option'];
        if ((intval($id)>0) && $option==1 ) {
            $rate->video_id = $id;
            $rate->user_id = $uid;
            $rate->rating = $rating;
            $rate->save();
            echo "success";
        }
        else {
            
        }

     }

     public function search(Request $request, Movie $movie){
        $page = isset($_GET['page'])  ? intval($_GET['page']) : 0;
        $key = '';
        $key = $request->input('key');
        if (!$key) {
            $key = isset($_GET['key'])?$_GET['key']:'';
        }
        $limit = 15;
        $offset = $page*$limit;
        $data['item'] = $movie->Where('Genre1',$key)->Where('Genre2',$key)->Where('Genre3',$key)->orWhere('MovieName','like','%'.$key.'%')->skip($offset)->take($limit)->get();
        $data['page'] = $page;
        $total = count($data['item']);
        $data['next'] = $offset < $total;
        $data['key'] = isset($_POST['key'])?$_POST['key']:$_GET['key'];
        return view('search',$data);
     }

     public function show(Request $request, Rate $h,$id){
        //  write to history
        $uid = Auth::id();
        //$history = new History;
        /*
        if (intval($id)>0) {
            $h->video_id = $id;
            $h->user_id = $uid;
            $h->rating = 0;
            $h->save();
        }*/
        $history = $h->where('user_id',$uid)->get();
        $his = array();
        foreach ($history as $value ) {
            $his[] = $value->video_id;
        }
        $history = Movie::findMany($his);
        $movie = Movie::find($id);
        $data['movie'] = $movie;
        $data['history'] = $history;
        return view('detail',$data);
     }

     public function edit($id){
        echo 'edit';
     }
     public function update(Request $request, $id){
        echo 'update';
     }

     public function destroy($id){
        echo 'destroy';
     }
}
