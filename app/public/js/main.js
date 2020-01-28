const place = document.querySelectorAll('.hall__place');
const hall = document.querySelectorAll('.hall');

place.forEach(e => {
    e.addEventListener('click', function () {
        let status = e.getAttribute('data-status');
        let hall_id = e.getAttribute('data-id');
        const count_place = document.getElementsByClassName('count-place_' + hall_id)[0];
        let available = document.getElementsByClassName('available_' + hall_id)[0];
        let message = document.getElementsByClassName('message_' + hall_id)[0];

        if (status == '1') {
            let json = JSON.stringify({
                status: status,
                id: e.getAttribute('alt'),
                hall_id: hall_id
            });

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/hall/place");
            xhr.setRequestHeader('Content-type', 'application/json; charset=utf-8');
            xhr.responseType = 'json';
            xhr.send(json);

            xhr.onload = function () {
                if (xhr.status === 200) {
                    e.setAttribute('data-status', xhr.response.status);
                    img_place(e.getAttribute('data-status'), e);
                    if (xhr.response.available != '0')
                        append(available, xhr.response.available);
                    else {
                        count_place.innerHTML = 'Свободных мест нет!';
                        available.style.display = 'none';
                    }
                } else console.log(`Проихошла ошибка: ${xhr.status} ${xhr.statusText}`);
            };
            xhr.onerror = function () {
                alert(`Ошибка соединения`);
            };
        } else {
            append(message, 'Место занято', 'true');
        }
    });
});

function img_place(status, e) {
    e.setAttribute('src', 'app/public/img/svg/chair_' + status + '.svg');
}

function append(elem, text, setTime = '') {
    elem.innerHTML = '';
    elem.append(text);
    if (setTime != '')
        setTimeout(() => elem.innerHTML = '', 2000);
}