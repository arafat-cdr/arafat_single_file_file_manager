<?php

/**
 *
 * @author: arafat.dml@gmail.com
 * @package arafat simple One file . File manager
 * @Develop finish date: 23-September-2022
 * @hireme by mailing me or
 * @fiverr.com/web_lover
 *
 */


function redirect($url){
    echo "<script>window.location.href='".$url."'</script>";
    exit();
}
echo "<style>
    .btn {
      background-color: #4CAF50;
      border: none;
      color: white;
      padding: 15px 32px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      margin: 4px 2px;
      cursor: pointer;
    }

    .btn__red {
      background-color: red;
    }
    .btn__green {
      background-color: #4CAF50;
    }

    .btn-red {
      background-color: red;
    }

    .wl_table {
      font-family: Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    .wl_table td, .wl_table th {
      border: 1px solid #ddd;
      padding: 8px;
    }

    .wl_table tr:nth-child(even){background-color: #f2f2f2;}

    .wl_table tr:hover {background-color: #ddd;}

    .wl_table th {
      padding-top: 12px;
      padding-bottom: 12px;
      text-align: left;
      background-color: #04AA6D;
      color: white;
    }

    .button {
      background-color: #4CAF50; /* Green */
      border: none;
      color: white;
      padding: 16px 32px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      margin: 4px 2px;
      transition-duration: 0.4s;
      cursor: pointer;
    }

    .btn_green {
      background-color: white; 
      color: black; 
      border: 2px solid #4CAF50;
    }

    .btn_green:hover {
      background-color: #4CAF50;
      color: white;
    }

    .btn_blue {
      background-color: white; 
      color: black; 
      border: 2px solid #008CBA;
    }

    .btn_blue:hover {
      background-color: #008CBA;
      color: white;
    }

    .btn_red {
      background-color: white; 
      color: black; 
      border: 2px solid #f44336;
    }

    .btn_red:hover {
      background-color: #f44336;
      color: white;
    }

    .btn_grey {
      background-color: white;
      color: black;
      border: 2px solid #e7e7e7;
    }

    .btn_grey:hover {background-color: #e7e7e7;}

    .btn_black {
      background-color: white;
      color: black;
      border: 2px solid #555555;
    }

    .btn_black:hover {
      background-color: #555555;
      color: white;
    }
    .file_upload_div{
        float: right;
        border-style: dashed;
        border-color: #4787ed;
        margin-top: -21px;
        padding: 12px;
        margin-left: 10px;
        margin-bottom: 20px;
    }
    .rename_copy_move_div{
      margin: auto;
      width: 50%;
      padding: 10px;
    }
    .file_upload{

    }
    .wl_heading {
        clear: both;
        text-align: center;
    }
    .text_success{
        color:  #4787ed;
    }
    input[type=text] {
      width: 100%;
      padding: 12px 20px;
      margin: 8px 0;
      box-sizing: border-box;
      border: 1px solid #555;
      outline: none;
    }

    input[type=text]:focus {
      background-color: lightblue;
    }
    .red{
        clear: both;
        color: red;
    }
    textarea {
        width: 100%;
        height: 500px;
        background-color: #f8f8f8;
        color: green;
    }
    .wl_textarea {
      width: 100%;
      height: 150px;
      padding: 12px 20px;
      box-sizing: border-box;
      border: 2px solid #ccc;
      border-radius: 4px;
      background-color: #f8f8f8;
      font-size: 16px;
    }

</style>";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

# My constant 
define("DOCUMENT_ROOT", $_SERVER['DOCUMENT_ROOT'].'/');
define("HOST", 'http://'.$_SERVER['HTTP_HOST'].'/');

function pr($data, $die = false){
    echo "<pre>";
    print_r($data);
    echo "</pre>";

    if( $die ){
        die();
    }
}


function set_flash($msg, $key = 'msg'){
    $_SESSION[$key] = $msg;
}

function get_flash($key = 'msg'){

    if( isset( $_SESSION[$key] ) ){
        return $_SESSION[$key];
    }
    return false;
}

function show_flash($key = 'msg'){

    if( isset( $_SESSION[$key] ) ){
        
        $session_var = $_SESSION[$key];
        
        if( is_array( $session_var ) ){
            foreach( $session_var as $k => $v ){
                echo $v;
            }
        }else{
            echo $session_var;
        }

        # delete Session
        unset( $_SESSION[$key] );
    }
}

function wl_get_file_ext( $path ){

    return strtolower(pathinfo($path, PATHINFO_EXTENSION));
}

function wl_get_current_path(){

    $current_path = DOCUMENT_ROOT;

    if( isset( $_GET['path'] ) ){
        $current_path = $_GET['path'];
    }

    $current_path = rtrim( $current_path );
    $current_path = $current_path.'/';

    return $current_path;
}


function wl_read_file_update_file( $path ){

    $read = file_get_contents( $path );

    # --------------------------------------
    # Code Save
    #---------------------------------------

    if( isset( $_POST['codeSave'] ) ){
        $update_code = file_put_contents($path, $_POST['update_code']);
    }
    
    #--------------------------------------
    # end Code save
    # --------------------------------------

    echo "<form action='' method='post' ><textarea name='update_code'>".$read."</textarea> <input type='submit' name='codeSave' value='codeSaveNow' class='btn btn-red'>";
}

function wl_read_zip_file($zip_file){
    $zip = zip_open( $zip_file );

    if ($zip) {
        while ($zip_entry = zip_read($zip)) {
            echo "<p>" . zip_entry_name($zip_entry) . "<br>";
        }
        zip_close($zip);
    }

    # Now Extract the Zip

    $extract_to = dirname( $zip_file );

    $zip = new ZipArchive;

    if ($zip->open($zip_file) === TRUE) {

        $zip->extractTo( $extract_to );
        $zip->close();

        echo 'Extract Success';
    } else {
        echo 'Zip Extract failed';
    }

}

function wl_file_view_processing( $path ){

    echo "<h3 class='red wl_heading'>You are viewing Full Path File: <strong> <mark>".$path."</mark> </strong></h3>";
    echo "<h3 class='red wl_heading'>You are viewing File: <strong> <mark>".basename($path)."</mark> </strong></h3>";

    $path = ltrim( $path, '/' );
    $path = rtrim( $path, '/' );

    $path = '/'.$path;

    $file_ext = wl_get_file_ext( $path );

    $not_read_file =  array('doc','dot','docx','dotx','docm','dotm','xls','xlt','xla','xlsx','xltx','xlsm','xltm','xlam','xlsb','ppt','pot','pps','ppa','pptx','potx','ppsx','ppam','pptm','potm','ppsm','pdf');

    $video = array('mov', 'mpeg-1', 'mpeg-2', 'mpeg4', 'mp4', 'mpg', 'avi', 'wmv', 'mpegps', 'flv', '3gpp', 'webm', 'dnxhr', 'prores', 'cineform', 'hevc');

    $supported_img = array( 'jpg', 'jpeg', 'png', 'gif', 'webp' );

    if( 'wl_file_manager.php' == basename($path) ){
        echo "<h1 class='red wl_heading'>Not allow to edit the core file</h1>";
    }else if( $file_ext == 'zip' ){
        wl_read_zip_file( $path );
    }else if( in_array($file_ext,  array_merge( $not_read_file,  $video) ) ){
        echo "<h1 class='red wl_heading'>This is a {$file_ext} File</h1>";
    }else if( in_array( $file_ext, $supported_img) ){
        $path = str_replace( DOCUMENT_ROOT, HOST, $path );
        echo "<img src='".$path."' width='500' height=300 >";
    }else if( isset( $_GET['rename'] ) || isset( $_GET['copy'] ) || isset( $_GET['move'] ) ){
        // do nothing
    }else {
        wl_read_file_update_file( $path );
    }
}

####################################################################
$path = wl_get_current_path();
# Back url
$back_url = dirname($path);
echo "<h2 class='red wl_heading'> You are browsing <strong> $path </strong> </h2>";

# -------------------------------------------
show_flash();
# -------------------------------------------

echo "<a href='?path=".$back_url."'> <button class='btn'> << Back </button><br/><br/><br/> </a>";

echo "<div class='file_upload_div'> <h4 class='red wl_heading'> File Upload Panel <hr/> </h4> <form action='' method='post' enctype='multipart/form-data'> <label> <strong> File Upload </strong> </label><br/> <input type='file' name='upload_file' class='file_upload'> <input type='submit' name='Upload' value='Upload' class='button btn__green'> </form> </div>";


echo "<div class='file_upload_div'> <h4 class='red wl_heading'> File Create Panel <hr/> </h4> <form action='' method='post'> <label> <strong> File Create </strong> </label><br/><input type='text' name='file_create' class='file_create' placeholder='file name'> <label> <strong> File Contents </strong> </label><br/><textarea name='file_contents' class='file_contents wl_textarea' placeholder='file contents'>Hello world</textarea><input type='submit' name='Create_File' value='Create File' class='button btn__green'> </form> </div>";

echo "<div class='file_upload_div'> <h4 class='red wl_heading'> Folder Create Panel <hr/> </h4> <form action='' method='post'> <label> <strong> Folder Create </strong> </label><br/> <input type='text' name='folder_create' class='folder_create' placeholder='folder name'> <input type='submit' name='Create_Folder' value='Create Folder' class='button btn__green'> </form> </div>";
####################################################################

function wl_rename_file_folder( $path, $new_name, $action = 'rename', $type = 'file' ){

    # If action is rename
    if( $action == 'rename' ){
        // $new_name = 
        $add_path = dirname( $path );
        $add_path = rtrim( $add_path, '/' );

        $new_name = $add_path.'/'.$new_name;
    }

    if( is_dir( $path ) ){
        $type = 'Folder';
    }else if( is_file( rtrim( $path, "/" ) ) ){
        $type = 'file';
        $path = rtrim( $path, "/" );
    }else {
        $type = false;
        $msg = "<h2 class='wl_heading red'> Rename Failed {$path} Not a valid Directory or File </h2>";
    }

    if( $type ){
        $res = rename( $path, $new_name );
        $msg = "<h2 class='wl_heading red'><strong class='red'>{$type}</strong> Rename To {$new_name} Failed </h2>";
        if( $res ){
            $msg = "<h2 class='wl_heading text_success'> <strong class='red'>{$type}</strong> Rename To {$new_name} Successfully </h2>";
        }

    }

    # Set flash
    set_flash($msg);

    # redirect
    $path = wl_get_current_path();
    $path = dirname( $path );
    redirect('?path='.$path);

}

function wl_copy_file_only( $path, $new_path, $type = 'file' ){

    if( is_dir( $path ) ){
        $type = false;
        $msg = "<h2 class='wl_heading red'> Copy Failed {$path} It is A directory use Another Custom made function for copy </h2>";

        # For redirect Purpose
        $new_path = $path;

    }else if( is_file( rtrim( $path, "/" ) ) ){
        $type = 'file';
        $path = rtrim( $path, "/" );
        $new_path = rtrim( $new_path, "/" );
    }else {

        $type = false;
        $msg = "<h2 class='wl_heading red'> Copy Failed {$path} Not a valid Directory or File </h2>";

        # For redirect Purpose
        $new_path = $path;
    }

    if( $type ){
        $res = copy( $path, $new_path );
        $msg = "<h2 class='wl_heading red'><strong class='red'>{$type}</strong> Copy To {$new_path} Failed </h2>";
        if( $res ){
            $msg = "<h2 class='wl_heading text_success'> <strong class='red'>{$type}</strong> Copy To {$new_path} Successfully </h2>";
        }

    }

    # Set flash
    set_flash($msg);

    $new_path = dirname( $new_path );

    # redirect
    redirect('?path='.$new_path);
}

function wl_copy_folder( $path, $new_path ){
    #-----------------------------------------
    #-----------------------------------------

    # shell will work only unix so let's write code
    /*
    $res = shell_exec("ls");
    pr($res);
    */
    # End
    #-----------------------------------------
    #-----------------------------------------

    # if destination not exist create
    if( !is_dir( $new_path ) ){
        @mkdir( $new_path );
    }

    $src_files = scandir( $path );
    $src_files = array_diff($src_files, array('.', '..'));

    $right_path = rtrim($path, '/');
    $right_path = $right_path.'/';

    $right_new_path = rtrim( $new_path, '/' );
    $right_new_path = $right_new_path.'/';

    // pr( $src_files );
    # Now do a loop
    foreach( $src_files as $k => $file ){
        if( is_file( $right_path.$file ) ){
            $res = copy( $right_path.$file, $right_new_path.$file );
            // var_dump('copy '. $res);
        }else if( is_dir( $right_path.$file ) ){
            $res = mkdir( $right_new_path.$file );
            // var_dump('mkdir '. $res);
            #recursive Call the func
            wl_copy_folder( $right_path.$file, $right_new_path.$file );
        }else{
            // echo 'no <br/>';
        }

    }

    $msg = "<h2 class='wl_heading text_success'> Folder from {$path} to {$new_path} Copy Successfully </h2>";

    # Set flash
    set_flash($msg);
    $path = wl_get_current_path();
    // redirect
    redirect('?path='.$path);

}

function wl_rename_copy_move_html_form($action_name = 'Rename'){

    if( isset( $_POST['Process_Rename_Copy_Move'] ) ){

        $path = wl_get_current_path();
        $new_name = $_POST['to'];

        if( $_POST['Process_Rename_Copy_Move'] == 'Rename' ){

            wl_rename_file_folder($path, $new_name);

        }else if( $_POST['Process_Rename_Copy_Move'] == 'Copy' ){

            if( is_file( rtrim( $path, "/" ) ) ){
                # For copy a file only
                wl_copy_file_only($path, $new_name);

            }else if( is_dir( $path ) ){
                # For copy folder and its content custom func
                wl_copy_folder( $path, $new_name );
            }
            
        }else if( $_POST['Process_Rename_Copy_Move'] == 'Move' ){
            wl_rename_file_folder($path, $new_name, 'move');
        }
    }

    $path = wl_get_current_path();

    echo "<div class='rename_copy_move_div'><h3 class='wl_heading text_success'>$action_name Fields</h3>
    <form action='' method='post'>
    <input type='text' name='from' value='".$path."' placeholder='from'>
    <input type='text' name='to' placeholder='to'>
    <input type='submit' name='Process_Rename_Copy_Move' class='button btn_green' value='".$action_name."' placeholder='to'>
    </form> </div>";
}

if( isset( $_GET['rename'] ) ){
    wl_rename_copy_move_html_form( 'Rename' );
}else if( isset( $_GET['copy'] ) ){
    wl_rename_copy_move_html_form( 'Copy' );
}else if( isset( $_GET['move'] ) ){
    wl_rename_copy_move_html_form( 'Move' );
}

function wl_table_view_file( array $folder_file_arr = [] ){
    // pr( $folder_file_arr,1 );
    echo "<table class='wl_table'>";
    echo '
    <tr>
        <th>Name</th>
        <th>Type</th>
        <th>Permission</th>
        <th>Last Edit</th>
        <th>Actions</th>
    </tr>';

    if( $folder_file_arr ){
        foreach( $folder_file_arr as $k => $v ){

            $name = $v['name'];
            $path = $v['path'];
            $type = $v['type'];
            $perm = $v['perm'];
            $modified_at = $v['modified_at'];

            $edit = "<a href='?path=".$path."' > <button class='button btn_green'>Edit</button><a>";
            $view = "<a href='?path=".$path."' > <button class='button btn_black'>View</button> <a>";

            $rename = "<a href='?path=".$path."&rename=1' > <button class='button btn_green'>Rename</button> <a>";

            $copy = "<a href='?path=".$path."&copy=1' > <button class='button btn_grey'>Copy</button> <a>";

            $move = "<a href='?path=".$path."&move=1' > <button class='button btn_black'>Move</button> <a>";

            $delete = "<a href='?path=".$path."&delete=1' onclick='return confirm(\"Are you sure ? You want to Delete this permanatly\")'><button class='button btn_red'>Delete</button></a>";

              echo "<tr>";
              echo "<td>$name</td>";
              echo "<td> $type </td>";
              echo "<td>$perm</td>";
              echo "<td>
                <span class='red'> $modified_at </span>
               </td>";
              echo "<td style='border: 2px solid red;'>
                  $edit
                  $view
                  $rename
                  <br/>
                  $copy
                  $move
                  $delete
              </td>";
            echo "</tr>";

        }
    }
echo "</table>";

}


function wl_create_folder($post){
    $folder_name = $_POST['folder_create'];

    $path = wl_get_current_path().$folder_name;

    if( is_dir( $path ) ){
        echo "<h2 class='red wl_heading'> Directory <strong class='red'> {$path}  </strong> Already Exist </h2>";
    }else{
        $res = mkdir($path, 0777, true);

        if( $res ){
            echo "<h2 class='text_success wl_heading'> Directory <strong class='red'> {$path}  </strong> Created Succesfully</h2>";
        }else{
            echo "<h2 class='red wl_heading'> Directory <strong class='red'> {$path}  </strong> Created Failed</h2>";
        }
    }

}

function wl_create_file($post){

    $file_name = $_POST['file_create'];
    $file_contents = $_POST['file_contents'];

    $file_name = wl_get_current_path().$file_name;

    $res = file_put_contents( $file_name, $file_contents );

    if( $res ){
        echo "<h2 class='text_success wl_heading'>File <strong class='red'> {$file_name}  </strong> Created Succesfully</h2>";
    }else{
        echo "<h2 class='red wl_heading'>File <strong class='red'> {$file_name}  </strong> Creation Failed</h2>";
    }

}

function wl_upload_file($post){

    $upload_file = $_FILES['upload_file'];
    $upload_file_name = $upload_file['name'];

    $target = wl_get_current_path().$upload_file_name;

    $res =  move_uploaded_file($upload_file['tmp_name'], $target);

    if( $res ){
        echo "<h2 class='text_success wl_heading'>File <strong class='red'> {$upload_file_name}  </strong> Uploaded Succesfully</h2>";
    }else{
        echo "<h2 class='red wl_heading'>File <strong class='red'> {$upload_file_name}  </strong> Upload Failed</h2>";
    }

}

#--------------------------------
# Handle create and upload
#--------------------------------
if( isset( $_POST['Create_Folder'] ) ){
        
    wl_create_folder( $_POST );
}else if( isset( $_POST['Create_File'] ) ){
    wl_create_file( $_POST );

}else if( isset( $_POST['Upload'] ) ){

    wl_upload_file( $_POST );
}

#--------------------------------
# End Handle create and upload
#--------------------------------

function wl_delete_file($path){
    # First wrtie content on 
    # File so that Recover 
    # is not poosible

    # Remove forward slash from end
    $path = rtrim( $path, '/' );

    if( is_file( $path ) ){
        $content = "Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.";

        $res = file_put_contents($path, $content);
        if( $res ){
           
           $res =  unlink($path);

           $msg = "<h2 class='red wl_heading'>File <strong class='red'> {$path}  </strong> Deleted Failed</h2>";
           if( $res ){
                $msg = "<h2 class='text_success wl_heading'>File <strong class='red'> {$path}  </strong> Deleted From server</h2>";
           }

        }else{
            $msg = "<h2 class='red wl_heading'>File <strong class='red'> {$upload_file_name}  </strong> Write failed and unlink are also  Failed</h2>";
        }
    }else{
        $msg = "<h2 class='red wl_heading'>File <strong class='red'> {$upload_file_name}  </strong> is not a valid file</h2>";
    }

    // set session
    set_flash($msg);

    # redirect
    $path = wl_get_current_path();
    $path = dirname( $path );
    redirect('?path='.$path);
}

function wl_delete_folder_recursive($path){

    if ( is_dir( $path ) ) {

        $files = scandir($path);

        $files = array_diff( $files, array('.', '..') );

        foreach ($files as $file)
        {
            # Recursive call
            wl_delete_folder_recursive(realpath($path) . '/' . $file);
        }

       return  rmdir($path);

    }else if ( is_file( rtrim( $path, '/' ) ) ){

       $path = rtrim( $path, '/' );

       return unlink($path);
    }

    return false;

}

#---------------------------------------------
# Delete Files and Folder action
#---------------------------------------------
if( isset( $_GET['delete'] ) && $_GET['delete'] == 1 ){
    $path = wl_get_current_path();
    if( is_file( rtrim($path, '/') ) ){
       # call the file delete Function
       wl_delete_file( $path );
    }else if( is_dir($path) ){
       #call the folder delete Function 
       $res = wl_delete_folder_recursive($path);

        $msg = "<h2 class='text_success wl_heading'>Directory <strong class='red'> {$path}  </strong> Deleted successfuly</h2>";
       // set session
       set_flash($msg);
       
       # redirect
       $path = wl_get_current_path();
       $path = dirname( $path );
       redirect('?path='.$path);

    }else{
        echo "<h2 class='red wl_heading'><strong class='red'> Not a File Not A directory  </strong> </h2>";
    }
    die();
}

#---------------------------------------------
# End Delete Files and Folder action
#---------------------------------------------
function wl_walk_on_server( $path_to_go = '' ){

    # Get it from my constant
    $document_root = DOCUMENT_ROOT;

    // pr( $document_root, 1 );

    $path = $document_root;

    if( $path_to_go ){
        $path = $path_to_go;
    }

    # Fix forward slash issue
    $path = rtrim( $path, '/' );

    # Add forward slash
    $path = $path.'/';

    // pr( $path, 1 );

    #################################################
    $all_folder_arr = $all_file_arr = array();

    if( is_dir( $path ) ){
        
        $files = scandir($path);
        $files = array_diff(scandir($path), array('.', '..'));



        foreach($files as $k => $file){

         $abs_path = $path.$file;

         if( is_dir( $abs_path ) ){
            # it is a directory
            $all_folder_arr[] = array(
                'name' => $file,
                'path' => $abs_path,
                'type' => 'Folder',
                'perm' => '',
                'modified_at' => '',
            ); 
         }else if( is_file( $abs_path ) ){
            
            # filetype
            $file_type = '';
            $file_type .= '<mark>'.wl_get_file_ext($abs_path).'</mark>';
            
            # It is a file
            $file_type .= is_readable( $abs_path ) ? ' -read' : '';
            $file_type .= is_writable( $abs_path ) ? '/write' : '';

            $all_file_arr[] = array(
                'name' => $file,
                'path' => $abs_path,
                'type' => $file_type,
                'perm' =>  substr(sprintf('%o', fileperms($abs_path)), -4),
                'modified_at' => ' Last Modified: '.date( "F d Y H:i:s.", filemtime($abs_path) ),
            );
         }

        }

        # merger the array
        $all_folder_n_files = array_merge( $all_folder_arr, $all_file_arr );

        # Send to the table view func
        wl_table_view_file( $all_folder_n_files );

    }else if( is_file( rtrim( $path, '/' ) ) ){
        wl_file_view_processing( $path );
    }else{
        echo "<h2 class='wl_heading'> You are browsing <strong class='red'> $path </strong> It is not a file Not and Directory </h2>";
    }

}

# ==========================================================
# Uncomment this to run with out user login
# ==========================================================

# go the the path
$path_to_go = '';
if( isset( $_GET['path'] ) ){
   // pr( $_GET['path'] );
   $path_to_go =  str_replace("'", "", $_GET['path'] ) ;
}

wl_walk_on_server( $path_to_go );


# ==========================================================
# End Uncomment this to run with out user login
# ==========================================================
