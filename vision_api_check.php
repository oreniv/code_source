<?php

    require 'vendor/autoload.php';
    use Google\Cloud\Vision\VisionClient;
    session_start();

function vision_api($file)
{
    $vision = new VisionClient(['keyFile' => json_decode(file_get_contents("key.json"),true)]) ;
    $photo = fopen ($file,'r');
    $query = $vision->image($photo,['SAFE_SEARCH_DETECTION','LABEL_DETECTION']);
    $result = $vision->annotate($query);
    
    $safeSearch = $result->safeSearch();
    $labels = $result->labels();
 
    $banned_items = array(
    'Trigger',
    'Air Gun',
    'Machine Gun',
    'Gun Barrel',
    'Gun Accessory',
    'Shotgun',
    'Pistol',
    'Bomb',
    'Bullet',
    'Knife',
    'Revolver',
    'Glock',
    'Uzi',
    'Sks',
    'M-16',
    'Cross',
    'Handgun'
    );
    $banned_items_len = count($banned_items);

    foreach($labels as $key => $label)
    {
            for ($i=0;$i<$banned_items_len;$i++)
            { 
        // run through the banned items with every response and if found + above 70% confidence level then alert 
                if (ucfirst($label->info()['description']) == $banned_items[$i] &&
                    number_format($label->info()['score'] * 100 , 2) > 70.00)
                     return False;
            }
    }
    foreach($safeSearch->info() as $key => $val)
    {
        if ($val == 'LIKELY' || $val == 'VERY_LIKELY')
            if ($key == 'adult' || $key == 'violence' || $key == 'racy')
            return False;
    }
    
    
return True;
}

