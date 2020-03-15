<?php
$page_title = 'Add User';
require_once('../load.php');
page_require_level(1);
$groups = find_all('user_groups');
?>

<?php
if(isset($_POST['add_user']))
{
  $req_fields = array('full-name','username','password','level' );
  validate_fields($req_fields);

  if(empty($errors))
  {
    $name = remove_junk($db->escape($_POST['full-name']));
    $username = remove_junk($db->escape($_POST['username']));
    $password = remove_junk($db->escape($_POST['password']));
    $user_level = (int)$db->escape($_POST['level']);
    $password = sha1($password);
    $query = "INSERT INTO users (";
    $query .="name,username,password,user_level,status";
    $query .=") VALUES (";
    $query .=" '{$name}', '{$username}', '{$password}', '{$user_level}','1'";
    $query .=")";
    
    if($db->query($query))
    {
      //sucess
      $session->msg('s',"User account has been created successfully.");
      redirect('../auth_info/add_user.php', false);
    } 
    else 
    {
      //failed
      $session->msg('d','Sorry, failed to create user account.');
      redirect('../auth_info/add_user.php', false);
    }
  } 
  else 
  {
    $session->msg("d", $errors);
    redirect('../auth_info/add_user.php',false);
  }
}
?>

<?php include_once('../header.php');?>

<div id="page-wrapper">
  <br>
  <div class="row">
    <div class="col-lg-12">
      <?php echo display_msg($msg);?>
    </div>
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <span class="glyphicon glyphicon-th"></span>
          <span>Add New User</span>
        </div>
        <div class="panel-body">
          <form method="post" action="../auth_info/add_user.php" class="clearfix">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="full-name" placeholder="Full Name">
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" placeholder="Username">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name ="password"  placeholder="Password">
            </div>
            <div class="form-group">
              <label for="level">User Role</label>
              <select class="form-control" name="level">
                <?php foreach ($groups as $group ):?>
                <option value="<?php echo $group['group_level'];?>"><?php echo ucwords($group['group_name']);?></option>
                <?php endforeach;?>
              </select>
            </div>
            <div class="form-group">
              <button type="submit" name="add_user" class="btn btn-primary">Add User</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once('../footer.php');?>