<?php

/* * ************************
Paging Functions
* ************************* */

/*
get page number from query string
*/
function getPagingQuery($sql, $itemPerPage = 10) {
	if (isset($_GET['page']) && (int) $_GET['page'] > 0) {
		$page = (int) $_GET['page'];
	} else {
		$page = 1;
	}
	
	// start fetching from this row number
	$offset = ($page - 1) * $itemPerPage;
	
	return $sql . " LIMIT $offset, $itemPerPage";
}

/*
Get the links to navigate between one result page to another.
Supply a value for $strGet if the page url already contain some
GET values for example if the original page url is like this :
http://localhost/index.php?page=2
use "c=12" as the value for $strGet. But if the url is like this :
http://localhost/index.php
then there's no need to set a value for $strGet
*/	
function getPagingLink($sql, $itemPerPage = 10, $strGet = '') {
	$result = dbQuery($sql);
	$pagingLink = '';
	$totalResults = dbNumRows($result);
	$totalPages = ceil($totalResults / $itemPerPage);
	
	// how many link pages to show
	$numLinks = 10;
	
	// create the paging links only if we have more than one page of results
	if ($totalPages > 1) {
		$self = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
		
		if (isset($_GET['page']) && (int) $_GET['page'] > 0) {
			$pageNumber = (int) $_GET['page'];
		} else {
			$pageNumber = 1;
		}
		
		// print 'previous' link only if we're not
		// on page one
		if ($pageNumber > 1) {
			$page = $pageNumber - 1;
			if ($page > 1) {
				if ($strGet == '') {
					$prev = " <a href=\"$self?page=$page\">‹ Prev </a> ";
				} else {
					$prev = " <a href=\"$self?page=$page&$strGet\">‹ Prev </a> ";
				}
			} else {
				if ($strGet != '') {
					$prev = " <a href=\"$self?$strGet\">‹ Prev </a> ";
				} else {
					$prev = " <a href=\"$self\">‹ Prev </a> ";
				}
			}
			
			if ($strGet == '') {
				$first = " <a href=\"$self\">« First </a> ";
			} else {
				$first = " <a href=\"$self?$strGet\">« First </a> ";
			}
		} else {
			$prev = ''; // we're on page one, don't show 'previous' link
			$first = ''; // nor 'first page' link
		}
		
		// print 'next' link only if we're not
		// on the last page
		if ($pageNumber < $totalPages) {
			$page = $pageNumber + 1;
			if ($strGet == '') {
				$next = " <a href=\"$self?page=$page\"> Next ›</a> ";
				$last = " <a href=\"$self?page=$totalPages\"> Last »</a> ";
			} else {
				$next = " <a href=\"$self?page=$page&$strGet\"> Next ›</a> ";
				$last = " <a href=\"$self?page=$totalPages&$strGet\"> Last »</a> ";
			}
		} else {
			$next = ''; // we're on the last page, don't show 'next' link
			$last = ''; // nor 'last page' link
		}

		$start = $pageNumber - ($pageNumber % $numLinks) + 1;
		$end = $start + $numLinks - 1;
		$end = min($totalPages, $end);
		$pagingLink = array();
		
		for ($page = $start; $page <= $end; $page++) {
			if ($page == $pageNumber) {
				$pagingLink[] = "<span class='selected'> $page </span>"; // no need to create a link to current page
			} else {
				if ($page == 1) {
					if ($strGet != "") {
						$pagingLink[] = " <a href=\"$self?$strGet\">$page</a> ";
					} else {
						$pagingLink[] = " <a href=\"$self\">$page</a> ";
					}
				} else {
					if ($strGet != "") {
						$pagingLink[] = " <a href=\"$self?page=$page&$strGet\">$page</a> ";
					} else {
						$pagingLink[] = " <a href=\"$self?page=$page\">$page</a> ";
					}
				}
			}
		}
		
		$pagingLink = implode('<span class="seperator"> | </span>', $pagingLink);
		
		// return the page navigation link
		$pagingLink = $first . $prev . $pagingLink . $next . $last;
	}
	
	return $pagingLink;
}

/*
Join up the key value pairs in $_GET
into a single query string
*/
function queryString() {
	$qString = array();
	foreach ($_GET as $key => $value) {
		if (trim($value) != '') {
			$qString[] = $key . '=' . trim($value);
		} else {
			$qString[] = $key;
		}
	}
	
	$qString = implode('&', $qString);
	return $qString;
}

/*
* End of file pagination.php
*/