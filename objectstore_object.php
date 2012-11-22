<?php

class OSObject {

  // public $id, $name;

  // public function __construct($id, $name) {
  //   $this->id = $id;
  //   $this->name = $name;
  // }

  // serialized version of the object
  public function __toString() {
    return serialize($this) . "\n";
  }

  public function update($hash) {
    foreach ($hash as $key => $value)
      $this->$key = $value;
  }

}

