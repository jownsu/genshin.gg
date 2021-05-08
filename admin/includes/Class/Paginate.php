<?php

class Paginate{

    public $page;
    public $items_per_page;
    public $total_count;

    function __construct($total_count, $page = 1 , $items_per_page = 5){
        $this->page           = (int)$page;
        $this->items_per_page = (int)$items_per_page;
        $this->total_count    = (int)$total_count;
    }

    function total_page(){
        return ceil($this->total_count / $this->items_per_page);
    }

    function offset(){
        return (($this->page - 1) * $this->items_per_page);
    }

    function has_next(){
        return $this->page >= $this->total_page() ? false : true;
    }

    function has_previous(){
        return $this->page <= 1 ? false : true;
    }

    function next(){
        return $this->page + 1;
    }

    function previous(){
        return $this->page - 1;
    }


}