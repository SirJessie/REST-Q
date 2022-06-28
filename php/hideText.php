<?php
    function hideEmail($email){
        $parts = explode('@', $email);
        return substr($parts[0], 0, min(4, strlen($parts[0])-1)) . str_repeat('*', max(1, strlen($parts[0]) - 4)) . '@' . $parts[1];
    }

    function hidePassword($password){
        $parts = $password;
        return substr($parts, 0, 3) . str_repeat('*', strlen($parts) - 5) . substr($parts, -2, 2);
    }

    function hideContact($contact){
        $parts = $contact;
        return substr($parts, 0, 4) . str_repeat('x', 5) . substr($parts, -2, 2);
    }

    function changeContactFormat($contact){
        $newNumber = '+63' . trim($contact, '0');

        return $newNumber;
    }
?>