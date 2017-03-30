<?php
	// get the json data
	$json = json_decode(file_get_contents('http://devel2.ordermate.online/wp-json/wp/v2/posts'));

	// filter title, content, published date, person who has commented
	$json = array_filter($json, function($q) use ($_GET){
		$date = date_format(date_create(addslashes($q->date)), 'Y-m-d');
		$dateFrom = date_format(date_create(addslashes($_GET['from'])), 'Y-m-d');
		$dateTo = date_format(date_create(addslashes($_GET['to'])), 'Y-m-d');

		// if keyword is not empty
		if(!empty($_GET['keyword'])){

			// check if keyword is match with post title or post content
			if(
				preg_match('/' . strtolower($_GET['keyword']) . '/', strtolower($q->title->rendered)) ||
				preg_match('/' . strtolower($_GET['keyword']) . '/', strtolower($q->content->rendered))
			){
				// check if published date is within the range of date from and date to
				if(!empty($_GET['from']) && !empty($_GET['to'])){
					return strtotime($date) >= strtotime($dateFrom) && strtotime($date) <= strtotime($dateTo);
				}else{
					return true;
				}
			}

		// check if published date is within the range of date from and date to
		}else if(strtotime($date) >= strtotime($dateFrom) && strtotime($date) <= strtotime($dateTo)){

			return true;

		// else
		}else{

			return false;

		}
	});

	// sorting the objects
	usort($json, function($a, $b){

		// order by title
		if(@$_GET['order'] == 'title' || !isset($_GET['order'])){

			// ascending
			if(@$_GET['by'] == 'ASC' || !isset($_GET['by'])){
	    		return $a->title->rendered > $b->title->rendered ? 1 : -1;
	    	// descending
			}else{
	    		return $a->title->rendered > $b->title->rendered ? -1 : 1;
			}

		// order by published date
		}else{

			// ascending
			if(@$_GET['by'] == 'ASC'){
				return $a->date > $b->date ? 1 : -1;
			// descending
			}else{
				return $a->date > $b->date ? -1 : 1;
			}

		}
	});