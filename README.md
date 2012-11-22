ObjectStore
===========

Usage
-----

### Include it:

    include "objectstore/objectstore.php";

### Subclass it:

    // Collection
    class VerseCollection extends OSCollection { 
    }

    // Single objects
    class Verse extends OSObject {
      public $id, $book, $chapter, $verse;
      public function __construct($id, $book, $chapter, $verse) {
        $this->id = $id;
        $this->book = $book;
        $this->chapter = $chapter;
        $this->verse = $verse;
      }
    }

### Note

Objects *MUST* have an `id` property.



