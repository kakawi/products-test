$().ready(function(){
   $('button[name=go]').on('click', function(){
       $.ajax({
           url: "products.class.php",
           data: {sum: $('input[name=sum]').val()},
           dataType: 'json'
       }).done(function(data) {
           data.forEach(function(item){
               $('#result').append(item + '<br>');
           })
       });
   });

    $('button[name=clear]').on('click', function(){
        $('#result').empty();
    })
});