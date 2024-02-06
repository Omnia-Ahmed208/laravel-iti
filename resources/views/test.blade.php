<h1>Hello <?php echo $name;?></h1>

<?php foreach ($books as $book){ ?>

    <h1>{{$book}}</h1> <!--laravel-->

<?php }?>

<!-- laravel code -->

@foreach($books as $book)
    <h1>{{$book}}</h1>
@endforeach
