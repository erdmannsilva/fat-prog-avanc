<?php

  require_once("templates/header.php");

  require_once("dao/MovieDAO.php");

  // Dao dos Filmes
  $movieDao = new MovieDAO($conn, $BASE_URL);

  $lastestMovies = $movieDao->getLatestMovies();

  $actionMovies = $movieDao->getMoviesByCategory("Ação");

  $comedyMovies = $movieDao->getMoviesByCategory("Comédia");

  $dramaMovies = $movieDao->getMoviesByCategory("Drama");


  include_once("templates/footer.php");

?>
