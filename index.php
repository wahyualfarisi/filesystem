<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>File System</title>
    <link rel="stylesheet" href="./assets/bootstrap.css">
</head>
<body>

    <div class="container" style="margin-top: 20px;">
        <h2 align="center"> List Folder From Directory </h2>

        <div align="right">
            <button type="button" name="create_folder" id="create_folder" class="btn btn-success">Create</button>
        </div>

        <div id="folder-table" class="table-responsive">

        </div>

    </div>


    <!-- Modal create folder , rename folder -->
    <div id="folderModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> <span id="change_title"> Create Folder </span> </h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Enter name folder</label>
                        <input type="text" class="form-control" name="folder_name" id="folder_name"> 
                    </div>
                    <input type="hidden" name="action" class="form-control" id="action">
                    <input type="hidden" name="old_name" class="form-control" id="old_name">
                    <input type="button" value="Create" id="folder_button" name="folder_button" class="btn btn-info" />
                </div>
            </div>
        </div>
    </div> 
    <!-- End Modal -->


       <!-- Modal Upload File -->
       <div id="uploadModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> <span id="change_title"> Create Folder </span> </h4>
                </div>
                <div class="modal-body">
                  <form method="post" id="upload_form" enctype="multipart/form-data" >
                    <p>Select Image</p>
                    <div class="form-group">
                        <label>Pilih file</label>
                        <input type="file" name="upload_file" id="upload_file">
                        <input type="text" name="hidden_folder_name" id="hidden_folder_name" class="form-control">
                        <input type="submit" value="Upload" name="upload_button" class="btn btn-info" />
                    </div>
                  </form>
                </div>
            </div>
        </div>
    </div> 
    <!-- End Modal -->

    


    <script src="./assets/jquery-3.2.1.min.js" ></script>
    <script src="./assets/bootstrap.min.js" ></script>
</body>
</html>

<script>

    $(document).ready(function() {
        load_folder_list()

        /**
         * load folder  
         */
        function load_folder_list()
        {
            var action = "fetch";
            $.ajax({
                url: "action.php",
                method: "POST",
                data: { action: action },
                success: function(data){
                    $('#folder-table').html(data)
                }
            })
        }

        /**
         * click button to add new folder
         */
        $(document).on('click', '#create_folder', function() {
            $('#action').val('create'); //set action value
            $('#folder_name').val('');
            $('#folder_button').val('Create');
            $('#old_name').val('');
            $('#change_title').text('Create Folder');
            $('#folderModal').modal('show');
        })

        /**
         * click button to add new folder or rename folder and submit to server
         */
        $(document).on('click', '#folder_button', function() {
            var folder_name = $('#folder_name').val();
            var action      = $('#action').val();
            var old_name    = $('#old_name').val();
            if(folder_name !== '')
            {
                $.ajax({
                    url: 'action.php',
                    method: 'POST',
                    data: {folder_name: folder_name , old_name: old_name, action: action},
                    success: function(data){
                        $('#folderModal').modal('hide')
                        load_folder_list()
                        alert(data)
                    }
                })
            }else 
            {
                alert('Enter Folder Name')
            }
        })

        /**
         * click button to rename folder 
         */
        $(document).on('click', '.update', function() {
            var folder_name = $(this).data('name');
            $('#old_name').val(folder_name)
            $('#folder_name').val(folder_name)
            $('#action').val('change');
            $('#folder_button').val('update');
            $('#change_title').text('Change Folder Name ');
            $('#folderModal').modal('show')
        })

        /**
         * upload file  
         */
        $(document).on('click', '.upload', function() {
            var folder_name = $(this).data('name');
            $('#hidden_folder_name').val(folder_name)
            $('#uploadModal').modal('show')
        })

        $(document).on('submit', '#upload_form', function(e) {
            e.preventDefault()
            
            $.ajax({
                url: 'upload.php',
                method: 'POST',
                data: new FormData(this),
                contentType: false ,
                cache: false ,
                processData: false ,
                success: function(data){
                    load_folder_list()
                    alert(data)
                    // console.log(data)
                }
            })

        })

        

       
    })


</script>