function setOnImgErrListener() {
    $('img').off('error')
        .on('error', function () {
            console.log(this.id);
            $(this).attr('src', '/GameConsole/views/img/gravatar.jpg');
        });
}