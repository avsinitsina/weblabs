<?php
namespace App\Entities;

use CodeIgniter\Entity;

class Rapper extends Entity {
//    protected $dates = ['from'];

    public function getFromDate() {
//        return $this->from->toLocalizedString('dd.MM.Y');
        return \DateTime::createFromFormat('Y-m-d', $this->attributes['from'])->format('d.m.Y');

    }
    public function getFrom()
    {
        return $this->getFromDate();
    }
    public function getDeadBaddy()
    {
        return ( $this->attributes['dead_baddy']== 1)? 'Killed in a fight' : 'Not killed in a fight';
    }
}