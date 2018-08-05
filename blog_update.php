<?php include 'header.php';
      if (!isset($_SESSION['u_id'])) {
        header("Location: index.php?loggedin=false");
        exit();
      }elseif (isset($_SESSION['u_id'])) {
        $post_id = $_GET['blog'];
        $sql = "SELECT * FROM `blogs` WHERE `post_id` = '$post_id'";
        // result = what is found in the database
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
          // If there are no results in the database...
        if ($resultCheck < 1) {
            header("Location: index.php?blog=noblog");
            exit();
        }else{
          $row = mysqli_fetch_assoc($result);
          // If the current user is not the author
           // of the blog, redirect to home page.
          if($_SESSION['u_uid'] == $row['post_author']){
      ?>
  <section>
    <p> <?php echo $row['post_author'] ?> </p>
    <p> <?php echo $_SESSION['u_uid'] ?> </p>
    <div class="container">
      <div id='signup' class="main-wrapper">
        <h2>Update blog</h2>
        <form  action="includes/blogs/update_blog.inc.php<?php echo '?blog='. $row['post_id']?>" method="post">
            <label>Blog Title</label>
          <input class="form-control"type="text" name="title" placeholder="Blog Title" value="<?php echo $row['post_title'] ?> "required>
            <!-- <label>Blog Url(optional)</label>
          <input class="form-control"type="text" name="url" placeholder="Blog Url" required> -->
            <label>Blog Body</label>
          <textarea rows='10'class="form-control"type="text" name="body" placeholder="What's on your mind?" required><?php echo $row['post_body'] ?> </textarea>
          <button class="form-control btn btn-primary"type="submit" name="submit">Update</button>
        </form>
      </div>
    </div>
  </section>
<?php
} else{
    header("Location: ../../index.php?blog=error");
    exit();
      };
    };
  };
include 'footer.php';
 ?>