@extends('layouts.app')

@section('content')

@include('shared.partials')

  <!-- Year / Month filter -->

  <?php
    $years = [
      '2011' => '2011', '2012' => '2012', '2013' => '2013', '2014' => '2014', '2015' => '2015',
      '2016' => '2016', '2017' => '2017', '2018' => '2018', '2019' => '2019', '2020' => '2020',
      '2021' => '2021', '2022' => '2022', '2023' => '2023', '2024' => '2024', '2025' => '2025',
    ];
  ?>

  <div class="col-md-12">
    <!-- Posts Index -->
    <div class="card py-0 mt-4">
      <div class="panel panel-primary filterable">
        <table id="postsTable" class="display table-hover table-bordered table-striped">
          <thead  class="blue-grey lighten-4 py-0">
            <tr style="background: #3B3B91; color: white;">
              <th class="text-center" style="width: 4%;">ID</th>
              <th class="text-center" style="width: 4%;">Icon</th>
              <th>Title</th>
              <th class="text-center" style="width: 100px;">Category</th>
              <th class="text-center" style="width: 130px;">Tag</th>
              <th class="text-center" style="width: 120px;">Created</th>
              <th class="text-center" style="width: 140px;">
                <a href="#" class="add-post btn btn-success btn-sm" data-toggle="modal" data-target="#addModal">
                  <i class="fa fa-plus"></i> New Post
                </a>
              </th>
            </tr>
          </thead>
          <tbody id="post-coll" name="post-coll">
          </tbody>
        </table>  
      </div>
      <!-- Card footer -->
      <div class="panel-footer py-0" style="background: #0079D3; color: white;">
        <div class="row col-md-12">
          <div class="col col-md-4 mt-2">
            <p id="showing" class="pull-left m-0"></p>
          </div>
          <div class="col-md-8">
            <span class="pull-right py-0">{{ $data->links() }}</span>
          </div>
        </div>
      </div>     
    </div>  
  </div>
@endsection

@section('javascripts')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

  <script type="text/javascript">

    $(function () {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      // Column definitions
      var table = $('#postsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('posts.index') }}",
        columns: [
          {data: 'id', name: 'id'},
          {data: 'cover_image', name: 'cover_image'},
          {data: 'title', name: 'title'},
          {data: 'category', name: 'category'},
          {data: 'tag', name: 'tag'},
          {data: 'created_at', name: 'created_at'},
          {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
      });

      //=================================
      // Show a post
      
      $(document).on('click', '.show-modal', function () {
        console.log('Show button clicked!')
        $('.modal-title').text('Show Post - ' + $(this).data('id'))
        $('#id_show').val($(this).data('id'))
        // $('#category_show').val($(this).data('category'))
        // $('#tag_show').val($(this).data('tag'))
        const id = $('#id_show').val()
        console.log('ID = ', id)
        // $('.s_modal-content').html($(this).data('content'));
        // $('#showModal').modal('show');

        console.log('Sending Ajax Get request.  ID: ', id)
        $.ajax({
          url: '/posts/' + id,
          method: 'GET',
          dataType: 'json',
          success: ( res ) => {
            console.log('Back from Ajax GET request');
            $('.errorTitle').addClass('hidden');
            $('.errorContent').addClass('hidden');
            if ((res.errors)) {
              setTimeout(function () {
                $('#showModal').modal('show');
                toastr.error('Validation error!', 'Error Alert', { timeOut: 5000 });
              }, 500);

              if (res.errors.title) {
                $('.errorTitle').removeClass('hidden');
                $('.errorTitle').text(res.errors.title);
              }
              if (res.errors.content) {
                $('.errorContent').removeClass('hidden');
                $('.errorContent').text(res.errors.content);
              }
            } else {
              console.log('Success...');
              // console.log('Res: ', res.content);
              toastr.success('Successfully received Post!', 'Success Alert', { timeOut: 3000 });
              $('.modal-title').text(res.title);
              // $('#title_show').val(res.title);
              // $('.s_category').val(res.category);
              // $('.s_tag').val(res.tag);
              $('.s_modal-content').html(res.content);
              $('#showModal').modal('show');
            }
          }
        });
      });

      //=================================
      //== Add a new post

      $(document).on('click', '.add-modal', (e) => {
        console.log('New Post button clicked!');
        $('.modal-title').text('Add Post');
        $('#addModal').modal('show');
        $('#addModal input[0]').trigger('focus');  // Focus 'Title' field
      });

      $('.modal-footer').on('click', '.crud_add', (e) => {
        console.log('crud_add clicked!');
        e.preventDefault();

        var editor = tinyMCE.get('a_post_body');
        $('#a_post_body').val(editor.getContent());
        //$('#a_post_body').val(tinymce.get($('#a_post_body')).getContent());
        post_data = new FormData($('#addPostForm')[0]);
        console.log('POST data: ', post_data);

        $.ajax({
          url: '/posts',
          method: 'POST',
          //dataType: 'json',
          data:  post_data, // new FormData($('#addPostForm')[0]),
          //dataType: 'json',
          cache: false,
          processData: false,
          contentType: false,
          success: function ( res ) {
            console.log('Back from Ajax POST request');
            //console.log(res.responseJSON.message);
            $('.errorTitle').addClass('hidden');
            $('.errorContent').addClass('hidden');

            if ((res.errors)) {
              console.log('Error...');
              setTimeout(function () {
                $('#addModal').modal('show');
                toastr.error('Validation error!', 'Error Alert', { timeOut: 5000 });
              }, 500);

              if (res.errors.title) {
                $('.errorTitle').removeClass('hidden');
                $('.errorTitle').text(res.errors.title);
              }
              if (res.errors.content) {
                $('.errorContent').removeClass('hidden');
                $('.errorContent').text(res.errors.content);
              }
            } else {
              console.log('Success... Data: ');
              console.log(data);

              var rData =
                '<tr>' +
                  '<td align="center">' + res.id + '</td>' +
                  '<td align="center" width="4%"><img src="/storage/cover_images/noimage.png" style="width:50%"/>' +
                  '<td>' + res.title +
                  '<td>' + res.category +
                  '<td>' + res.tag +
                  '<td align="center">' +
                  "<button class='show-modal btn btn-info btn-xs' data-id='" + res.id + "' data-title='.' data-category='.' data-tag='.' data-content='.'><i class='fa fa-eye ml-1'></i></button>" +
                  "<button class='edit-modal btn btn-warning btn-xs' data-id='" + res.id + "' data-title='.' data-category='.' data-tag='.' data-tag='.' data-content='.'><i class='fa fa-edit ml-1'></i></button>" +
                  "<button class='delete-modal btn btn-danger btn-xs' data-id='" + res.id + "' data-title='.' data-category='.' data-tag='.' data-content='.'><i class='fa fa-trash ml-1'></i></button>" +
                '</tr>';
              $("#postsTable").append( rData )

              toastr.success('Successfully added Post!' + res.id, 'Success Alert', { timeOut: 3000 });
            }
          }  
        }
      })

      //=================================
      $('#createNewBook').click(function () {
        $('#saveBtn').val("create-book");
        $('#book_id').val('');
        $('#bookForm').trigger("reset");
        $('#modelHeading').html("Create New Book");
        $('#ajaxModel').modal('show');
      });

      $('body').on('click', '.editBook', function () {
        var post_id = $(this).data('id');
        $.get("{{ route('books.index') }}" +'/' + book_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Book");
          $('#saveBtn').val("edit-book");
          $('#editPost').modal('show');
          $('#post_id').val(data.id);
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
$endsection