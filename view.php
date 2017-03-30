<?php
	include('header.php');

	// json for specific post
	$post = json_decode(file_get_contents('http://devel2.ordermate.online/wp-json/wp/v2/posts/' . $_GET['post']));

	// convert _links object to array so we can use keys with wp:
	$links = (array)$post->_links;

	// json for image
	$image = json_decode(file_get_contents($links['wp:featuredmedia'][0]->href));

	// json for author
	$author = json_decode(file_get_contents($links['author'][0]->href));

	// json for comments
	$replies = json_decode(file_get_contents($links['replies'][0]->href));

	// sorting the comments (oldest first)
	usort($replies, function($a, $b){
		return $a->date > $b->date ? 1 : -1;
	});
?>

	<div class="container">
		
		<h1>View Blog</h1>
		<p>&nbsp;</p>

		<div class="row">

			<div class="col-sm-12">

				<?php
					// if image is existing, then display it
					if($image):
						echo '
							<div class="text-center">
								<img src="' . $image->media_details->sizes->large->source_url . '" class="img-thumbnail" />
							</div>
						';
					endif;

					// title
					echo '<h1>' . $post->title->rendered . '</h1>';

					// date published and author name
					echo '
						<p>
							<small>
								Posted on ' . date('F j, Y', strtotime($post->date)) . '<br />
								by ' . $author->name . '
							</small>
						</p>
					';

					// content
					echo $post->content->rendered;

					// back button
					echo '
						<a href="index.php?' . (isset($_GET['from']) ? '&from=' . $_GET['from'] : '') . (isset($_GET['to']) ? '&to=' . $_GET['to'] : '') . (isset($_GET['keyword']) ? '&keyword=' . $_GET['keyword'] : '') . (isset($_GET['order']) ? '&order=' . $_GET['order'] : '') . (isset($_GET['by']) ? '&by=' . $_GET['by'] : '') . '" class="btn btn-default">
							<span class="glyphicon glyphicon-circle-arrow-left"></span> Back
						</a>
						<p>&nbsp;</p>
					';

					// comments
					echo '<h2>' . count($replies) . ' thought' . (count($replies) > 1 ? 's' : '') . ' on "' . $post->title->rendered . '"' . '</h2>';
					
					if(count($replies) > 0):
						foreach($replies as $reply):
							// avatar
							$avatar = (array)$reply->author_avatar_urls;
							// get the medium size
							next($avatar);

							echo '
								<div class="media">
							  		<div class="media-left">
								      	<img class="media-object" src="' . current($avatar) . '" />
							  		</div>
							  		<div class="media-body">
									    <h4 class="media-heading">' . $reply->author_name . ' says:</h4>
								    	<p><small>' . date('F j, Y', strtotime($reply->date)) . ' at ' . date('h:i A', strtotime($reply->date)) . '</small></p>
							    		' . $reply->content->rendered . '
							  		</div>
								</div>
							';
						endforeach;
					endif;
				?>

			</div>

		</div>

	</div>

<?php include('footer.php') ?>