<?php

namespace Throneroom\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Comment extends Eloquent {
  public  $table = 'comments',
          $fillable = ['bid', 'text'];

  public function getText() {
    return $this->text;
  }

}
