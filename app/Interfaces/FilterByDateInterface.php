<?php
namespace App\Interfaces;

interface FilterByDateInterface {
    public function filterByDate(?string $from, ?string $to=null);
}
?>
