<?php include "header.php"; 
   if ($admin != 1) 
   {
      header("location:index.php");
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
<div class="container-fluid">
   <!-- Page Heading -->
   <h5 class="mb-2 text-gray-800">Categories</h5>
   <!-- DataTales Example -->
   <div class="card shadow">
      <div class="card-header py-3 d-flex justify-content-between">
         <div>
            <a href="add_cat.php">
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
                     <th>Category Name</th>
                     <th colspan="2">Action</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                     $sql = "SELECT * FROM categories LIMIT $offset, $limit";
                     $query = mysqli_query($config, $sql);
                     $rows = mysqli_num_rows($query);
                     if ($rows) 
                     {
                        while ($row = mysqli_fetch_assoc($query)) 
                        {
                        ?>
                           <tr>
                              <td><?= ++$offset ?></td>
                              <td><?= $row['category_name'] ?></td>
                              <td>
                                 <a href="edit_cat.php?id=<?= $row['category_id'] ?> " class="btn btn-sm btn-outline-success">Edit</a>
                              </td>
                              <td>
                                 <form action="" method="POST" onsubmit="return confirm('Are you sure, You want to delete?') ">
                                    <input type="hidden" name="cat_id" value="<?= $row['category_id'] ?>">
                                    <input type="submit" name="delete_cat" value="Delete"
                                    class="btn btn-sm btn-outline-danger">
                                 </form>
                              </td>
                           </tr>
                        <?php   
                        }
                     }
                     else
                     {
                     ?>
                        <tr><th colspan="4">No Record Found</th></tr>
                     <?php   
                     }

                  ?>
               </tbody>
            </table>
                     <!-- pagination start -->
            <?php
               $pagination = "SELECT * FROM categories";
               $run_q = mysqli_query($config, $pagination);
               $total_post = mysqli_num_rows($run_q);
               $pages = ceil($total_post / $limit);
               if ($total_post > $limit) {
            ?>
               <ul class="pagination pt-2 pb-5">
               <?php for ($i=1; $i <= $pages ; $i++) { ?>
                  <li class="page-item <?=($i == $page)? $active = "active":"";?>">
                     <a href="categories.php?page=<?= $i ?>" class="page-link">
                     <?= $i ?>
                     </a>
                  </li>
                  <?php } ?>
               </ul>
               <?php } ?>
                  <!-- ---------------- -->
         </div>
      </div>
   </div>
</div>
<!-- /.container-fluid -->
</div>
<?php 
   include "footer.php"; 

   if (isset($_POST['delete_cat'])) 
   {
      $id = $_POST['cat_id'];
      $delete = "DELETE FROM categories WHERE category_id = '$id'";
      $run = mysqli_query($config, $delete);
      if ($run) 
      {
         $msg = ['Category has been Deleted Successfully', 'alert-success'];
         $_SESSION['msg']=$msg;
         header("location:Categories.php");
      }
      else
      {
         $msg = ['Failed, Please try again', 'alert-success'];
         $_SESSION['msg']=$msg;
         header("location:Categories.php");
      }
   }

?>
