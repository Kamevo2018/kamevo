 <?php
if(isset($_COOKIE['first_visit'])){

}else{
    setcookie("first_visit", "done",time()+(365*24*60*60));
    $cookieAdvisor = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur maxime deserunt dolorem ullam repudiandae architecto voluptates dicta, porro reiciendis doloribus quisquam, ratione facere cum, dolorum, illum minus necessitatibus. Molestiae, earum.';
}
?> 