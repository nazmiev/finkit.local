document.addEventListener('DOMContentLoaded', function () {
    const setCookie = (name, value, days = 7, path = '/') => {
        const expires = new Date(Date.now() + days * 864e5).toUTCString()
        document.cookie = name + '=' + encodeURIComponent(value) + '; expires=' + expires + '; path=' + path
    }

    const getCookie = (name) => {
        return document.cookie.split('; ').reduce((r, v) => {
            const parts = v.split('=')
            return parts[0] === name ? decodeURIComponent(parts[1]) : r
        }, '')
    }

    const deleteCookie = (name, path) => {
        setCookie(name, '', -1, path);
        return;
    }

    const logOut = document.querySelector('[role="logout"]');

    if (logOut) {
        logOut.addEventListener('click', () => {
            deleteCookie('user');
            window.location.reload();
        })
    }

    const ViewProfile = (user_cookie) => {
        const user = JSON.parse(user_cookie);
        const info = document.getElementById('profile');
        info.classList.remove('hidden');
        info.querySelector('[role="avatar"]').src = user.photo;
        info.querySelector('[role="name"]').innerText = user.name;
        info.querySelector('[role="birthday"]').innerText  = user.birthday;
    }

    const form = document.getElementById("auth");

    if (getCookie('user')) {
        form.classList.add('hidden');
        ViewProfile(getCookie('user'));
    }

    form.addEventListener('submit', getData);

    function getData(event) {
        event.preventDefault();

        const success = document.querySelector('[id="success"]');
        const error = document.querySelector('[id="error"]');
        const login = form.querySelector('[name="login"]');
        const password = form.querySelector('[name="password"]');

        fetch('auth.php', {
            method: 'POST',
            body: 'login=' + login.value + '&password=' + password.value,
            headers: { "content-type": "application/x-www-form-urlencoded" }
        }).then((response) => {
            if (response.status !== 200) {
                return Promise.reject();
            }
            return response.text()
        }).then(function (data) {
            const result = JSON.parse(data);
            if (result.code == 1) {
                form.classList.add('hidden');
                error.classList.add('hidden');
                success.classList.remove('hidden');
                setCookie('user', JSON.stringify(result.user));
                setTimeout(() => {
                    success.classList.add('hidden');
                    ViewProfile(JSON.stringify(result.user));
                }, 10000);

            } else {
                error.classList.remove('hidden');
            }
        }).catch(() => console.log('err'));
    }
});

