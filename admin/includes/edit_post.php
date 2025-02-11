<?php 

if(isset($_GET['p_id'])) {
    $post_id = mysqli_real_escape_string($connection, $_GET['p_id']);
}

$query = "SELECT * FROM posts WHERE post_id = $post_id ";
$select_posts = mysqli_query($connection, $query);

while($row = mysqli_fetch_assoc($select_posts)) {
    $post_id = $row['post_id'];
    $post_category_id = $row['post_category_id'];
    $post_title = $row['post_title'];
    $post_author = $row['post_author'];
    $post_image = $row['post_image'];
    $post_tags = $row['post_tags'];
    $post_status = $row['post_status'];
    $post_content = $row['post_content'];
}

if(isset($_POST['update_post'])) {

    $post_title = mysqli_real_escape_string($connection, $_POST['title']);
    $post_author = mysqli_real_escape_string($connection, $_POST['author']);
    $post_category_id = mysqli_real_escape_string($connection, $_POST['post_category']);
    $post_status = mysqli_real_escape_string($connection, $_POST['status']);
    
    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];
    
    $post_tags = mysqli_real_escape_string($connection, $_POST['tags']);
    $post_content = mysqli_real_escape_string($connection, $_POST['content']);
    
    if(!empty($post_image)) {
        move_uploaded_file($post_image_temp, "../images/$post_image");
    } else {
        $query = "SELECT post_image FROM posts WHERE post_id = $post_id";
        $select_image = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($select_image)) {
            $post_image = $row['post_image'];
        }
    }

    $query = "UPDATE posts SET ";
    $query .= "post_title = '{$post_title}', ";
    $query .= "post_category_id = '{$post_category_id}', ";
    $query .= "post_date = now(), ";
    $query .= "post_author = '{$post_author}', ";
    $query .= "post_status = '{$post_status}', ";
    $query .= "post_tags = '{$post_tags}', ";
    $query .= "post_content = '{$post_content}', ";
    $query .= "post_image = '{$post_image}' ";
    $query .= "WHERE post_id = {$post_id}";

    $update_post = mysqli_query($connection, $query);

    confirmQuery($update_post);
   
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input value="<?php echo $post_title ?>" type="text" class="form-control" name="title" required>
    </div>

    <div class="form-group">
        <select name="post_category" id="">
        <?php 
            $query = "SELECT * FROM categories";
            $select_categories = mysqli_query($connection, $query);

            confirmQuery($select_categories);

            while($row = mysqli_fetch_assoc($select_categories)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];

                if ($cat_id == $post_category_id) {
                    echo "<option value='{$cat_id}' selected>{$cat_title}</option>";
                } else {
                    echo "<option value='{$cat_id}'>{$cat_title}</option>";
                }
            }
        ?>
        </select>
    </div>

    <div class="form-group">
        <label for="author">Author</label>
        <input value="<?php echo $post_author ?>" type="text" class="form-control" name="author" required>
    </div>

    <div class="form-group">
        <label for="status">Post Status</label>
        <input value="<?php echo $post_status ?>" type="text" class="form-control" name="status">
    </div>

    <div class="form-group">
        <label for="image">Post Image</label>
        <input type="file" class="form-control" name="image">
        <img src="../images/<?php echo $post_image; ?>" alt="" width="100">
    </div>

    <div class="form-group">
        <label for="tags">Post Tags</label>
        <input value="<?php echo $post_tags ?>" type="text" class="form-control" name="tags">
    </div>

    <div class="form-group">
        <label for="content">Post Content</label>
        <textarea class="form-control" name="content" cols="30" rows="10" required><?php echo $post_content ?></textarea>
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_post" value="Update Post">
    </div>
</form>