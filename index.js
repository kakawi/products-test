$().ready(function(){
   $('button[name=go]').on('click', function(){
       $.ajax({
           url: "products.class.php",
           data: {sum: $('input[name=sum]').val()},
           dataType: 'json',
           success: function(data) {
               turnOff();
               data.forEach(function(item){
                   $('#result').append(item + '<br>');
                   }
               )
           },
           ajaxStart: turnOn()
       });
   });

    $('button[name=clear]').on('click', function(){
        $('#result').empty();
    })

    function turnOn()
    {
        $('#onLoad').show();
    };

    function turnOff()
    {
        $('#onLoad').hide();
    };
});