<?php
    function generateRandomString($length = 6, $type = 'general') {
        $charactersArray = [
            'general' => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'code' => '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',
        ];
        $characters = $charactersArray[$type];
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }