<?php
	// include header
	include('header.php');

	// json variable
	$json = array();

	// when searching and filtering is triggered
	if((isset($_GET['from']) && isset($_GET['to'])) || isset($_GET['keyword'])):

		// include search script
		include('search.php');

	endif;
?>

	<div class="container">
		
		<h1>Search Blog</h1>

		<div class="row">

			<div class="col-sm-6 col-sm-offset-3">

				<form class="form-horizontal">
					<div class="form-group">
						<label class="control-label col-sm-3">Published Date</label>
						<div class="col-sm-9">
							<div class="input-group">
								<input type="text" class="form-control datepicker" name="from" placeholder="mm/dd/YYYY" value="<?php echo isset($_GET['from']) ? $_GET['from'] : '' ?>" />
								<span class="input-group-addon">to</span>
								<input type="text" class="form-control datepicker" name="to" placeholder="mm/dd/YYYY" value="<?php echo isset($_GET['to']) ? $_GET['to'] : '' ?>" />
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3">Keyword</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="keyword" placeholder="enter keyword..." value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>" />
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-9 col-sm-offset-3">
							<button class="btn btn-default" type="submit" id="search"><span class="glyphicon glyphicon-search"></span> Search</button>
							<button class="btn btn-default" type="button" onclick="location.href='index.php'"><span class="glyphicon glyphicon-refresh"></span> Clear</button>
						</div>
					</div>
				</form>

			</div>

	    </div>
	    <p>&nbsp;</p>

	    <div class="row">

	    	<div class="col-sm-12">

	    		<div id="results">
	    			
	    			<?php
	    				// if there are results found
	    				if(count($json) > 0):
	    					// sorting feature
	    					echo '
	    						<div class="dropdown">
								  	<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
									    Sort by ' . (isset($_GET['order']) ? ucfirst($_GET['order']) : 'Title') . ' ' . (isset($_GET['by']) ? $_GET['by'] : 'ASC') . ' <span class="caret"></span>
								  	</button>
								  	<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
								    	<li><a href="?order=title&by=ASC' . (isset($_GET['from']) ? '&from=' . $_GET['from'] : '') . (isset($_GET['to']) ? '&to=' . $_GET['to'] : '') . (isset($_GET['keyword']) ? '&keyword=' . $_GET['keyword'] : '') . '">Title ASC</a></li>
								    	<li><a href="?order=title&by=DESC' . (isset($_GET['from']) ? '&from=' . $_GET['from'] : '') . (isset($_GET['to']) ? '&to=' . $_GET['to'] : '') . (isset($_GET['keyword']) ? '&keyword=' . $_GET['keyword'] : '') . '">Title DESC</a></li>
								    	<li><a href="?order=date&by=ASC' . (isset($_GET['from']) ? '&from=' . $_GET['from'] : '') . (isset($_GET['to']) ? '&to=' . $_GET['to'] : '') . (isset($_GET['keyword']) ? '&keyword=' . $_GET['keyword'] : '') . '">Date ASC</a></li>
								    	<li><a href="?order=date&by=DESC' . (isset($_GET['from']) ? '&from=' . $_GET['from'] : '') . (isset($_GET['to']) ? '&to=' . $_GET['to'] : '') . (isset($_GET['keyword']) ? '&keyword=' . $_GET['keyword'] : '') . '">Date DESC</a></li>
								  	</ul>
								</div>
	    					';

	    					// display results
	    					foreach($json as $res):
	    						echo '
	    							<div class="media">
									  	<div class="media-body">
										    <h4 class="media-heading">' . $res->title->rendered . '</h4>
									    	' . $res->excerpt->rendered . '
									    	<div>
									    		<a href="view.php?post=' . $res->id . (isset($_GET['from']) ? '&from=' . $_GET['from'] : '') . (isset($_GET['to']) ? '&to=' . $_GET['to'] : '') . (isset($_GET['keyword']) ? '&keyword=' . $_GET['keyword'] : '') . (isset($_GET['order']) ? '&order=' . $_GET['order'] : '') . (isset($_GET['by']) ? '&by=' . $_GET['by'] : '') . '" class="btn btn-default">
									    			<span class="glyphicon glyphicon-eye-open"></span> View
									    		</a>
									    		<a href="edit.php?post=' . $res->id . (isset($_GET['from']) ? '&from=' . $_GET['from'] : '') . (isset($_GET['to']) ? '&to=' . $_GET['to'] : '') . (isset($_GET['keyword']) ? '&keyword=' . $_GET['keyword'] : '') . (isset($_GET['order']) ? '&order=' . $_GET['order'] : '') . (isset($_GET['by']) ? '&by=' . $_GET['by'] : '') . '" class="btn btn-default">
									    			<span class="glyphicon glyphicon-pencil"></span> Edit
									    		</a>
									    	</div>
									  	</div>
									</div>
									<p>&nbsp;</p>
	    						';
    						endforeach;
    					endif;
	    			?>

	    		</div>

	    	</div>

	    </div>

	</div>

<?php include('footer.php') ?>