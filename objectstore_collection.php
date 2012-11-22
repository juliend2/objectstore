<?php

class OSCollection { 

  protected $file_name;
  public $data;

  public function __construct($file_name = null) {
    $this->file_name = $file_name;
    if ($this->file_name && file_exists($this->file_name)) {
      $this->set_data($this->file_name);
    }
  }

  public function get_by_id($id) {
    return $this->select_first_where(function($obj) use ($id) {
      return ($obj->id == $id);
    });
  }

  public function select_all_where($func) {
    return array_values(array_filter($this->data, $func));
  }

  public function select_first_where($func) {
    $all = $this->select_all_where($func);
    return $all[0];
  }

  public function get_next_id() {
    $highest_id = 0;
    foreach ($this->data as $v)
      if ($v->id > $highest_id) 
        $highest_id = $v->id;

    return $highest_id + 1;
  }

  public function remove($id) {
    foreach ($this->data as $key => $object)
      if ($object->id == $id) 
        unset($this->data[$key]);

    $this->rewrite_data();
  }

  public function update($object_hash) {
    foreach ($this->data as $key => $object)
      if ($object->id == $object_hash['id'])
        $this->data[$key]->update($object_hash);

    $this->rewrite_data();
  }

  public function append($object) {
    $this->data[] = $object;
    $this->rewrite_data();
  }

  private function rewrite_data() {
    $this->write_to_file(join("", $this->data), 'w');
    $this->set_data();
  }

  private function write_to_file($string, $mode='a') {
    $fp = fopen($this->file_name, $mode);
    fwrite($fp, (string)$string);
    fclose($fp);
  }

  // Set $this->data selon ce qui est dans le fichier $file_name
  private function set_data($file_name=null) {
    if (!$file_name && $this->file_name) {
      $file_name = $this->file_name;
    }
    $data_string = file_get_contents($file_name); // prend contenu du fichier de data
    $lines = $this->split_lines($data_string); // split les lignes
    array_pop($lines); // enlever l'element vide
    $this->data = array(); // make sure to reset it, if it was already set
    foreach ($lines as $line) {
      $this->data[] = unserialize($line); 
    }
  }

  private function split_lines($multiline_string) {
    return explode("\n", $multiline_string);
  }

}

