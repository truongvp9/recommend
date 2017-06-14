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

public function index(Request $request, Movie $movie,Rate $rate){
        $movies = $movie->where('id','>',200)->paginate(12);
        $request->session()->put('option', '1');
	$page = isset($_GET['page'])  ? intval($_GET['page']) : 0;
        if ($page <= 0) $page = 0;
        $limit = 12;
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
        $result = $rate->where('user_id',$uid)->where('option',1)->get();
        $r = array();
        foreach ($result as $value ) {
           $r[] = $value->video_id;
        }
        $data['rate'] = $movie->findMany($r);
        return view('movies',$data);
     }

     //
     public function view(Movie $movie,Rate $rate){
        $uid = Auth::id();
        $rates = $rate->where('user_id',$uid)->where('option',2)->get();
        $data['rate'] = $rates;
        $r = array();
        foreach ($rates as $value ) {
           $r[] = $value->video_id;
        }
        $data['movie'] = $movie->findMany($r);
        return view('table',$data);
     }

     //
     public function recommend(Request $request,Rate $rate, Movie $movie){

	$recommend = array();
	if (isset($_POST['irecommend'])) {
		$recommend = (array) json_decode($_POST['irecommend']);
		$request->session()->put('option', '2');
		$request->session()->put('recommend',$recommend);
	}
        $page = isset($_GET['page'])  ? intval($_GET['page']) : 0;
        if ($page <= 0) $page = 0;
        $limit = 12;    
        $offset = $page*$limit;
        $recommend = $request->session()->get('recommend');
        $list = $recommend['itemScores'];
        
        // todo: change recommend data
        $data['item'] = $movie->paginate(12);
        $data['page'] = $page;
        $total = count($data['item']);
        $data['next'] = $offset < $total;
        $uid = Auth::id();
        $result = $rate->where('user_id',$uid)->where('option',2)->get();
        $history = $rate->where('user_id',$uid)->where('option',1)->get();
        $r = array();
        $genres = array();
	$blacklist = array();
	foreach ($history as $value){
		$m = Movie::find($value->video_id);
		if ($value->rating > 3) {
           		if ($m->Genre1 != NULL && array_key_exists($m->Genre1,$genres)) {
               			$genres[$m->Genre1] ++;
           		}
           		else {
               			$genres[$m->Genre1] = 1;
           		}
           		if ($m->Genre2 != NULL && array_key_exists($m->Genre2,$genres)) {
               			$genres[$m->Genre2] ++;
           		}
           		else {
               			$genres[$m->Genre2] = 1;
           		}
           		if ($m->Genre3 != NULL && array_key_exists($m->Genre3,$genres)) {
               			$genres[$m->Genre3] ++;
           		}
           		else {
               			$genres[$m->Genre3] = 1;
           		}
		}
		else {
			$blacklist [] = $value->video_id;
		}
	}
        foreach ($result as $value ) {
           $r[] = $value->video_id;
        }
        arsort($genres);
	$most_genre = key($genres);
        $i = array();
        foreach($list as $value){
            $i[] = $value->item;
        }
        //print_r($genres);
        //die();
        $data['rate'] = $movie->findMany($r);
        $data['item'] = $movie->wherein('MovieLensId',$i)->whereNotIn('MovieLensId',$blacklist)->where(function ($query) use ($most_genre){return $query->where('Genre1',$most_genre)->orWhere('Genre2',$most_genre)->orWhere('Genre3',$most_genre);})->paginate(12);
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

     public function store(Request $request, Rate $rate){
        //  write to rate   
        $r = array('Not sure','1. Bad','2. Not good','3. What ever','4. Very Good','5. Great');
        $uid = Auth::id();
        $id = $_POST['id'];
        $rating = $_POST['rate'];
        $option = $request->session()->get('option');
        if ((intval($id)>0) && (intval($option)>0) ) {
            $rate->video_id = $id;
            $rate->user_id = $uid;
            $rate->rating = $rating;
            $rate->option = $option;
            $rate->save();
            echo $r[$rating];
        }
        else {
            echo "fail";
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
        $option = $request->session()->get('option');
        $history = $h->where('user_id',$uid)->where('option',$option)->get();
        $his = array();
        foreach ($history as $value ) {
            $his[] = $value->video_id;
        }
        $history = Movie::findMany($his);
        $movie = Movie::find($id);
        
        $data['movie'] = $movie;
        $data['history'] = $history;
        $data['option'] = $option;
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
