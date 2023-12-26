$(document).ready(function() {
  $('#table').DataTable({
    language: {
      //customize pagination prev and next buttons: use arrows instead of words
      'paginate': {
        'previous': '<span class="fa fa-chevron-left"></span>',
        'next': '<span class="fa fa-chevron-right"></span>'
      },
      //customize number of elements to be displayed
      "lengthMenu": 'Hiện <select class="form-control input-sm">'+
        '<option value="5">5</option>'+
        '<option value="10">10</option>'+
        '<option value="25">25</option>'+ 
        '<option value="50">50</option>'+
        '<option value="100">100</option>'+
        '<option value="-1">All</option>'+
        '</select> bản ghi',
      "search": "Tìm kiếm",
      "info": "Hiện từ _START_ đến _END_ của _TOTAL_ bản ghi"
    }
  })  
} );