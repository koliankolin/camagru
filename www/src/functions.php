<?php

function userFilter($users, $col, $filter)
{
    if (!$users) {
        return false;
    }
    if (is_null($filter)) {
        return $users;
    }
    $usersNew = [];
    foreach ($users as $user) {
        if (strtolower($user[$col]) == strtolower($filter)) {
            $usersNew[] = $user;
        }
    }
    return $usersNew;
}

function getImagesFromPhotos($photos)
{

    $images = [];
    if (!empty($photos)) {
        foreach ($photos as $photo) {
            $images[] = $photo["photo"];
        }
    }
    return $images;
}
