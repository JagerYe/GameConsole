function getCookie(name) {
    let start = document.cookie.indexOf(`${name}=`);
    if (start === -1) {
        return '';
    }
    let end = (document.cookie.indexOf(';', start) === -1) ?
        document.cookie.length : document.cookie.indexOf(';', start);

    return document.cookie.substring((start + name.length + 1), end);
}

function setCookie(name, value) {
    let date = new Date();
    date.setTime(date.getTime() + (1000 * 60 * 60 * 24 * 365));
    let expires = `expires=${date.toUTCString()}`;
    // document.cookie = startStr + name + "=" + value + ";" + endStr + expires + "; path=/";
    document.cookie = `${name}=${value}; ${expires}; path=/`;
    return true;
}

function deleteCookie(name) {
    let date = new Date();
    date.setTime(date.getTime() - 1);
    let expires = `expires=${date.toUTCString()}`;
    document.cookie = `${name}=; ${expires}; path=/;`;
}