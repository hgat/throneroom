<?php

namespace Throneroom\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

use Throneroom\Models\Comment;

class Bog extends Eloquent {
  public  $table = 'bogs',
          $fillable = ['name', 'coords', 'address', 'thumb', 'bio', 'rating'];

  public function getData() {
    $comments = Comment::where('bid', $this->id)->get();
    $array = [];
    foreach($comments as $comment) {
      $array[] = $comment->getText();
    }
    return [
      'id' => $this->id,
      'name' => $this->name,
      'coords' => $this->coords,
      'thumb' => $this->thumb,
      'bio' => $this->bio,
      'address' => $this->address,
      'rating' => $this->rating,
      'created_at' => $this->created_at,
      'comments' => $array,
    ];
  }
}
