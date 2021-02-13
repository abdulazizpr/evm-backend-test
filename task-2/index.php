<?php

require 'TreasureHunt.php';

//instace treasure hunt class
$treasureHunt = new TreasureHunt();

do {
    //clear system on windows use "system('cls')"
    system('clear');

    //print layout
    $treasureHunt->printLayout();

    //print result if any
    if (count($treasureHunt->getResult()) > 0) {
        print "Letak harta karun ditemukan:\n";

        foreach ($treasureHunt->getResult() as $position) {
            print "Harta karun berada di posisi x: " . $position['x'] . ", y:" . $position["y"] . "\n";
        }
    }
    
    print "\n";
    print "Silahkan gerakan sesuai dengan navigasi (A=maju, B=kanan, C=bawah, D=kiri) : ";
    
    //input navigation
    $input = trim(fgets(STDIN));

    //set navigation
    $treasureHunt->navigate($input);

} while ($treasureHunt->failedGame() === false); // check if the game not end

//if game end.
if ($treasureHunt->failedGame()) {
    print "\nGame Over!\n";
}