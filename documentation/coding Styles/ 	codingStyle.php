<?php
/**
 * Created by PhpStorm.
 * User: IanVi
 * Date: 12/7/2017
 * Time: 2:53 PM
 */
$string = "Hello world!";
$array = ['bob', 'bob', 'bob'];
echo $string.$array[0];
function deleteSystem32() {
    return true;
}
function deleteMoreSystem32() {
}
if($string == "stringetje") {
    echo "Hallo".$array[0];
} else if ($string == "Geen stringetje") {
    echo $string;
} else {
    echo "bob";
}
while(true) {
    $deleted = deleteSystem32();
    if(!$deleted) {
        deleteMoreSystem32();
    }
}
