<?php  include('config.php'); ?>
<?php include('include/public_functions.php'); ?>

<?php if(isset($_GET['slug'])){
  $slug = $_GET['slug'];
  $post = getPostBySlug($slug);
} ?>

<!-- Depending wether slug is set or not including either postupload or update -->
<?php 
if(isset($_GET['slug'])){
  include('include/updatepost.php');
} 
else if(!isset($_GET['slug'])){
  include("include/postupload.php");
}?>

<!-- Header section -->
<?php include('include/header_section.php')?>
<!-- Redirecting to the index page if someone not logged in is trying to access create post -->
<?php if(!isset($_SESSION['user'])){
  header("location: index.php");
} ?>

<title><?php if(isset($_GET['slug'])){
              echo "Edit Post";
            }else{
              echo "Create Post";
            } ?></title>
  </head>
  <body>
<?php $topics=getAllTopics(); ?>
<!-- Navbar -->
<?php include('include/navbar.php')?>

    <main>
      <div class="container">
        <div class="sign-up">
          <h1 id="card-title"  class="hmm <?php if(isset($_GET['postupdate'])){
            echo "updated";
          } ?>"> 
          <?php if(isset($_GET['slug'])){
              echo "Edit Post";
            }else{
              echo "Create New Post";
            } ?></h1>

          <!-- Including error display in case fields are left empty -->
          <div class="posterror"><?php include(ROOT_PATH . '/include/errors.php') ?></div>
          <div class="banner-wrapper">
            <img src="<?php if(isset($_GET['slug'])){
              echo BASE_URL . '/static/img/' . $post['image'];
            }else{
              echo BASE_URL . '/static/img/defaultpostimg.png';
            } ?>" alt="article-banner" class="banner-img">
          </div>
          <form action="<?php if(isset($_GET['slug'])){
            echo "createPost.php?slug=" . $_GET['slug'] ;
          }else{
            echo "createPost.php";
          } ?>" method="POST" enctype="multipart/form-data" class="article-form">
            
            <label class="costumUpload" for="uploadBanner"><i class="fas fa-upload"></i>Upload Banner Image</label>
            <input type="file" name="uploadBanner" id="uploadBanner">
            <label class="article-input-text" for="article-title">Article Title</label>
            <input type="text" name="article-title" id="article-title" value="<?php if(isset($_GET['slug'])){
              echo htmlentities($post['title']);} ?>" />
            
            <label class="article-input-text" for="article-content">Article Content</label>
            <textarea name="article-content" id="article-content" ><?php if(isset($_GET['slug'])){
              echo $post['body'];} ?></textarea>
            <div class="add-category-wrapper">
                <select name="category" id="choose-catedory">
                <option value="">Choose Category</option>
                <?php foreach ($topics as $topic): ?>
                  <option value="<?php echo $topic['id']?>" <?php if($topic['name'] === $post['topic']['name'] ){
                    echo 'selected';
                  } ?>><?php echo $topic['name']; ?></option>
            <?php endforeach ?>
                </select>
            </div>
            <button type="submit" name = "submitpost" class="btn post-btn"><?php if(isset($_GET['slug'])){
              echo "Update";
            }else{
              echo "Post";
            } ?></button>
          </form>
        </div>
      </div>
    </main>
    
    <script> 
      window.addEventListener('load', reloaded);
      
      function reloaded() {
          let shit = document.querySelector('#card-title');

          if(shit.classList.includes('hmm')){
            console.log('tesssssssssssssasdfsdgfsdfsdf')
          }
      }
      
    </script>
    <script src="createPost.js"></script>


    <?php include('include/footer.php') ?>
    

    <!-- <option value="sport">Sport</option>
                <option value="travel">Travel</option>
                <option value="lifestyle">Life Style</option> -->

                <!-- https://user-images.githubusercontent.com/194400/49531010-48dad180-f8b1-11e8-8d89-1e61320e1d82.png -->

                