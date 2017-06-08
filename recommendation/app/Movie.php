<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Rate;

class Movie extends Model
{
    public function getCategory($video_id) {
        $movie = Movie::find($video_id);
        return $movie->Genre1.' '.$movie->Genre2.' '.$movie->Genre3;
    }
    
    public function getRate($video_id) {
         $r = Rate::where('video_id',$video_id)->get()->first();
         return $this->rating($r->rating);
    }
    
    public function rating($val, $max=5) {
        $r = '';
        $v = round($val);
        for ($i=0; $i<$max; $i++) {
          if ($i < $v) {
            $r .= '<span class="glyphicon glyphicon-star"></span>';
          } else {
            $r .= '<span class="glyphicon glyphicon-star-empty"></span>';
          }
        }
        $r .= ' (' . round($val, 1) . ')';
        return $r;
    }
}