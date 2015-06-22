<?php

namespace Webaccess\WCMSLaravel\Helpers;

class AdminMenu {
    private $items;

    public function addItem($item) {
        $this->items[]= $item;
    }

    public function getItems() {
        return $this->items;
    }
}