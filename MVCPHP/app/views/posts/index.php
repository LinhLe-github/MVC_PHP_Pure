<?php require_once APPROOT.'/views/inc/header.php'; ?>
<?php flash('Post_added'); ?>
<div class="row">
    <div class="col-md-6">
        <h1>Posts</h1>


    </div>
    <div class="col-md-6">

        <a href="<?php echo URLROOT?>/posts/add" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Add Post</a>
    </div>
    <?php foreach ($data['posts'] as $post) : ?>
        <div class="card card-body mb-3 col-md-6 ">
            <h4 class="card-title"><?php print_r($post->title) ?></h4>
            <div class="bg-light p-2 mb">
                written by <?php echo $post->name ?> On <?php echo $post->postCreated?>
            </div>
            <p class="card-text">
                <?php echo $post->body ?>
            </p>
            <a href="<?php echo URLROOT ?>/posts/show/<?php echo $post->id ?>" class="btn btn-dark">More</a>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once APPROOT.'/views/inc/footer.php'?>
