function setOnImgErrListener() {
    $('img').off('error').on('error', function () {
        $(this).attr('src', '/GameConsole/views/img/gravatar.jpg');
    });
}