@extends('layouts.app')

@section('content')
<div class="container">
  <h4>Laravel 9 CRUD with AJAX</h3>
  
  <table class="display table-hover table-striped table-bordered data-table">
    <thead>
      <tr>
        <th class="text-center" style="width: 3%;">Nr</th>
        <th>Title</th>
        <th class="text-center" style="width: 280px;">Author</th>
        <th class="text-center" style="width: 90px;">
        <a class="btn btn-success btn-sm" href="javascript:void(0)" id="createNewBook">New Book</a>
        </th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
</div>

<!-- Modal -->

<div class="modal fade" id="ajaxModel" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modelHeading">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="bookForm" name="bookForm" class="form-horizontal">
          <input type="hidden" name="book_id" id="book_id">
          <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Title</label>
            <div class="col-sm-12">
              <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" value="" maxlength="50" required="">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">Author</label>
            <div class="col-sm-12">
              <textarea id="author" name="author" required="" placeholder="Enter Author" class="form-control"></textarea>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm" id="saveBtn" value="create">Save changes        </button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('javascripts')
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>   -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>  

<script type="text/javascript">

  $(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  var table = $('.data-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('books.index') }}",
    columns: [
      {data: 'id', name: 'id'},
      {data: 'title', name: 'title'},
      {data: 'author', name: 'author'},
      {data: 'action', name: 'action', orderable: false, searchable: false},
    ]
  });

  $('#createNewBook').click(function () {
    $('#saveBtn').val("create-book");
    $('#book_id').val('');
    $('#bookForm').trigger("reset");
    $('#modelHeading').html("Create New Book");
    $('#ajaxModel').modal('show');
  });

  $('body').on('click', '.editBook', function () {
    var book_id = $(this).data('id');
    $.get("{{ route('books.index') }}" +'/' + book_id +'/edit', function (data) {
      $('#modelHeading').html("Edit Book");
      $('#saveBtn').val("edit-book");
      $('#ajaxModel').modal('show');
      $('#book_id').val(data.id);
      $('#title').val(data.title);
      $('#author').val(data.author);
    })
  });

  $('#saveBtn').click(function (e) {
    e.preventDefault();
    $(this).html('Save');

    $.ajax({
      data: $('#bookForm').serialize(),
      url: "{{ route('books.store') }}",
      type: "POST",
      dataType: 'json',
      success: function (data) {
        $('#bookForm').trigger("reset");
        $('#ajaxModel').modal('hide');
        table.draw();
      },
      error: function (data) {
        console.log('Error:', data);
        $('#saveBtn').html('Save Changes');
      }
    });
  });
    
    $('body').on('click', '.deleteBook', function () {
      
      var book_id = $(this).data("id");
      confirm("Are You sure want to delete !");
    
      $.ajax({
        type: "DELETE",
        url: "{{ route('books.store') }}"+'/'+book_id,
        success: function (data) {
          table.draw();
        },
        error: function (data) {
          console.log('Error:', data);
        }
      });

    });
     
  });
</script>
@endsection