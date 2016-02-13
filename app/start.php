<?php

use Slim\Slim;
use Throneroom\Models\Toilet;
require '../vendor/autoload.php';

$app = new Slim();

$app->config([
  'baseUrl' => 'http://localhost/throneroom/public'
]);

function distance($lat1, $lon1, $lat2, $lon2, $unit) {

  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);

  if ($unit == "K") {
    return ($miles * 1.609344);
  } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
        return $miles;
      }
}


require 'database.php';
require 'routes.php';

$faker = Faker\Factory::create('en_GB');
/*


$images = [
  "http://www.hahastop.com/pictures/Great_Toilets.jpg",
  "http://www.stuff.co.nz/content/dam/images/1/8/6/b/v/w/image.related.StuffLandscapeSixteenByNine.620x349.1866f3.png/1447893741406.jpg",
  "http://homeandfurnituregallery.com/wp-content/uploads/2011/03/Futuristic-toilet-designed-by-Young-Sang-Eun.jpg",
  "http://i.dailymail.co.uk/i/pix/2008/10/18/article-1078738-021C53C3000005DC-392_468x454.jpg",
  "http://www.thetraveltart.com/wp-content/uploads/2010/10/A-Toilet.jpg",
  "http://www.lbc.co.uk/mm/photos/2013/01/1939/460x/28029.jpg",
  "https://s1.yimg.com/bt/api/res/1.2/6lwXbnDc0Y5mYXIaB.kE2w--/YXBwaWQ9eW5ld3NfbGVnbztxPTg1O3c9NjMw/http://media.zenfs.com/en-GB/blogs/the-sochi-network-uk/Crazy-toilet.jpg",
  "https://static-secure.guim.co.uk/sys-images/Travel/Pix/pictures/2008/11/28/LooX4.jpg",
  "https://ethnosense.files.wordpress.com/2011/05/img_0637.jpg",
  "https://pbs.twimg.com/media/BpmbXArCEAA01U8.jpg",
  "https://s-media-cache-ak0.pinimg.com/236x/eb/37/28/eb3728057165efb365cb29952d52131d.jpg",
  "http://www.roughguides.com/wp-content/uploads/2013/10/1.-Denali.jpg",
];

foreach(range(1,100) as $i) {
  $data = [
    'name' => $faker->city,
    'coords' => json_encode([
      'lat' => $faker->latitude,
      'lng' => $faker->longitude,
    ]),
    'address' => $faker->address,
    'bio' => $faker->text,
    'rating' => rand(0, 250),
    'thumb' => $images[rand(0, count($images) - 1)],
  ];
  $bog = Throneroom\Models\Bog::create($data);
}
*/
/*
$bogs = Throneroom\Models\Bog::all();
//var_dump($bogs);

foreach($bogs as $bog) {
  $bid = $bog->getData()['id'];
  foreach(range(1,3) as $n) {
    $data = [
      'bid' => $bid,
      'text' => $faker->text
    ];
    $comment = Throneroom\Models\Comment::create($data);
  }
}

*/
