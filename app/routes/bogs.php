<?php

use Throneroom\Models\Bog;
use Throneroom\Validation\Validator;

$app->get('/bogs', function() use ($app) {
  $sort_by = ($app->request->get('sort_by')) ? $app->request->get('sort_by') : 'created_at';
  $count = ($app->request->get('count')) ? $app->request->get('count') : 12;

  // validation
  $v = new Validator;
  $v->validate([
    'sort_by' => [$sort_by, 'belongs_to:created_at:rating:nearest'],
    'count' => [$count, 'number'],
  ]);

  if($v->passes() === false) {
    $app->response->setStatus(400);
    $app->response->write(json_encode($v->errors()));
  } else {
    if($sort_by == 'nearest') {
      if($app->request->get('coords') == null) {
        return $app->response->write(json_encode([
          'error' => [
            'code' => 2001,
            'message' => "You must supply a 'coords' variable for sort_by type of 'nearest'.",
          ]
        ]));
      } else {
        $coords = json_decode($app->request->get('coords'));
        $query = "
        SELECT *,
         3956 * 2 * ASIN(SQRT( POWER(SIN(({$coords['lat']} -
         abs(
         dest.lat)) * pi()/180 / 2),2) + COS(@orig_lat * pi()/180 ) * COS(
         abs
         (dest.lat) *  pi()/180) * POWER(SIN((@orig_lon – dest.lon) *  pi()/180 / 2), 2) ))

         as distance FROM hotels desthaving distance < @distORDER BY distance limit 10;
        ";
        $bogs = Bog::query($query)->get();
        $app->response->setStatus(200);
        //var_dump($bogs);
        $response = [];

        foreach($bogs as $bog) {
          $response[] = $bog->getData();
        }
        $app->response->write(json_encode($response));
      }
    } else {
      $bogs = Bog::orderBy($sort_by, 'DESC')->take($count)->get();
      $app->response->headers->set('Access-Control-Allow-Origin', '*');

      $app->response->setStatus(200);
      $response = [];
      foreach ($bogs as $bog) {
        $response[] = $bog->getData();
      }
      $app->response->write(json_encode($response));
    }
  }
});

$app->get('/bogs/:id', function($id) use ($app) {
  $bog = Bog::where('id', $id)->first();
  if($bog) {
    $app->response->setStatus(200);
    $app->response->headers->set('Access-Control-Allow-Origin', '*');
    return $app->response->write(json_encode($bog->getData()));
  } else {
    $app->response->setStatus(404);
    return $app->response->write(json_encode([
      'error' => [
        'code' => 1001,
        'message' => 'That bog doesn\'t exist. ',
      ]
    ]));
  }
});
