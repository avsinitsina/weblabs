<?php

class Student {
    public $name = '';
    public $lastName = '';
    public $birthDate = '';

    public function __construct($name='', $lastName='', $birthDate=''){
        $gender = rand(0,1);
        $lastNames = ['Иванов', 'Петров', 'Васильев', 'Синицина'];
        $names = [
        0 => ['Петя', 'Вова', 'Кек', 'Петр'],
        1 => ['Анна', 'Алина']
        ];
        if(empty($name)) {
            $nameIndex = array_rand($names[$gender]);
            $this->name = $names[$nameIndex];
        } else
        {
            $this->name = $name;
        }
        if(empty($lastName)) {
            $lastNameIndex = array_rand($lastNames);
            $this->lastName = $names[$lastNameIndex] . ($gender==1 ? 'a':'');
        } else
        {
            $this->lastName = $lastName;
        }
        if(empty($name)) {
            $date = new DateTime('1 January 2000');
            $dayShift = rand(-150, 500);
            $date->modify("+$dayShift days");
            $this->birthDate = $date->format('d.m.Y');
        } else
        {
            $this->birthDate = $birthDate;
        }
        $this->name = $name;
        $this->lastName = $lastName;
        $this->birthDate = $birthDate;
    }

    public function toString(){
        return "$this->name $this->lastName ($this->birthName)";
    }
}
?>