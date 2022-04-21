<!-- Test Modal -->

<div id="testModal" class="modal" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Modal body text goes here.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Create Post Modal -->

<div id="addModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="apModalLabel">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <!-- Modal header -->
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span type="hidden" id="id_show" name="id_show" />
      </div>
      <!-- Modal body -->
      <div class="modal-body container-fluid">
        {{ Form::model('Post', ['id' =>'addPostForm', 'enctype' => 'multipart/form-data']) }}
        <!--form id="addPostForm" class="form-horizontal" role="form" enctype="multipart/form-data"-->
          {{ csrf_field() }}
          <!-- Title, Categories & Tags -->
          <div class="form-group row">
            <div class="col-md-6">
              <label for="title" class="control-label">Title</label>
              <input type="text" id="title_add" name="title" class="form-control" data-error="Please enter Post title." required autofocus/>
              <div class="help-block with-errors"></div>
            </div>
            <div class="col-md-3">
              {{Form::label('category', 'Category')}}
              {{Form::select('category', $categories, 0, ['id'=>'category_add', 'class' => 'form-control']) }}
            </div>
            <div class="col-md-3">
              {{Form::label('tag', 'Tag')}}
              {{Form::select('tag', $tags, 0, ['id'=>'tag_add', 'class' => 'form-control']) }}
            </div>
          </div>
          <!-- Post Body -->
          <div class="form-group">
            <label for="body" class="control-label">Body</label>
            <textarea id="a_post_body" name="content" rows="25" cols="160" class="form-control  mceEditor"></textarea>
            <p class="errorContent text-center alert alert-danger hidden"></p>
            <div class="help-block with-errors"></div>
          </div>
          <div class="col-md-2">
            <input type="file" id="a_cover_image" name="cover_image"/>
          </div>
        {{ Form::close() }}
      </div>
      <!-- Modal Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-warning btn-xs" data-dismiss="modal">
          <i class="fa fa-times ml-1"></i> Cancel
        </button>
        <button type="button" class="btn btn-success btn-xs crud_add" data-dismiss="modal">
          <i class="fa fa-plus ml-1"></i> Add Post
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Edit Post Modal -->

<div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="epModalLabel">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <!-- Modal header -->
      <div class="modal-header">
       <h5 class="modal-title">Edit Post </h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span type="text" id="id_edit"  name="id_edit" hidden/>
      </div>
      <!-- Modal body -->
      <div class="modal-body container-fluid">
        {{ Form::model('Post', ['id' =>'editPostForm', 'enctype' => 'multipart/form-data']) }}
        <!--form id="editPostForm" class="form-horizontal" role="form" enctype="multipart/form-data"-->
          {{-- csrf_field() --}}
          {{ form::hidden('_method', 'PUT') }}
          <!-- Title, Categories & Tags -->
          <div class="form-group row">
            <div class="col-md-6">
              <label class="control-label" for="title">Title</label>
              <input type="text" name="title" id="title_edit" class="form-control" data-error="Please enter Post title." required autofocus/>
              <div class="help-block with-errors"></div>
            </div>
            <div class="col-sm-3">
              {{Form::label('category', 'Category')}}
              {{Form::select('category', $categories, 0, ['id'=>'category_edit', 'class' => 'form-control e_category']) }}
            </div>
            <div class="col-sm-3">
              {{Form::label('tag', 'Tag')}}
              {{Form::select('tag', $tags, 0, ['id'=>'tag_edit', 'class' => 'form-control e_tag']) }}
            </div>
          </div>
          <!-- Post Body -->
          <div class="form-group">
            <label for="body" class="control-label">Body</label>
            <textarea id="e_post_body" name="content" rows="25" cols="160" class="form-control mceEditor"></textarea>
            <p class="errorContent text-center alert alert-danger hidden"></p>
            <div class="help-block with-errors"></div>
          </div>
          <div class="col-sm-2">
            <input type="file" id="e_cover_image" name="cover_image"/>
          </div>
        {{ Form::close() }}
      </div>
      <!-- Modal Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-warning btn-xs" data-bs-dismiss="modal">
          <i class="fa fa-times ml-1"></i> Cancel
        </button>
        <button type="button" class="btn btn-success btn-xs crud_update" data-bs-dismiss="modal">
          <i class="fa fa-plus ml-1"></i> Update Post
        </button>
      </div>
    </div>
  </div>  
</div>

<!-- Show Post Modal -->

<div id="showModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="vpModalLabel">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <!-- Modal header -->
      <div class="modal-header">
        <h5 class="modal-title">Show Post: </h5>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
        <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        <input type="text" id="id_show" hidden />
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <form id="showPostForm" class="form-horizontal" role="form">
          {{csrf_field()}}
          <!-- Post Body -->
          <div class="form-group">
            <div class="col-md-12 s_modal-content">
              <label class="control-label" for="body">Body</label>
              <textarea id="s_post_body" rows="25" cols="160" class="form-control" disabled></textarea>
              <p class="errorContent text-center alert alert-danger hidden"></p>
              <div class="help-block with-errors"></div>
            </div>
          </div>
        </form>  
      </div>
      <!-- Modal Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-xs" data-bs-dismiss="modal">
          <i class="fa fa-times ml-1"></i> Done
        </button>
      </div>  
    </div>  
  </div>
</div>

<!-- Delete Post Modal -->

<div id="deleteModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <h4 class="text-center">Are you sure you want to delete the following post?</h4>
        <br />
        <form class="form-horizontal" role="form">
          <div class="form-group">
            <label class="control-label col-sm-2" for="id">ID:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="id_delete" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="title">Title:</label>
            <div class="col-sm-10">
              <input type="name" class="form-control" id="title_delete" disabled>
            </div>
          </div>
        </form>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger delete btn-xs" data-bs-dismiss="modal">
            <i class="fa fa-trash ml-1"></i> Delete
          </button>
          <button type="button" class="btn btn-warning btn-xs" data-bs-dismiss="modal">
            <i class="fa fa-times ml-1"></i> Close
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
