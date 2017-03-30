<?php
	include('header.php');

	// success variable
	$success = false;

	// saving
	if(isset($_POST['save'])):

		// saving script
		include('save.php');

	endif;

	// json for specific post
	$post = json_decode(file_get_contents('http://devel2.ordermate.online/wp-json/wp/v2/posts/' . $_GET['post']));
?>

	<div class="container">
		
		<h1>Edit Blog :: <?php echo $post->title->rendered ?></h1>
		<p>&nbsp;</p>

		<div class="row">

			<div class="col-sm-12">

				<form method="post" class="form-horizontal">

					<?php if($success): ?>
						<div class="alert alert-success" role="alert">Changes has been successfully saved.</div>
					<?php endif; ?>

					<div class="form-group">
						<label class="control-label col-sm-3">Title</label>
						<div class="col-sm-6">
							<input type="text" name="title" class="form-control" value="<?php echo $post->title->rendered ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3">Content</label>
						<div class="col-sm-6">
							<textarea name="content" class="form-control" name="content"><?php echo $post->content->rendered ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-6 col-sm-offset-3">
							<button class="btn btn-primary" type="submit" name="save"><span class="glyphicon glyphicon-floppy-disk"></span> Save Changes</button>
							<a href="index.php?<?php echo (isset($_GET['from']) ? '&from=' . $_GET['from'] : '') . (isset($_GET['to']) ? '&to=' . $_GET['to'] : '') . (isset($_GET['keyword']) ? '&keyword=' . $_GET['keyword'] : '') . (isset($_GET['order']) ? '&order=' . $_GET['order'] : '') . (isset($_GET['by']) ? '&by=' . $_GET['by'] : '') ?>" class="btn btn-default">
								<span class="glyphicon glyphicon-circle-arrow-left"></span> Back
							</a>
						</div>
					</div>

				</form>

			</div>

		</div>

	</div>

<?php include('footer.php') ?>