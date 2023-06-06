
import './styles/app.scss';
import 'popper.js';
import 'bootstrap';
import 'select2';
import routes from './../public/js/fos_js_routes.json';
const Routing = require('./../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js');
Routing.setRoutingData(routes);
import $ from 'jquery';
import 'bootstrap-typeahead';
import 'jquery-ui/ui/widgets/autocomplete';
$( document ).ready(function() {

    /***** load movies for autocomplete  ******/
    function autocompleteSearch(data){
        var titles = data.map(function(movie) {
            return movie.original_title;
        });
        $('.search-movies').autocomplete({
            source: titles,
            minLength: 3,
            select: function( event, ui ) {
                getMovies(ui.item.label);
            }
        });
    }
    /***** load movies by  keyword ******/
    $('.search-movies').keyup(function () {
        var keyword = $(this).val();
        if(keyword !=""){
            getMovies(keyword);
        }else{
            $('#container').html("");
        }
    })
    /***** load movies by  genre ******/
    $('.actionCheckbox').change(function() {
        var checkboxValue = $(this).val();
        $.ajax({
            type: "GET",
            url: Routing.generate('api_movies',{"genre":checkboxValue}),
            dataType: "json",
            success: function(response) {
                addContent(response)
            }
        });
    })
    /***** Modal Logic ******/
    $(document).on("click", ".movieModal", function(e) {
        var  idMovie =$(this).attr("data-id");
        console.log(idMovie)
        $.ajax({
            type: "GET",
            url: Routing.generate('api_get_movie',{id:idMovie}),
            dataType: "json",
            success: function(movie) {
                const videos = movie.videos.results;
                const videoKey = videos.length > 0 ? videos[0].key : null;
                const videoContainer = document.getElementById('videoContainer');
                videoContainer.innerHTML = '';
                if (videoKey) {
                    const videoURL = `https://www.youtube.com/embed/${videoKey}`;
                    const videoIframe = document.createElement('iframe');
                    videoIframe.style.width = '100%'
                    videoIframe.src = videoURL;
                    videoContainer.appendChild(videoIframe);
                } else {
                    videoContainer.append("no video");
                }
                $("#titleMovie").text(movie.original_title);
                 let textDetails=`
                    Filim : ${movie.overview}  ${convertVoteAverageToStars(movie.vote_average)} ${movie.vote_average} pour ${movie.vote_count}  utlisateur 
                 `
                $("#overviewMovie").append(textDetails);

                $('#exampleModal').modal('show');
            }
        });

    });
    $(document).on("click", "#closeModal", function(e) {
        const videoContainer = document.getElementById('videoContainer');
        videoContainer.innerHTML = '';
        $("#titleMovie").text("");
        $("#overviewMovie").append("");

    });
    /***** shared functions ******/
    function addContent(response){
        $('#container').html("");
        var movies= response.results;
        $.each(movies, function(index, movie) {
            var element = `
                       <div class="row mt-3" >
                    <div class="col-md-3">
           
                        <img src="https://image.tmdb.org/t/p/w200${movie.poster_path}"  class="img-fluid" alt="Item 1 Image">
                    </div>
                    <div class="col-md-9">
                        <h5>${movie.original_title}</h5>
                        <p>${getYear(movie.release_date)}</p>
                        <p>${movie.overview}</p>
                        <div class="star-ratings">
                            <span class="text-muted">Ratings:  ${movie.vote_count}</span>
                             ${convertVoteAverageToStars(movie.vote_average)}
                        </div>
                           <button data-id="${movie.id}" type="button" class="btn btn-primary movieModal" style="float: right"   >
                             lire en détail
                          </button>
                          
                    </div>
                </div>
                     `
            $('#container').append(element);
        });
    }
    function getYear(dateString){
        if(dateString ==""){
            return  "";
        }
        return new Date(dateString).getFullYear();
    }
    function convertVoteAverageToStars(voteAverage) {
        var maxRating = 10; // Maximum rating value (in this case, 10)
        var starRating = 5; // Number of stars in the rating system (in this case, 5)

        var ratingPercentage = (voteAverage / maxRating) * 100; // Calculate the percentage

        var stars = Math.round((ratingPercentage / 100) * starRating); // Calculate the number of stars
        var starsHtml="";
        for (var i = 0; i < 5; i++) {
            if(stars<5){
                starsHtml+=' <i class="fa fa-star" checked></i>'
            }else {
                starsHtml+=' <i class="fa fa-star"></i>'
            }

        }
        return starsHtml;
    }
    function getMovies(keyword){
        $.ajax({
            type: "GET",
            url: Routing.generate('api_search_movies',{keyword:keyword}),
            dataType: "json",
            success: function(response) {
                autocompleteSearch(response.results)
                addContent(response)
            }
        });
    }
})

