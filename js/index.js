$().ready(function(){
    /**
     * Обработка нажатия клавиши GO
     * отправляется ajax запрос
     */
   $('button[name=go]').on('click', function(){
       $.ajax({
           url: "class/products.class.php",
           data: {sum: $('input[name=sum]').val()},
           dataType: 'json',
           success: function(data) {
               turnOff(); // Выключаем Предзагрузчик
               $('button[name=clear]').click(); // Очищаем вывод
               data.forEach(function(item){ // Вывод пришедших данных
                   $('#result').append(item + '<br>');
                   }
               )
           },
           ajaxStart: turnOn()
       });
   });

    /**
     * Очищаем
     */
    $('button[name=clear]').on('click', function(){
        $('#result').empty();
    })

    /**
     * Включаем предзагрузкик
     */
    function turnOn()
    {
        $('#onLoad').show();
    };

    /**
     * Выключаем предзагрузчик
     */
    function turnOff()
    {
        $('#onLoad').hide();
    };
});