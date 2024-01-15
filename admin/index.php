<?php include "header.php"; 
   
   if (isset($_SESSION['user_data'])) 
   {
      $user_id = $_SESSION['user_data']['0'];
   }
   // pagination
   if (!isset($_GET['page'])) 
   {
      $page = 1;
   }
   else
   {
      $page = $_GET['page'];
   }
   $limit = 5;
   $offset = ($page - 1) * $limit;
   // -----------
?>
<!-- Begin Page Content -->
<div class="container-fluid" id="adminpage">
   <!-- Page Heading -->
   <h5 class="mb-2 text-gray-800">Blog Posts</h5>
   <!-- DataTales Example -->
   <div class="card shadow">
      <div class="card-header py-3 d-flex justify-content-between">
         <div>
            <a href="add_blog.php">
               <h6 class="font-weight-bold text-primary mt-2">Add New</h6>
            </a>
         </div>
         <div>
            <form class="navbar-search">
               <div class="input-group">
                  <input type="text" class="form-control bg-white border-0 small" placeholder="Search for...">
                  <div class="input-group-append">
                     <button class="btn btn-primary" type="button"> <i class="fa fa-search"></i> </button>
                  </div>
               </div>
            </form>
         </div>
      </div>
      <div class="card-body">
         <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
               <thead>
                  <tr>
                     <th>Sr.No</th>
                     <th>Title</th>
                     <th>Category</th>
                     <th>Author</th>
                     <th>Date</th>
                     <th colspan="2">Action</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                     $sql = "SELECT * FROM blog LEFT JOIN Categories ON blog.category=Categories.Category_id LEFT JOIN user ON blog.author_id=user.user_id WHERE user_id = '$user_id' ORDER BY blog.publish_date DESC LIMIT $offset,$limit ";
                     $query = mysqli_query($config, $sql);
                     $rows = mysqli_num_rows($query);
                     if ($rows) 
                     {
                        while ($result = mysqli_fetch_assoc($query)) { ?>
                           <tr>
                              <td><?= ++$offset ?></td>
                              <td><?= $result['blog_title'] ?></td>
                              <td><?= $result['category_name'] ?></td>
                              <td><?= $result['username'] ?></td>
                              <td>
                                 <?= date('d/M/Y', strtotime($result['publish_date'])) ?>
                              </td>
                              <td>
                                 <a href="edit_blog.php?id=<?= $result['blog_id'] ?>" class="btn btn-sm btn-outline-success">Edit</a>
                              </td>
                              <td>
                                 <form method="POST" onsubmit="return confirm('Are you sure, You want to delete?') ">
                                    <input type="hidden" name="id" value="<?= $result['blog_id'] ?>">
                                    <input type="hidden" name="img" value="<?= $result['blog_img'] ?>">
                                    <input type="submit" name="delete_post" value="Delete"
                                    class="btn btn-sm btn-outline-danger">
                                 </form>
                              </td>

                           </tr>


                        <?php }
                     }
                     else
                     {
                        ?>
                        <tr><th colspan="7">No Record Found</th></tr>
                        <?php
                     }

                  ?>
               </tbody>
            </table>
            <!-- Pagination start -->
            <?php
            $pagination = "SELECT * FROM blog WHERE author_id='$user_id'";
            $run_q = mysqli_query($config, $pagination);
            $total_post = mysqli_num_rows($run_q);
            $pages = ceil($total_post / $limit);
            if ($total_post > $limit) {
             ?>
               <ul class="pagination pt-2 pb-5">
                  <?php for ($i=1; $i <= $pages ; $i++) { ?>
                  <li class="page-item <?=($i == $page)? $active = "active":"";?>">
                     <a href="index.php?page=<?= $i ?>" class="page-link">
                     <?= $i ?>
                     </a>
                  </li>
                  <?php } ?>
               </ul>
               <?php } ?>
            <!-- ================= -->
         </div>
      </div>
   </div>
</div>
<!-- /.container-fluid -->
</div>
<?php include "footer.php"; 

   if (isset($_POST['delete_post'])) 
   {
      $id = $_POST['id'];
      $img = "upload/".$_POST['img'];
      $delete = "DELETE FROM blog WHERE blog_id = '$id'";
      $run = mysqli_query($config, $delete);
      if ($run) 
      {
         unlink($img);
         $msg = ['Post has been Deleted Successfully', 'alert-success'];
         $_SESSION['msg']=$msg;
         header("location:index.php");
      }
      else
      {
         $msg = ['Failed, Please try again', 'alert-success'];
         $_SESSION['msg']=$msg;
         header("location:index.php");
      }
   }

?>
