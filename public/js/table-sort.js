$(function() {
    $(".tablesort").tablesorter({
    
        headers: {
          // disable sorting of the specific column
          // note that "sort-false" is a class on the span INSIDE the first column th cell
          '.sort-false' : {
            // disable it by setting the property sorter to false
            sorter: false
          }
        }
      });
  });