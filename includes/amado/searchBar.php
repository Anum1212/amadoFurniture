<?php
if (isset($_GET['searchItem'])) {
    // receive all input values from the form
    $searchString = mysqli_real_escape_string($dbConnect, $_GET['search']);
    $searchString = trim($searchString, " ");
    // if(preg_match('/\s/',$searchString) > 0)
    $searchWord = explode(" ", $searchString);

    for($i=0; $i<count($searchWord); $i++)
    $searchWord_soundexArray[] = soundex ( $searchWord[$i] );

    $_SESSION['searchWord'] = $searchWord;
    $_SESSION['searchWord_soundexArray'] = $searchWord;

    header('location: /furniture/productSearchResult.php');
  } ?>

    <!-- Search Wrapper Area Start -->
    <div class="search-wrapper section-padding-100">
        <div class="search-close">
            <i class="fa fa-close" aria-hidden="true"></i>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="search-content">
                        <form action="" method="GET">
                            <input type="search" name="search" id="search" placeholder="Type your keyword..." required>
                            <button type="submit" name="searchItem"><img src="/furniture/myAssets/amado/img/core-img/search.png" alt=""></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Search Wrapper Area End -->
